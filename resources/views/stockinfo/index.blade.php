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
        <a href="#" data-url="{{ route('stockinfo.create') }}" class="btn btn-sm btn-primary" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Update Stock By Invoice Number')}}">
            Update Stock By Invoice Number
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
                            <th scope="col">{{__('CustTin')}}</th>
                            <th scope="col">{{__('CustBhfId')}}</th>
                            <th scope="col">{{__('SarNo')}}</th>
                            <th scope="col">{{__('OcrnDt')}}</th>
                            <th scope="col">{{__('TotItemCnt')}}</th>
                            <th scope="col">{{__('Status')}}</th>
                            <th scope="col" >{{__('Action')}}</th>
                        </tr>
                        </thead>
                        <tbody class="list">
                            @foreach ($stockMoveList as $stockMove)
                                <tr>
                                    <td>{{ $stockMove->id }}</td>
                                    <td>{{ $stockMove->custTin }}</td>
                                    <td>{{ $stockMove->custBhfId }}</td>
                                    <td>{{ $stockMove->sarNo }}</td>
                                    <td>{{ $stockMove->ocrnDt }}</td>
                                    <td>{{ $stockMove->totItemCnt }}</td>
                                    <td>{{ $stockMove->status }}</td>
                                    <td>
                                        <div class="action-btn bg-warning ms-2">
                                            <a href="{{ route('stockinfo.show',$stockMove) }}" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="tooltip" title="{{__('Details')}}"><i class="ti ti-eye text-white"></i></a>
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


