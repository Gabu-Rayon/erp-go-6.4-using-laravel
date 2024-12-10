@extends('layouts.admin')
@section('page-title')
    {{ __('Add Sales Credit Note') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('invoice.index') }}">{{ __('Sales') }}</a></li>
    <li class="breadcrumb-item">{{ ucwords($invoiceDue->invoice_id) }}</li>
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
                    var file_uploads = $(this).find('input.multi');
                    if (file_uploads.length) {
                        $(this).find('input.multi').MultiFile({
                            max: 3,
                            accept: 'png|jpg|jpeg',
                            max_size: 2048
                        });
                    }
                    $('.select2').select2();
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

        $(document).ready(function() {
            $(document).on('change', '.itemCode', function() {
                var item_id = $(this).val();
                var url = `http://localhost:8000/getitem/${item_id}`;
                var el = $(this).closest('[data-clone]');

                if (el.length) {
                    $.ajax({
                        url: url,
                        type: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': jQuery('#token').val()
                        },
                        cache: false,
                        success: function(data) {
                            try {

                                if (!data.data) {
                                    alert("Item information is empty.");
                                } else {
                                    var item = data.data;

                                    if (Object.keys(item).length === 0) {
                                        alert("Item object is empty.");
                                    } else {

                                        el.find('.itemClassCode').val(item.itemClsCd);

                                        el.find('.itemTypeCode').val(item.itemTyCd);

                                        el.find('.itemName').val(item.itemNm);

                                        el.find('.orgnNatCd').val(item.orgnNatCd);

                                        el.find('.taxTypeCode').val(item.taxTyCd);

                                        el.find('.unitPrice').val(item.dftPrc);

                                        el.find('.isrcAplcbYn').val(item.isrcAplcbYn);

                                        el.find('.pkgUnitCode').val(item.pkgUnitCd);

                                        el.find('.qtyUnitCd').val(item.qtyUnitCd);

                                    }
                                }
                            } catch (error) {
                                console.error("Error processing item information:", error);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Error retrieving item information:", error);
                        }
                    });
                }
            });

            function calculateDiscountAmount(unitPrice, packageQuantity, quantity, discountRate) {
                // Calculate the total price before discount
                var totalPrice = unitPrice * quantity * packageQuantity;

                // Calculate the discounted price
                var discountAmount = totalPrice * (discountRate / 100);

                return discountAmount;
            }

            // Function to update discount amount field
            function updateDiscountAmount(row) {
                // Get values of required fields
                var unitPrice = parseFloat(row.find('.unitPrice').val());
                var packageQuantity = parseFloat(row.find('.pkgQuantity').val());
                var quantity = parseFloat(row.find('.quantity').val());
                var discountRate = parseFloat(row.find('.discountRate').val());

                // Calculate discount amount
                var discountAmt = calculateDiscountAmount(unitPrice, packageQuantity, quantity, discountRate) || 0;

                // Update discount amount field
                row.find('.discountAmt').val(discountAmt.toFixed(2));
            }

            // Event listener for change in unitPrice, pkgQuantity, quantity, and discountRate fields
            $(document).on('keyup change', '.unitPrice, .pkgQuantity, .quantity, .discountRate', function() {
                // Find the closest row containing the changed field
                var row = $(this).closest('tr');

                // Update discount amount for the row
                updateDiscountAmount(row);
            });

            // Initial update of discount amount for existing rows
            $('.repeater-item').each(function() {
                updateDiscountAmount($(this));
            });
        });
    </script>

    <script>
        $(document).on('click', '[data-repeater-delete]', function() {
            $(".price").change();
            $(".discount").change();
        });
    </script>
@endpush

