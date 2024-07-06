@extends('layouts.admin')
@section('page-title')
    {{ __('Add Sales Credit Note') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('salescreditnote.index') }}">{{ __('Sales') }}</a></li>
    <li class="breadcrumb-item">{{ ucwords($invoiceDue->invoice_id) }}</li>
@endsection

@push('script-page')
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/jquery.repeater.min.js') }}"></script>
    <script></script>
@endpush

@section ('content')

{{ \Log::info('INVOICE DUE') }}
{{ \Log::info($invoiceDue) }}

{{ Form::open(array('route' => array('invoice.credit.note',$invoice_id),'method'=>'post')) }}
    <div class="modal-body">
        <div class="row">
            <div class="form-group col-md-3">
                {{ Form::label('invoiceNo', __('Invoive No'), ['class' => 'form-label']) }}
                <span class="text-danger">*</span>
                {{ Form::text('invoiceNo', $invoiceDue->response_invoiceNo, array('class' => 'form-control', 'readonly' => true)) }}
            </div>
            <div class="form-group col-md-3">
                {{ Form::label('customerName', __('Customer Name'), ['class' => 'form-label']) }}
                <span class="text-danger">*</span>
                {{ Form::text('customerName', $customer->name, array('class' => 'form-control', 'readonly' => true)) }}
            </div>
            <div class="form-group col-md-3">
                {{ Form::label('customerID', __('Customer ID'), ['class' => 'form-label']) }}
                <span class="text-danger">*</span>
                {{ Form::text('customerID', $customer->id, array('class' => 'form-control', 'readonly' => true)) }}
            </div>
            <div class="form-group col-md-3">
                {{ Form::label('totItemCnt', __('Total Item Count'), ['class' => 'form-label']) }}
                <span class="text-danger">*</span>
                {{ Form::text('totItemCnt', count($invoiceDue->products), array('class' => 'form-control', 'readonly' => true)) }}
            </div>
            <div class="form-group col-md-3">
                {{ Form::label('salesType', __('Sales Type'), ['class' => 'form-label']) }}
                {{ Form::select('salesType', $salesTypeCodes, $invoiceDue->saleType, ['class' => 'form-control select2']) }}
            </div>
            <div class="form-group col-md-3">
                {{ Form::label('paymentType', __('Payment Type'), ['class' => 'form-label']) }}
                {{ Form::select('paymentType', $paymentTypeCodes, $invoiceDue->paymentTypeCode, ['class' => 'form-control select2']) }}
            </div>
            <div class="form-group col-md-3">
                {{ Form::label('invoiceStatusCode', __('Invoice Status'), ['class' => 'form-label']) }}
                <span class="text-danger">*</span>
                {{ Form::select('invoiceStatusCode', $invoiceStatusCodes, $invoiceDue->salesSttsCode, ['class' => 'form-control select2', 'required' => true]) }}
            </div>
            <div class="form-group col-md-3">
                {{ Form::label('isPurchaseAccept', __('Purchase Accepted?'), ['class' => 'form-label']) }}
                {{ Form::select('isPurchaseAccept', [true => 'Yes', false => 'No'], $invoiceDue->prchrAcptcYn, ['class' => 'form-control select2']) }}
            </div>
            <div class="form-group col-md-3">
                {{ Form::label('traderInvoiceNo', __('Trader Invoice No'), ['class' => 'form-label']) }}
                <span class="text-danger">*</span>
                {{ Form::text('traderInvoiceNo', '', array('class' => 'form-control traderInvoiceNo', 'required' => true)) }}
            </div>
            <div class="form-group col-md-3">
                {{ Form::label('confirmDate', __('Confirm Date'),['class'=>'form-label']) }}
                <span class="text-danger">*</span>
                {{ Form::date('confirmDate', $invoiceDue->confirmDate, array('class' => 'form-control', 'required' => 'required')) }}
            </div>
            <div class="form-group col-md-3">
                {{ Form::label('salesDate', __('Sales Date'),['class'=>'form-label']) }}
                <span class="text-danger">*</span>
                {{ Form::date('salesDate', $invoiceDue->salesDate, array('class' => 'form-control', 'required' => 'required')) }}
            </div>
            <div class="form-group col-md-3">
                {{ Form::label('stockReleseDate', __('Stock Release Date'),['class'=>'form-label']) }}
                {{ Form::date('stockReleseDate', $invoiceDue->stockReleaseDate, array('class' => 'form-control')) }}
            </div>
            <div class="form-group col-md-3">
                {{ Form::label('receiptPublishDate', __('Receipt Publish Date'),['class'=>'form-label']) }}
                <span class="text-danger">*</span>
                {{ Form::date('receiptPublishDate', $invoiceDue->receipt_RcptPbctDt, array('class' => 'form-control', 'required' => 'required')) }}
            </div>
            <div class="form-group col-md-3">
                {{ Form::label('occurredDate', __('Occurred Date'),['class'=>'form-label']) }}
                <span class="text-danger">*</span>
                {{ Form::date('occurredDate', '', array('class' => 'form-control', 'required' => 'required')) }}
            </div>
            <div class="form-group col-md-3">
                {{ Form::label('creditNoteDate', __('Credit Note Date'),['class'=>'form-label']) }}
                <span class="text-danger">*</span>
                {{ Form::date('creditNoteDate', '', array('class' => 'form-control')) }}
            </div>
            <div class="form-group col-md-3">
                {{ Form::label('creditNoteReason', __('Credit Note Reason'), ['class' => 'form-label']) }}
                <span class="text-danger">*</span>
                {{ Form::select('creditNoteReason', $creditNoteReasons, null, ['class' => 'form-control select2', 'required' => 'required']) }}
            </div>
            <div class="form-group col-md-12">
                {{ Form::label('remark', __('Remark'),['class'=>'form-label']) }}
                {{ Form::textarea('remark', '', array('class' => 'form-control', 'rows' => '3')) }}
            </div>
        </div>
    </div>
    
    <div class="col-12">
        <h5 class="d-inline-block mb-4">{{ __('Product & Services') }}</h5>
        <div class="card">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Item</th>
                                <th scope="col">Unit Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Package Quantity</th>
                                <th scope="col">Discount Rate</th>
                                <th scope="col">Discount Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoiceDue->products as $index => $product)
                                <tr>
                                    <td>
                                        {{ $product->itemName }}
                                        {{ Form::hidden("items[$index][product_id]", $product->id) }}
                                    </td>
                                    <td>
                                        {{ Form::text("items[$index][unitPrice]", $product->price, array('class' => 'form-control', 'required' => true)) }}
                                    </td>
                                    <td>
                                        {{ Form::text("items[$index][quantity]", $product->quantity, array('class' => 'form-control', 'required' => true)) }}
                                    </td>
                                    <td>
                                        {{ Form::text("items[$index][pkgQuantity]", $product->pkgQuantity, array('class' => 'form-control', 'required' => true)) }}
                                    </td>
                                    <td>
                                        {{ Form::text("items[$index][discountRate]", $product->discountRate, array('class' => 'form-control', 'required' => true)) }}
                                    </td>
                                    <td>
                                        {{ Form::text("items[$index][discountAmt]", $product->discountAmt, array('class' => 'form-control', 'required' => true)) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    

    <div class="modal-footer">
        <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
        <input type="submit" value="{{__('Add')}}" class="btn  btn-primary">
    </div>
{{ Form::close() }}
@endsection