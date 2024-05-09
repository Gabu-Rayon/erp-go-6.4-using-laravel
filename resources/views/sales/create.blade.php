@extends('layouts.admin')
@section('page-title')
    {{ __('Add Sale') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('sales.index') }}">{{ __('Sales') }}</a></li>
    <li class="breadcrumb-item">{{ __('Add Sale') }}</li>
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
        var totalPrice = unitPrice * quantity;

        // Calculate the discounted price
        var discountedPrice = totalPrice * (1 - discountRate);

        // Calculate the discount amount
        var discountAmount = totalPrice - discountedPrice;

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

            $(document).on('keyup change', '.customerName', async function() {
                var customer_id = $(this).val();
                var url = `http://localhost:8000/getcustomer/${customer_id}`;
                const response = await fetch(url);
                const { data } = await response.json();

                console.log(data);

                if (data) {
                    $('.customerTin').val(data.customerTin);
                    $('.customerNo').val(data.customerNo);
                    $('.customerMobileNo').val(data.contact);
                }
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
    <div class="row">
        {{ Form::open(['url' => 'sales', 'class' => 'w-100']) }}
        <div class="col-12">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-3">
                            {{ Form::label('customerName', __('Customer Name (*)'), ['class' => 'form-label']) }}
                            {{ Form::select('customerName', $customers, null, ['class' => 'form-control customerName', 'required' => 'required']) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('customerTin', __('Customer Tin (*)'),['class'=>'form-label']) }}
                            {{ Form::text('customerTin', '', array('class' => 'form-control customerTin', 'required' => 'required', 'readonly' => true)) }}
                        </div> 
                        <div class="form-group col-md-3">
                            {{ Form::label('customerNo', __('Customer Number'),['class'=>'form-label']) }}
                            {{ Form::text('customerNo', '', array('class' => 'form-control customerNo', 'readonly' => true)) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('customerMobileNo', __('Customer Mobile Number'),['class'=>'form-label']) }}
                            {{ Form::text('customerMobileNo', '', array('class' => 'form-control customerMobileNo', 'readonly' => true)) }}
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
                            {{ Form::label('traderInvoiceNo', __('Trader Invoive No (*)'), ['class' => 'form-label']) }}
                            {{ Form::text('traderInvoiceNo', '', array('class' => 'form-control traderInvoiceNo', 'required' => true)) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('confirmDate', __('Confirm Date (*)'),['class'=>'form-label']) }}
                            {{ Form::datetime('confirmDate', '', array('class' => 'form-control', 'required' => 'required')) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('salesDate', __('Sales Date (*)'),['class'=>'form-label']) }}
                            {{ Form::date('salesDate', '', array('class' => 'form-control', 'required' => 'required')) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('stockReleseDate', __('Stock Release Date'),['class'=>'form-label']) }}
                            {{ Form::datetime('stockReleseDate', '', array('class' => 'form-control')) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('receiptPublishDate', __('Receipt Publish Date (*)'),['class'=>'form-label']) }}
                            {{ Form::datetime('receiptPublishDate', '', array('class' => 'form-control', 'required' => 'required')) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('occurredDate', __('Occurred Date (*)'),['class'=>'form-label']) }}
                            {{ Form::date('occurredDate', '', array('class' => 'form-control', 'required' => 'required')) }}
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
                            {{ Form::label('mapping', __('Mapping'),['class'=>'form-label']) }}
                            {{ Form::text('mapping', '', array('class' => 'form-control')) }}
                        </div>
                        <div class="form-group col-md-12">
                            {{ Form::label('remark', __('Remark'),['class'=>'form-label']) }}
                            {{ Form::textarea('remark', '', array('class' => 'form-control', 'rows' => '3')) }}
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
                            <tbody class="ui-sortable" data-repeater-item data-clone>
                                <tr class="row p-3">
                                    <td class="form-group col-md-4">
                                        {{ Form::label('itemCode', __('Item (*)'), ['class' => 'form-label']) }}
                                        {{ Form::select('itemCode', $items, null, ['class' => 'form-control itemCode', 'required' => 'required']) }}
                                    </td>
                                    <td class="form-group col-md-4">
                                        {{ Form::label('itemClassCode', __('Item Quantity'),['class'=>'form-label']) }}
                                        {{ Form::text('itemClassCode', '', array('class' => 'form-control itemClassCode', 'readonly' => true)) }}
                                    </td>
                                    <td class="form-group col-md-4">
                                        {{ Form::label('itemTypeCode', __('Item Type Code'),['class'=>'form-label']) }}
                                        {{ Form::text('itemTypeCode', '', array('class' => 'form-control itemTypeCode', 'readonly' => true)) }}
                                    </td>
                                    <td class="form-group col-md-4">
                                        {{ Form::label('itemName', __('Item Name'),['class'=>'form-label']) }}
                                        {{ Form::text('itemName', '', array('class' => 'form-control itemName', 'readonly' => true)) }}
                                    </td>
                                    <td class="form-group col-md-4">
                                        {{ Form::label('orgnNatCd', __('Origin Nation Code'),['class'=>'form-label']) }}
                                        {{ Form::text('orgnNatCd', '', array('class' => 'form-control orgnNatCd', 'readonly' => true)) }}
                                    </td>
                                    <td class="form-group col-md-4">
                                        {{ Form::label('taxTypeCode', __('Tax Type Code'),['class'=>'form-label']) }}
                                        {{ Form::text('taxTypeCode', '', array('class' => 'form-control taxTypeCode', 'readonly' => true)) }}
                                    </td>
                                    <td class="form-group col-md-4">
                                        {{ Form::label('unitPrice', __('Unit Price (*)'),['class'=>'form-label']) }}
                                        {{ Form::number('unitPrice', '', array('class' => 'form-control unitPrice', 'required' => 'required')) }}
                                    </td>
                                    <td class="form-group col-md-4">
                                        {{ Form::label('isrcAplcbYn', __('ISRCAPLCBYN?'),['class'=>'form-label']) }}
                                        {{ Form::select('isrcAplcbYn', ['true' => 'Yes', 'false' => 'No'], null, ['class' => 'form-control isrcAplcbYn']) }}
                                    </td>
                                    <td class="form-group col-md-4">
                                        {{ Form::label('pkgUnitCode', __('Package Unit Code'),['class'=>'form-label']) }}
                                        {{ Form::text('pkgUnitCode', '', array('class' => 'form-control pkgUnitCode', 'readonly' => true)) }}
                                    </td>
                                    <td class="form-group col-md-4">
                                        {{ Form::label('pkgQuantity', __('Package Quantity (*)'),['class'=>'form-label']) }}
                                        {{ Form::number('pkgQuantity', '', array('class' => 'form-control pkgQuantity', 'required' => 'required')) }}
                                    </td>
                                    <td class="form-group col-md-4">
                                        {{ Form::label('qtyUnitCd', __('Quantity Unit Code'),['class'=>'form-label']) }}
                                        {{ Form::text('qtyUnitCd', '', array('class' => 'form-control qtyUnitCd', 'readonly' => true)) }}
                                    </td>
                                    <td class="form-group col-md-4">
                                        {{ Form::label('quantity', __('Quantity (*)'),['class'=>'form-label']) }}
                                        {{ Form::number('quantity', '', array('class' => 'form-control quantity', 'required' => 'required')) }}
                                    </td>
                                    <td class="form-group col-md-4">
                                        {{ Form::label('discountRate', __('Discount Rate'),['class'=>'form-label']) }}
                                        {{ Form::number('discountRate', '', array('class' => 'form-control discountRate', 'required' => 'required')) }}
                                    </td>
                                    <td class="form-group col-md-4">
                                        {{ Form::label('discountAmt', __('Discount Amount'),['class'=>'form-label']) }}
                                        {{ Form::number('discountAmt', '', array('class' => 'form-control discountAmt', 'readonly' => true)) }}
                                    </td>
                                    <td class="form-group col-md-4">
                                        {{ Form::label('itemExprDate', __('Item Expiry Date'),['class'=>'form-label']) }}
                                        {{Form::date('itemExprDate',null,array('class'=>'form-control'))}}
                                    </td>
                                    <td class="ti ti-trash text-white text-white repeater-action-btn bg-danger ms-2" data-repeater-delete></td>
                                </tr>
                            </tbody>
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
