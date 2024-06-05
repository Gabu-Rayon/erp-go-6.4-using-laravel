@extends('layouts.admin')
@section('page-title')
    {{ __('Manage Notices List') }}
@endsection
@push('script-page')
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Notices List') }}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        <a href="{{ route('noticelist.synchronize') }}" class="btn btn-sm btn-primary">
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
                                    <th>{{ __(' NoticeNo') }}</th>
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('Cont') }}</th>
                                    <th>{{ __('registeredName') }}</th>
                                    <th>{{ __('Url') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($notices as $notice)
                                    <tr class="font-style">
                                        <td>{{ $notice->id }}</td>
                                        <td>{{ $notice->noticeNo }}</td>
                                        <td>{{ $notice->title }}</td>
                                        <td>{{ $notice->cont }}</td>
                                        <td>{{ $notice->regrNm }}</td>
                                        <td class="text-wrap text-truncate" style="max-width: 200px;">{{ $notice->dtlUrl }}</td>
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
