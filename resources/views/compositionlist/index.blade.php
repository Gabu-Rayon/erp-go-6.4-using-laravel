@extends('layouts.admin')
@push('script-page')
@endpush
@section('page-title')
    {{__('Composition List')}}
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0 ">{{__('Composition List')}}</h5>
    </div>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Composition List')}}</li>
@endsection

@section('action-btn')
    <div class="float-end">
       <a href="{{ route('compositionlist.create') }}" data-size="lg" data-bs-toggle="tooltip" title="{{__('Create')}}" data-title="{{__('Create Composition List Form Sample')}}" class="btn btn-sm btn-primary">
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
                            <th scope="col">{{__('Main Item')}}</th>
                            <th scope="col">{{__('Total CompItems')}}</th>
                            <th scope="col">{{__('Action')}}</th>
                        </tr>
                        </thead>
                        <tbody class="list">
                        @foreach ($compositionslistitems as $compositionlistitem)
                            <tr>
                                <td>{{ \App\Models\ItemInformation::where('itemCd', $compositionlistitem->mainItemCode)->first()->itemNm }}</td>
                                <td>{{ $compositionlistitem->compositionItems_count }}</td>

                                 @if(Gate::check('edit purchase') || Gate::check('delete purchase') || Gate::check('show purchase'))
                                        <td class="Action">
                                            <span>
                                                 @can('show purchase')
                                                    <div class="action-btn bg-warning ms-2">
                                                        <a href="{{ route('compositionlist.show', $compositionlistitem->id) }}"
                                                           class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                           data-bs-whatever="{{__('View composition list items')}}" data-bs-toggle="tooltip"
                                                           data-bs-original-title="{{__('View')}}"> 
                                                           <span class="text-white"><i class="ti ti-eye"></i></span></a>
                                                    </div>
                                                @endcan
                                            </span>
                                        </td>
                                    @endif
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
