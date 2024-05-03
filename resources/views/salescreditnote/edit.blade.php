@extends('layouts.admin')
@section('page-title')
    {{ __('Add Sales Credit Note') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('salescreditnote.index') }}">{{ __('Sales') }}</a></li>
    <li class="breadcrumb-item">{{ ucwords($sale->traderInvoiceNo) }}</li>
@endsection
@push('script-page')
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/jquery.repeater.min.js') }}"></script>
@endpush

@section('content')
    <div class="card m-3">
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-4">
                    <h5>Invoice Number:</h5>
                    <p>{{ $sale->traderInvoiceNo }}</p>
                </div>
                <div class="form-group col-md-4">
                    <h5>Customer Name:</h5>
                    <p>{{ $sale->customerName }}</p>
                </div>
                <div class="form-group col-md-4">
                    <h5>Total Item Count:</h5>
                    <p>{{ count($items) }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        {{ Form::open(['url' => 'salescreditnote', 'class' => 'w-100 sales-form']) }}
        <div class="col-12">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-3">
                            {{ Form::label('creditNoteReason', __('Credit Note Reason (*)'),['class'=>'form-label']) }}
                            {{ Form::select('creditNoteReason', $creditNoteReasons, null, ['class' => 'form-control item-name']) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('salesTypeCodes', __('Sales Type Code (*)'),['class'=>'form-label']) }}
                            {{ Form::select('salesTypeCodes', $salesTypeCodes, null, ['class' => 'form-control item-name']) }}
                        </div>
                        {{ \Log::info('PMT TY CDS')}}
                        {{ \Log::info($paymentTypeCodes)}}
                        <div class="form-group col-md-3">
                            {{ Form::label('paymentTypeCodes', __('Payment Type Code (*)'),['class'=>'form-label']) }}
                            {{ Form::select('paymentTypeCodes', $paymentTypeCodes, null, ['class' => 'form-control item-name']) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('invoiceStatusCodes', __('Sales Type'),['class'=>'form-label']) }}
                            {{ Form::select('invoiceStatusCodes', $invoiceStatusCodes, null, ['class' => 'form-control item-name']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h6 class="card-title">Items</h6>
                @foreach ($items as $item)
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

        <div class="modal-footer">
            <input type="button" value="{{ __('Cancel') }}" onclick="location.href = '{{ route('sales.index') }}';"
                class="btn btn-light">
            <button type="submit" class="btn  btn-primary thee-one-submit-button">{{ __('Create') }}</button>
        </div>
        {{ Form::close() }}
    </div>
@endsection