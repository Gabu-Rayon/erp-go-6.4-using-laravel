@extends('layouts.admin')
@push('script-page')
@endpush
@section('page-title')
    {{__('Sales')}}
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0 ">{{__('Sales')}}</h5>
    </div>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Sales')}}</li>
@endsection

@section('action-btn')
    <div class="float-end">
        <a href="{{ route('sales.create',0) }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="{{__('Add Sales')}}">
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
                            <th scope="col">{{__('Trader Invoice No')}}</th>
                            <th scope="col">{{__('Customer Tin')}}</th>
                            <th scope="col">{{__('Sales Type')}}</th>
                            <th scope="col">{{__('Payments Type')}}</th>
                            <th scope="col">{{__('Status')}}</th>
                            <th scope="col" >{{__('Action')}}</th>
                        </tr>
                        </thead>
                        <tbody class="list">
                            @foreach ($sales as $sale)
                                <tr>
                                    <td>{{ $sale->id }}</td>
                                    <td>{{ $sale->traderInvoiceNo }}</td>
                                    <td>{{ $sale->customerTin }}</td>
                                    <td>{{ $sale->salesType }}</td>
                                    <td>{{ $sale->paymentType }}</td>
                                    <td>{{ $sale->status }}</td>
                                    <td>
                                        <div class="action-btn bg-info">
                                            <a href="{{ route('sales.show',$sale) }}" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="tooltip" title="{{__('Details')}}">
                                                <i class="ti ti-eye text-white"></i>
                                            </a>
                                        </div>
                                        <div class="action-btn bg-success">
                                            <a href="{{ route('sales.print',$sale) }}" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="tooltip" title="{{__('Print')}}">
                                                <i class="ti ti-printer text-white"></i>
                                            </a>
                                        </div>
                                        <div class="action-btn bg-secondary">
                                            <a href="{{ route('salescreditnote.edit',$sale) }}" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="tooltip" title="{{__('Credit Note')}}">
                                                <i class="ti ti-book text-white"></i>
                                            </a>
                                        </div>
                                        <div class="action-btn bg-warning">
                                            <a href="{{ route('sales.edit',$sale) }}" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="tooltip" title="{{__('Edit')}}">
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

