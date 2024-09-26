@extends('layouts.admin')
@section('page-title')
    {{ __('Move Stock') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('branch.transfer.index') }}">{{ __('Stock Move List') }}</a></li>
    <li class="breadcrumb-item">{{ __('Move Stock') }}</li>
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
                var url = $(this).data('url');
                var el = $(this).closest('[data-clone]');

                if (el.length) {
                    console.log("Change event triggered for.itemCode[data-clone]");

                    console.log("item_id:", item_id);
                    console.log("url:", url);
                    console.log("el:", el);

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
                                        console.log(
                                            "Item object is not empty. Populating fields..."
                                        );

                                        // Populate fields only for the current cloned form
                                        console.log("Populating unitPrice:", item.dftPrc);
                                        el.find('.unitPrice').val(item.dftPrc);


                                        console.log("Populating tax:", item.taxTyCd);
                                        el.find('.tax').val(item.taxTyCd);

                                        console.log("Populating itemClsCd:", item
                                            .itemClsCd);
                                        el.find('.itemClsCd').val(item.itemClsCd);

                                        console.log("Populating itemNm:", item
                                            .itemNm);
                                        el.find('.itemNm').val(item.itemNm);

                                        console.log("Populating Bcd:", item
                                            .bcd);
                                        el.find('.bcd').val(item.bcd);

                                        console.log("Populating PkgUnitCd:", item
                                            .pkgUnitCd);
                                        el.find('.pkgUnitCd').val(item.pkgUnitCd);

                                        // Calculate tax based on taxTyCd
                                        var taxTyCd = item.taxTyCd;
                                        var taxRate = 0;

                                        if (taxTyCd === 'B') {
                                            taxRate = 16; // VAT 16%
                                        } else if (taxTyCd === 'E') {
                                            taxRate = 8; // VAT 8%
                                        }

                                        // Calculate item tax price based on unit price and tax rate
                                        var itemTaxPrice = parseFloat((taxRate / 100) * (item
                                            .dftPrc * 1));
                                        el.find('.itemTaxPrice').val(itemTaxPrice.toFixed(2));

                                        // Update total tax rate and display
                                        el.find('.itemTaxRate').val(taxRate.toFixed(2));

                                        // Trigger change event for affected fields
                                        el.find(
                                                '.itemTaxRate,.discount,.itemTaxPrice,.taxes,.amount'
                                            )
                                            .trigger('change');


                                        // Calculate item tax price based on unit price and tax rate
                                        var itemTaxPrice = parseFloat((taxRate / 100) * (item
                                            .dftPrc * 1));
                                        el.find('.itemTaxPrice').val(itemTaxPrice.toFixed(2));

                                        // Update total tax rate and display
                                        el.find('.itemTaxRate').val(taxRate.toFixed(2));

                                        // Trigger change event for affected fields
                                        $('.itemTaxRate, .discount, .itemTaxPrice,.taxes,.amount')
                                            .trigger(
                                                'change');

                                        // Calculate amount
                                        var amount = parseFloat(item.dftPrc);
                                        // Update total tax rate and display
                                        el.find('.amount').val(taxRate.toFixed(2));

                                        // Calculate subtotal
                                        var subtotal = parseFloat(item.dftPrc);
                                        // Update subtotal field
                                        el.find('.subTotal').val(subtotal.toFixed(2));

                                        // Calculate total amount
                                        var totalAmount = subtotal + parseFloat(itemTaxPrice);
                                        // Update total amount field
                                        el.find('.totalAmount').val(totalAmount.toFixed(2));

                                        // Update total tax field
                                        el.find('.totalTax').val(itemTaxPrice.toFixed(2));
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
            $(document).on('keyup change', '.quantity', function() {
                // var el = $(this).closest('.row');
                var el = $(this).closest('[data-clone]');
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
                el.siblings().find('.itemTaxPrice').each(function() {
                    totalItemTaxPrice += parseFloat($(this).val());
                });
                el.parent().find('.totalTax').html(totalItemTaxPrice.toFixed(2));

                // Update subtotal and total amount
                var totalItemPrice = 0;
                el.siblings().find('.quantity').each(function(index) {
                    totalItemPrice += parseFloat($('.unitPrice').eq(index).val()) * parseFloat($(
                        this).val());
                });
                el.parent().find('.subTotal').html(totalItemPrice.toFixed(2));
                var totalAmount = totalItemPrice + totalItemTaxPrice;
                el.parent().find('.totalAmount').html(totalAmount.toFixed(2));
            });

            $(document).on('keyup change', '.unitPrice', function() {
                // var el = $(this).closest('.row'); 
                var el = $(this).closest('[data-clone]');
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

                // Update subtotal and total amount
                var totalItemPrice = 0;
                el.siblings().find('.quantity').each(function(index) {
                    totalItemPrice += parseFloat($('.unitPrice').eq(index).val()) * parseFloat($(
                        this).val());
                });
                el.parent().find('.subTotal').html(totalItemPrice.toFixed(2));
                var totalItemTaxPrice = 0;
                el.siblings().find('.itemTaxPrice').each(function() {
                    totalItemTaxPrice += parseFloat($(this).val());
                });
                var totalAmount = totalItemPrice + totalItemTaxPrice;
                el.parent().find('.totalAmount').html(totalAmount.toFixed(2));
            });

            $(document).on('keyup change', '.discount', function() {
                var el = $(this).closest('[data-clone]'); // Find the closest clone form
                var discountRate = parseFloat($(this).val()) || 0;

                var price = parseFloat(el.find('.unitPrice').val());
                var quantity = parseFloat(el.find('.quantity').val());

                var totalItemPrice = (price * quantity) * (1 - discountRate / 100);
                var itemTaxRate = parseFloat(el.find('.itemTaxRate').val());
                var itemTaxPrice = parseFloat((itemTaxRate / 100) * totalItemPrice);
                el.find('.itemTaxPrice').val(itemTaxPrice.toFixed(2));

                var totalAmount = itemTaxPrice + totalItemPrice;
                el.find('.amount').html(totalAmount.toFixed(2));

                // Update total tax price
                var totalItemTaxPrice = 0;
                el.siblings().find('.itemTaxPrice').each(function() { // Find itemTaxPrice only in siblings
                    totalItemTaxPrice += parseFloat($(this).val());
                });
                el.parent().find('.totalTax').html(totalItemTaxPrice.toFixed(2));

                // Update subtotal and total amount
                var totalItemPrice = 0;
                el.siblings().find('.quantity').each(function(index) {
                    totalItemPrice += parseFloat(el.siblings().find('.unitPrice').eq(index).val()) *
                        parseFloat($(this).val());
                });
                el.parent().find('.subTotal').html(totalItemPrice.toFixed(2));

                // Calculate total discount amount
                var totalDiscountAmount = 0;
                el.closest('[data-clone]').find('.quantity').each(function(index) {
                    var discountRate = parseFloat($(this).closest('[data-clone]').find('.discount')
                        .eq(index).val()) || 0;
                    totalDiscountAmount += (parseFloat($(this).closest('[data-clone]').find(
                            '.unitPrice').eq(index).val()) *
                        parseFloat($(this).val())) * (discountRate / 100);
                });

                // Update total discount and Discount Amount input field for the closest cloned form
                el.parent().find('.totalDiscount').html(totalDiscountAmount.toFixed(2));
                el.closest('[data-clone]').find('.discountAmt').val(totalDiscountAmount.toFixed(2));

                // Update total amount
                var totalAmount = totalItemPrice + totalItemTaxPrice;
                el.parent().find('.totalAmount').html(totalAmount.toFixed(2));
            });

            // Initialize Select2 for all select elements with the class 'select2'
            $('.select2').select2({
                templateResult: function(data) {
                    var $option = $(data.element);
                    return $option.data('text') || data.text;
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
        {{ Form::open(['url' => 'stockmove', 'class' => 'w-100']) }}
        <div class="col-12">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-4">
                            {{ Form::label('branchId', __('Branch From(*)'), ['class' => 'form-label']) }}
                            {{ Form::select('branchFrom', $branches, null, ['class' => 'form-control select2']) }}
                        </div>
                        <div class="form-group col-md-4">
                            {{ Form::label('branchId', __('Branch To (*)'), ['class' => 'form-label']) }}
                            {{ Form::select('branchTo', $branches, null, ['class' => 'form-control select2']) }}
                        </div>
                        <div class="form-group col-md-4">
                            {{ Form::label('occurredDate', __('Occurred Date(*)'),['class'=>'form-label']) }}
                            {{ Form::date('occurredDate', null, ['class' => 'form-control select2']) }}
                        </div>
                        {{-- <div class="form-group col-md-4">
                            {{ Form::label('releaseType', __('Stored / Release Type (*)'),['class'=>'form-label']) }}
                            {{ Form::select('releaseType', $releaseTypes, null, ['class' => 'form-control select2']) }}
                        </div> --}}
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
                                <tr>
                                    <td class="form-group col-md-4">
                                        {{ Form::label('item', __('Item'), ['class' => 'form-label']) }}
                                        {{ Form::select('itemCode', $items, null, ['class' => 'form-control select2']) }}
                                    </td>
                                    <td class="form-group col-md-4">
                                        {{ Form::label('quantity', __('Quantity'),['class'=>'form-label']) }}
                                        {{ Form::text('quantity', '', array('class' => 'form-control', 'required' => 'required')) }}
                                    </td>
                                    <td class="form-group col-md-4">
                                        {{ Form::label('pkgQuantity', __('PackageQuantity'),['class'=>'form-label']) }}
                                        {{ Form::text('pkgQuantity', '', array('class' => 'form-control', 'required' => 'required')) }}
                                    </td>
                                    <td class="ti ti-trash text-white repeater-action-btn bg-danger ms-2" data-repeater-delete></td>
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