@section('content')
    {{ Form::open(['route' => ['invoice.credit.note', $invoice_id], 'method' => 'post']) }}
    <div class="modal-body">
        <div class="row">
            <div class="form-group col-md-3">
                {{-- Show the Customer Name from using the ID  of Invoice  --}}
                {{ Form::label('customerName', __('Customer Name (*)'), ['class' => 'form-label']) }}
                {{ Form::text('customerName', $invoice->customer->customerName, [
                    'class' => 'form-control customerName',
                    'required' => 'required',
                    'readonly' => true,
                ]) }}
            </div>
            <div class="form-group col-md-3">
                {{-- Show the Customer Tin from using the ID  of Invoice  --}}
                {{ Form::label('customerTin', __('Customer Tin (*)'), ['class' => 'form-label']) }}
                {{ Form::text('customerTin', $invoice->customer->customerTin, [
                    'class' => 'form-control customerTin',
                    'required' => 'required',
                    'readonly' => true,
                ]) }}
            </div>
            <div class="form-group col-md-3">
                {{ Form::label('salesType', __('Sales Type'), ['class' => 'form-label']) }}
                {{ Form::select('salesType', $salesTypeCodes, null, ['class' => 'form-control']) }}
            </div>
            <div class="form-group col-md-3">
                {{ Form::label('paymentType', __('Payment Type'), ['class' => 'form-label']) }}
                {{ Form::select('paymentType', $paymentTypeCodes, null, ['class' => 'form-control']) }}
            </div>
            <div class="form-group col-md-3">
                {{ Form::label('creditNoteReason', __('Credit Note Reason (*)'), ['class' => 'form-label']) }}
                {{ Form::select('creditNoteReason', $creditNoteReasons, null, ['class' => 'form-control', 'required' => 'required']) }}
            </div>
            <div class="form-group col-md-3">
                {{ Form::label('creditNoteDate', __('Credit Note Date (*)'), ['class' => 'form-label']) }}
                {{ Form::date('creditNoteDate', '', ['class' => 'form-control']) }}
            </div>
            <div class="form-group col-md-3">
                {{-- Show the Trader Invoice No using the ID --}}
                {{ Form::label('traderInvoiceNo', __('Trader Invoice No (*)'), ['class' => 'form-label']) }}
                {{ Form::text('traderInvoiceNo', $invoice->response_trderInvoiceNo, ['class' => 'form-control traderInvoiceNo', 'readonly' => true, 'required' => true]) }}
            </div>
            <div class="form-group col-md-3">
                {{ Form::label('confirmDate', __('Confirm Date (*)'), ['class' => 'form-label']) }}
                {{ Form::date('confirmDate', '', ['class' => 'form-control', 'required' => 'required']) }}
            </div>
            <div class="form-group col-md-3">
                {{ Form::label('salesDate', __('Sales Date (*)'), ['class' => 'form-label']) }}
                {{ Form::date('salesDate', '', ['class' => 'form-control', 'required' => 'required']) }}
            </div>
            <div class="form-group col-md-3">
                {{ Form::label('stockReleseDate', __('Stock Release Date'), ['class' => 'form-label']) }}
                {{ Form::date('stockReleseDate', '', ['class' => 'form-control']) }}
            </div>
            <div class="form-group col-md-3">
                {{ Form::label('receiptPublishDate', __('Receipt Publish Date (*)'), ['class' => 'form-label']) }}
                {{ Form::date('receiptPublishDate', '', ['class' => 'form-control', 'required' => 'required']) }}
            </div>
            <div class="form-group col-md-3">
                {{ Form::label('occurredDate', __('Occurred Date (*)'), ['class' => 'form-label']) }}
                {{ Form::date('occurredDate', '', ['class' => 'form-control', 'required' => 'required']) }}
            </div>
            <div class="form-group col-md-3">
                {{ Form::label('invoiceStatusCode', __('Invoice Status'), ['class' => 'form-label']) }}
                {{ Form::select('invoiceStatusCode', $invoiceStatusCodes, null, ['class' => 'form-control']) }}
            </div>
            <div class="form-group col-md-3">
                {{ Form::label('isPurchaseAccept', __('Purchase Accepted?'), ['class' => 'form-label']) }}
                {{ Form::select('isPurchaseAccept', ['true' => 'Yes', 'false' => 'No'], null, ['class' => 'form-control']) }}
            </div>
            <div class="form-group col-md-3">
                {{ Form::label('isStockIOUpdate', __('Stock IO Update?'), ['class' => 'form-label']) }}
                {{ Form::select('isStockIOUpdate', ['true' => 'Yes', 'false' => 'No'], null, ['class' => 'form-control']) }}
            </div>
            <div class="form-group col-md-3">
                {{ Form::label('mapping', __('Mapping'), ['class' => 'form-label']) }}
                {{ Form::text('mapping', '', ['class' => 'form-control']) }}
            </div>
            <div class="form-group col-md-6">
                {{ Form::label('remark', __('Remark'), ['class' => 'form-label']) }}
                {{ Form::textarea('remark', '', ['class' => 'form-control', 'rows' => '3']) }}
            </div>
            {{-- <div class="form-group col-md-6">
                {{ Form::label('description', __('Description'), ['class' => 'form-label']) }}
                {{ Form::textarea('description', '', ['class' => 'form-control', 'rows' => '3']) }}
            </div> --}}
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
            <div class="card-body table-border-style">
                <div class="#">
                    <table class="table mb-0">
                        <thead>
                        </thead>
                        <tbody data-repeater-list="items" id="sortable-table">
                            @foreach ($invoiceProducts as $invoiceProduct)
                                <tr class="row p-3 ui-sortable" data-repeater-item data-clone>


                                    <td class="form-group col-md-3">
                                        {{ Form::label('item_' . $invoiceProduct->id, __('Item (*)'), ['class' => 'form-label']) }}

                                        {{-- Show the product name to the user but post kraItemCode --}}
                                        {{ Form::text('kraItemCode_' . $invoiceProduct->id, $invoiceProduct->product->name, ['class' => 'form-control itemCode', 'readonly' => true, 'required' => 'required']) }}
                                        {{ Form::hidden('item_', $invoiceProduct->product->kraItemCode, ['class' => 'form-control itemCode', 'readonly' => true, 'required' => 'required']) }}

                                    </td>

                                    <td class="form-group col-md-3">
                                        {{ Form::label('price', __('Unit Price (*)'), ['class' => 'form-label']) }}
                                        {{ Form::number('price', $invoiceProduct->unitPrice, ['class' => 'form-control unitPrice', 'required' => 'required']) }}
                                        <small class="text-success"><i>Subject to change by user</i></small>
                                    </td>
                                    <td class="form-group col-md-3">
                                        {{ Form::label('pkgQuantity', __('Package Quantity (*)'), ['class' => 'form-label']) }}
                                        {{ Form::number('pkgQuantity', $invoiceProduct->pkgQuantity, ['class' => 'form-control pkgQuantity', 'required' => 'required']) }}
                                    </td>
                                    <td class="form-group col-md-3">
                                        {{ Form::label('quantity', __('Quantity (*)'), ['class' => 'form-label']) }}
                                        {{ Form::number('quantity', $invoiceProduct->quantity, ['class' => 'form-control quantity', 'required' => 'required']) }}
                                    </td>
                                    <td class="form-group col-md-3">
                                        {{ Form::label('discountRate', __('Discount Rate'), ['class' => 'form-label']) }}
                                        {{ Form::number('discountRate', $invoiceProduct->discountRate ?? null, ['class' => 'form-control discountRate', 'required' => 'required']) }}
                                    </td>
                                    <td class="form-group col-md-3">
                                        {{ Form::label('discountAmt', __('Discount Amount'), ['class' => 'form-label']) }}
                                        {{ Form::number('discountAmt', $invoiceProduct->discountAmt ?? null, ['class' => 'form-control discountAmt']) }}
                                    </td>
                                    <td class="form-group col-md-3">
                                        {{ Form::label('itemExprDate', __('Item Expiry Date'), ['class' => 'form-label']) }}
                                        {{ Form::date('itemExprDate', $invoiceProduct->itemExprDate ?? null, ['class' => 'form-control']) }}
                                        {{-- Show the current one --}}
                                        <small><i class="text-danger">Current :
                                            </i>{{ $invoiceProduct->itemExprDate ? \Carbon\Carbon::createFromFormat('Ymd', $invoiceProduct->itemExprDate)->format('d-m-Y') : 'No expiry date set' }}</small>
                                    </td>

                                    <td class="ti ti-trash text-white text-white repeater-action-btn bg-danger ms-2"
                                        data-repeater-delete></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="button" value="{{ __('Cancel') }}" class="btn btn-light" data-bs-dismiss="modal">
        <input type="submit" value="{{ __('Add') }}" class="btn  btn-primary">
    </div>
    {{ Form::close() }}
@endsection

@push('script-page')
    <script>
        const customerNameField = document.querySelector('.customerName');
        const customerTinField = document.querySelector('.customerTin');
        customerNameField.addEventListener('change', async function() {
            const url = `http://localhost:8000/getcustomerbyname/${this.value}`;
            const response = await fetch(url);
            const {
                data
            } = await response.json();
            const {
                customerTin,
                customerNo,
                contact
            } = data;
            customerTinField.value = customerTin;
        });
    </script>
@endpush
