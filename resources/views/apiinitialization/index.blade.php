@extends('layouts.admin')
@push('script-page')
@endpush
@section('page-title')
    {{__('API Initialization')}}
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0 ">{{__('API Initialization')}}</h5>
    </div>Support
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('API Initialization')}}</li>
@endsection

@section('action-btn')
    <div class="float-end">
       <a href="#" data-size="lg" data-url="{{ route('apiinitialization.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create')}}" data-title="{{__('Create API Initialization')}}" class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table datatable">
                        <thead>
                        <tr>
                            <th scope="col">{{__('Tax Payer ID')}}</th>
                            <th scope="col">{{__('BHF ID')}}</th>
                            <th scope="col">{{__('Device Serial No')}}</th>
                            <th scope="col">{{__('Tax Payer Name')}}</th>
                            <th scope="col">{{__('Business Activity')}}</th>
                            <th scope="col">{{__('BHF Name')}}</th>
                            <th scope="col">{{__('BHF Open Date')}}</th>
                            <th scope="col" >{{__('Province Number')}}</th>
                        </tr>
                        </thead>
                        <tbody class="list">
                          
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection

