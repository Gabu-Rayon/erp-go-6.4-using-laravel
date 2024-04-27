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
    <li class="breadcrumb-item">{{ ucwords($importedItem->srNo) }}</li>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            {{ Form::open(['url' => 'importeditems', 'enctype' => 'multipart/form-data']) }}
                <div class="row">
                    <div class="form-group col-md-4">
                        {{ Form::label('bsnsActv', __('Task Code'), ['class' => 'form-label']) }}
                        {{ Form::text('bsnsActv', $importedItem->taskCode, ['class' => 'form-control ', 'required' => 'required', 'placeholder' => $importedItem->taskCode, 'readonly' => true]) }}
                    </div>

                    <div class="form-group col-md-4">
                        {{ Form::label('bhfNm', __('Item Name'), ['class' => 'form-label']) }}
                        {{ Form::text('bhfNm', $importedItem->itemName, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>

                    <div class="form-group col-md-4">
                        {{ Form::label('bhfOpenDt', __('HS Code'), ['class' => 'form-label']) }}
                        {{ Form::text('bhfOpenDt', $importedItem->hsCode, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-4">
                        {{ Form::label('prvncNm', __('Package Unit Code'), ['class' => 'form-label']) }}
                        {{ Form::text('prvncNm', $importedItem->pkgUnitCode, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-4">
                        {{ Form::label('dstrtNm', __('Net Weight'), ['class' => 'form-label']) }}
                        {{ Form::text('dstrtNm', $importedItem->netWeight, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-4">
                        {{ Form::label('scrtNm', __('Invoice Foreign Code'), ['class' => 'form-label']) }}
                        {{ Form::text('sctrNm', $importedItem->invForCode, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-4">
                        {{ Form::label('locDesc', __('Declaration Date'), ['class' => 'form-label']) }}
                        {{ Form::text('locDesc', $importedItem->declarationDate, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-4">
                        {{ Form::label('hqYn', __('Origin Nation Code'), ['class' => 'form-label']) }}
                        {{ Form::text('hqYn', $importedItem->orginNationCode, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-4">
                        {{ Form::label('mgrNm', __('Quantity'), ['class' => 'form-label']) }}
                        {{ Form::text('mgrNm', $importedItem->qty, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-4">
                        {{ Form::label('mgrTelNo', __('Supplier Name'), ['class' => 'form-label']) }}
                        {{ Form::text('mgrTelNo', $importedItem->supplierName, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-4">
                        {{ Form::label('mgrEmail', __('nvcFcurExcrt'), ['class' => 'form-label']) }}
                        {{ Form::text('mgrEmail', $importedItem->nvcFcurExcrt, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-4">
                        {{ Form::label('dvcId', __('Item Sequence'), ['class' => 'form-label']) }}
                        {{ Form::text('dvcId', $importedItem->itemSeq, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-4">
                        {{ Form::label('sdcId', __('Export Nation Code'), ['class' => 'form-label']) }}
                        {{ Form::text('sdcId', $importedItem->exprtNatCode, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-4">
                        {{ Form::label('devicesrlno', __('Quantity Code'), ['class' => 'form-label']) }}
                        {{ Form::text('mrcNo', $importedItem->qtyUnitCode, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-4">
                        {{ Form::label('devicesrlno', __('Agent Name'), ['class' => 'form-label']) }}
                        {{ Form::text('cmcKey', $importedItem->agentName, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-4">
                        {{ Form::label('devicesrlno', __('Declaration Number'), ['class' => 'form-label']) }}
                        {{ Form::text('cmcKey', $importedItem->declarationNo, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-4">
                        {{ Form::label('devicesrlno', __('Package'), ['class' => 'form-label']) }}
                        {{ Form::text('cmcKey', $importedItem->package, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-4">
                        {{ Form::label('devicesrlno', __('Gross Weight'), ['class' => 'form-label']) }}
                        {{ Form::text('cmcKey', $importedItem->grossWeight, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-4">
                        {{ Form::label('devicesrlno', __('Invoice Foreign Currency Amount'), ['class' => 'form-label']) }}
                        {{ Form::text('cmcKey', $importedItem->invForCurrencyAmount, ['class' => 'form-control ', 'required' => 'required']) }}
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
