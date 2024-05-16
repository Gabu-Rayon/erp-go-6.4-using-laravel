@extends('layouts.admin')
@section('page-title')
    {{ __('Add Direct Credit Note') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('credit.note') }}">{{ __('Credit Notes') }}</a></li>
    <li class="breadcrumb-item">{{ __('Add Direct Credit Note') }}</li>
@endsection

@<div class="modal-body">
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
            });
        </script>
        <script>
            $(document).on('click', '[data-repeater-delete]', function() {
                $(".itemCode").change();
                $(".price").change();
                $(".quantity").change();
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
                            <div class="form-group  col-md-6">
                                {{ Form::label('orgInvoiceNo', __('Org Invoice No'), ['class' => 'form-label']) }}
                                {{ Form::number('orgInvoiceNo', null, ['class' => 'form-control', 'required' => 'required']) }}

                            </div>
                            <div class="form-group col-md-6">
                                {{ Form::label('traderInvoiceNo', __('Trader Invoice No(*)'), ['class' => 'form-label']) }}
                                {{ Form::number('traderInvoiceNo', null, ['class' => 'form-control', 'required' => 'required']) }}
                            </div>
                            <div class="form-group col-md-6">
                                {{ Form::label('salesType', __('Sales Type(*)'), ['class' => 'form-label']) }}
                                {{ Form::select('salesType', $salesTypeCodes, null, ['class' => 'form-control']) }}
                            </div>
                            <div class="form-group col-md-6">
                                {{ Form::label('paymentType', __('Payment Type'), ['class' => 'form-label']) }}
                                {{ Form::select('paymentType', $paymentTypeCodes, null, ['class' => 'form-control']) }}
                            </div>
                            <div class="form-group col-md-6">
                                {{ Form::label('creditNoteDate', __('Credit Note Date (*)'), ['class' => 'form-label']) }}
                                {{ Form::date('creditNoteDate', '', ['class' => 'form-control creditNoteDate', 'required' => true]) }}
                            </div>
                            <div class="form-group col-md-6">
                                {{ Form::label('confirmDate', __('Confirm Date (*)'), ['class' => 'form-label']) }}
                                {{ Form::date('confirmDate', '', ['class' => 'form-control', 'required' => 'required']) }}
                            </div>
                            <div class="form-group col-md-6">
                                {{ Form::label('salesDate', __('Sales Date (*)'), ['class' => 'form-label']) }}
                                {{ Form::date('salesDate', '', ['class' => 'form-control', 'required' => 'required']) }}
                            </div>
                            <div class="form-group col-md-6">
                                {{ Form::label('stockReleseDate', __('Stock Release Date'), ['class' => 'form-label']) }}
                                {{ Form::date('stockReleseDate', '', ['class' => 'form-control']) }}
                            </div>
                            <div class="form-group col-md-6">
                                {{ Form::label('receiptPublishDate', __('Receipt Publish Date (*)'), ['class' => 'form-label']) }}
                                {{ Form::date('receiptPublishDate', '', ['class' => 'form-control', 'required' => 'required']) }}
                            </div>
                            <div class="form-group col-md-6">
                                {{ Form::label('occurredDate', __('Occurred Date (*)'), ['class' => 'form-label']) }}
                                {{ Form::date('occurredDate', '', ['class' => 'form-control', 'required' => 'required']) }}
                            </div>
                            <div class="form-group col-md-6">
                                {{ Form::label('creditNoteReason', __('Credit Note Reason(*)'), ['class' => 'form-label']) }}
                                {{ Form::select('creditNoteReason', $creditNoteReasons, null, ['class' => 'form-control']) }}
                            </div>
                            <div class="form-group col-md-6">
                                {{ Form::label('invoiceStatusCode', __('Invoice Status'), ['class' => 'form-label']) }}
                                {{ Form::select('invoiceStatusCode', $invoiceStatusCodes, null, ['class' => 'form-control']) }}
                            </div>
                            <div class="form-group col-md-6">
                                {{ Form::label('isPurchaseAccept', __('Purchase Accepted?'), ['class' => 'form-label']) }}
                                {{ Form::select('isPurchaseAccept', ['true' => 'Yes', 'false' => 'No'], null, ['class' => 'form-control']) }}
                            </div>
                            <div class="form-group col-md-6">
                                {{ Form::label('isStockIOUpdate', __('Stock IO Update?'), ['class' => 'form-label']) }}
                                {{ Form::select('isStockIOUpdate', ['true' => 'Yes', 'false' => 'No'], null, ['class' => 'form-control']) }}
                            </div>
                            <div class="form-group col-md-6">
                                {{ Form::label('mapping', __('Mapping'), ['class' => 'form-label']) }}
                                {{ Form::text('mapping', '', ['class' => 'form-control']) }}
                            </div>
                            <div class="form-group col-md-6">
                                {{ Form::label('amount', __('Amount(*)'), ['class' => 'form-label']) }}
                                {{ Form::number('amount', '', ['class' => 'form-control']) }}
                            </div>
                            <div class="form-group col-md-12">
                                {{ Form::label('remark', __('Remark'), ['class' => 'form-label']) }}
                                {{ Form::textarea('remark', '', ['class' => 'form-control', 'rows' => '3']) }}
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
                                            {{ Form::label('itemCode', __('Item Code'), ['class' => 'form-label']) }}
                                            {{ Form::select('itemCode', $product_services_Codes, '', ['class' => 'form-control select2 itemCode', 'data-url' => route('invoice.custom.credit.getiteminformation'), 'required' => 'required']) }}

                                        </td>
                                        <td class="form-group col-md-4">
                                            {{ Form::label('unitPrice', __('Unit Price'), ['class' => 'form-label']) }}
                                            {{ Form::number('unitPrice', '', ['class' => 'form-control unitPrice', 'required' => true]) }}

                                        </td>
                                        <td class="form-group col-md-4">
                                            {{ Form::label('quantity', __('Quantity'), ['class' => 'form-label']) }}
                                            {{ Form::number('quantity', '', ['class' => 'form-control quantity', 'required' => true]) }}
                                        </td>
                                        <td class="ti ti-trash text-white text-white repeater-action-btn bg-danger ms-2"
                                            data-repeater-delete>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <input type="button" value="{{ __('Cancel') }}" onclick="location.href = '{{ route('credit.note') }}';"
                    class="btn btn-light">
                <input type="submit" value="{{ __('Create') }}" class="btn  btn-primary">
            </div>
            {{ Form::close() }}
        </div>
    @endsection
</div>
