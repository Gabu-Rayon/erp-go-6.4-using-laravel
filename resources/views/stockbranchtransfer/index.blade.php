@extends('layouts.admin')
@push('script-page')
@endpush
@section('page-title')
    {{ __('Stock Branch Transfer List') }}
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="mb-0 h4 d-inline-block font-weight-400 ">{{ __('Stock Branch Transfer List') }}</h5>
    </div>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Stock Branch Transfer List') }}</li>
@endsection

@section('action-btn')
    <div class="float-end">
        <a href="{{ route('branch.transfer.create', 0) }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="{{ __('Add Stock Branch Transfer') }}">
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
                                    <th scope="col">{{ __('SrNo') }}</th>
                                    <th scope="col">{{ __('Brnach From') }}</th>
                                    <th scope="col">{{ __('Branch To') }}</th>
                                    <th scope="col">{{ __('Total items') }}</th>
                                    <th scope="col">{{ __('Status') }}</th>
                                    <th scope="col">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                            <td></td>
                            <td></td>
                            <td></td>
                                @foreach ($branchTransfers as $branchTransfer)
                                    <tr>
                                        <td>{{ $branchTransfer->id }}</td>
                                        <td>{{ $branchTransfer->from_branch }}</td>
                                        <td>{{ $branchTransfer->to_branch }}</td>
                                        <td>{{ $branchTransfer->totItemCnt }}</td>
                                         <td>{{ $branchTransfer->status }}</td>
                                        <td>
                                            <div class="action-btn bg-warning ms-2">
                                                <a href="{{ route('branch.transfer.show', $branchTransfer) }}"
                                                    class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                    data-bs-toggle="tooltip" title="{{ __('Details') }}">
                                                    <i class="text-white ti ti-eye"></i>
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
