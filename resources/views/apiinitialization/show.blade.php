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
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-3">
                        <h6>Business Activity</h6>
                        <p>{{ $apiinitialization->bsnsActv }}</p>
                    </div>
                    <div class="form-group col-md-3">
                        <h6>BHF Name</h6>
                        <p>{{ $apiinitialization->bhfNm }}</p>
                    </div>
                    <div class="form-group col-md-3">
                        <h6>BHF Open Date</h6>
                        <p>{{ $apiinitialization->bhfOpenDt }}</p>
                    </div>
                    <div class="form-group col-md-3">
                        <h6>Province</h6>
                        <p>{{ $apiinitialization->prvncNm }}</p>
                    </div>
                    <div class="form-group col-md-3">
                        <h6>District</h6>
                        <p>{{ $apiinitialization->dstrtNm }}</p>
                    </div>
                    <div class="form-group col-md-3">
                        <h6>Tax Locality Name</h6>
                        <p>{{ $apiinitialization->sctrNm }}</p>
                    </div>
                    <div class="form-group col-md-3">
                        <h6>Local Description</h6>
                        <p>{{ $apiinitialization->locDesc ? $apiinitialization->locDesc : 'N/A' }}</p>
                    </div>
                    <div class="form-group col-md-3">
                        <h6>HeadQuarter?</h6>
                        <p>{{ $apiinitialization->hqYn == 'Y' ? 'Yes' : 'No' }}</p>
                    </div>
                    <div class="form-group col-md-3">
                        <h6>Manager Name</h6>
                        <p>{{ $apiinitialization->mgrNm }}</p>
                    </div>
                    <div class="form-group col-md-3">
                        <h6>Manager Contact No</h6>
                        <p>{{ $apiinitialization->mgrTelNo }}</p>
                    </div>
                    <div class="form-group col-md-3">
                        <h6>Manager Email</h6>
                        <p>{{ $apiinitialization->mgrEmail }}</p>
                    </div>
                    <div class="form-group col-md-3">
                        <h6>Device ID</h6>
                        <p>{{ $apiinitialization->dvcId }}</p>
                    </div>
                    <div class="form-group col-md-3">
                        <h6>SDC ID</h6>
                        <p>{{ $apiinitialization->sdcId }}</p>
                    </div>
                    <div class="form-group col-md-3">
                        <h6>MRC NO</h6>
                        <p>{{ $apiinitialization->mrcNo }}</p>
                    </div>
                    <div class="form-group col-md-4">
                        <h6>CMD Key</h6>
                        <p>{{ $apiinitialization->cmcKey }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection