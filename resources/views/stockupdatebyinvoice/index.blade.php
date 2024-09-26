@extends('layouts.admin')
@push('script-page')
@endpush
@section('page-title')
    {{ __('Stock Move List') }}
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="mb-0 h4 d-inline-block font-weight-400 ">{{ __('Stock Move List') }}</h5>
    </div>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Stock Move List') }}</li>
@endsection

@section('action-btn')
    <div class="float-end">
        <div class="mb-4 d-inline-block">
            {{ Form::open(['route' => 'stockmove.searchByDate', 'method' => 'POST', 'class' => 'w-100']) }}
            @csrf
            <div class="form-group">
                {{ Form::label('SearchByDate', __('Search By Date'), ['class' => 'form-label']) }}
                {{ Form::date('searchByDate', null, ['class' => 'form-control', 'required' => 'required']) }}
            </div>
            <button type="submit" class="btn btn-primary sync">{{ __('Search') }}</button>
            {{ Form::close() }}
        </div>
        <!-- <a href="#" data-url="{{ route('stockinfo.create') }}" class="btn btn-sm btn-primary" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{ __('Update Stock By Invoice Number') }}">
                                            Update Stock By Invoice Number
                                        </a> -->
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
                                    <th scope="col">{{ __('From') }}</th>
                                    <th scope="col">{{ __('To') }}</th>
                                    <th scope="col">{{ __('Product') }}</th>
                                    <th scope="col">{{ __('Quantity') }}</th>
                                    <th scope="col">{{ __('Package Quantity') }}</th>
                                    <th scope="col">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @foreach ($branchTransfer as $transfer)
                                    @foreach ($transfer->products as $product)
                                        <tr>
                                            <td>{{ $transfer->fromBranch->name }}</td>
                                            <td>{{ $transfer->toBranch->name }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->pivot->quantity }}</td>
                                            <td>{{ $product->pivot->package_quantity }}</td>
                                            <td>
                                                <a href="{{ route('stockmove.show', $transfer->id) }}"
                                                    class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                                                    title="{{ __('View') }}">
                                                    <i class="fas fa-eye fa-sm"></i>
                                                </a>
                                                <a href="{{ route('stockmove.edit', $transfer->id) }}"
                                                    class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                                                    title="{{ __('Edit') }}">
                                                    <i class="fas fa-pencil-alt fa-sm"></i>
                                                </a>
                                                <a href="#"
                                                    data-url="{{ route('stockmove.destroy', $transfer->id) }}"
                                                    data-branch="{{ $transfer->fromBranch->name }}"
                                                    data-product="{{ $product->name }}"
                                                    class="btn btn-sm btn-danger delete-alert" data-bs-toggle="tooltip"
                                                    title="{{ __('Delete') }}">
                                                    <i class="fas fa-trash fa-sm"></i>
                                                </a>
                                            </td>
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
