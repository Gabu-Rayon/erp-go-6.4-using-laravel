
@extends('layouts.admin')

@section('page-title')
    {{ __('Branch Stock Transfer Information') }}
@endsection

@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0">{{ __('Branch Stock Transfer Information') }}</h5>
    </div>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('branch.transfer.index') }}">{{ __('Branch Stock Transfer List') }}</a></li>
    <li class="breadcrumb-item">{{ ucwords($branch->to_branch) }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3">
                    <h6>{{ __('Branch From: ') }}</h6>
                    <p>{{ $branch->from_branch }}</p>
                </div>
                <div class="col-md-3">
                    <h6>{{ __('Branch To: ') }}</h6>
                    <p>{{ $branch->to_branch }}</p>
                </div>
                <div class="col-md-3">
                    <h6>{{ __('Total Items: ') }}</h6>
                    <p>{{ $branch->totItemCnt }}</p>
                </div>
                <div class="col-md-3">
                    <h6>{{ __('Status: ') }}</h6>
                    <p>{{ $branch->status }}</p>
                </div>
            </div>

            <h5 class="mt-4">{{ __('Transfer Items') }}</h5>
            <div class="row">
                @foreach ($branchTransferProducts as $product)
                    <div class="col-md-3">
                        <h6>{{ __('Item Code: ') }}</h6>
                        <p>{{ $product->itemCode }}</p>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Quantity: ') }}</h6>
                        <p>{{ $product->quantity }}</p>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Package Quantity: ') }}</h6>
                        <p>{{ $product->pkgQuantity }}</p>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Created At: ') }}</h6>
                        <p>{{ $product->created_at }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
