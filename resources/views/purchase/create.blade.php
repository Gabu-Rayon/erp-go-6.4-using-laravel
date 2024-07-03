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

        $(document).on('change', '.itemCode', async function() {
            const itemCode = $(this).val();
            const url = `http://localhost:8000/getitem/${itemCode}`;

            try {
                const response = await fetch(url);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const data = await response.json();
                console.log(data); // Debug: Log the response data

                if (data.data) {
                    const item = data.data;
                    const { unitPrice } = item;

                    $(this).closest('tr').find('.unitPrice').val(unitPrice);
                } else {
                    console.error('Item data not found in response');
                }
            } catch (error) {
                console.error('Fetch error:', error);
            }
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
                <div class="card-body" data-autofill>
                    <div class="row">
                        <div class="form-group col-md-3" id="vender-box">
                            {{ Form::label('supplierTin', __('Supplier'), ['class' => 'form-label']) }}
                            {{ Form::select('supplierTin', $venders, '', ['class' => 'form-control select2 supplierName']) }}
                        </div>
                        <div class="form-group col-md-3" id="vender-box">
                            {{ Form::label('supplierInvcNo', __('Supplier Invoice No'), ['class' => 'form-label']) }}
                            {{ Form::text('supplierInvcNo', null, ['class' => 'form-control supplierInvcNo']) }}
                        </div>
                        <div class="form-group col-md-3" id="vender-box">
                            {{ Form::label('purchTypeCode', __('Purchase Type'), ['class' => 'form-label']) }}
                            <span class="text-danger">*</span>
                            {{ Form::select('purchTypeCode', $purchaseTypeCodes, null, ['class' => 'form-control select2 purchTypeCode', 'required' => 'required']) }}
                        </div>
                        <div class="form-group col-md-3" id="vender-box">
                            {{ Form::label('purchStatusCode', __('Purchase Status'), ['class' => 'form-label']) }}
                            <span class="text-danger">*</span>
                            {{ Form::select('purchStatusCode', $purchaseStatusCodes, null, ['class' => 'form-control select2 purchStatusCode', 'required' => 'required']) }}
                        </div>
                        <div class="form-group col-md-3" id="vender-box">
                            {{ Form::label('pmtTypeCode', __('Payment Type'), ['class' => 'form-label']) }}
                            <span class="text-danger">*</span>
                            {{ Form::select('pmtTypeCode', $paymentTypeCodes, null, ['class' => 'form-control select2 pmtTypeCode', 'required' => 'required']) }}
                        </div>
                        <div class="form-group col-md-3" id="vender-box">
                            {{ Form::label('purchDate', __('Purchase Date'), ['class' => 'form-label']) }}
                            <span class="text-danger">*</span>
                            {{ Form::date('purchDate', null, ['class' => 'form-control', 'required' => 'required']) }}
                        </div>
                        <div class="form-group col-md-3" id="vender-box">
                            {{ Form::label('occurredDate', __('Occurred Date'), ['class' => 'form-label']) }}
                            <span class="text-danger">*</span>
                            {{ Form::date('occurredDate', null, ['class' => 'form-control', 'required' => 'required']) }}
                        </div>
                        <div class="form-group col-md-3" id="vender-box">
                            {{ Form::label('confirmDate', __('Confirm Date'), ['class' => 'form-label']) }}
                            {{ Form::date('confirmDate', null, ['class' => 'form-control']) }}
                        </div>
                        <div class="form-group col-md-3" id="vender-box">
                            {{ Form::label('warehouseDate', __('Warehouse Date'), ['class' => 'form-label']) }}
                            {{ Form::date('warehouseDate', null, ['class' => 'form-control']) }}
                        </div>
                        <div class="form-group col-md-3" id="vender-box">
                            {{ Form::label('mapping', __('Mapping'), ['class' => 'form-label']) }}
                            {{ Form::text('mapping', null, ['class' => 'form-control invno-field']) }}
                        </div>
                        <div class="form-group col-md-12" id="vender-box">
                            {{ Form::label('remark', __('Remark'), ['class' => 'form-label']) }}
                            {{ Form::textarea('remark', null, ['class' => 'form-control item_standard_name', 'rows' => '2', 'placeholder' => __('Remark')]) }}
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
                        <table class="table mb-0 table-custom-style" data-repeater-list="items" id="sortable-table" layout="auto">
                            <tbody class="ui-sortable border-2 border-top border-bottom border-primary p-3 mb-3" data-repeater-item>
                                <tr class="col-md-12">
                                    <td class="col-md-4">
                                        {{ Form::label('itemCode', __('Item'), ['class' => 'form-label']) }}
                                        <span class="text-danger">*</span>
                                        {{ Form::select('itemCode', $items, null, ['class' => 'form-control select2 itemCode', 'required' => 'required']) }}
                                    </td>
                                    <td class="col-md-4">
                                        {{ Form::label('quantity', __('Qty'), ['class' => 'form-label']) }}
                                        <span class="text-danger">*</span>
                                        {{ Form::number('quantity', '', ['class' => 'form-control', 'required' => 'required']) }}
                                    </td>
                                    <td class="col-md-4">
                                        {{ Form::label('pkgQuantity', __('Pkg Qty'), ['class' => 'form-label']) }}
                                        <span class="text-danger">*</span>
                                        {{ Form::number('pkgQuantity', '', ['class' => 'form-control', 'required' => 'required']) }}
                                    </td>
                                </tr>
                                <tr class="col-md-12">
                                    <td class="col-md-4">
                                        {{ Form::label('unitPrice', __('Price'), ['class' => 'form-label']) }}
                                        <span class="text-danger">*</span>
                                        {{ Form::number('unitPrice', '', ['class' => 'form-control unitPrice', 'required' => 'required']) }}
                                    </td>
                                    <td class="col-md-4">
                                        {{ Form::label('discountRate', __('Discount'), ['class' => 'form-label']) }}
                                        {{ Form::number('discountRate', '', ['class' => 'form-control']) }}
                                    </td>
                                    <td class="col-md-4">
                                        {{ Form::label('itemExprDt', __('Expiry Date'), ['class' => 'form-label']) }}
                                        {{ Form::date('itemExprDt', null, ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-md-4">
                                        {{ Form::label('supplrItemCode', __('Supplier Item Code'), ['class' => 'form-label']) }}<span
                                                class="text-success">(Optional)</span>
                                        {{ Form::text('supplrItemCode', null, ['class' => 'form-control']) }}
                                    </td>
                                    <td class="col-md-4">
                                        {{ Form::label('supplrItemClsCode', __('Supplier Item Class Code'), ['class' => 'form-label']) }}<span
                                                class="text-success">(Optional)</span>
                                        {{ Form::text('supplrItemClsCode', null, ['class' => 'form-control']) }}
                                    </td>
                                    <td class="col-md-4">
                                        {{ Form::label('supplrItemName', __('Supplier Item Name'), ['class' => 'form-label']) }}<span
                                                class="text-success">(Optional)</span>
                                        {{ Form::text('supplrItemName', null, ['class' => 'form-control']) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <button class="btn btn-danger" data-repeater-delete>Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td></td>
                                    <td><strong>{{__('Sub Total')}} ({{\Auth::user()->currencySymbol()}})</strong></td>
                                    <td class="text-end subTotal">0.00</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td></td>
                                    <td><strong>{{__('Discount')}} ({{\Auth::user()->currencySymbol()}})</strong></td>
                                    <td class="text-end totalDiscount">0.00</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td></td>
                                    <td><strong>{{__('Tax')}} ({{\Auth::user()->currencySymbol()}})</strong></td>
                                    <td class="text-end totalTax">0.00</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td class="blue-text"><strong>{{__('Total Amount')}} ({{\Auth::user()->currencySymbol()}})</strong></td>
                                    <td class="text-end totalAmount blue-text"></td>
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
