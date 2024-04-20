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
                <!-- Button to trigger the getItemInformationApi and Synchronize it to my Database() method -->
       <a href="#" id="synchronizeBtn" data-size="lg" data-url="{{ route('productservice.synchronizeitemclassifications') }}"
            data-ajax-popup="true" data-bs-toggle="tooltip" title="{{ __('Synchronize Item Classifications') }}" class="btn btn-sm btn-primary">
            <i class="#">Synchronize</i>
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
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($itemclassifications as $classification)
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

