@extends('layouts.admin')
@section('page-title')
    {{ __('Add Sales') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('sales.index') }}">{{ __('Sales') }}</a></li>
    <li class="breadcrumb-item">{{ __('Add Sales') }}</li>
@endsection
@push('script-page')
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/jquery.repeater.min.js') }}"></script>
@endpush

@section('content')
    <div class="row">
        {{ Form::open(['url' => 'sales', 'class' => 'w-100 sales-form']) }}
        <div class="col-12">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-4">
                            {{ Form::label('customerName', __('Customer Name (*)'),['class'=>'form-label']) }}
                            {{ Form::text('customerName', '', array('class' => 'form-control customerName','required'=>'required')) }}
                        </div>
                        <div class="form-group col-md-4">
                            {{ Form::label('customerTin', __('Customer TIN (*)'),['class'=>'form-label']) }}
                            {{ Form::text('customerTin', '', array('class' => 'form-control customerTin','required'=>'required')) }}
                        </div>
                        <div class="form-group col-md-4">
                            {{ Form::label('customerNo', __('Customer Number'),['class'=>'form-label']) }}
                            {{ Form::number('customerNo', '', array('class' => 'form-control customerNo')) }}
                        </div>
                        <div class="form-group col-md-4">
                            {{ Form::label('customerMobileNo', __('Customer Mobile Number'),['class'=>'form-label']) }}
                            {{ Form::text('customerMobileNo', '', array('class' => 'form-control customerMobileNo')) }}
                        </div>
                        <div class="form-group col-md-4">
                            {{ Form::label('salesType', __('Sales Type'),['class'=>'form-label']) }}
                            {{ Form::text('salesType', '', array('class' => 'form-control salesType')) }}
                        </div>
                        <div class="form-group col-md-4">
                            {{ Form::label('paymentType', __('Payment Type'),['class'=>'form-label']) }}
                            {{ Form::text('paymentType', '', array('class' => 'form-control paymentType')) }}
                        </div>
                        <div class="form-group col-md-4">
                            {{ Form::label('traderInvoiceNo', __('Trader Invoice Number (*)'),['class'=>'form-label']) }}
                            {{ Form::text('traderInvoiceNo', '', array('class' => 'form-control traderInvoiceNo','required'=>'required')) }}
                        </div>
                        <div class="form-group col-md-4">
                            {{ Form::label('confirmDate', __('Confirm Date (*)'),['class'=>'form-label']) }}
                            {{ Form::date('confirmDate', '', array('class' => 'form-control confirmDate','required'=>'required')) }}
                        </div>
                        <div class="form-group col-md-4">
                            {{ Form::label('salesDate', __('Sales Date (*)'),['class'=>'form-label']) }}
                            {{ Form::date('salesDate', '', array('class' => 'form-control salesDate','required'=>'required')) }}
                        </div>
                        <div class="form-group col-md-4">
                            {{ Form::label('stockReleseDate', __('Stock Release Date'),['class'=>'form-label']) }}
                            {{ Form::date('stockReleseDate', '', array('class' => 'form-control stockReleseDate')) }}
                        </div>
                        <div class="form-group col-md-4">
                            {{ Form::label('receiptPublishDate', __('Receipt Publish Date (*)'),['class'=>'form-label']) }}
                            {{ Form::date('receiptPublishDate', '', array('class' => 'form-control receiptPublishDate','required'=>'required')) }}
                        </div>
                        <div class="form-group col-md-4">
                            {{ Form::label('occurredDate', __('Occurred Date (*)'),['class'=>'form-label']) }}
                            {{ Form::date('occurredDate', '', array('class' => 'form-control occurredDate','required'=>'required')) }}
                        </div>
                        <div class="form-group col-md-4">
                            {{ Form::label('invoiceStatusCode', __('Invoice Status Code'),['class'=>'form-label']) }}
                            {{ Form::text('invoiceStatusCode', '', array('class' => 'form-control invoiceStatusCode')) }}
                        </div>
                        <div class="form-group col-md-4">
                            {{ Form::label('isPurchaseAccept', __('Purchase Accepted'),['class'=>'form-label']) }}
                            {{ Form::select('isPurchaseAccept', array('true' => 'True', 'false' => 'False'), null, array('class' => 'isPurchaseAccept form-control')) }}
                        </div>
                        <div class="form-group col-md-4">
                            {{ Form::label('isStockIOUpdate', __('Stock IO Update'),['class'=>'form-label']) }}
                            {{ Form::select('isStockIOUpdate', array('true' => 'True', 'false' => 'False'), null, array('class' => 'isStockIOUpdate form-control')) }}
                        </div>
                        <div class="form-group col-md-4">
                            {{ Form::label('mapping', __('Mapping'),['class'=>'form-label']) }}
                            {{ Form::text('mapping', '', array('class' => 'form-control mapping')) }}
                        </div>
                        <div class="form-group col-md-12">
                            {{ Form::label('remark', __('Remark'),['class'=>'form-label']) }}
                            {{ Form::textarea('remark', '', array('class' => 'form-control remark', 'rows' => '3')) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Add Items</h4>
            </div>
            <div class="card-body repeater items">
                <div class="card">
                    <div class="card-header">
                        <button type="button" data-repeater-create  class="btn btn-sm btn-primary float-end my-10">Add Item</button>
                    </div>
                    <div data-repeater-list="items" class="card-body">
                        <div data-repeater-item class="row">
                            <h5 class="card-title text-info text-lg">Item</h5>
                            <div class="form-group col-md-4" name="itemName[]">
                                {{ Form::label('itemName', __('Item Name'),['class'=>'form-label']) }}
                                {{ Form::select('itemName', $items, null, ['class' => 'form-control item-name']) }}
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('itemCode', __('Item Code (*)'),['class'=>'form-label']) }}
                                {{ Form::text('itemCode', '', array('class' => 'form-control item-code', 'required' => 'required', "readonly" => "readonly")) }}
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('itemClassCode', __('Item Class Code'),['class'=>'form-label']) }}
                                {{ Form::text('itemClassCode', '', array('class' => 'form-control item-class-code', "readonly" => "readonly")) }}
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('itemTypeCode', __('Item Type Code'),['class'=>'form-label']) }}
                                {{ Form::text('itemTypeCode', '', array('class' => 'form-control item-type-code', "readonly" => "readonly")) }}
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('orgnNatCd', __('Origin Nation Code'),['class'=>'form-label']) }}
                                {{ Form::text('orgnNatCd', '', array('class' => 'form-control org-nat-code', "readonly" => "readonly")) }}
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('taxTypeCode', __('Tax Type Code'),['class'=>'form-label']) }}
                                {{ Form::text('taxTypeCode', '', array('class' => 'form-control tax-type-code', "readonly" => "readonly")) }}
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('unitPrice', __('Unit Price (*)'),['class'=>'form-label']) }}
                                {{ Form::number('unitPrice', '', array('class' => 'form-control unit-price', "required" => "required")) }}
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('isrcAplcbYn	', __('ISRCAPLCBYN	'),['class'=>'form-label']) }}
                                {{ Form::select('isrcAplcbYn', array('true' => 'True', 'false' => 'False'), null, array('class' => 'form-control isrcAplcbYn')) }}
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('pkgUnitCode', __('Package Unit Code'),['class'=>'form-label']) }}
                                {{ Form::text('pkgUnitCode', '', array('class' => 'form-control package-unit-code', 'readonly' => 'readonly')) }}
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('pkgQuantity', __('Package Quantity (*)'),['class'=>'form-label']) }}
                                {{ Form::number('pkgQuantity', '', array('class' => 'form-control pkg-quantity', "required" => "required")) }}
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('qtyUnitCd', __('Quantity Unit Code'),['class'=>'form-label']) }}
                                {{ Form::text('qtyUnitCd', '', array('class' => 'form-control qty-unit-cd', 'readonly' => 'readonly')) }}
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('qty', __('Quantity (*)'),['class'=>'form-label']) }}
                                {{ Form::number('qty', '', array('class' => 'form-control quantity', "required" => "required")) }}
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('discountRate', __('Discount Rate'),['class'=>'form-label']) }}
                                {{ Form::text('discountRate', '', array('class' => 'form-control discount-rate')) }}
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('discountAmt', __('Discount Amount'),['class'=>'form-label']) }}
                                {{ Form::text('discountAmt', '', array('class' => 'form-control discount-amt')) }}
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('itemExprDate', __('Item Expiry Date'),['class'=>'form-label']) }}
                                {{ Form::date('itemExprDate', '', array('class' => 'form-control item-expr-date')) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <input type="button" value="{{ __('Cancel') }}" onclick="location.href = '{{ route('sales.index') }}';"
                class="btn btn-light">
            <button type="submit" class="btn  btn-primary thee-one-submit-button">{{ __('Create') }}</button>
        </div>
        {{ Form::close() }}
    </div>
@endsection

@push('script-page')
<script>
    $(document).ready(function() {
        
        let itemDataArray = [];
        const salesForm = document.querySelector('.sales-form');
        const loader = document.createElement('div');
        
            $('.repeater.items').repeater({
                initEmpty: false,
                show: function() {
                    $(this).slideDown();
                    attachItemNameEventListener(this);
                },
                hide: function(deleteElement) {
                    if (confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                    }
                }
            });
            
            attachItemNameEventListener(document);
            
            function attachItemNameEventListener(container) {
                const itemNames = container.querySelectorAll('.item-name');
                itemNames.forEach(itemName => {
                    itemName.addEventListener('change', async function (event) {
                        const url = `http://localhost:8000/getitem/${event.target.value}`;
                        const response = await fetch(url);
                        const { data } = await response.json();
                        const repeaterItem = itemName.closest('[data-repeater-item]');
                        const itemCodeField = repeaterItem.querySelector('.item-code');
                        const itemClassCodeField = repeaterItem.querySelector('.item-class-code');
                        const itemTypeCodeField = repeaterItem.querySelector('.item-type-code');
                        const OrgNatCodeField = repeaterItem.querySelector('.org-nat-code');
                        const taxTypeCodeField = repeaterItem.querySelector('.tax-type-code');
                        const unitPriceCodeField = repeaterItem.querySelector('.unit-price');
                        const packageUnitCodeField = repeaterItem.querySelector('.package-unit-code');
                        const quantityUnitCodeField = repeaterItem.querySelector('.qty-unit-cd');
                        console.log(data);
                        if (data
                        && data.itemCd
                        && data.itemClsCd
                        && data.itemTyCd
                        && data.orgnNatCd
                        && data.taxTyCd
                        && data.dftPrc
                        && data.pkgUnitCd
                                && data.qtyUnitCd
                            ) {
                                itemCodeField.value = data.itemCd;
                                itemClassCodeField.value = data.itemClsCd;
                                itemTypeCodeField.value = data.itemTyCd;
                                OrgNatCodeField.value = data.orgnNatCd;
                                taxTypeCodeField.value = data.taxTyCd;
                                unitPriceCodeField.value = data.dftPrc;
                                packageUnitCodeField.value = data.pkgUnitCd;
                                quantityUnitCodeField.value = data.qtyUnitCd;
                            } else {
                                itemCodeField.value = '';
                                itemClassCodeField.value = '';
                                itemTypeCodeField.value = '';
                                OrgNatCodeField.value = '';
                                taxTypeCodeField.value = '';
                                unitPriceCodeField.value = '';
                                packageUnitCodeField.value = '';
                                quantityUnitCodeField.value = '';
                            }
                        });
                    });
                }
                salesForm.addEventListener('submit', async e => {
                    e.preventDefault();
                    
                    const loader = document.createElement('div');
                    loader.classList.add('spinner-border', 'text-light', 'spinner-border-sm');
                    loader.role = 'status';
                    const submitButton = document.querySelector('.thee-one-submit-button');
                    submitButton.appendChild(loader);
                    console.log(submitButton);
                    itemDataArray = [];
                    const repeatedItems = document.querySelectorAll('[data-repeater-item]');
                    repeatedItems.forEach(repeaterItem => {
                        const itemNameField = repeaterItem.querySelector('.item-name');
                        const itemCodeField = repeaterItem.querySelector('.item-code');
                        const itemClassCodeField = repeaterItem.querySelector('.item-class-code');
                        const itemTypeCodeField = repeaterItem.querySelector('.item-type-code');
                        const OrgNatCodeField = repeaterItem.querySelector('.org-nat-code');
                        const taxTypeCodeField = repeaterItem.querySelector('.tax-type-code');
                        const unitPriceCodeField = repeaterItem.querySelector('.unit-price');
                        const packageUnitCodeField = repeaterItem.querySelector('.package-unit-code');
                        const pkgQuantityField = repeaterItem.querySelector('.pkg-quantity');
                        const qtyUnitCdField = repeaterItem.querySelector('.qty-unit-cd');
                        const quantityField = repeaterItem.querySelector('.quantity');
                        const discountRateField = repeaterItem.querySelector('.discount-rate');
                        const discountAmtField = repeaterItem.querySelector('.discount-amt');
                        const itemExprDateField = repeaterItem.querySelector('.item-expr-date');
                        const isrcAplcbYnField = repeaterItem.querySelector('.isrcAplcbYn');
                        
                        const itemData = {
                            itemCode: itemCodeField.value || '',
                            itemClassCode: itemClassCodeField.value || '',
                            itemTypeCode: itemTypeCodeField.value || '',
                            itemName: itemNameField.value || '',
                            orgnNatCd: OrgNatCodeField.value || '',
                            taxTypeCode: taxTypeCodeField.value || '',
                            unitPrice: parseFloat(unitPriceCodeField.value) || '',
                            isrcAplcbYn: isrcAplcbYnField || '',
                            pkgUnitCode: packageUnitCodeField.value || '',
                            pkgQuantity: parseInt(pkgQuantityField.value) || '',
                            qtyUnitCd: qtyUnitCdField.value || '',
                            quantity: parseInt(quantityField.value) || '',
                            discountRate: parseFloat(discountRateField.value) || '',
                            discountAmt: parseFloat(discountAmtField.value) || '',
                            itemExprDate: itemExprDateField.value || ''
                        };
                        
                        itemDataArray.push(itemData);
                    });
                    
                    const formDataObject = {};
                    
                    formDataObject.customerName = document.querySelector('.customerName').value;
                    formDataObject.customerTin = document.querySelector('.customerTin').value;
                    formDataObject.customerNo = document.querySelector('.customerNo').value;
                    formDataObject.customerMobileNo = document.querySelector('.customerMobileNo').value;
                    formDataObject.salesType = document.querySelector('.salesType').value;
                    formDataObject.paymentType = document.querySelector('.paymentType').value;
                    formDataObject.traderInvoiceNo = document.querySelector('.traderInvoiceNo').value;
                    formDataObject.confirmDate = document.querySelector('.confirmDate').value;
                    formDataObject.salesDate = document.querySelector('.salesDate').value;
                    formDataObject.stockReleseDate = document.querySelector('.stockReleseDate').value;
                    formDataObject.receiptPublishDate = document.querySelector('.receiptPublishDate').value;
                    formDataObject.occurredDate = document.querySelector('.occurredDate').value;
                    formDataObject.invoiceStatusCode = document.querySelector('.invoiceStatusCode').value;
                    formDataObject.isPurchaseAccept = document.querySelector('.isPurchaseAccept').value;
                    formDataObject.isStockIOUpdate = document.querySelector('.isStockIOUpdate').value;
                    formDataObject.mapping = document.querySelector('.mapping').value;
                    formDataObject.remark = document.querySelector('.remark').value;
                    formDataObject.saleItemList = itemDataArray

                    const url = 'http://localhost:8000/sales';
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    
                    try {
    const response = await fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify(formDataObject)
    });

    // Correctly await the response data
    const data = await response.json(); // Corrected line

    console.log(data);

    // Remove the loader
    submitButton.removeChild(loader);

    // Show success message
    if (data.status === 'error') {
        const popup = document.createElement('div');
    popup.classList.add('alert', 'alert-danger');
    popup.innerHTML = 'Error Adding Sale'; // Simplified for demonstration
    popup.style.position = 'absolute';
    popup.style.top = '50%';
    popup.style.left = '50%';
    popup.style.transform = 'translate(-50%, -50%)';
    popup.style.zIndex = '9999';
    document.body.appendChild(popup);

    // Reload the page after a delay
    setTimeout(() => {
        location.reload();
    }, 3000);
    } else {
        const popup = document.createElement('div');
    popup.classList.add('alert', 'alert-success');
    popup.innerHTML = data.message || 'Sale Added Successfully'; // Assuming the message key is 'message'
    popup.style.position = 'absolute';
    popup.style.top = '50%';
    popup.style.left = '50%';
    popup.style.transform = 'translate(-50%, -50%)';
    popup.style.zIndex = '9999';
    document.body.appendChild(popup);
    }

    // Redirect to sales page after a delay
    setTimeout(() => {
        window.location.href = '/sales';
    }, 3000);
} catch (e) {
    console.log(e);

    // Remove the loader
    submitButton.removeChild(loader);

    // Show error message
    const popup = document.createElement('div');
    popup.classList.add('alert', 'alert-danger');
    popup.innerHTML = 'Error Adding Sale'; // Simplified for demonstration
    popup.style.position = 'absolute';
    popup.style.top = '50%';
    popup.style.left = '50%';
    popup.style.transform = 'translate(-50%, -50%)';
    popup.style.zIndex = '9999';
    document.body.appendChild(popup);

    // Reload the page after a delay
    setTimeout(() => {
        location.reload();
    }, 3000);
}


                });
            });
    </script>


@endpush