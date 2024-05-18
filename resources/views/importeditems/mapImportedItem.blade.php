@extends('layouts.admin')

@section('page-title')
    {{ __('Map Imported Product') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('importeditems.index') }}">{{ __('Imported Product') }}</a></li>
    <li class="breadcrumb-item">{{ __('Map Imported Product') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body" data-autofill>
                    {{ Form::open(['url' => 'mapimporteditem', 'method' => 'POST', 'class' => 'w-100']) }}
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <div class="row">
                        <div class="form-group col-md-12">
                            {{ Form::label('importedItemName', __('Imported Product Name'), ['class' => 'form-label']) }}
                            {{ Form::select('importedItemName', $importedItems, null, ['class' => 'form-control select2 item-name']) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('item', __('My Item(s) Name'), ['class' => 'form-label']) }}
                            {{ Form::select('item', $items, null, ['class' => 'form-control select2 item-name']) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('importItemStatusCode', __('Import Product Status Code'), ['class' => 'form-label']) }}
                            {{ Form::select('importItemStatusCode', $importItemStatusCode, null, ['class' => 'form-control select2 item-name']) }}
                        </div>
                        <div class="form-group col-md-12">
                            {{ Form::label('remark', __('Remark(*)'), ['class' => 'form-label']) }}
                            {{ Form::textarea('remark', '', ['class' => 'form-control', 'placeholder' => 'Enter your remarks...', 'required' => 'required']) }}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="button" value="{{ __('Cancel') }}" onclick="location.href = '{{ route('importeditems.index') }}';" class="btn btn-light">
                        <input type="submit" value="{{ __('Save') }}" class="btn btn-primary">
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
