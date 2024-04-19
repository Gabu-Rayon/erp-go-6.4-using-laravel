@extends('layouts.admin')
@push('script-page')
@endpush
@section('page-title')
    {{__('Manage Item Information')}}
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0 ">{{__('Item Information')}}</h5>
    </div>Support
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Manage Item Information')}}</li>
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
                        <th scope="col">{{__('Code')}}</th>
                        <th scope="col">{{__('Classification Code')}}</th>
                        <th scope="col">{{__('Type Code')}}</th>
                        <th scope="col">{{__('Name')}}</th>
                        <th scope="col">{{__('Price')}}</th>
                        <th scope="col" >{{__('Action')}}</th>
                        </tr>
                        </thead>
                        <tbody class="list">
                        @foreach ($iteminformations as $iteminformation)
                            <tr>
                                <td>{{ $iteminformation->id }}</td>
                                <td>{{ $iteminformation->itemCd }}</td>
                                <td>{{ $iteminformation->itemClsCd }}</td>
                                <td>{{ $itemtypes[$iteminformation->itemTyCd - 1]['item_type_name'] }}</td>
                                <td>{{ $iteminformation->itemNm }}</td>
                                <td>{{ $iteminformation->dftPrc }}</td>
                                <td>
                                    <div class="action-btn bg-warning ms-2">
                                        <a href="{{ route('iteminformation.show',$iteminformation->id) }}" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="tooltip" title="{{__('Details')}}"><i class="ti ti-eye text-white"></i></a>
                                    </div>
                                    <div class="action-btn bg-info ms-2">
                                        <a href="#" class="mx-3 btn btn-sm  align-items-center" data-url="{{ route('iteminformation.edit',$iteminformation->id) }}" data-ajax-popup="true"  data-size="lg " data-bs-toggle="tooltip" title="{{__('Edit')}}"  data-title="{{__('Edit Item Info')}}">
                                            <i class="ti ti-pencil text-white"></i>
                                        </a>
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

