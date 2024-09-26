@extends('layouts.admin')
@section('page-title')
    {{ __('Stock Move') }}
@endsection

@section('title')
    <div class="d-inline-block">
        <h6 class="h6 d-inline-block font-weight-400 mb-0">{{ __('Stock Move') }}</h6>
    </div>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('stockinfo.index') }}">{{ __('Stock Move') }}</a></li>
    <li class="breadcrumb-item">Details</li>
@endsection

@section('action-btn')
    <div class="float-end m-2">
        <a href="{{ route('stockmove.index') }}" class="btn btn-sm btn-info">
            {{__('Back')}}
        </a>
    </div>
    <div class="float-end m-2">
        <a href="{{ route('stockmove.index', $stockMove->id) }}" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="{{__('Cancel')}}">
            {{__('Cancel')}}
        </a>
    </div>
    <div class="float-end m-2">
        <a href="{{ route('stockmove.edit', $stockMove->id) }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="{{__('Cancel')}}">
            {{__('Stock Move')}}
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            {{ Form::open(['url' => 'stockmove', 'enctype' => 'multipart/form-data']) }}
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3">
                        <h6>{{ __('Customer TIN: ') }}</h6>
                        <p>{{ $stockMove->custTin }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Customer Branch ID: ') }}</h6>
                        <p>{{ $stockMove->custBhfId }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Sar NO: ') }}</h6>
                        <p>{{ $stockMove->sarNo }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('OCRN Date: ') }}</h6>
                        <p>{{ $stockMove->ocrnDt }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Total Item Count: ') }}</h6>
                        <p>{{ $stockMove->totItemCnt }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Total Taxable Amount: ') }}</h6>
                        <p>{{ $stockMove->totTaxblAmt }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Total Tax Amount: ') }}</h6>
                        <p>{{ $stockMove->totTaxAmt }}</h6>
                    </div>
                    <div class="col-md-12">
                        <h6>{{ __('Remark: ') }}</h6>
                        <p>{{ $stockMove->remark }}</h6>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title">Items</h6>
                        @foreach ($stockMoveItems as $item)
                        {{ \Log::info($item) }}
                        <div class="card-body">
                            <div class="row">
                            <h6 class="card-title text-info text-lg">Item</h6>
                            <div class="col-md-3">
                                <h6>{{ __('Item Sequence No: ') }}</h6>
                                <p>{{ $item->itemSeq }}</h6>
                            </div>
                            <div class="col-md-3">
                                <h6>{{ __('Classification Code: ') }}</h6>
                                <p>{{ $item->itemClsCd }}</h6>
                            </div>
                            <div class="col-md-3">
                                <h6>{{ __('Item Code: ') }}</h6>
                                <p>{{ $item->itemCd }}</h6>
                            </div>
                            <div class="col-md-3">
                                <h6>{{ __('Item Name: ') }}</h6>
                                <p>{{ $item->itemNm }}</h6>
                            </div>
                            <div class="col-md-3">
                                <h6>{{ __('Bar Code: ') }}</h6>
                                <p>{{ $item->bcd }}</h6>
                            </div>
                            <div class="col-md-3">
                                <h6>{{ __('Quantity Unit Code: ') }}</h6>
                                <p>{{ $item->qtyUnitCd }}</h6>
                            </div>
                            <div class="col-md-3">
                                <h6>{{ __('Quantity: ') }}</h6>
                                <p>{{ $item->qty }}</h6>
                            </div>
                            <div class="col-md-3">
                                <h6>{{ __('Item Expiry Date: ') }}</h6>
                                <p>{{ $item->itemExprDt }}</h6>
                            </div>
                            <div class="col-md-3">
                                <h6>{{ __('Price: ') }}</h6>
                                <p>{{ $item->prc }}</h6>
                            </div>
                            <div class="col-md-3">
                                <h6>{{ __('Supply Amount: ') }}</h6>
                                <p>{{ $item->splyAmt }}</h6>
                            </div>
                            <div class="col-md-3">
                                <h6>{{ __('Total Discount Amount: ') }}</h6>
                                <p>{{ $item->totDcAmt }}</h6>
                            </div>
                            <div class="col-md-3">
                                <h6>{{ __('Taxable Amount: ') }}</h6>
                                <p>{{ $item->taxblAmt }}</h6>
                            </div>
                            <div class="col-md-3">
                                <h6>{{ __('Tax Type Code: ') }}</h6>
                                <p>{{ $item->taxTyCd }}</h6>
                            </div>
                            <div class="col-md-3">
                                <h6>{{ __('Tax Amount: ') }}</h6>
                                <p>{{ $item->taxAmt }}</h6>
                            </div>
                            <div class="col-md-3">
                                <h6>{{ __('Total Amount: ') }}</h6>
                                <p>{{ $item->totAmt }}</h6>
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
