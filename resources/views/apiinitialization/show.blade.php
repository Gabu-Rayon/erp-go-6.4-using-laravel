@extends('layouts.admin')
@section('page-title')
    {{ __('API Initialization') }}
@endsection

@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0">{{ __('API Initialization') }}</h5>
    </div>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('apiinitialization.index') }}">{{ __('API Initialization') }}</a></li>
    <li class="breadcrumb-item">{{ ucwords($apiinitialization->dvcSrlNo) }}</li>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            {{ Form::open(['url' => 'apiinitialization', 'enctype' => 'multipart/form-data']) }}
            <div class="modal-body">
                {{-- start for ai module --}}
                @php
                    $plan = \App\Models\Utility::getChatGPTSettings();
                @endphp
                @if ($plan->chatgpt == 1)
                    <div class="text-end">
                        <a href="#" data-size="md" class="btn  btn-primary btn-icon btn-sm"
                            data-ajax-popup-over="true" data-url="{{ route('generate', ['apiinitialization']) }}"
                            data-bs-placement="top" data-title="{{ __('Generate content with AI') }}">
                            <i class="fas fa-robot"></i> <span>{{ __('Generate with AI') }}</span>
                        </a>
                    </div>
                @endif
                {{-- end for ai module --}}
                <div class="row">
                    <div class="form-group col-md-6">
                        {{ Form::label('bsnsActv', __('Bsns Actv'), ['class' => 'form-label']) }}
                        {{ Form::text('bsnsActv', $apiinitialization->bsnsActv, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>

                    <div class="form-group col-md-6">
                        {{ Form::label('bhfNm', __('Bhf Name'), ['class' => 'form-label']) }}
                        {{ Form::text('bhfNm', $apiinitialization->bhfNm, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>

                    <div class="form-group col-md-6">
                        {{ Form::label('bhfOpenDt', __('bhf Open Date'), ['class' => 'form-label']) }}
                        {{ Form::text('bhfOpenDt', $apiinitialization->bhfOpenDt, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-6">
                        {{ Form::label('prvncNm', __('Province Name'), ['class' => 'form-label']) }}
                        {{ Form::text('prvncNm', $apiinitialization->prvncNm, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-6">
                        {{ Form::label('dstrtNm', __('District'), ['class' => 'form-label']) }}
                        {{ Form::text('dstrtNm', $apiinitialization->dstrtNm, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-6">
                        {{ Form::label('scrtNm', __('Scrt Name'), ['class' => 'form-label']) }}
                        {{ Form::text('sctrNm', $apiinitialization->sctrNm, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-6">
                        {{ Form::label('locDesc', __('Local Description'), ['class' => 'form-label']) }}
                        {{ Form::text('locDesc', $apiinitialization->locDesc, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-6">
                        {{ Form::label('hqYn', __('HQ Yn'), ['class' => 'form-label']) }}
                        {{ Form::text('hqYn', $apiinitialization->hqYn, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-6">
                        {{ Form::label('mgrNm', __('Mgr Name'), ['class' => 'form-label']) }}
                        {{ Form::text('mgrNm', $apiinitialization->mgrNm, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-6">
                        {{ Form::label('mgrTelNo', __('mgr Tel No'), ['class' => 'form-label']) }}
                        {{ Form::text('mgrTelNo', $apiinitialization->mgrTelNo, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-6">
                        {{ Form::label('mgrEmail', __('mgrEmail'), ['class' => 'form-label']) }}
                        {{ Form::text('mgrEmail', $apiinitialization->mgrEmail, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-6">
                        {{ Form::label('dvcId', __('device ID'), ['class' => 'form-label']) }}
                        {{ Form::text('dvcId', $apiinitialization->dvcId, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-6">
                        {{ Form::label('sdcId', __('SDC ID'), ['class' => 'form-label']) }}
                        {{ Form::text('sdcId', $apiinitialization->sdcId, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-6">
                        {{ Form::label('devicesrlno', __('MRC NO'), ['class' => 'form-label']) }}
                        {{ Form::text('mrcNo', $apiinitialization->mrcNo, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-6">
                        {{ Form::label('devicesrlno', __(' CMD Key'), ['class' => 'form-label']) }}
                        {{ Form::text('cmcKey', $apiinitialization->cmcKey, ['class' => 'form-control ', 'required' => 'required']) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <input type="button" value="{{ __('Cancel') }}" class="btn btn-light" data-bs-dismiss="modal">
            <input type="submit" value="{{ __('Send') }}" class="btn btn-primary">
        </div>
        {{ Form::close() }}

    </div>
    </div>
    </div>
    </div>
@endsection
