@extends('layouts.admin')
@section('page-title')
    {{__('API Initialization')}}
@endsection

@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0">{{__('API Initialization')}}</h5>
    </div>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('apiinitialization.index')}}">{{__('API Initialization')}}</a></li>
    <li class="breadcrumb-item">{{ucwords($apiinitialization->dvcSrlNo)}}</li>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>{{__('Tin')}}</td>
                                <td>{{ $apiinitialization->tin }}</td>
                            </tr>
                            <tr>
                                <td>{{__('BHD Id')}}</td>
                                <td>{{ $apiinitialization->bhfId }}</td>
                            </tr>
                            <tr>
                                <td>{{__('DVC SrlNo')}}</td>
                                <td>{{ $apiinitialization->dvcSrlNo }}</td>
                            </tr>
                            <tr>
                                <td>{{__('Taxpr Nm')}}</td>
                                <td>{{ $apiinitialization->taxprNm }}</td>
                            </tr>
                            <tr>
                                <td>{{__('Head Quarter')}}</td>
                                <td>{{ $apiinitialization->hqYn }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection