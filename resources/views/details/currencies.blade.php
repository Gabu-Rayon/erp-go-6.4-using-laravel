@extends('layouts.admin')
@section('page-title')
    {{__('Currencies')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Currencies')}}</li>
@endsection

@section('action-btn')
    <div class="float-end">
        <a
            href="{{ route('details.sync', 'currencies') }}"
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
                                    <th> {{__('Currency')}}</th>
                                    <th> {{__('Code')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($currencies as $currency)
                                    <tr class="font-style">
                                        <td>{{ $currency->cdNm }}</td>
                                        <td>{{ $currency->cd }}</td>
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
