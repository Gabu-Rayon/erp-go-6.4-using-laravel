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
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($itemclassfications as $classification)
                                    <tr class="font-style">
                                        <td>{{$classification->id }}</td>
                                        <td>{{ $classification->itemClsCd }}</td>
                                        <td>{{$classification->itemClsNm}}</td>
                                        <td>{{$classification->itemClsLvl }}</td>
                                        <td>{{$classification->useYn}}</td>
                                        <td></td>
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

