@extends('layouts.admin')
@php
    $dir = asset(Storage::url('uploads/plan'));
@endphp
@section('page-title')
    {{ __('Manage Insurance Plans') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Insurance Plan') }}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        @can('create plan')
            <a href="#" data-size="lg" data-url="{{ route('plans.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create New Insurance')}}" data-title="{{__('Create New Insurance')}}" class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>
        @endcan
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
                                <th>#</th>
                                <th> {{__('InsuranceCode')}}</th>
                                <th> {{__('InsuranceName')}}</th>
                                <th> {{__('PremiumRate')}}</th>
                                <th>{{__('isUsed')}}</th>
                            </tr>
                            </thead>
                            <tbody>                                
                             @foreach ($plans as $plan)
                                    <tr class="font-style">
                                        <td>{{$plan->id }}</td>
                                        <td>{{ $plan->insuranceCode }}</td>
                                        <td>{{$plan->insuranceName }}</td>
                                        <td>{{$plan->premiumRate }}</td>
                                        <td>{{$plan->isUsed ? 'Y' : 'N'}}

                                            </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

 
