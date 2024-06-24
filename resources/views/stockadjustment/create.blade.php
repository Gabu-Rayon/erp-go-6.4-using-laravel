@extends('layouts.admin')

@push('script-page')
@endpush

@section('page-title')
    {{__('Stock Adjustment List')}}
@endsection

@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0 ">{{__('Stock Adjustment List')}}</h5>
    </div>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Stock Adjustment List')}}</li>
@endsection

@section('action-btn')
    <div class="float-end">
        <a href="{{ route('stockadjustment.create', 0) }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="{{ __('Add Stock Adjustment') }}">
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
                            <th scope="col">{{__('Item Code')}}</th>
                            <th scope="col">{{__('RSD Quantity')}}</th>
                            <th scope="col">{{__('Package Quantity')}}</th>
                            <th scope="col">{{__('Quantity')}}</th>
                        </tr>
                        </thead>
                        <tbody class="list">
                        @foreach ($stockadjustments as $stockadjustment)
                            @foreach ($stockadjustment->stockAdjustmentProductLists as $productList)
                                <tr>
                                    <td>{{ $productList->itemCode }}</td>
                                    <td>{{ $stockadjustment->rsdQty }}</td>
                                    <td>{{ $productList->packageQuantity }}</td>
                                    <td>{{ $productList->quantity }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
