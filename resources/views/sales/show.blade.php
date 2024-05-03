@extends('layouts.admin')
@section('page-title')
    {{ __('Sale') }}
@endsection

@section('title')
    <div class="d-inline-block">
        <h6 class="h6 d-inline-block font-weight-400 mb-0">{{ __('Sale') }}</h6>
    </div>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('sales.index') }}">{{ __('Sales') }}</a></li>
    <li class="breadcrumb-item">Details</li>
@endsection

@section('action-btn')
<div class="float-end m-2">
    <a href="{{ route('sales.index') }}" class="btn btn-sm btn-info">
        {{__('Back')}}
    </a>
</div>
    <div class="float-end m-2">
        <a href="{{ route('sales.cancel', $sale->id) }}" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="{{__('Cancel Sale')}}">
            {{__('Cancel Sale')}}
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            {{ Form::open(['url' => 'sale', 'enctype' => 'multipart/form-data']) }}
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3">
                        <h6>{{ __('Customer No: ') }}</h6>
                        <p>{{ $sale->customerNo }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Customer TIN: ') }}</h6>
                        <p>{{ $sale->customerTin }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Customer Name: ') }}</h6>
                        <p>{{ $sale->customerName }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Customer Mobile Number: ') }}</h6>
                        <p>{{ $sale->customerMobileNo }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Sales Type: ') }}</h6>
                        <p>{{ $sale->salesType }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Payment Type: ') }}</h6>
                        <p>{{ $sale->paymentType }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Trader Invoice No: ') }}</h6>
                        <p>{{ $sale->traderInvoiceNo }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Confirm Date: ') }}</h6>
                        <p>{{ $sale->confirmDate }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Sales Date: ') }}</h6>
                        <p>{{ $sale->salesDate }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Stock Release Date: ') }}</h6>
                        <p>{{ $sale->stockReleseDate }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Receipt Publish Date: ') }}</h6>
                        <p>{{ $sale->receiptPublishDate }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Occurred Date: ') }}</h6>
                        <p>{{ $sale->occurredDate }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Invoice Status Code: ') }}</h6>
                        <p>{{ $sale->invoiceStatusCode }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Mapping: ') }}</h6>
                        <p>{{ $sale->mapping }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Purchase Accept: ') }}</h6>
                        <p>{{ $sale->isPurchaseAccept ? 'True' : 'False'}}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Stock IO Update: ') }}</h6>
                        <p>{{ $sale->isStockIOUpdate ? 'True' : 'False'}}</h6>
                    </div>
                    <div class="col-md-12">
                        <h6>{{ __('Remark: ') }}</h6>
                        <p>{{ $sale->remark }}</h6>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title">Items</h6>
                        @foreach ($items as $item)
                        {{ \Log::info($item) }}
                        <div class="card-body">
                            <div class="row">
                            <h6 class="card-title text-info text-lg">Item</h6>
                            <div class="col-md-3">
                                <h6>{{ __('Item Name: ') }}</h6>
                                <p>{{ $item->itemName }}</h6>
                            </div>
                            <div class="col-md-3">
                                <h6>{{ __('Item Code: ') }}</h6>
                                <p>{{ $item->itemCode }}</h6>
                            </div>
                            <div class="col-md-3">
                                <h6>{{ __('Item Class Code: ') }}</h6>
                                <p>{{ $item->itemClassCode }}</h6>
                            </div>
                            <div class="col-md-3">
                                <h6>{{ __('Item Type Code: ') }}</h6>
                                <p>{{ $item->itemTypeCode }}</h6>
                            </div>
                            <div class="col-md-3">
                                <h6>{{ __('Origin Nation Code: ') }}</h6>
                                <p>{{ $item->orgnNatCd }}</h6>
                            </div>
                            <div class="col-md-3">
                                <h6>{{ __('Tax Type Code: ') }}</h6>
                                <p>{{ $item->taxTypeCode }}</h6>
                            </div>
                            <div class="col-md-3">
                                <h6>{{ __('Unit Price: ') }}</h6>
                                <p>{{ $item->unitPrice }}</h6>
                            </div>
                            <div class="col-md-3">
                                <h6>{{ __('ISRCAPLCBYN: ') }}</h6>
                                <p>{{ $item->isrcAplcbYn ? 'True' : 'False' }}</h6>
                            </div>
                            <div class="col-md-3">
                                <h6>{{ __('Package Unit Code: ') }}</h6>
                                <p>{{ $item->pkgUnitCode }}</h6>
                            </div>
                            <div class="col-md-3">
                                <h6>{{ __('Package Quantity: ') }}</h6>
                                <p>{{ $item->pkgQuantity }}</h6>
                            </div>
                            <div class="col-md-3">
                                <h6>{{ __('Quantity Unit Code: ') }}</h6>
                                <p>{{ $item->qtyUnitCd }}</h6>
                            </div>
                            <div class="col-md-3">
                                <h6>{{ __('Quantity: ') }}</h6>
                                <p>{{ $item->quantity }}</h6>
                            </div>
                            <div class="col-md-3">
                                <h6>{{ __('Discount Rate: ') }}</h6>
                                <p>{{ $item->discountRate }}</h6>
                            </div>
                            <div class="col-md-3">
                                <h6>{{ __('Discount Amount: ') }}</h6>
                                <p>{{ $item->discountAmt }}</h6>
                            </div>
                            <div class="col-md-3">
                                <h6>{{ __('Item Expiry Date: ') }}</h6>
                                <p>{{ $item->itemExprDate }}</h6>
                            </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        {{ Form::close() }}

    </div>
    </div>
    </div>
    </div>
@endsection
