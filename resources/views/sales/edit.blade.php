@extends('layouts.admin')
@section('page-title')
    {{ __('Edit Sale') }}
@endsection

@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0">{{ __('Edit Sale') }}</h5>
    </div>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('sales.index') }}">{{ __('Sales') }}</a></li>
    <li class="breadcrumb-item">{{ ucwords($sale->id) }}</li>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            {{ Form::open(['url' => 'sales', 'enctype' => 'multipart/form-data']) }}
            <div class="modal-body">
                <div class="row">
                <div class="form-group col-md-3">
                        {{ Form::label('customerNo', __('Customer No'), ['class' => 'form-label']) }}
                        {{ Form::text('customerNo', $sale->customerNo, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>

                    <div class="form-group col-md-3">
                        {{ Form::label('customerTin', __('Customer Tin'), ['class' => 'form-label']) }}
                        {{ Form::text('customerTin', $sale->customerTin, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>

                    <div class="form-group col-md-3">
                        {{ Form::label('customerName', __('Customer Name'), ['class' => 'form-label']) }}
                        {{ Form::text('customerName', $sale->customerName, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-3">
                        {{ Form::label('customerMobileNo', __('Customer Mobile Number'), ['class' => 'form-label']) }}
                        {{ Form::text('customerMobileNo', $sale->customerMobileNo, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-3">
                        {{ Form::label('salesType', __('Sales Type'), ['class' => 'form-label']) }}
                        {{ Form::text('salesType', $sale->salesType, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-3">
                        {{ Form::label('paymentType', __('Payment Type'), ['class' => 'form-label']) }}
                        {{ Form::text('paymentType', $sale->paymentType, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-3">
                        {{ Form::label('traderInvoiceNo', __('Trader Invoice Number'), ['class' => 'form-label']) }}
                        {{ Form::text('traderInvoiceNo', $sale->traderInvoiceNo, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-3">
                        {{ Form::label('confirmDate', __('Confirm Date'), ['class' => 'form-label']) }}
                        {{ Form::text('confirmDate', $sale->confirmDate, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-3">
                        {{ Form::label('salesDate', __('Sales Date'), ['class' => 'form-label']) }}
                        {{ Form::text('salesDate', $sale->salesDate, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-3">
                        {{ Form::label('stockReleseDate', __('Stock Release Date'), ['class' => 'form-label']) }}
                        {{ Form::text('stockReleseDate', $sale->stockReleseDate, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-3">
                        {{ Form::label('receiptPublishDate', __('Receipt Publish Date'), ['class' => 'form-label']) }}
                        {{ Form::text('receiptPublishDate', $sale->receiptPublishDate, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-3">
                        {{ Form::label('occurredDate', __('Occurred Date'), ['class' => 'form-label']) }}
                        {{ Form::text('occurredDate', $sale->occurredDate, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-3">
                        {{ Form::label('invoiceStatusCode', __('Invoice Status Code'), ['class' => 'form-label']) }}
                        {{ Form::text('invoiceStatusCode', $sale->invoiceStatusCode, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-3">
                        {{ Form::label('mapping', __('Mapping'), ['class' => 'form-label']) }}
                        {{ Form::text('mapping', $sale->mapping, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-3">
                        {{ Form::label('isPurchaseAccept', __('Purchase Accept'), ['class' => 'form-label']) }}
                        {{ Form::text('isPurchaseAccept', $sale->isPurchaseAccept, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-3">
                        {{ Form::label('isStockIOUpdate', __('Stock IO Update'), ['class' => 'form-label']) }}
                        {{ Form::text('isStockIOUpdate', $sale->isStockIOUpdate, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-12">
                        {{ Form::label('remark', __('Remark'), ['class' => 'form-label']) }}
                        {{ Form::textarea('remark', $sale->remark, ['class' => 'form-control ', 'required' => 'required', 'rows' => 2]) }}
                    </div>
                    <div class="form-group col-md-3">
                        {{ Form::label('totalItemCount', __('Total Item Count'), ['class' => 'form-label']) }}
                        {{ Form::text('totalItemCount', '', ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-3">
                        {{ Form::label('totalTaxableAmount', __('Total Taxable Amount'), ['class' => 'form-label']) }}
                        {{ Form::text('totalTaxableAmount', '', ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-3">
                        {{ Form::label('totalTaxAmount', __('Total Tax Amount'), ['class' => 'form-label']) }}
                        {{ Form::text('totalTaxAmount', '', ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-3">
                        {{ Form::label('totalAmount', __('Total Amount'), ['class' => 'form-label']) }}
                        {{ Form::text('totalAmount', '', ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <input type="button" value="{{ __('Cancel') }}" class="btn btn-light" data-bs-dismiss="modal">
            <input type="submit" value="{{ __('Edit') }}" class="btn btn-primary">
        </div>
        {{ Form::close() }}

    </div>
    </div>
    </div>
    </div>
@endsection
