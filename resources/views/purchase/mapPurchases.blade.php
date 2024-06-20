@extends('layouts.admin')
@section('page-title')
    {{ __('Purchase List') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Admin') }}</li>
     <li class="breadcrumb-item">{{ __('Purchases') }}</li>
      <li class="breadcrumb-item">{{ __('List') }}</li>
@endsection
@push('script-page')
    <script>
        $('.copy_link').click(function(e) {
            e.preventDefault();
            var copyText = $(this).attr('href');

            document.addEventListener('copy', function(e) {
                e.clipboardData.setData('text/plain', copyText);
                e.preventDefault();
            }, true);

            document.execCommand('copy');
            show_toastr('success', 'Url copied to clipboard', 'success');
        });
    </script>
@endpush

@section('action-btn')
    <div class="float-end">
            <div class="d-inline-block mb-4">
                {{ Form::open(['route' => 'purchase.searchByDate', 'method' => 'POST', 'class' => 'w-100']) }}
                @csrf
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <div class="form-group">
                    {{ Form::label('SearchByDate', __('Search By Date'), ['class' => 'form-label']) }}
                    {{ Form::date('searchByDate', null, ['class' => 'form-control', 'required' => 'required']) }}
                </div>
                <button type="submit" class="btn btn-primary  sync">{{ __('Search') }}</button>
                {{ Form::close() }}
            </div>
            <a href="{{ route('purchase.create', 0) }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                title="{{ __('Add New Purchase') }}">
                <i class="ti ti-plus"></i>
            </a>
    </div>
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
                                    <th> {{ __('ID') }}</th>
                                    <th> {{ __('InvcNo') }}</th>
                                    <th> {{ __('Purchase Date') }}</th>
                                    <th> {{ __('SupplrTin') }}</th>
                                    <th>{{ __('supplrBhfId') }}</th>
                                    <th>{{ __('SupplrName') }}</th>
                                     <th>{{ __('SupplrInvcNo') }}</th>
                                    @if (Gate::check('edit purchase') || Gate::check('delete purchase') || Gate::check('show purchase'))
                                        <th> {{ __('Action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            @if (isset($filteredPurchases))
                            <tbody>
                                @foreach ($mappedPurchases as $purchase)
                                    <tr>
                                        <td>{{ $purchase->mappedPurchaseId }}</td>
                                        <td>{{ $purchase->invcNo }}</td>
                                        <td>{{ $purchase->purchaseDate }}</td>
                                        <td>{{ $purchase->supplrTin }}</td>
                                        <td>{{ $purchase->supplrBhfId }}</td>
                                        <td>{{ $purchase->supplrName }}</td>
                                        <td>{{ $purchase->supplrInvcNo }}</td>
                                            <td class="Action">
                                                <span>
                                                        <div class="action-btn bg-info ms-2">
                                                            <a href="{{ route('mappedPurchases.details', ['id' => $purchase->id]) }}"
                                                                class="mx-3 btn btn-sm align-items-center"
                                                                data-bs-toggle="tooltip"
                                                                title="{{ __('View Map purchase Item Details') }}"
                                                                data-original-title="{{ __('View Map purchase Item Details') }}">
                                                                <i class="ti ti-eye text-white"></i></a>
                                                        </div>
                                                </span>
                                            </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            @else if (isset($filteredPurchases))
                            <tbody>
                                @foreach ($filteredPurchases as $purchase)
                                     <tr>
                                        <td>{{ $purchase->mappedPurchaseId }}</td>
                                        <td>{{ $purchase->invcNo }}</td>
                                        <td>{{ $purchase->orgInvcNo }}</td>
                                        <td>{{ $purchase->supplrTin }}</td>
                                        <td>{{ $purchase->supplrBhfId }}</td>
                                        <td>{{ $purchase->supplrName }}</td>
                                        <td>{{ $purchase->supplrInvcNo }}</td>
                                            <td class="Action">
                                                <span>
                                                        <div class="action-btn bg-info ms-2">
                                                            <a href="{{ route('mappedPurchases.details', ['id' => $purchase->id]) }}"
                                                                class="mx-3 btn btn-sm align-items-center"
                                                                data-bs-toggle="tooltip"
                                                                title="{{ __('View Map purchase Item Details') }}"
                                                                data-original-title="{{ __('View Map purchase Item Details') }}">
                                                                <i class="ti ti-eye text-white"></i></a>
                                                        </div>
                                                </span>
                                            </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>   

@endsection
