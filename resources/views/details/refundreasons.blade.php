@extends('layouts.admin')
@section('page-title')
    {{__('Refund Reasons')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Refund Reasons')}}</li>
@endsection

@section('action-btn')
    <div class="float-end">
        <a
            href="{{ route('details.sync', 'refundreasons') }}"
            class="btn btn-sm btn-primary">
            Synchronize
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-3">
            @include('layouts.account_setup')
        </div>
        <div class="col-9">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th> {{__('Reason Name')}}</th>
                                    <th> {{__('Code')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($refundreasons as $refundreason)
                                    <tr class="font-style">
                                        <td>{{ $refundreason->cdNm }}</td>
                                        <td>{{ $refundreason->cd }}</td>
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
