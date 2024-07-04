@extends('layouts.admin')
@section('page-title')
    {{ __('Invoice Create') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('invoice.index') }}">{{ __('Invoice') }}</a></li>
    <li class="breadcrumb-item">{{ __('Invoice Create') }}</li>
@endsection
@push('script-page')
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/jquery.repeater.min.js') }}"></script>
    <script>
        var selector = "body";
        if ($(selector + " .repeater").length) {
            var $dragAndDrop = $("body .repeater tbody").sortable({
                handle: '.sort-handler'
            });
            var $repeater = $(selector + ' .repeater').repeater({
                initEmpty: false,
                defaultValues: {
                    'status': 1
                },
                show: function() {
                    $(this).slideDown();
                },
                hide: function(deleteElement) {
                    if (confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                        $(this).remove();

                        var inputs = $(".amount");
                        var subTotal = 0;
                        for (var i = 0; i < inputs.length; i++) {
                            subTotal = parseFloat(subTotal) + parseFloat($(inputs[i]).html());
                        }
                        $('.subTotal').html(subTotal.toFixed(2));
                        $('.totalAmount').html(subTotal.toFixed(2));
                    }
                },
                ready: function(setIndexes) {

                    $dragAndDrop.on('drop', setIndexes);
                },
                isFirstItemUndeletable: true
            });
            var value = $(selector + " .repeater").attr('data-value');
            if (typeof value != 'undefined' && value.length != 0) {
                value = JSON.parse(value);
                $repeater.setList(value);
            }

        }

        $(document).on('change', '#customer', function() {
            $('#customer_detail').removeClass('d-none');
            $('#customer_detail').addClass('d-block');
            $('#customer-box').removeClass('d-block');
            $('#customer-box').addClass('d-none');
            var id = $(this).val();
            var url = $(this).data('url');
            $.ajax({
                url: url,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': jQuery('#token').val()
                },
                data: {
                    'id': id
                },
                cache: false,
                success: function(data) {
                    if (data != '') {
                        $('#customer_detail').html(data);
                    } else {
                        $('#customer-box').removeClass('d-none');
                        $('#customer-box').addClass('d-block');
                        $('#customer_detail').removeClass('d-block');
                        $('#customer_detail').addClass('d-none');
                    }
                },

            });

        });

        $(document).on('click', '#remove', function() {
            $('#customer-box').removeClass('d-none');
            $('#customer-box').addClass('d-block');
            $('#customer_detail').removeClass('d-block');
            $('#customer_detail').addClass('d-none');
        })

        $(document).ready(function() {
            function calculateSubtotal() {
                var inputs = $(".amount");
                var subTotal = 0;
                for (var i = 0; i < inputs.length; i++) {
                    subTotal += parseFloat($(inputs[i]).text());
                }

                var discounts = $(".discountAmount");
                var totalDiscount = 0;
                for (var i = 0; i < discounts.length; i++) {
                    totalDiscount += parseFloat($(discounts[i]).val()) || parseFloat(0);
                }

                var taxAmounts = $(".taxAmount");
                var totalTax = 0;
                for (var i = 0; i < taxAmounts.length; i++) {
                    totalTax += parseFloat($(taxAmounts[i]).val()) || parseFloat(0);
                }

                const stot = (subTotal + totalDiscount) - totalTax;
                $('.subTotal').html(stot.toFixed(2));
                $('.totalAmount').html(subTotal.toFixed(2));
            }

            function calculateTotalDiscount() {
                var discounts = $(".discountAmount");
                var totalDiscount = 0;
                for (var i = 0; i < discounts.length; i++) {
                    totalDiscount += parseFloat($(discounts[i]).val()) || parseFloat(0);
                }
                $('.totalDiscount').html(totalDiscount.toFixed(2));
            }

            function calculateTotalTax() {
                var taxAmounts = $(".taxAmount");
                var totalTax = 0;
                for (var i = 0; i < taxAmounts.length; i++) {
                    totalTax += parseFloat($(taxAmounts[i]).val()) || parseFloat(0);
                }
                $('.totalTax').html(totalTax.toFixed(2));
            }

            calculateSubtotal();
            calculateTotalDiscount();
            calculateTotalTax();

            $(document).on('change', '.quantity, .unitPrice, .pkgQuantity, .discount, .taxCode', function() {
                calculateSubtotal();
                calculateTotalDiscount();
                calculateTotalTax();
            });

            $(document).on('click', '[data-repeater-delete]', function() {
                calculateSubtotal();
                calculateTotalDiscount();
                calculateTotalTax();
            });

            $(document).on('change', '.itemCode', async function() {
                const el = $(this);
                const id = $(this).val();
                const url = `http://localhost:8000/getitem/${id}`;

                const response = await fetch(url);
                const {
                    data
                } = await response.json();

                const {
                    dftPrc,
                    taxTyCd
                } = data;


                $(el).closest('tr').find('.unitPrice').val(dftPrc);

                const taxationtypes = {!! json_encode($taxes) !!};
                console.log(taxationtypes);
                $(el).closest('tr').find('.taxCode').val(taxationtypes[taxTyCd]);

                const quantity = parseFloat($(el).closest('tr').find('.quantity').val()) || parseFloat(
                    0);
                const unitPrice = parseFloat($(el).closest('tr').find('.unitPrice').val()) ||
                    parseFloat(0);
                const discountRate = parseFloat($(el).closest('tr').find('.discount').val()) ||
                    parseFloat(0);
                const taxCode = parseFloat($(el).closest('tr').find('.taxCode').val()) || parseFloat(0);
                const pkgQuantity = parseFloat($(el).closest('tr').find('.pkgQuantity').val()) ||
                    parseFloat(0);
                const subtotal = quantity * unitPrice * pkgQuantity;
                const discountAmount = subtotal * (discountRate / 100);
                const totalAmount = subtotal - discountAmount;
                const taxAmount = totalAmount * (taxCode / 100);
                const finalAmount = totalAmount + taxAmount;

                $(el).closest('tr').find('.taxAmount').val(parseFloat(taxAmount));
                $(el).closest('tr').find('.discountAmount').val(parseFloat(discountAmount));
                $(el).closest('tr').find('.amount').html(parseFloat(finalAmount));

            });

            $(document).on('keyup change', '.quantity', function() {
                const el = $(this);
                const quantity = parseFloat($(this).val()) || parseFloat(0);
                const unitPrice = parseFloat($(el).closest('tr').find('.unitPrice').val()) || parseFloat(0);
                const discountRate = parseFloat($(el).closest('tr').find('.discount').val()) || parseFloat(
                    0);
                const taxCode = parseFloat($(el).closest('tr').find('.taxCode').val()) || parseFloat(0);
                const pkgQuantity = parseFloat($(el).closest('tr').find('.pkgQuantity').val()) ||
                    parseFloat(0);
                const subtotal = quantity * unitPrice * pkgQuantity;
                const discountAmount = subtotal * (discountRate / 100);
                const totalAmount = subtotal - discountAmount;
                const taxAmount = totalAmount * (taxCode / 100);
                const finalAmount = totalAmount + taxAmount;

                $(el).closest('tr').find('.taxAmount').val(parseFloat(taxAmount));
                $(el).closest('tr').find('.discountAmount').val(parseFloat(discountAmount));
                $(el).closest('tr').find('.amount').html(parseFloat(finalAmount));
            });

            $(document).on('keyup change', '.taxCode', function() {
                const el = $(this);
                const taxCode = parseFloat($(this).val()) || parseFloat(0);
                const unitPrice = parseFloat($(el).closest('tr').find('.unitPrice').val()) || parseFloat(0);
                const discountRate = parseFloat($(el).closest('tr').find('.discount').val()) || parseFloat(
                    0);
                const quantity = parseFloat($(el).closest('tr').find('.quantity').val()) || parseFloat(0);
                const pkgQuantity = parseFloat($(el).closest('tr').find('.pkgQuantity').val()) ||
                    parseFloat(0);
                const subtotal = quantity * unitPrice * pkgQuantity;
                const discountAmount = subtotal * (discountRate / 100);
                const totalAmount = subtotal - discountAmount;
                const taxAmount = totalAmount * (taxCode / 100);
                const finalAmount = totalAmount + taxAmount;

                $(el).closest('tr').find('.taxAmount').val(parseFloat(taxAmount));
                $(el).closest('tr').find('.discountAmount').val(parseFloat(discountAmount));
                $(el).closest('tr').find('.amount').html(parseFloat(finalAmount));
                $(el).closest('tr').find('.taxTypeCode').val($(el).closest('tr').find('.taxCode option:selected').text());
            });

            $(document).on('keyup change', '.unitPrice', function() {
                const el = $(this);
                const unitPrice = parseFloat($(this).val()) || parseFloat(0);
                const quantity = parseFloat($(el).closest('tr').find('.quantity').val()) || parseFloat(0);
                const discountRate = parseFloat($(el).closest('tr').find('.discount').val()) || parseFloat(
                    0);
                const taxCode = parseFloat($(el).closest('tr').find('.taxCode').val()) || parseFloat(0);
                const pkgQuantity = parseFloat($(el).closest('tr').find('.pkgQuantity').val()) ||
                    parseFloat(0);
                const subtotal = quantity * unitPrice * pkgQuantity;
                const discountAmount = subtotal * (discountRate / 100);
                const totalAmount = subtotal - discountAmount;
                const taxAmount = totalAmount * (taxCode / 100);
                const finalAmount = totalAmount + taxAmount;

                $(el).closest('tr').find('.taxAmount').val(parseFloat(taxAmount));
                $(el).closest('tr').find('.discountAmount').val(parseFloat(discountAmount));
                $(el).closest('tr').find('.amount').html(parseFloat(finalAmount));
            });

            $(document).on('keyup change', '.discount', function() {


                const el = $(this);
                const discountRate = parseFloat($(this).val()) || parseFloat(0);
                const quantity = parseFloat($(el).closest('tr').find('.quantity').val()) || parseFloat(0);
                const unitPrice = parseFloat($(el).closest('tr').find('.unitPrice').val()) || parseFloat(0);
                const taxCode = parseFloat($(el).closest('tr').find('.taxCode').val()) || parseFloat(0);
                const pkgQuantity = parseFloat($(el).closest('tr').find('.pkgQuantity').val()) ||
                    parseFloat(0);
                const subtotal = quantity * unitPrice * pkgQuantity;
                const discountAmount = subtotal * (discountRate / 100);
                const totalAmount = subtotal - discountAmount;
                const taxAmount = totalAmount * (taxCode / 100);
                const finalAmount = totalAmount + taxAmount;

                $(el).closest('tr').find('.taxAmount').val(parseFloat(taxAmount));
                $(el).closest('tr').find('.discountAmount').val(parseFloat(discountAmount));
                $(el).closest('tr').find('.amount').html(parseFloat(finalAmount));
            });

            $(document).on('keyup change', '.pkgQuantity', function() {


                const el = $(this);
                const pkgQuantity = parseFloat($(this).val()) || parseFloat(0);
                const quantity = parseFloat($(el).closest('tr').find('.quantity').val()) || parseFloat(0);
                const unitPrice = parseFloat($(el).closest('tr').find('.unitPrice').val()) || parseFloat(0);
                const taxCode = parseFloat($(el).closest('tr').find('.taxCode').val()) || parseFloat(0);
                const discountRate = parseFloat($(el).closest('tr').find('.discount').val()) || parseFloat(
                    0);
                const subtotal = quantity * unitPrice * pkgQuantity;
                const discountAmount = subtotal * (discountRate / 100);
                const totalAmount = subtotal - discountAmount;
                const taxAmount = totalAmount * (taxCode / 100);
                const finalAmount = totalAmount + taxAmount;

                $(el).closest('tr').find('.taxAmount').val(parseFloat(taxAmount));
                $(el).closest('tr').find('.discountAmount').val(parseFloat(discountAmount));
                $(el).closest('tr').find('.amount').html(parseFloat(finalAmount));
            });


            $('.select2').select2({
                templateResult: function(data) {
                    var $option = $(data.element);
                    return $option.data('text') || data.text;
                }
            });
        });

        var customerId = '{{ $customerId }}';
        if (customerId > 0) {
            $('#customer').val(customerId).change();
        }
    </script>
    <script>
        $(document).on('click', '[data-repeater-delete]', function() {
            $(".price").change();
            $(".discount").change();
        });
    </script>
