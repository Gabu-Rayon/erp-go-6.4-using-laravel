@extends('layouts.admin')
@push('script-page')
@endpush
@section('page-title')
    {{__('Manage Code List')}}
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0 ">{{__('Code List')}}</h5>
    </div>Support
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Manage Code List')}}</li>
@endsection

@section('action-btn')
    <div class="float-end">
       <a href="#" data-size="lg" data-url="{{ route('iteminformation.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create Item Information')}}" data-title="{{__('Create Item Information')}}" class="btn btn-sm btn-primary">
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
                            <th scope="col">{{__('SrNo')}}</th>
                            <th scope="col">{{__('CDCls')}}</th>
                            <th scope="col">{{__('CDClsNm')}}</th>
                            <th scope="col">{{__('Use')}}</th>
                            <th scope="col">{{__('UserDfnNm1')}}</th>
                            <th scope="col">{{__('LastRequestDate')}}</th>
                        </tr>
                        </thead>
                        <tbody class="list">
                            @foreach($codelists as $codelist)
                                <tr>
                                    <td>{{$codelist->id}}</td>
                                    <td>{{$codelist->cdCls}}</td>
                                    <td>{{$codelist->cdClsNm}}</td>
                                    <td>{{$codelist->useYn}}</td>
                                    <td>{{$codelist->userDfnNm1}}</td>
                                    <td>{{$codelist->created_at}}</td>
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

