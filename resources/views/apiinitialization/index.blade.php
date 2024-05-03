@extends('layouts.admin')
@push('script-page')
@endpush
@section('page-title')
    {{__('API Initialization')}}
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0 ">{{__('API Initialization')}}</h5>
    </div>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('API Initialization')}}</li>
@endsection

@section('action-btn')
    <div class="float-end">
        <a href="#" data-url="{{ route('apiinitialization.create') }}" class="btn btn-sm btn-primary" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create New Initialization')}}">
            Initialization New
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
                            <th scope="col">{{__('Tin')}}</th>
                            <th scope="col">{{__('BHD Id')}}</th>
                            <th scope="col">{{__('DVC SrlNo')}}</th>
                            <th scope="col">{{__('Taxpr Nm')}}</th>
                            <th scope="col">{{__('Head Quarter')}}</th>
                            <th scope="col" >{{__('Action')}}</th>
                        </tr>
                        </thead>
                        <tbody class="list">
                            @foreach ($apiinitializations as $apiinitialization)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $apiinitialization->tin }}</td>
                                    <td>{{ $apiinitialization->bhfId }}</td>
                                    <td>{{ $apiinitialization->dvcSrlNo }}</td>
                                    <td>{{ $apiinitialization->taxprNm }}</td>
                                    <td>{{ $apiinitialization->hqYn }}</td>
                                    <td>
                                        <div class="action-btn bg-warning ms-2">
                                            <a href="{{ route('apiinitialization.show',$apiinitialization->id) }}" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="tooltip" title="{{__('Details')}}"><i class="ti ti-eye text-white"></i></a>
                                        </div>
                                    </td>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection

