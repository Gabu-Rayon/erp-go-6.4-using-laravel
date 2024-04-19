@extends('layouts.admin')
@section('page-title')
    {{ __('Manage Branches List') }}
@endsection
@push('script-page')
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Branches List') }}</li>
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
                                    <th>{{ __('PIN') }}</th>
                                    <th>{{ __('Branch Name') }}</th>
                                    <th>{{ __('Manager') }}</th>
                                    <th>{{ __('Prvnc Name') }}</th>
                                    <th>{{ __('Default') }}</th>
                                    <th>{{ __('Sctr Name') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($branches as $branch)
                                    <tr class="font-style">
                                        <td>{{ $branch->id }}</td>
                                        <td>{{ $branch->tin }}</td>
                                        <td>{{ $branch->bhfNm }}</td>
                                        <td>{{ $branch->bhfSttsCd }}</td>
                                        <td>{{ $branch->prvncNm }}</td>
                                        <td>{{ $branch->hqYn }}</td>
                                        <td>{{ $branch->sctrNm }}</td>
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
