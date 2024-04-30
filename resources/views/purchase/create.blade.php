@extends('layouts.admin')
@section('page-title')
    {{ __('Purchase Create') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('purchase.index') }}">{{ __('Purchase') }}</a></li>
    <li class="breadcrumb-item">{{ __('Purchase Create') }}</li>
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

        $(document).on('change', '.itemCode', function() {
            var item_id = $(this).val();
            var url = $(this).data('url');
            var el = $(this);
            $.ajax({
                url: url,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': jQuery('#token').val()
                },
                data: {
                    'itemCode': item_id
                },
                cache: false,
                success: function(data) {
                    try {
                        console.log("Item information:", data.data);

                        if (!data.data) {
                            console.log("Item information is empty.");
                        } else {
                            console.log("Item information is not empty. Processing...");

                            var item = data.data;

                            console.log("Item object:", item);

                            if (Object.keys(item).length === 0) {
                                console.log("Item object is empty.");
                            } else {
                                console.log("Item object is not empty. Populating fields...");

                                // Populate fields
                                $('.unitPrice').val(item.dftPrc);
                                $('.pkgQuantity').val(item.pkgUnitCd);
                                $('.item_standard_name').val(item.itemStdNm);
                                $('.tax').val(item.taxTyCd);
                                $('.country_of_origin').val(item.orgnNatCd);
                                $('.unitPrice, .pkgQuantity,.item_standard_name,.country_of_origin,.tax')
                                    .trigger('change');

                                // Calculate tax based on taxTyCd
                                var taxTyCd = item.taxTyCd;
                                var taxRate = 0;

                                // Determine tax rate based on taxTyCd
                                if (taxTyCd === 'B') {
                                    taxRate = 16; // VAT 16%
                                } else if (taxTyCd === 'E') {
                                    taxRate = 8; // VAT 8%
                                }

                                // Calculate item tax price based on unit price and tax rate
                                var itemTaxPrice = parseFloat((taxRate / 100) * (item.dftPrc * 1));
                                $('.itemTaxPrice').val(itemTaxPrice.toFixed(2));

                                // Update total tax rate and display
                                $('.itemTaxRate').val(taxRate.toFixed(2));

                                // Trigger change event for affected fields
                                $('.itemTaxRate, .discount, .itemTaxPrice,.taxes,.amount').trigger(
                                    'change');

                                // Calculate amount
                                var amount = parseFloat(item.dftPrc);
                                // Update subtotal field
                                $('.amount').html(amount.toFixed(2));

                                // Calculate subtotal
                                var subtotal = parseFloat(item.dftPrc);
                                // Update subtotal field
                                $('.subTotal').html(subtotal.toFixed(2));

                                // Calculate total amount
                                var totalAmount = subtotal + parseFloat(itemTaxPrice);
                                // Update total amount field
                                $('.totalAmount').html(totalAmount.toFixed(2));

                                // Update total tax field
                                $('.totalTax').html(itemTaxPrice.toFixed(2));
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
        });



        $(document).on('keyup change', '.quantity', function() {
            var el = $(this).closest('.row'); 
            var quantity = parseFloat($(this).val());
            var price = parseFloat($(el.find('.unitPrice')).val());
            var discount = parseFloat($(el.find('.discount')).val()) ||
                0; // Use default value if discount is not provided
            var totalItemPrice = (quantity * price) - discount;
            var itemTaxRate = parseFloat($(el.find('.itemTaxRate')).val());
            var itemTaxPrice = parseFloat((itemTaxRate / 100) * totalItemPrice);
            $(el.find('.itemTaxPrice')).val(itemTaxPrice.toFixed(2));

            // Calculate total amount including tax
            var totalAmount = itemTaxPrice + totalItemPrice;
            $(el.find('.amount')).html(totalAmount.toFixed(2));

            // Update total tax price
            var totalItemTaxPrice = 0;
            $('.itemTaxPrice').each(function() {
                totalItemTaxPrice += parseFloat($(this).val());
            });
            $('.totalTax').html(totalItemTaxPrice.toFixed(2));

            // Update subtotal and total amount
            var totalItemPrice = 0;
            $('.quantity').each(function(index) {
                totalItemPrice += parseFloat($('.unitPrice').eq(index).val()) * parseFloat($(this).val());
            });
            $('.subTotal').html(totalItemPrice.toFixed(2));
            $('.totalAmount').html((totalItemPrice + totalItemTaxPrice).toFixed(2));
        });



        $(document).on('keyup change', '.unitPrice', function() {
            var el = $(this).closest('.row'); // Use closest() to find the closest ancestor with class 'row'
            var price = parseFloat($(this).val());
            var quantity = parseFloat($(el.find('.quantity')).val());
            var discount = parseFloat($(el.find('.discount')).val()) ||
                0; // Use default value if discount is not provided
            var totalItemPrice = (quantity * price) - discount;

            var itemTaxRate = parseFloat($(el.find('.itemTaxRate')).val());
            var itemTaxPrice = parseFloat((itemTaxRate / 100) * totalItemPrice);
            $(el.find('.itemTaxPrice')).val(itemTaxPrice.toFixed(2));

            // Calculate total amount including tax
            var totalAmount = itemTaxPrice + totalItemPrice;
            $(el.find('.amount')).html(totalAmount.toFixed(2));

            // Update total tax price
            var totalItemTaxPrice = 0;
            $('.itemTaxPrice').each(function() {
                totalItemTaxPrice += parseFloat($(this).val());
            });
            $('.totalTax').html(totalItemTaxPrice.toFixed(2));

            // Update subtotal and total amount
            var totalItemPrice = 0;
            $('.quantity').each(function(index) {
                totalItemPrice += parseFloat($('.unitPrice').eq(index).val()) * parseFloat($(this).val());
            });
            $('.subTotal').html(totalItemPrice.toFixed(2));
            $('.totalAmount').html((totalItemPrice + totalItemTaxPrice).toFixed(2));
        });


       $(document).on('keyup change', '.discount', function() {
    var el = $(this).closest('.row');
    var discountRate = parseFloat($(this).val()) || 0; 

    var price = parseFloat($(el.find('.unitPrice')).val());
    var quantity = parseFloat($(el.find('.quantity')).val());

    var totalItemPrice = (price * quantity) * (1 - discountRate / 100);
    var itemTaxRate = parseFloat($(el.find('.itemTaxRate')).val());
    var itemTaxPrice = parseFloat((itemTaxRate / 100) * totalItemPrice);
    $(el.find('.itemTaxPrice')).val(itemTaxPrice.toFixed(2));

    var totalAmount = itemTaxPrice + totalItemPrice;
    $(el.find('.amount')).html(totalAmount.toFixed(2));

    // Update total tax price
    var totalItemTaxPrice = 0;
    $('.itemTaxPrice').each(function() {
        totalItemTaxPrice += parseFloat($(this).val());
    });
    $('.totalTax').html(totalItemTaxPrice.toFixed(2));

    // Update subtotal and total amount
    var totalItemPrice = 0;
    $('.quantity').each(function(index) {
        totalItemPrice += parseFloat($('.unitPrice').eq(index).val()) * parseFloat($(this).val());
    });
    $('.subTotal').html(totalItemPrice.toFixed(2));

    // Update total discount
    var totalItemDiscountPrice = 0;
    $('.discount').each(function() {
        totalItemDiscountPrice += parseFloat($(this).val()) || 0;
    });
    $('.totalDiscount').html(totalItemDiscountPrice.toFixed(2));
    // Update Discount Amount input field
    $('.discountAmt').val(totalItemDiscountPrice.toFixed(2));

    // Update total amount
    var totalAmount = totalItemPrice + totalItemTaxPrice;
    $('.totalAmount').html(totalAmount.toFixed(2));
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
    <div class="row">
        {{ Form::open(['url' => 'purchase', 'class' => 'w-100']) }}
        <div class="col-12">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-4" id="vender-box">
                            {{ Form::label('supplierName', __('Supplier Name'), ['class' => 'form-label']) }}
                            {{ Form::number('supplierName', null, ['class' => 'form-control name-field', 'required' => 'required']) }}
                        </div>
                        <div class="form-group col-md-4" id="vender-box">
                            {{ Form::label('supplierTin', __('Supplier Tin'), ['class' => 'form-label']) }}
                            {{ Form::text('supplierTin', null, ['class' => 'form-control tin-field', 'required' => 'required']) }}
                        </div>
                        <div class="form-group col-md-4" id="vender-box">
                            {{ Form::label('supplierBhfId', __('Supplier BhfId'), ['class' => 'form-label']) }}
                            {{ Form::number('supplierBhfId', null, ['class' => 'form-control bhfid-field', 'required' => 'required']) }}
                        </div>
                        <div class="form-group col-md-4" id="vender-box">
                            {{ Form::label('supplierInvNo', __('Supplier Invoice No'), ['class' => 'form-label']) }}
                            {{ Form::number('supplierInvNo', null, ['class' => 'form-control invno-field', 'required' => 'required']) }}
                        </div>
                        <div class="form-group col-md-4" id="vender-box">
                            {{ Form::label('purchTypeCode', __('Purchase Type Code'), ['class' => 'form-label']) }}
                            {{ Form::select('purchTypeCode', $purchaseTypeCodes, null, ['class' => 'form-control select2 purchTypeCode', 'required' => 'required']) }}
                        </div>
                        <div class="form-group col-md-4" id="vender-box">
                            {{ Form::label('purchStatusCode', __('Purchase Status Code'), ['class' => 'form-label']) }}
                            {{ Form::select('purchStatusCode', $purchaseStatusCodes, null, ['class' => 'form-control select2 purchStatusCode', 'required' => 'required']) }}
                        </div>
                        <div class="form-group col-md-4" id="vender-box">
                            {{ Form::label('pmtTypeCode', __('Payment Type Code'), ['class' => 'form-label']) }}
                            {{ Form::select('pmtTypeCode', $paymentTypeCodes, null, ['class' => 'form-control select2 pmtTypeCode', 'required' => 'required']) }}
                        </div>
                        <div class="form-group col-md-4" id="vender-box">
                            {{ Form::label('category', __('Category'), ['class' => 'form-label']) }}
                            {{ Form::select('category', $category, null, ['class' => 'form-control select2 category', 'required' => 'required']) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('purchDate', __('Purchase Date'), ['class' => 'form-label']) }}
                            {{ Form::date('purchDate', null, ['class' => 'form-control', 'required' => 'required']) }}
                        </div>

                        <div class="form-group col-md-3">
                            {{ Form::label('purchase_number', __('Purchase Number'), ['class' => 'form-label']) }}
                            <input type="text" class="form-control" value="{{ $purchase_number }}" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('occurredDate', __('Occurred Date'), ['class' => 'form-label']) }}
                            {{ Form::date('occurredDate', null, ['class' => 'form-control', 'required' => 'required']) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('confirmDate', __('Confirm Date'), ['class' => 'form-label']) }}
                            {{ Form::date('confirmDate', null, ['class' => 'form-control', 'required' => 'required']) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('warehouseDate', __('Warehouse Date'), ['class' => 'form-label']) }}
                            {{ Form::date('warehouseDate', null, ['class' => 'form-control', 'required' => 'required']) }}
                        </div>
                        <div class="form-group col-md-4" id="vender-box">
                            {{ Form::label('warehouse', __('Ware House'), ['class' => 'form-label']) }}
                            {{ Form::select('warehouse', $warehouse, null, ['class' => 'form-control select2 warehouse', 'required' => 'required']) }}
                        </div>
                        <div class="form-group col-md-6" id="vender-box">
                            {{ Form::label('mapping', __('Mapping'), ['class' => 'form-label']) }}
                            {{ Form::text('mapping', null, ['class' => 'form-control invno-field']) }}
                        </div>
                        <div class="form-group col-md-6" id="vender-box">
                            {{ Form::label('remark', __('Remark'), ['class' => 'form-label']) }}
                            {{ Form::textarea('remark', null, ['class' => 'form-control item_standard_name', 'rows' => '2', 'placeholder' => __('Remark')]) }}
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
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table mb-0" data-repeater-list="items" id="sortable-table">
                            <thead>
                            </thead>
                            <tbody class="ui-sortable" data-repeater-item>
                                <tr>
                                    <td width="25%" class="form-group pt-1">
                                        {{ Form::label('itemCode', __('Item Code'), ['class' => 'form-label']) }}
                                        {{ Form::select('itemCode', $product_services_Codes, '', ['class' => 'form-control select2 itemCode', 'data-url' => route('productservice.getiteminformation'), 'required' => 'required']) }}

                                    </td>
                                    <td>
                                        {{ Form::label('item_standard_name', __('Item Standard Name'), ['class' => 'form-label']) }}
                                        {{ Form::text('item_standard_name', null, ['class' => 'form-control item_standard_name', 'required' => 'required']) }}
                                    </td>

                                    <td>
                                        {{ Form::label('supplritemClsCode', __('Supplier Item Cls Code'), ['class' => 'form-label']) }}
                                        {{ Form::text('supplieritemClsCode', null, ['class' => 'form-control', 'required' => 'required']) }}
                                    </td>
                                    <td>
                                        {{ Form::label('supplierItemCode', __('Supplier Item Code'), ['class' => 'form-label']) }}
                                        {{ Form::text('supplrItemCode', null, ['class' => 'form-control supplierItemCode', 'required' => 'required']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {{ Form::label('quantity', __('Quantity'), ['class' => 'form-label']) }}
                                        {{ Form::number('quantity', null, ['class' => 'form-control quantity', 'required' => 'required', 'placeholder' => __('Quantity'), 'required' => 'required']) }}
                                    </td>

                                    <td>
                                        {{ Form::label('unitPrice', __('Unit Price'), ['class' => 'form-label']) }}
                                        {{ Form::number('unitPrice', null, ['class' => 'form-control unitPrice', 'required' => 'required', 'placeholder' => __('unitPrice'), 'required' => 'required']) }}

                                    </td>
                                    <td>
                                        {{ Form::label('pkgQuantity', __('Pkg Quantity Code'), ['class' => 'form-label']) }}
                                        {{ Form::text('pkgQuantity', null, ['class' => 'form-control pkgQuantity', 'required' => 'required']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {{ Form::label('discount', __('Discount Rate (%)'), ['class' => 'form-label']) }}
                                        {{ Form::number('discount', null, ['class' => 'form-control discount', 'required' => 'required']) }}
                                    </td>
                                    <td>
                                        {{ Form::label('discount', __('Discount Amount'), ['class' => 'form-label']) }}
                                        {{ Form::text('discount', null, ['class' => 'form-control discountAmt', 'required' => 'required']) }}
                                    </td>
                                    <td>
                                        {{ Form::label('itemExprDt', __('item Expire Date'), ['class' => 'form-label']) }}
                                        {{ Form::date('itemExprDt', null, ['class' => 'form-control itemExprDt', 'required' => 'required']) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td>

                                        <div class="form-group">
                                            {{ Form::label('tax', __('Tax'), ['class' => 'form-label']) }}
                                            {{ Form::text('tax', '', ['class' => 'form-control tax']) }}
                                    </td>
                                    <td>
                                        {{ Form::label('itemtaxprice', __('Item Tax Price'), ['class' => 'form-label']) }}
                                        {{ Form::text('itemTaxPrice', '', ['class' => 'form-control itemTaxPrice']) }}
                                    </td>
                                    <td>
                                        {{ Form::label('itemtaxrate', __('Item Tax Rate'), ['class' => 'form-label']) }}
                                        {{ Form::text('itemTaxRate', '', ['class' => 'form-control itemTaxRate']) }}
                                    </td>
                                    <td colspan="2">
                                        {{ Form::label('Country_of_origin', __('Origin Nation Code'), ['class' => 'form-label']) }}
                                        {{ Form::text('orgnNatCd', null, ['class' => 'form-control country_of_origin', 'rows' => '2', 'placeholder' => __('Country of Origin')]) }}
                                    </td>
                                    <td colspan="5"></td>

                                    <td>
                                        <a href="#"
                                            class="ti ti-trash text-white text-white repeater-action-btn bg-danger ms-2"
                                            data-repeater-delete></a>
                                    </td>
                                </tr>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td></td>
                                    <td><strong>{{ __('Amount') }} <br><small
                                                class="text-danger font-weight-bold">{{ __('after  Tax & discount') }}</small>
                                            ({{ \Auth::user()->currencySymbol() }})</strong></td>
                                    <td class="text-end amount">0.00</td>
                                    <td></td>
                                    <td></td>
                                </tr>
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
                                    <td class="blue-text text-end totalAmount">0.00</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <input type="button" value="{{ __('Cancel') }}" onclick="location.href = '{{ route('purchase.index') }}';"
                class="btn btn-light">
            <input type="submit" value="{{ __('Create') }}" class="btn  btn-primary">
        </div>
        {{ Form::close() }}
    </div>
@endsection
