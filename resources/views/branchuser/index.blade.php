@extends('layouts.admin')
@section('page-title')
    {{ __('Manage Branch User') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Branch Users') }}</li>
@endsection

@section('action-btn')
    <div class="float-end">
            <a href="#" data-url="{{ route('branchuser.create') }}" data-ajax-popup="true"
                data-title="{{ __('Create New Branch User') }}" data-bs-toggle="tooltip" title="{{ __('Create') }}"
                class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-3">
            @include('layouts.hrm_setup')
        </div>
        <div class="col-9">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>User Name</th>
                                    <th>Contact No</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="font-style">
                                @foreach ($branchUsers as $branchUser)
                                    <tr>
                                        <td>{{ $branchUser->branchUserName }}</td>
                                        <td>{{ $branchUser->contactNo }}</td>
                                        <td>
                                            <div class="action-btn bg-info ms-2">
                                                <a href="#" class="mx-3 btn btn-sm  align-items-center" data-url="{{ route('branchuser.edit',$branchUser->id) }}" data-ajax-popup="true"  data-size="lg" data-bs-toggle="tooltip" title="{{__('Edit')}}"  data-title="{{__('Edit Branch User')}}">
                                                    <i class="ti ti-pencil text-white"></i>
                                                </a>
                                            </div> 
                                            <div class="action-btn bg-warning ms-2">
                                                <a href="#" class="mx-3 btn btn-sm  align-items-center" data-url="{{ route('branchuser.destroy',$branchUser->id) }}" data-ajax-popup="true"  data-size="lg" data-bs-toggle="tooltip" title="{{__('Delete')}}"  data-title="{{__('Delete Branch User')}}">
                                                    <i class="ti ti-trash text-white"></i>
                                                </a>
                                            </div> 
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
