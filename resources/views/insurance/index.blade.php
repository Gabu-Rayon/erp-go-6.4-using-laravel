@extends('layouts.admin')
@section('page-title')
    {{ __('Manage Purchase') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Insurance insurance') }}</li>
@endsection
@section('action-btn')
    <div class="float-end">
            <a href="#" data-size="lg" data-url="{{ route('insurance.create') }}" data-ajax-popup="true"  data-bs-toggle="tooltip" title="{{__('Add New Insurance')}}"  class="btn btn-sm btn-primary">
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
                                <th>#</th>
                                <th> {{__('InsuranceCode')}}</th>
                                <th> {{__('InsuranceName')}}</th>
                                <th> {{__('PremiumRate')}}</th>
                                <th>{{__('isUsed')}}</th>
                            </tr>
                            </thead>
                            <tbody>                                
                             @foreach ($insurances as $insurance)
                                    <tr class="font-style">
                                        <td>{{$insurance->id }}</td>
                                        <td>{{ $insurance->insuranceCode }}</td>
                                        <td>{{$insurance->insuranceName }}</td>
                                        <td>{{$insurance->premiumRate }}</td>
                                        <td>{{$insurance->isUsed ? 'Y' : 'N'}}

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

 
