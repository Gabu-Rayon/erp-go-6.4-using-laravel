@extends('layouts.admin')
@push('script-page')
@endpush
@section('page-title')
    {{ __('Manage Item Information') }}
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0 ">{{ __('Item Information') }}</h5>
    </div>
    Support
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Manage Item Information') }}</li>
@endsection

@section('action-btn')
    <div class="float-end">
        <div class="d-inline-block mb-4">
            {{ Form::open(['route' => 'productservice.searchByDate', 'method' => 'POST', 'class' => 'w-100']) }}
            @csrf
            <div class="form-group">
                {{ Form::label('SearchByDate', __('Search By Date'), ['class' => 'form-label']) }}
                {{ Form::date('searchByDate', null, ['class' => 'form-control', 'required' => 'required']) }}
            </div>
            <button type="submit" class="btn btn-primary sync">{{ __('Search') }}</button>
            {{ Form::close() }}
        </div>
        <a href="#" data-size="md" data-bs-toggle="tooltip" title="{{ __('Import') }}"
            data-url="{{ route('productservice.file.import') }}" data-ajax-popup="true"
            data-title="{{ __('Import product CSV file') }}" class="btn btn-sm btn-primary">
            <i class="ti ti-file-import"></i>
        </a>
        <a href="{{ route('productservice.export') }}" data-bs-toggle="tooltip" title="{{ __('Export') }}"
            class="btn btn-sm btn-primary">
            <i class="ti ti-file-export"></i>
        </a>
        <a href="{{ route('productservice.create') }}" data-bs-toggle="tooltip" title="{{ __('Create New Product') }}"
            class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>
        <a href="{{ route('productservice.synchronize') }}" class="btn btn-sm btn-primary sync" data-bs-toggle="tooltip"
            title="{{ __('Synchronize') }}">
            Synchronize
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="mt-2 {{ isset($_GET['category']) ? 'show' : '' }}" id="multiCollapseExample1">
                <div class="card">
                    <div class="card-body">
                        {{ Form::open(['route' => ['productservice.index'], 'method' => 'GET', 'id' => 'product_service']) }}
                        <div class="d-flex align-items-center justify-content-end">
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                <div class="btn-box">
                                    {{ Form::label('category', __('Category'), ['class' => 'form-label']) }}
                                    {{ Form::select('category', $category, null, ['class' => 'form-control select', 'id' => 'choices-multiple', 'required' => 'required']) }}
                                </div>
                            </div>
                            <div class="col-auto float-end ms-2 mt-4">
                                <a href="#" class="btn btn-sm btn-primary"
                                    onclick="document.getElementById('product_service').submit(); return false;"
                                    data-bs-toggle="tooltip" title="{{ __('Apply') }}">
                                    <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                </a>
                                <a href="{{ route('productservice.index') }}" class="btn btn-sm btn-danger"
                                    data-bs-toggle="tooltip" title="{{ __('Reset') }}">
                                    <span class="btn-inner--icon"><i class="ti ti-trash-off"></i></span>
                                </a>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ __('Code') }}</th>
                                        <th scope="col">{{ __('Classification Code') }}</th>
                                        <th scope="col">{{ __('Name') }}</th>
                                        <th scope="col">{{ __('Price') }}</th>
                                        <th scope="col">{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @foreach ($productServices as $iteminformation)
                                        <tr>
                                            <td>{{ $iteminformation->itemCd }}</td>
                                            <td>{{ $iteminformation->itemClsCd }}</td>
                                            <td>{{ $iteminformation->itemNM }}</td>
                                            <td>{{ $iteminformation->dftPrc }}</td>
                                            <td>
                                                <div class="action-btn bg-warning ms-2">
                                                    <a href="{{ route('productservice.show', $iteminformation->id) }}"
                                                        class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                        data-bs-toggle="tooltip" title="{{ __('Details') }}">
                                                        <i class="ti ti-eye text-white"></i>
                                                    </a>
                                                </div>
                                                <div class="action-btn bg-info ms-2">
                                                    <a href="#" class="mx-3 btn btn-sm align-items-center"
                                                        data-url="{{ route('productservice.edit', $iteminformation->id) }}"
                                                        data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip"
                                                        title="{{ __('Edit') }}"
                                                        data-title="{{ __('Edit Product Service Info') }}">
                                                        <i class="ti ti-pencil text-white"></i>
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
    </div>
@endsection