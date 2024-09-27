@extends('layouts.admin')
@section('page-title')
    {{ __('Stock Master Save Request') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a
            href="{{ route('stock.master.save.request.index') }}">{{ __('Stock Master Save Request') }}</a></li>
    <li class="breadcrumb-item">{{ __('Stock Master Save Request') }}</li>
@endsection

@section('content')
    <div class="row">
        {{ Form::open(['url' => 'save/request/store', 'class' => 'w-100']) }}
        <div class="col-12">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-3">
                            {{ Form::label('itemCd', __('Item'), ['class' => 'form-label']) }}
                            {{ Form::select('itemCd', $items, null, ['class' => 'form-control select2']) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('rsdQty', __('RSD Qty'), ['class' => 'form-label']) }}
                            {{ Form::text('rsdQty', '', ['class' => 'form-control']) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('bhfId', __('Branch'), ['class' => 'form-label']) }}
                            {{ Form::select('bhfId', $branches, null, ['class' => 'form-control select2']) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('tin', __('TIN'), ['class' => 'form-label']) }}
                            {{ Form::text('tin', '', ['class' => 'form-control']) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('modrId', __('MODR ID'), ['class' => 'form-label']) }}
                            {{ Form::text('modrId', '', ['class' => 'form-control']) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('modrNm', __('MODR Name'), ['class' => 'form-label']) }}
                            {{ Form::text('modrNm', '', ['class' => 'form-control']) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('regrId', __('REGR ID'), ['class' => 'form-label']) }}
                            {{ Form::text('regrId', '', ['class' => 'form-control']) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('regrNm', __('REGR Name'), ['class' => 'form-label']) }}
                            {{ Form::text('regrNm', '', ['class' => 'form-control']) }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <input type="button" value="{{ __('Cancel') }}"
                    onclick="location.href = '{{ route('stock.master.save.request.index') }}';" class="btn btn-light">
                <input type="submit" value="{{ __('Create') }}" class="btn btn-primary">
            </div>
            {{ Form::close() }}
        </div>
    @endsection
