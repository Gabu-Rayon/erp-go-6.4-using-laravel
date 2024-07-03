@extends('layouts.admin')
@section('page-title')
    {{__('Manage Payment Types')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Payment Types')}}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        <a
            href="{{ route('details.sync', 'paymenttypes') }}"
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
                                <th> {{__('Payment Stuff')}}</th>
                                <th> {{__('Some Stuff')}}</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($paymentTypes as $paymentType)
                                <tr class="font-style">
                                    <td>{{ $paymentType->cdNm }}</td>
                                    <td>{{ $paymentType->userDfnCd1 }}</td>
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
