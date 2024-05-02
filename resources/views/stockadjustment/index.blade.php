@extends('layouts.admin')
@push('script-page')
@endpush
@section('page-title')
    {{__('Stock Move List')}}
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0 ">{{__('Stock Move List')}}</h5>
    </div>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Stock Move List')}}</li>
@endsection

@section('action-btn')
    <div class="float-end">
        <a href="#" data-url="{{ route('stockadjustment.create') }}" class="btn btn-sm btn-primary" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Add Stock Adjustment')}}">
            Add Stock Adjustment
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
                            <th scope="col">{{__('SrNo')}}</th>
                            <th scope="col">{{__('Item Code')}}</th>
                            <th scope="col">{{__('RSD Quantity')}}</th>
                            <th scope="col">{{__('Registration No')}}</th>
                            <th scope="col">{{__('Registration ID')}}</th>
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