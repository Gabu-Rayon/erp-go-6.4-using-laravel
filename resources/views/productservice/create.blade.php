@extends('layouts.admin')
@section('page-title')
    {{ __('Add Product / Service') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('productservice.index') }}">{{ __('Products & Services') }}</a></li>
    <li class="breadcrumb-item">{{ __('Add Product / Service') }}</li>
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
        {{ Form::open(['url' => 'productservice', 'class' => 'w-100', 'enctype' => 'multipart/form-data']) }}
        <!-- {{ Form::open(['url' => 'productservice', 'enctype' => 'multipart/form-data']) }} -->
        <div class="col-12">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
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

                                    <td class="form-group col-md-3">
                                        <div class="form-group">
                                            {{ Form::label('sku', __('SKU'), ['class' => 'form-label']) }}<span
                                                class="text-danger">*</span>
                                            {{ Form::text('sku', '', ['class' => 'form-control', 'required' => 'required','placeholder' =>'ABC-12345-S-BL']) }}
                                        </div>
                                    </td>

                                    <td class="form-group col-md-3">
                                        <div class="form-group">
                                            {{ Form::label('sale_price', __('Sale Price'), ['class' => 'form-label']) }}<span
                                                class="text-danger">*</span>
                                            {{ Form::number('sale_price', '', ['class' => 'form-control', 'required' => 'required', 'step' => '0.01']) }}
                                        </div>
                                    </td>
                                    <td class="form-group col-md-3">
                                        <div class="form-group">
                                            {{ Form::label('purchase_price', __('Purchase Price'), ['class' => 'form-label']) }}<span
                                                class="text-danger">*</span>
                                            {{ Form::number('purchase_price', '', ['class' => 'form-control', 'required' => 'required', 'step' => '0.01']) }}
                                        </div>
                                    </td>
                                    <td class="form-group col-md-3">
                                        {{ Form::label('sale_chartaccount_id', __('Income Account'), ['class' => 'form-label']) }}
                                        <select name="sale_chartaccount_id" class="form-control" required="required">
                                            @foreach ($incomeChartAccounts as $key => $chartAccount)
                                                <option value="{{ $key }}" class="subAccount">{{ $chartAccount }}
                                                </option>
                                                @foreach ($incomeSubAccounts as $subAccount)
                                                    @if ($key == $subAccount['account'])
                                                        <option value="{{ $subAccount['id'] }}" class="ms-5"> &nbsp;
                                                            &nbsp;&nbsp; {{ $subAccount['code_name'] }}</option>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="form-group col-md-3">
                                        {{ Form::label('expense_chartaccount_id', __('Expense Account'), ['class' => 'form-label']) }}
                                        <select name="expense_chartaccount_id" class="form-control" required="required">
                                            @foreach ($expenseChartAccounts as $key => $chartAccount)
                                                <option value="{{ $key }}" class="subAccount">{{ $chartAccount }}
                                                </option>
                                                @foreach ($expenseSubAccounts as $subAccount)
                                                    @if ($key == $subAccount['account'])
                                                        <option value="{{ $subAccount['id'] }}" class="ms-5"> &nbsp;
                                                            &nbsp;&nbsp; {{ $subAccount['code_name'] }}</option>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </select>
                                    </td>

                                    <td class="form-group col-md-3">
                                        {{ Form::label('itemCode', __('Item Code'), ['class' => 'form-label']) }}
                                        {{ Form::text('itemCode', '', ['class' => 'form-control', 'required' => 'required']) }}
                                    </td>
                                    <td class="form-group col-md-3">
                                        {{ Form::label('itemClassifiCode', __('Item Classification Code'), ['class' => 'form-label']) }}
                                        {{ Form::select('itemClassifiCode', $itemclassifications, null, ['class' => 'form-control select2', 'placeholder' => __('Select Item Classification'), 'required' => 'required']) }}
                                    </td>
                                    <td class="form-group col-md-3">
                                        {{ Form::label('itemTypeCode', __('Item Type Code'), ['class' => 'form-label']) }}
                                        {{ Form::select('itemTypeCode', $itemtypes, null, ['class' => 'form-control select2', 'placeholder' => __('Select Item Type Code'), 'required' => 'required']) }}
                                    </td>
                                    <td class="form-group col-md-3">
                                        {{ Form::label('itemName', __('Item Name'), ['class' => 'form-label']) }}
                                        {{ Form::text('itemName', '', ['class' => 'form-control', 'required' => 'required']) }}
                                    </td>
                                    <td class="form-group col-md-3">
                                        {{ Form::label('itemStrdName', __('Item Std Name'), ['class' => 'form-label']) }}
                                        {{ Form::text('itemStrdName', '', ['class' => 'form-control', 'required' => 'required']) }}
                                    </td>
                                    <td class="form-group col-md-3">
                                        {{ Form::label('countryCode', __('Country Code'), ['class' => 'form-label']) }}
                                        {{ Form::select('countryCode', $countrynames, null, ['class' => 'form-control select2', 'placeholder' => __('Select Origin Place Code'), 'required' => 'required']) }}
                                    </td>
                                    <td class="form-group col-md-3">
                                        {{ Form::label('pkgUnitCode', __('Package Unit Code'), ['class' => 'form-label']) }}
                                        {{ Form::text('pkgUnitCode', '', ['class' => 'form-control', 'required' => 'required']) }}
                                    </td>
                                    <td class="form-group col-md-3">
                                        {{ Form::label('qtyUnitCode', __('Quantity Unit Code'), ['class' => 'form-label']) }}
                                        {{ Form::text('qtyUnitCode', '', ['class' => 'form-control', 'required' => 'required']) }}
                                    </td>
                                    <td class="form-group col-md-3">
                                        {{ Form::label('taxTypeCode', __('Tax Type Code'), ['class' => 'form-label']) }}
                                        {{ Form::select('taxTypeCode', $taxationtype, null, ['class' => 'form-control select2', 'placeholder' => __('Select Taxation Type Code'), 'required' => 'required']) }}
                                    </td>
                                    <td class="form-group col-md-3">
                                        {{ Form::label('batchNo', __('Batch Number'), ['class' => 'form-label']) }}
                                        {{ Form::text('batchNo', '', ['class' => 'form-control', 'required' => 'required']) }}
                                    </td>
                                    <td class="form-group col-md-3">
                                        {{ Form::label('barcode', __('Bar Code'), ['class' => 'form-label']) }}
                                        {{ Form::text('barcode', '', ['class' => 'form-control', 'required' => 'required','placeholder' =>'9347408001101']) }}
                                    </td>
                                    <td class="form-group col-md-3">
                                        {{ Form::label('unitPrice', __('Unit Price'), ['class' => 'form-label']) }}
                                        {{ Form::number('unitPrice', '', ['class' => 'form-control', 'required' => 'required']) }}
                                    </td>
                                    <td class="form-group col-md-3">
                                        {{ Form::label('group1UnitPrice', __('Group 1 Unit Price'), ['class' => 'form-label']) }}
                                        {{ Form::number('group1UnitPrice', '', ['class' => 'form-control', 'required' => 'required']) }}
                                    </td>
                                    <td class="form-group col-md-3">
                                        {{ Form::label('group2UnitPrice', __('Group 2 Unit Price'), ['class' => 'form-label']) }}
                                        {{ Form::number('group2UnitPrice', '', ['class' => 'form-control', 'required' => 'required']) }}
                                    </td>
                                    <td class="form-group col-md-3">
                                        {{ Form::label('group3UnitPrice', __('Group 3 Unit Price'), ['class' => 'form-label']) }}
                                        {{ Form::number('group3UnitPrice', '', ['class' => 'form-control', 'required' => 'required']) }}
                                    </td>
                                    <td class="form-group col-md-3">
                                        {{ Form::label('group4UnitPrice', __('Group 4 Unit Price'), ['class' => 'form-label']) }}
                                        {{ Form::number('group4UnitPrice', '', ['class' => 'form-control', 'required' => 'required']) }}
                                    </td>
                                    <td class="form-group col-md-3">
                                        {{ Form::label('group5UnitPrice', __('Group 5 Unit Price'), ['class' => 'form-label']) }}
                                        {{ Form::number('group5UnitPrice', '', ['class' => 'form-control', 'required' => 'required']) }}
                                    </td>
                                    <td class="form-group col-md-3">
                                        {{ Form::label('saftyQuantity', __('Safty Quantity'), ['class' => 'form-label']) }}
                                        {{ Form::number('saftyQuantity', '', ['class' => 'form-control', 'required' => 'required']) }}
                                    </td>
                                    <td class="form-group col-md-3">
                                        {{ Form::label('isInrcApplicable', __('Is Inrc Applicable'), ['class' => 'form-label']) }}
                                        {{ Form::select('isInrcApplicable', ['true' => 'Yes', 'false' => 'No'], null, ['class' => 'form-control', 'required' => 'required']) }}
                                    </td>
                                    <td class="form-group col-md-3">
                                        {{ Form::label('useYn', __('useYn'), ['class' => 'form-label']) }}
                                        {{ Form::select('useYn', ['true' => 'Yes', 'false' => 'No'], null, ['class' => 'form-control', 'required' => 'required']) }}
                                    </td>
                                    <td class="form-group col-md-3">
                                        {{ Form::label('isUsed', __('Is Used'), ['class' => 'form-label']) }}
                                        {{ Form::select('isUsed', ['true' => 'Yes', 'false' => 'No'], null, ['class' => 'form-control', 'required' => 'required']) }}
                                    </td>
                                    <td class="form-group col-md-3">
                                        {{ Form::label('quantity', __('Quantity'), ['class' => 'form-label']) }}
                                        {{ Form::number('quantity', '', ['class' => 'form-control', 'required' => 'required']) }}
                                    </td>
                                    <td class="form-group col-md-3">
                                        {{ Form::label('packageQuantity', __('Package Quantity'), ['class' => 'form-label']) }}
                                        {{ Form::number('packageQuantity', '', ['class' => 'form-control', 'required' => 'required']) }}
                                    </td>
                                    <td class="form-group col-md-3">
                                        {{ Form::label('category_id', __('Category'), ['class' => 'form-label']) }}<span
                                            class="text-danger">*</span>
                                        {{ Form::select('category_id', $category, null, ['class' => 'form-control select', 'required' => 'required']) }}

                                        <div class=" text-xs">
                                            {{ __('Please add constant category. ') }}<a
                                                href="{{ route('product-category.index') }}"><b>{{ __('Add Category') }}</b></a>
                                        </div>
                                    </td>
                                    <td class="col-md-3 form-group">
                                        {{ Form::label('pro_image', __('Product/Item Image'), ['class' => 'form-label']) }}
                                        <div class="choose-file ">
                                            <label for="pro_image" class="form-label">
                                                <input type="file" class="form-control" name="pro_image" id="pro_image"
                                                    data-filename="pro_image_create">
                                                <img id="image" class="mt-3" style="width:25%;" />
                                            </label>
                                        </div>
                                    </td>
                                    <td class="form-group col-md-3">
                                        <div class="form-group">
                                            <div class="btn-box">
                                                <label class="d-block form-label">{{ __('Type') }}</label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-check form-check-inline">
                                                            <input type="radio" class="form-check-input type"
                                                                id="customRadio5" name="type" value="product"
                                                                checked="checked">
                                                            <label class="custom-control-label form-label"
                                                                for="customRadio5">{{ __('Product') }}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-check form-check-inline">
                                                            <input type="radio" class="form-check-input type"
                                                                id="customRadio6" name="type" value="service">
                                                            <label class="custom-control-label form-label"
                                                                for="customRadio6">{{ __('Service') }}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="form-group col-md-6">
                                        {{ Form::label('additionalInfo', __('Additional Info'), ['class' => 'form-label']) }}
                                        {{ Form::textarea('additionalInfo', '', ['class' => 'form-control', 'required' => 'required']) }}
                                    </td>
                                    @if (!$customFields->isEmpty())
                                        <td class="form-group col-md-3">
                                            <div class="tab-pane fade show" id="tab-2" role="tabpanel">
                                                @include('customFields.formBuilder')
                                            </div>
                                        </td>
                                    @endif
                                    <td class="ti ti-trash text-white text-white repeater-action-btn bg-danger ms-2"
                                        data-repeater-delete></td>
                                    <td class="ti ti-trash text-white text-white repeater-action-btn bg-danger ms-2"
                                        data-repeater-delete></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <input type="button" value="{{ __('Cancel') }}"
                onclick="location.href = '{{ route('purchase.index') }}';" class="btn btn-light">
            <input type="submit" value="{{ __('Create') }}" class="btn  btn-primary">
        </div>
        {{ Form::close() }}
    </div>
@endsection
<script>
    document.getElementById('pro_image').onchange = function() {
        var src = URL.createObjectURL(this.files[0])
        document.getElementById('image').src = src
    }

    //hide & show quantity

    $(document).on('click', '.type', function() {
        var type = $(this).val();
        if (type == 'product') {
            $('.quantity').removeClass('d-none')
            $('.quantity').addClass('d-block');
        } else {
            $('.quantity').addClass('d-none')
            $('.quantity').removeClass('d-block');
        }
    });
</script>
