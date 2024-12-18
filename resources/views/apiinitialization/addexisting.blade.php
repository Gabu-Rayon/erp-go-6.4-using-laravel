@extends('layouts.admin')

@section('page-title')
    {{ __('Add Existing API Initialization') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('apiinitialization.index') }}">{{ __('API Initializations') }}</a></li>
    <li class="breadcrumb-item">{{ __('Add Existing API Initialization') }}</li>
@endsection

@section('content')
    <div class="row">
        {{ Form::open(['url' => 'apiinitialization/storeexisting', 'class' => 'w-100']) }}
            <div class="col-12">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-3">
                                {{ Form::label('tin', __('TIN (PIN) (*)'), ['class' => 'form-label']) }}
                                {{ Form::text('tin', '', array('class' => 'form-control','required'=>'required')) }}
                            </div>
                            <div class="form-group col-md-3">
                                {{ Form::label('bhfNm', __('Branch Office Name'), ['class' => 'form-label']) }}
                                {{ Form::select('bhfId', $branches, null, ['class' => 'form-control branchNameField']) }}
                            </div>
                            <div class="form-group col-md-3">
                                {{ Form::label('bhfId', __('Branch ID (*)'), ['class' => 'form-label']) }}
                                {{ Form::text('bhfId', '', array('class' => 'form-control branchIdField','required'=>'required','readonly'=>true)) }}
                            </div>
                            <div class="form-group col-md-3">
                                {{ Form::label('dvcSrlNo', __('Device Serial Number (*)'), ['class' => 'form-label']) }}
                                {{ Form::text('dvcSrlNo', '', array('class' => 'form-control','required'=>'required')) }}
                            </div>
                            <div class="form-group col-md-3">
                                {{ Form::label('taxPrNm', __('Taxpayer Name (*)'), ['class' => 'form-label']) }}
                                {{ Form::text('taxPrNm', '', array('class' => 'form-control','required'=>'required')) }}
                            </div>
                            <div class="form-group col-md-3">
                                {{ Form::label('bsnsActv', __('Business Activity'), ['class' => 'form-label']) }}
                                {{ Form::text('bsnsActv', '', array('class' => 'form-control')) }}
                            </div>
                            <div class="form-group col-md-3">
                                {{ Form::label('bhfOpenDt', __('Branch Open Date'), ['class' => 'form-label']) }}
                                {{ Form::date('bhfOpenDt', null, ['class' => 'form-control']) }}
                            </div>
                            <div class="form-group col-md-3">
                                {{ Form::label('prvncNm', __('County Name'), ['class' => 'form-label']) }}
                                {{ Form::text('prvncNm', '', array('class' => 'form-control')) }}
                            </div>
                            <div class="form-group col-md-3">
                                {{ Form::label('dstrtNm', __('Sub County Name'), ['class' => 'form-label']) }}
                                {{ Form::text('dstrtNm', '', array('class' => 'form-control')) }}
                            </div>
                            <div class="form-group col-md-3">
                                {{ Form::label('sctrNm', __('Tax Locality Name'), ['class' => 'form-label']) }}
                                {{ Form::text('sctrNm', '', array('class' => 'form-control')) }}
                            </div>
                            <div class="form-group col-md-3">
                                {{ Form::label('locDesc', __('Local Description'), ['class' => 'form-label']) }}
                                {{ Form::text('locDesc', '', array('class' => 'form-control')) }}
                            </div>
                            <div class="form-group col-md-3">
                                {{ Form::label('hqYn', __('HeadQuarter?'), ['class' => 'form-label']) }}
                                {{ Form::select('hqYn', ['Y' => 'Yes', 'N' => 'No'], null, ['class' => 'form-control hqYnField', 'readonly' => true]) }}
                            </div>
                            <div class="form-group col-md-3">
                                {{ Form::label('mgrNm', __('Manager Name'), ['class' => 'form-label']) }}
                                {{ Form::text('mgrNm', '', array('class' => 'form-control mgrNmField', 'readonly' => true)) }}
                            </div>
                            <div class="form-group col-md-3">
                                {{ Form::label('mgrTelNo', __('Manager Contact No'), ['class' => 'form-label']) }}
                                {{ Form::text('mgrTelNo', '', array('class' => 'form-control mgrTelNoField', 'readonly' => true)) }}
                            </div>
                            <div class="form-group col-md-3">
                                {{ Form::label('mgrEmail', __('Manager Email'), ['class' => 'form-label']) }}
                                {{ Form::text('mgrEmail', '', array('class' => 'form-control mgrEmailField', 'readonly' => true)) }}
                            </div>
                            <div class="form-group col-md-3">
                                {{ Form::label('dvcId', __('Device ID (*)'), ['class' => 'form-label']) }}
                                {{ Form::text('dvcId', '', array('class' => 'form-control','required'=>'required')) }}
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('sdcId', __('Sales Control Unit ID (*)'), ['class' => 'form-label']) }}
                                {{ Form::text('sdcId', '', array('class' => 'form-control','required'=>'required')) }}
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('mrcNo', __('MRC No (*)'), ['class' => 'form-label']) }}
                                {{ Form::text('mrcNo', '', array('class' => 'form-control','required'=>'required')) }}
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('cmcKey', __('CMC Key'), ['class' => 'form-label']) }}
                                {{ Form::text('cmcKey', '', array('class' => 'form-control')) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input
                    type="button"
                    value="{{ __('Cancel') }}"
                    onclick="location.href = '{{ route('purchase.index') }}';"
                    class="btn btn-light"
                    >
                <input type="submit" value="{{ __('Create') }}" class="btn  btn-primary">
            </div>
        {{ Form::close() }}
    </div>
@endsection

@push ('script-page')
    <script>
        const branchNameField = document.querySelector('.branchNameField');
        const branchIdField = document.querySelector('.branchIdField');
        const hqYnField = document.querySelector('.hqYnField');
        const mgrNmField = document.querySelector('.mgrNmField');
        const mgrTelNoField = document.querySelector('.mgrTelNoField');
        const mgrEmailField = document.querySelector('.mgrEmailField');
        branchNameField.addEventListener('change', async function () {
            const url = `http://localhost:8000/getbranchbyname/${this.value}`;
            const response = await fetch(url);
            const { data } = await response.json();
            branchIdField.value = data.bhfId;
            hqYnField.value = data.hqYn;
            mgrNmField.value = data.mgrNm;
            mgrTelNoField.value = data.mgrTelNo;
            mgrEmailField.value = data.mgrEmail;
        });
    </script>
@endpush