@endpush
@section('content')
    <div class="row">
        {{ Form::open(['url' => 'invoice', 'class' => 'w-100']) }}
        <div class="col-12">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group" id="customer-box">
                            {{ Form::label('customer_id', __('Customer'), ['class' => 'form-label']) }}
                            <span class="text-danger">*</span>
                            {{ Form::select('customer_id', $customers, '', ['class' => 'form-control customer_id select2', 'id' => 'customer', 'data-url' => route('invoice.customer'), 'required' => 'required']) }}
                        </div>
                        <div id="customer_detail" class="d-none">
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                {{ Form::label('traderInvoiceNo', __('Trader Invoice No'), ['class' => 'form-label']) }}
                                <span class="text-danger">*</span>
                                {{ Form::text('traderInvoiceNo', $invoice_number, ['class' => 'form-control', 'required' => 'required']) }}
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('salesType', __('Sales Type'), ['class' => 'form-label']) }}
                                {{ Form::select('salesType', $salesTypeCodes, null, ['class' => 'form-control select2', 'placeholder' => __('Select Sales Type')]) }}
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('paymentType', __('Payment Type Code'), ['class' => 'form-label']) }}
                                {{ Form::select('paymentType', $paymentTypeCodes, null, ['class' => 'form-control select2', 'placeholder' => __('Select Payment Type')]) }}
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('stockReleseDate', __('Stock Release Date'), ['class' => 'form-label']) }}
                                {{ Form::date('stockReleseDate', '', ['class' => 'form-control']) }}
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('category_id', __('Category'), ['class' => 'form-label']) }}
                                <span class="text-danger">*</span>
                                {{ Form::select('category_id', $category, null, ['class' => 'form-control select2', 'placeholder' => __('Select Category'), 'required' => 'required']) }}
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('confirmDate', __('Confirm Date'), ['class' => 'form-label']) }}
                                <span class="text-danger">*</span>
                                {{ Form::date('confirmDate', '', ['class' => 'form-control', 'required' => 'required']) }}
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('salesDate', __('Sales Date'), ['class' => 'form-label']) }}
                                <span class="text-danger">*</span>
                                {{ Form::date('salesDate', '', ['class' => 'form-control', 'required' => 'required']) }}
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('receiptPublishDate', __('Receipt Publish Date'), ['class' => 'form-label']) }}
                                <span class="text-danger">*</span>
                                {{ Form::date('receiptPublishDate', '', ['class' => 'form-control', 'required' => 'required']) }}
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('occurredDate', __('Occurred Date'), ['class' => 'form-label']) }}
                                <span class="text-danger">*</span>
                                {{ Form::date('occurredDate', '', ['class' => 'form-control', 'required' => 'required']) }}
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('issue_date', __('Issue Date'), ['class' => 'form-label']) }}
                                <span class="text-danger">*</span>
                                {{ Form::date('issue_date', '', ['class' => 'form-control', 'required' => 'required']) }}
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('send_date', __('Send Date'), ['class' => 'form-label']) }}
                                <span class="text-danger">*</span>
                                {{ Form::date('send_date', '', ['class' => 'form-control', 'required' => 'required']) }}
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('due_date', __('Due Date'), ['class' => 'form-label']) }}
                                <span class="text-danger">*</span>
                                {{ Form::date('due_date', '', ['class' => 'form-control', 'required' => 'required']) }}
                            </div>
                             <div class="form-group col-md-4">
                                {{ Form::label('invoiceStatusCode', __('Invoice Status'), ['class' => 'form-label']) }}
                                <span class="text-danger">*</span>
                                {{ Form::select('invoiceStatusCode', $invoiceStatusCodes, null, ['class' => 'form-control select2', 'placeholder' => __('Select Invoice Status'), 'required' => 'required']) }}
                            </div>                            
                            <div class="form-group col-md-4">
                                {{ Form::label('isPurchaseAccept', __('Purchase Accepted?'), ['class' => 'form-label']) }}
                                {{ Form::select('isPurchaseAccept', [true => 'Yes', false => 'No'], null, ['class' => 'form-control select2']) }}
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('ref_number', __('Reference Number'), ['class' => 'form-label']) }}
                                {{ Form::number('ref_number', '', ['class' => 'form-control']) }}
                            </div>
                            <div class="form-group col-md-12">
                                {{ Form::label('remark', __('Remark'), ['class' => 'form-label']) }}
                                {{ Form::textarea('remark', '', ['class' => 'form-control', 'rows' => '3']) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-12">
            <h5 class=" d-inline-block mb-4">{{ __('Product & Services') }}</h5>
            <div class="card repeater">
                <div class="item-section py-2">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-md-12 d-flex align-items-center justify-content-between justify-content-md-end">
                            <div class="all-button-box me-2">
                                <a href="#" data-repeater-create="" class="btn btn-primary" data-bs-toggle="modal"
                                    data-target="#add-bank">
                                    <i class="ti ti-plus"></i> {{ __('Add item') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-border-style mt-2">
                    <div class="table-responsive">
                        <table class="table  mb-0 table-custom-style" data-repeater-list="items" id="sortable-table">
                            <thead>
                                <tr>
                                    <th>{{ __('Items') }}</th>
                                    <th>{{ __('Quantity') }}</th>
                                    <th>{{ __('Price') }} </th>
                                    <th>{{ __('Discount') }}</th>
                                    <th>{{ __('Tax') }} (%)</th>
                                    <th class="text-end">
                                        {{ __('Amount') }}
                                        <br>
                                        <small
                                            class="text-danger font-weight-bold">{{ __('after tax & discount') }}</small>
                                    </th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody class="ui-sortable" data-repeater-item>
                                <tr>
                                    <td width="25%" class="form-group pt-0">
                                        <span class="text-danger">*</span>
                                        {{ Form::select('itemCode', $items, '', ['class' => 'form-control select2 itemCode', 'id' => 'itemCode', 'data-url' => route('invoice.product'), 'required' => 'required']) }}
                                    </td>
                                    <td>
                                        <span class="text-danger">*</span>
                                        <div class="form-group price-input input-group search-form">
                                            {{ Form::text('quantity', '', ['class' => 'form-control quantity', 'placeholder' => __('Qty'), 'required' => 'required']) }}
                                            {{ Form::text('pkgQuantity', '', ['class' => 'form-control pkgQuantity', 'placeholder' => __('Pkg Qty'), 'required' => 'required']) }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-danger">*</span>
                                        <div class="form-group price-input input-group search-form">
                                            {{ Form::text('price', '', ['class' => 'form-control unitPrice', 'placeholder' => __('Price'), 'required' => 'required']) }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group price-input input-group search-form">
                                            {{ Form::text('discount', '', ['class' => 'form-control discount', 'placeholder' => __('Discount')]) }}
                                            {{ Form::text('discountAmount', '', ['class' => 'form-control discountAmount', 'placeholder' => __('Discount')]) }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group price-input input-group search-form">
                                            {{ Form::select('tax', $taxes, null, ['class' => 'form-control taxCode', 'placeholder' => __('Select Tax')]) }}
                                            {{ Form::hidden('taxTypeCode', '', ['class' => 'form-control taxTypeCode']) }}
                                            {{ Form::text('taxAmount', '', ['class' => 'form-control taxAmount', 'placeholder' => __('Tax Amt')]) }}
                                        </div>
                                    </td>
                                    <td class="text-end amount">0.00</td>
                                    <td>
                                        <a href="#"
                                            class="ti ti-trash text-white repeater-action-btn bg-danger ms-2 bs-pass-para"
                                            data-repeater-delete></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div class="form-group">
                                            {{ Form::textarea('description', null, ['class' => 'form-control pro_description', 'rows' => '2', 'placeholder' => __('Description')]) }}
                                        </div>
                                    </td>
                                    <td colspan="2">
                                        <div class="form-group">
                                            {{ Form::label('itemExprDate', __('item Expiry Date'), ['class' => 'form-label']) }}
                                            {{ Form::date('itemExprDate', null, ['class' => 'form-control itemExprDt']) }}
                                        </div>
                                    </td>
                                    <td colspan="5"></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td></td>
                                    <td><strong>{{ __('Sub Total') }} ({{ \Auth::user()->currencySymbol() }})</strong>
                                    </td>
                                    <td class="text-end subTotal">0.00</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td></td>
                                    <td><strong>{{ __('Discount') }} ({{ \Auth::user()->currencySymbol() }})</strong></td>
                                    <td class="text-end totalDiscount">0.00</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td></td>
                                    <td><strong>{{ __('Tax') }} ({{ \Auth::user()->currencySymbol() }})</strong></td>
                                    <td class="text-end totalTax">0.00</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td class="blue-text"><strong>{{ __('Total Amount') }}
                                            ({{ \Auth::user()->currencySymbol() }})</strong></td>
                                    <td class="text-end totalAmount blue-text"></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal-footer">
            <input type="button" value="{{ __('Cancel') }}" onclick="location.href = '{{ route('invoice.index') }}';"
                class="btn btn-light">
            <input type="submit" value="{{ __('Create') }}" class="btn btn-primary">
        </div>
        {{ Form::close() }}

    </div>
@endsection
