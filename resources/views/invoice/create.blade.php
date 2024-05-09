@extends('layouts.admin')
@section('page-title')
    {{__('Invoice Create')}}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('invoice.index')}}">{{__('Invoice')}}</a></li>
    <li class="breadcrumb-item">{{__('Invoice Create')}}</li>
@endsection
@push('script-page')
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('js/jquery.repeater.min.js')}}"></script>
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
                show: function () {
                    $(this).slideDown();
                },
                hide: function (deleteElement) {
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
                ready: function (setIndexes) {

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

        $(document).on('change', '#customer', function () {
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
                success: function (data) {
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

        $(document).on('click', '#remove', function () {
            $('#customer-box').removeClass('d-none');
            $('#customer-box').addClass('d-block');
            $('#customer_detail').removeClass('d-block');
            $('#customer_detail').addClass('d-none');
        })

        $(document).on('change', '.item', function () {

            var iteams_id = $(this).val();
            var url = $(this).data('url');
            var el = $(this);

            $.ajax({
                url: url,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': jQuery('#token').val()
                },
                data: {
                    'product_id': iteams_id
                },
                cache: false,
                success: function (data) {
                    var item = JSON.parse(data);
                    console.log(el.parent().parent().find('.quantity'))
                    $(el.parent().parent().find('.quantity')).val(1);
                    $(el.parent().parent().find('.price')).val(item.product.sale_price);
                    $(el.parent().parent().parent().find('.pro_description')).val(item.product.description);
                    // $('.pro_description').text(item.product.description);

                    var taxes = '';
                    var tax = [];

                    var totalItemTaxRate = 0;

                    if (item.taxes == 0) {
                        taxes += '-';
                    } else {
                        for (var i = 0; i < item.taxes.length; i++) {
                            taxes += '<span class="badge bg-primary mt-1 mr-2">' + item.taxes[i].name + ' ' + '(' + item.taxes[i].rate + '%)' + '</span>';
                            tax.push(item.taxes[i].id);
                            totalItemTaxRate += parseFloat(item.taxes[i].rate);
                        }
                    }
                    var itemTaxPrice = parseFloat((totalItemTaxRate / 100)) * parseFloat((item.product.sale_price * 1));
                    $(el.parent().parent().find('.itemTaxPrice')).val(itemTaxPrice.toFixed(2));
                    $(el.parent().parent().find('.itemTaxRate')).val(totalItemTaxRate.toFixed(2));
                    $(el.parent().parent().find('.taxes')).html(taxes);
                    $(el.parent().parent().find('.tax')).val(tax);
                    $(el.parent().parent().find('.unit')).html(item.unit);
                    $(el.parent().parent().find('.discount')).val(0);

                    var inputs = $(".amount");
                    var subTotal = 0;
                    for (var i = 0; i < inputs.length; i++) {
                        subTotal = parseFloat(subTotal) + parseFloat($(inputs[i]).html());
                    }

                    var totalItemPrice = 0;
                    var priceInput = $('.price');
                    for (var j = 0; j < priceInput.length; j++) {
                        totalItemPrice += parseFloat(priceInput[j].value);
                    }

                    var totalItemTaxPrice = 0;
                    var itemTaxPriceInput = $('.itemTaxPrice');
                    for (var j = 0; j < itemTaxPriceInput.length; j++) {
                        totalItemTaxPrice += parseFloat(itemTaxPriceInput[j].value);
                        $(el.parent().parent().find('.amount')).html(parseFloat(item.totalAmount)+parseFloat(itemTaxPriceInput[j].value));
                    }

                    var totalItemDiscountPrice = 0;
                    var itemDiscountPriceInput = $('.discount');

                    for (var k = 0; k < itemDiscountPriceInput.length; k++) {

                        totalItemDiscountPrice += parseFloat(itemDiscountPriceInput[k].value);
                    }

                    $('.subTotal').html(totalItemPrice.toFixed(2));
                    $('.totalTax').html(totalItemTaxPrice.toFixed(2));
                    $('.totalAmount').html((parseFloat(totalItemPrice) - parseFloat(totalItemDiscountPrice) + parseFloat(totalItemTaxPrice)).toFixed(2));


                },
            });
        });

        $(document).on('keyup', '.quantity', function () {
            var quntityTotalTaxPrice = 0;

            var el = $(this).parent().parent().parent().parent();

            var quantity = $(this).val();
            var price = $(el.find('.price')).val();
            var discount = $(el.find('.discount')).val();
            if(discount.length <= 0)
            {
                discount = 0 ;
            }

            var totalItemPrice = (quantity * price) - discount;

            var amount = (totalItemPrice);


            var totalItemTaxRate = $(el.find('.itemTaxRate')).val();
            var itemTaxPrice = parseFloat((totalItemTaxRate / 100) * (totalItemPrice));
            $(el.find('.itemTaxPrice')).val(itemTaxPrice.toFixed(2));

            $(el.find('.amount')).html(parseFloat(itemTaxPrice)+parseFloat(amount));

            var totalItemTaxPrice = 0;
            var itemTaxPriceInput = $('.itemTaxPrice');
            for (var j = 0; j < itemTaxPriceInput.length; j++) {
                totalItemTaxPrice += parseFloat(itemTaxPriceInput[j].value);
            }


            var totalItemPrice = 0;
            var inputs_quantity = $(".quantity");

            var priceInput = $('.price');
            for (var j = 0; j < priceInput.length; j++) {
                totalItemPrice += (parseFloat(priceInput[j].value) * parseFloat(inputs_quantity[j].value));
            }

            var inputs = $(".amount");

            var subTotal = 0;
            for (var i = 0; i < inputs.length; i++) {
                subTotal = parseFloat(subTotal) + parseFloat($(inputs[i]).html());
            }

            $('.subTotal').html(totalItemPrice.toFixed(2));
            $('.totalTax').html(totalItemTaxPrice.toFixed(2));

            $('.totalAmount').html((parseFloat(subTotal)).toFixed(2));

        })

        $(document).on('keyup change', '.price', function () {
            var el = $(this).parent().parent().parent().parent();
            var price = $(this).val();
            var quantity = $(el.find('.quantity')).val();

            var discount = $(el.find('.discount')).val();
            if(discount.length <= 0)
            {
                discount = 0 ;
            }
            var totalItemPrice = (quantity * price)-discount;

            var amount = (totalItemPrice);


            var totalItemTaxRate = $(el.find('.itemTaxRate')).val();
            var itemTaxPrice = parseFloat((totalItemTaxRate / 100) * (totalItemPrice));
            $(el.find('.itemTaxPrice')).val(itemTaxPrice.toFixed(2));

            $(el.find('.amount')).html(parseFloat(itemTaxPrice)+parseFloat(amount));

            var totalItemTaxPrice = 0;
            var itemTaxPriceInput = $('.itemTaxPrice');
            for (var j = 0; j < itemTaxPriceInput.length; j++) {
                totalItemTaxPrice += parseFloat(itemTaxPriceInput[j].value);
            }


            var totalItemPrice = 0;
            var inputs_quantity = $(".quantity");

            var priceInput = $('.price');
            for (var j = 0; j < priceInput.length; j++) {
                totalItemPrice += (parseFloat(priceInput[j].value) * parseFloat(inputs_quantity[j].value));
            }

            var inputs = $(".amount");

            var subTotal = 0;
            for (var i = 0; i < inputs.length; i++) {
                subTotal = parseFloat(subTotal) + parseFloat($(inputs[i]).html());
            }

            $('.subTotal').html(totalItemPrice.toFixed(2));
            $('.totalTax').html(totalItemTaxPrice.toFixed(2));

            $('.totalAmount').html((parseFloat(subTotal)).toFixed(2));


        })

        $(document).on('keyup change', '.discount', function () {
            var el = $(this).parent().parent().parent();
            var discount = $(this).val();
            if(discount.length <= 0)
            {
                discount = 0 ;
            }

            var price = $(el.find('.price')).val();
            var quantity = $(el.find('.quantity')).val();
            var totalItemPrice = (quantity * price) - discount;


            var amount = (totalItemPrice);


            var totalItemTaxRate = $(el.find('.itemTaxRate')).val();
            var itemTaxPrice = parseFloat((totalItemTaxRate / 100) * (totalItemPrice));
            $(el.find('.itemTaxPrice')).val(itemTaxPrice.toFixed(2));

            $(el.find('.amount')).html(parseFloat(itemTaxPrice)+parseFloat(amount));

            var totalItemTaxPrice = 0;
            var itemTaxPriceInput = $('.itemTaxPrice');
            for (var j = 0; j < itemTaxPriceInput.length; j++) {
                totalItemTaxPrice += parseFloat(itemTaxPriceInput[j].value);
            }


            var totalItemPrice = 0;
            var inputs_quantity = $(".quantity");

            var priceInput = $('.price');
            for (var j = 0; j < priceInput.length; j++) {
                totalItemPrice += (parseFloat(priceInput[j].value) * parseFloat(inputs_quantity[j].value));
            }

            var inputs = $(".amount");

            var subTotal = 0;
            for (var i = 0; i < inputs.length; i++) {
                subTotal = parseFloat(subTotal) + parseFloat($(inputs[i]).html());
            }


            var totalItemDiscountPrice = 0;
            var itemDiscountPriceInput = $('.discount');

            for (var k = 0; k < itemDiscountPriceInput.length; k++) {

                totalItemDiscountPrice += parseFloat(itemDiscountPriceInput[k].value);
            }


            $('.subTotal').html(totalItemPrice.toFixed(2));
            $('.totalTax').html(totalItemTaxPrice.toFixed(2));

            $('.totalAmount').html((parseFloat(subTotal)).toFixed(2));
            $('.totalDiscount').html(totalItemDiscountPrice.toFixed(2));




        })

        var customerId = '{{$customerId}}';
        if (customerId > 0) {
            $('#customer').val(customerId).change();
        }
        

    </script>
    <script>
        $(document).on('click', '[data-repeater-delete]', function () {
            $(".price").change();
            $(".discount").change();
        });
    </script>
@endpush
@section('content')
    <div class="row">
        {{ Form::open(array('url' => 'invoice','class'=>'w-100')) }}
        <div class="col-12">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                            <div class="form-group" id="customer-box">
                                {{ Form::label('customer_id', __('Customer'),['class'=>'form-label']) }}
                                {{ Form::select('customer_id', $customers,'', array('class' => 'form-control customer_id select','id'=>'customer','data-url'=>route('invoice.customer'),'required'=>'required')) }}
                            </div>
                            <div id="customer_detail" class="d-none">
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    {{ Form::label('category_id', __('Item (*)'), ['class' => 'form-label']) }}
                                    {{ Form::select('category_id', $category, null, ['class' => 'form-control', 'required' => 'required']) }}
                                </div>
                                <div class="form-group col-md-4">
                                    {{ Form::label('salesType', __('Sales Type'), ['class' => 'form-label']) }}
                                    {{ Form::select('salesType', $salesTypeCodes, null, ['class' => 'form-control']) }}
                                </div>
                                <div class="form-group col-md-4">
                                    {{ Form::label('paymentType', __('Payment Type'), ['class' => 'form-label']) }}
                                    {{ Form::select('paymentType', $paymentTypeCodes, null, ['class' => 'form-control']) }}
                                </div>
                                <div class="form-group col-md-4">
                                    {{ Form::label('traderInvoiceNo', __('Trader Invoive No (*)'), ['class' => 'form-label']) }}
                                    {{ Form::text('traderInvoiceNo', $invoice_number, array('class' => 'form-control', 'required' => true, 'readonly' => 'readonly')) }}
                                </div>
                                <div class="form-group col-md-4">
                                    {{ Form::label('confirmDate', __('Confirm Date (*)'),['class'=>'form-label']) }}
                                    {{ Form::datetime('confirmDate', '', array('class' => 'form-control', 'required' => 'required')) }}
                                </div>
                                <div class="form-group col-md-4">
                                    {{ Form::label('salesDate', __('Sales Date (*)'),['class'=>'form-label']) }}
                                    {{ Form::date('salesDate', '', array('class' => 'form-control', 'required' => 'required')) }}
                                </div>
                                <div class="form-group col-md-4">
                                    {{ Form::label('stockReleseDate', __('Stock Release Date'),['class'=>'form-label']) }}
                                    {{ Form::datetime('stockReleseDate', '', array('class' => 'form-control')) }}
                                </div>
                                <div class="form-group col-md-4">
                                    {{ Form::label('receiptPublishDate', __('Receipt Publish Date (*)'),['class'=>'form-label']) }}
                                    {{ Form::datetime('receiptPublishDate', '', array('class' => 'form-control', 'required' => 'required')) }}
                                </div>
                                <div class="form-group col-md-4">
                                    {{ Form::label('occurredDate', __('Occurred Date (*)'),['class'=>'form-label']) }}
                                    {{ Form::date('occurredDate', '', array('class' => 'form-control', 'required' => 'required')) }}
                                </div>
                                <div class="form-group col-md-4">
                                    {{ Form::label('invoiceStatusCode', __('Invoice Status'), ['class' => 'form-label']) }}
                                    {{ Form::select('invoiceStatusCode', $invoiceStatusCodes, null, ['class' => 'form-control']) }}
                                </div>
                                <div class="form-group col-md-4">
                                    {{ Form::label('isPurchaseAccept', __('Purchase Accepted?'), ['class' => 'form-label']) }}
                                    {{ Form::select('isPurchaseAccept', ['true' => 'Yes', 'false' => 'No'], null, ['class' => 'form-control']) }}
                                </div>
                                <div class="form-group col-md-4">
                                    {{ Form::label('isStockIOUpdate', __('Stock IO Update?'), ['class' => 'form-label']) }}
                                    {{ Form::select('isStockIOUpdate', ['true' => 'Yes', 'false' => 'No'], null, ['class' => 'form-control']) }}
                                </div>
                                <div class="form-group col-md-4">
                                    {{ Form::label('issue_date', __('Issue Date (*)'), ['class' => 'form-label']) }}
                                    {{ Form::date('issue_date', '', array('class' => 'form-control', 'required' => 'required')) }}
                                </div>
                                <div class="form-group col-md-4">
                                    {{ Form::label('send_date', __('Send Date (*)'), ['class' => 'form-label']) }}
                                    {{ Form::date('send_date', '', array('class' => 'form-control', 'required' => 'required')) }}
                                </div>
                                <div class="form-group col-md-4">
                                    {{ Form::label('due_date', __('Due Date (*)'), ['class' => 'form-label']) }}
                                    {{ Form::date('due_date', '', array('class' => 'form-control', 'required' => 'required')) }}
                                </div>
                                <div class="form-group col-md-4">
                                    {{ Form::label('mapping', __('Mapping'),['class'=>'form-label']) }}
                                    {{ Form::text('mapping', '', array('class' => 'form-control')) }}
                                </div>
                                <div class="form-group col-md-4">
                                    {{ Form::label('ref_number', __('Reference Number'),['class'=>'form-label']) }}
                                    {{ Form::text('ref_number', '', array('class' => 'form-control')) }}
                                </div>
                                <div class="form-group col-md-12">
                                    {{ Form::label('remark', __('Remark'),['class'=>'form-label']) }}
                                    {{ Form::textarea('remark', '', array('class' => 'form-control', 'rows' => '3')) }}
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <h5 class=" d-inline-block mb-4">{{__('Product & Services')}}</h5>
            <div class="card repeater">
                <div class="item-section py-2">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-md-12 d-flex align-items-center justify-content-between justify-content-md-end">
                            <div class="all-button-box me-2">
                                <a href="#" data-repeater-create="" class="btn btn-primary" data-bs-toggle="modal" data-target="#add-bank">
                                    <i class="ti ti-plus"></i> {{__('Add item')}}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-border-style mt-2">
                    <div class="table-responsive">
                        <table class="table row  mb-0 table-custom-style" data-repeater-list="items" id="sortable-table">
                            <tbody class="ui-sortable card m-3 col-md-12" data-repeater-item>
                                    <tr class="card-body row">
                                        <td class="form-group col-md-4">
                                            {{ Form::label('itemCode', __('Item (*)'), ['class' => 'form-label']) }}
                                            {{ Form::select('itemCode', $product_services, null, ['class' => 'form-control itemCode', 'required' => 'required']) }}
                                        </td>
                                        <td class="form-group col-md-4">
                                            {{ Form::label('unitPrice', __('Unit Price'),['class'=>'form-label']) }}
                                            {{ Form::number('unitPrice', '', array('class' => 'form-control', 'required' => true)) }}
                                        </td>
                                        <td class="form-group col-md-4">
                                            {{ Form::label('pkgQuantity', __('Package Quantity'),['class'=>'form-label']) }}
                                            {{ Form::number('pkgQuantity', '', array('class' => 'form-control', 'required' => true)) }}
                                        </td>
                                        <td class="form-group col-md-4">
                                            {{ Form::label('quantity', __('Quantity'),['class'=>'form-label']) }}
                                            {{ Form::number('quantity', '', array('class' => 'form-control', 'required' => true)) }}
                                        </td>
                                        <td class="form-group col-md-4">
                                            {{ Form::label('discountRate', __('Discount Rate'),['class'=>'form-label']) }}
                                            {{ Form::number('discountRate', '', array('class' => 'form-control')) }}
                                        </td>
                                        <td class="form-group col-md-4">
                                            {{ Form::label('tax', __('Tax (*)'), ['class' => 'form-label']) }}
                                            {{ Form::select('tax', $taxationtype, null, ['class' => 'form-control', 'required' => 'required']) }}
                                        </td>
                                        <td class="form-group col-md-12">
                                            {{ Form::label('itemExprDate', __('Item Expiry Date'),['class'=>'form-label']) }}
                                            {{Form::date('itemExprDate',null,array('class'=>'form-control'))}}
                                        </td>
                                        <td>
                                            <a href="#" class="ti ti-trash text-white repeater-action-btn bg-danger ms-2" data-repeater-delete></a>
                                        </td>
                                    </tr>
                                </div>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <input type="button" value="{{__('Cancel')}}" onclick="location.href = '{{route("invoice.index")}}';" class="btn btn-light">
            <input type="submit" value="{{__('Create')}}" class="btn btn-primary">
        </div>
        {{ Form::close() }}

    </div>
@endsection


