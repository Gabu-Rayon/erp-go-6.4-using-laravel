@extends('layouts.admin')
@push('script-page')
@endpush
@section('page-title')
    {{__('Imported Items')}}
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0 ">{{__('Imported Items')}}</h5>
    </div>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Imported Items')}}</li>
@endsection

@section ('action-btn')
    <div class="float-end">
        <a href="#" data-url="{{ route('updateimporteditems.create') }}" class="btn btn-sm btn-primary" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Add Import Item')}}">
            Add Import Item
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
                            <th scope="col">{{__('Task Code')}}</th>
                            <th scope="col">{{__('Declaration Date')}}</th>
                            <th scope="col">{{__('Item Sequence')}}</th>
                            <th scope="col" >{{__('HS Code')}}</th>
                            <th scope="col" >{{__('Item Code')}}</th>
                            <th scope="col" >{{__('Item Classification Code')}}</th>
                        </tr>
                        </thead>
                        <tbody class="list">
                            @foreach ($updateImportedItems as $updateImportedItem)
                                <tr>
                                    <td>{{ $updateImportedItem->srNo }}</td>
                                    <td>{{ $updateImportedItem->taskCode }}</td>
                                    <td>{{ $updateImportedItem->declarationDate }}</td>
                                    <td>{{ $updateImportedItem->itemSeq }}</td>
                                    <td>{{ $updateImportedItem->hsCode }}</td>
                                    <td>{{ $updateImportedItem->itemClassificationCode }}</td>
                                    <td>{{ $updateImportedItem->itemCode }}</td>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection

