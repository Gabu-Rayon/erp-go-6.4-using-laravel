@extends('layouts.admin')
@section('page-title')
    {{ __('Manage Item Classifications') }}
@endsection
@push('script-page')
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Item Classifications') }}</li>
@endsection

@section('action-btn')
    <div class="float-end">
        <div class="d-inline-block mb-4">
            {{ Form::open(['route' => 'productservice.searchItemClassificationByDate', 'method' => 'POST', 'class' => 'w-100']) }}
            @csrf
            <div class="form-group">
                {{ Form::label('SearchItemClassificationByDate', __('Search Date (ex- 01-Jan-2022)'), ['class' => 'form-label']) }}
                {{ Form::date('searchItemClassificationByDate', null, ['class' => 'form-control', 'required' => 'required']) }}
            </div>
            <button type="submit" class="btn btn-primary sync">{{ __('Search') }}</button>
            {{ Form::close() }}
        </div>
        <a href="{{ route('productservice.synchronizeitemclassifications') }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
            title="{{ __('Synchronize') }}">
            Synchronize
        </a>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('SrNo') }}</th>
                                    <th>{{ __('Code') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Level') }}</th>
                                    <th>{{ __('useYn') }}</th>
                                    <th>{{ __('Mapping') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($itemclassifications as $classification)
                                    <tr class="font-style">
                                        <td>{{$classification->id }}</td>
                                        <td>{{ $classification->itemClsCd }}</td>
                                        <td class="text-wrap">{{$classification->itemClsNm}}</td>
                                        <td>{{$classification->itemClsLvl }}</td>
                                        <td>{{ $classification->useYn }}</td>
                                        <td>{{$classification->mapping}}</td>
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