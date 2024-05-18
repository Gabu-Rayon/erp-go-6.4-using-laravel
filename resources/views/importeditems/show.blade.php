@extends('layouts.admin')
@section('page-title')
    {{ __('Imported Item') }}
@endsection

@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0">{{ __('Imported Item') }}</h5>
    </div>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('importeditems.index') }}">{{ __('Imported Items') }}</a></li>
    <li class="breadcrumb-item">{{ ucwords($importedItem->taskCode) }}</li>
@endsection

@section('action-btn')
    <div class="float-end m-2">
        <a href="{{ route('importeditems.index') }}" class="btn btn-sm btn-info">
            {{__('Back')}}
        </a>
    </div>
    <div class="float-end m-2">
        <a href="{{ route('importeditems.index') }}" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="{{__('Cancel Sale')}}">
            {{__('Cancel')}}
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            {{ Form::open(['url' => 'importeditems', 'enctype' => 'multipart/form-data']) }}
                <div class="row">
                    <div class="col-md-3">
                        <h6>{{ __('Item Sequence: ') }}</h6>
                        <p>{{ $importedItem->itemSeq }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Task Code: ') }}</h6>
                        <p>{{ $importedItem->taskCode }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Item Name: ') }}</h6>
                        <p>{{ $importedItem->itemName }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('HS Code: ') }}</h6>
                        <p>{{ $importedItem->hsCode }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Package Unit Code: ') }}</h6>
                        <p>{{ $importedItem->pkgUnitCode }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Net Weight: ') }}</h6>
                        <p>{{ $importedItem->netWeight }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Invoice Foreign Code: ') }}</h6>
                        <p>{{ $importedItem->invForCode }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Declaration Date: ') }}</h6>
                        <p>{{ $importedItem->declarationDate }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Origin Nation Code: ') }}</h6>
                        <p>{{ $importedItem->orginNationCode }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Quantity: ') }}</h6>
                        <p>{{ $importedItem->qty }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Supplier Name: ') }}</h6>
                        <p>{{ $importedItem->supplierName }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('NVCFCUREXCRT: ') }}</h6>
                        <p>{{ $importedItem->nvcFcurExcrt }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Export Nation Code: ') }}</h6>
                        <p>{{ $importedItem->exprtNatCode }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Quantity Unit Code: ') }}</h6>
                        <p>{{ $importedItem->qtyUnitCode }}</h6>
                    </div>
                   <div class="col-md-3">
                        <h6>{{ __('Agent Name: ') }}</h6>
                        <p>{{ $importedItem->agentName }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Declaration Number: ') }}</h6>
                        <p>{{ $importedItem->declarationNo }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Package: ') }}</h6>
                        <p>{{ $importedItem->package }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Gross Weight: ') }}</h6>
                        <p>{{ $importedItem->grossWeight }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Invoice Foreign Currency Amount: ') }}</h6>
                        <p>{{ $importedItem->invForCurrencyAmount }}</h6>
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
