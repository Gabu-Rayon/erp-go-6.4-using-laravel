@extends('layouts.admin')
@push('script-page')
@endpush
@section('page-title')
    {{__('API Initialization')}}
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0 ">{{__('API Initialization')}}</h5>
    </div>Support
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('API Initialization')}}</li>
@endsection

@section('action-btn')
    <div class="float-end">
       <a href="#" data-size="lg" data-url="{{ route('apiinitialization.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create')}}" data-title="{{__('Create API Initialization')}}" class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>
    </div>
    <div class="float-end">
       <a href="#" data-size="lg" data-url="{{ route('apiinitialization.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Add Existing Initialization')}}" data-title="{{__('Add Existing API Initialization')}}" class="btn btn-sm btn-primary">
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
                            <th scope="col">{{__('SrNo')}}</th>
                            <th scope="col">{{__('Code')}}</th>
                            <th scope="col">{{__('Name')}}</th>
                            <th scope="col">{{__('DVC SrlNo')}}</th>
                            <th scope="col">{{__('Level')}}</th>
                            <th scope="col">{{__('Mapping')}}</th>
                            <th scope="col">{{__('Action')}}</th>
                        </tr>
                        </thead>
                        <tbody class="list">
                        @foreach ($itemclassifications as $itemclassification)
                                <td>{{ $itemclassification->id }}</td>
                                <td>{{ $itemclassification->itemClsCd }}</td>
                                <td>{{ $itemclassification->itemClsNm }}</td>
                                <td>{{ $itemclassification->itemClsLvl }}</td>
                                <td>{{ $itemclassification->taxprNm }}</td>
                                <td>
                                    @if ($apiinitialization->hqYn == 'Y')
                                        <span class="btn btn-sm btn-success">Default</span>
                                    @else
                                        <span></span>
                                    @endif
                                </td>

                                <td>
                                    <div class="action-btn bg-warning ms-2">
                                        <a
                                            href="#"
                                            class="mx-3 btn btn-sm align-items-center"
                                            data-url="{{ route('apiinitialization.create',$apiinitialization->id) }}"
                                            data-ajax-popup="true" data-bs-toggle="tooltip"
                                            title="{{__('API Initialization Details')}}"
                                            data-title="{{__('API Initialization Details')}}"
                                        >
                                            <i class="ti ti-eye text-white"></i>
                                        </a>
                                    </div>
                                    <div class="action-btn bg-info ms-2">
                                        <a href="#" class="mx-3 btn btn-sm  align-items-center" data-url="{{ route('apiinitialization.create',$apiinitialization->id) }}" data-ajax-popup="true"  data-size="lg " data-bs-toggle="tooltip" title="{{__('Edit')}}"  data-title="{{__('Edit API Initialization')}}">
                                            <i class="ti ti-pencil text-white"></i>
                                            </a>
                                    </div>
                                </td>
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