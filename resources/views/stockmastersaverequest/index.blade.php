@extends('layouts.admin')
@push('script-page')
@endpush
@section('page-title')
    {{ __('Stock Master Save Request') }}
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="mb-0 h4 d-inline-block font-weight-400 ">{{ __('Stock Master Save Request') }}</h5>
    </div>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Stock Master Save Request') }}</li>
@endsection

@section('action-btn')
    <div class="float-end">
        <a href="{{ route('save.request.create') }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
            title="{{ __('Stock Master Save Request') }}">
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
                                    <th scope="col">{{ __('Item Code') }}</th>
                                    <th scope="col">{{ __('RSD Quantity') }}</th>
                                    <th scope="col">{{ __('Regr ID') }}</th>
                                    <th scope="col">{{ __('Regr Name') }}</th>
                                    <th scope="col">{{ __('Modr Name') }}</th>
                                    <th scope="col">{{ __('Modr ID') }}</th>
                                    <th scope="col">{{ __('TIN') }}</th>
                                    <th scope="col">{{ __('Branch ID') }}</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @foreach ($requests as $reqq)
                                    <tr>
                                        <td>{{ $reqq->itemCd }}</td>
                                        <td>{{ $reqq->rsdQty }}</td>
                                        <td>{{ $reqq->regrId }}</td>
                                        <td>{{ $reqq->regrNm }}</td>
                                        <td>{{ $reqq->modrNm }}</td>
                                        <td>{{ $reqq->modrId }}</td>
                                        <td>{{ $reqq->tin }}</td>
                                        <td>{{ $reqq->bhfId }}</td>
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
