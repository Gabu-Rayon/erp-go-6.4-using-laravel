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

@section('action-btn')
    <div class="float-end">
        <div class="d-inline-block mb-4">
            {{ Form::open(['route' => 'importeditems.sync', 'method' => 'POST', 'class' => 'w-100']) }}
            @csrf
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <div class="form-group">
                {{ Form::label('importedItemDate', __('Search Date (ex- 01-Dec-2021)'), ['class' => 'form-label']) }}
                {{ Form::date('importedItemDate', null, ['class' => 'form-control','required' => 'required']) }}
            </div>
            <button type="submit" class="btn btn-primary  sync">{{ __('Search') }}</button>
            {{ Form::close() }}
        </div>
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
                            <th scope="col">{{__('Item Name')}}</th>
                            <th scope="col">{{__('Status')}}</th>
                            <th scope="col">{{__('Action')}}</th>
                        </tr>
                        </thead>
                        <tbody class="list">
                            @foreach ($importedItems as $importedItem)
                                <tr>
                                    <td>{{ $importedItem->srNo }}</td>
                                    <td>{{ $importedItem->taskCode }}</td>
                                    <td>{{ $importedItem->itemName }}</td>
                                    <td>{{ $importedItem->status }}</td>
                                    <td>
                                        <div class="action-btn bg-warning ms-2">
                                            <a href="{{ route('importeditems.show',$importedItem->id) }}" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="tooltip" title="{{__('Details')}}"><i class="ti ti-eye text-white"></i></a>
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
