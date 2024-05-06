@extends('layouts.admin')
@section('page-title')
    {{ __('Manage Mapped Purchase') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Mapped Purchases') }}</li>
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
        <!-- Add the form for date search -->
        @can('create purchase')
            <div class="d-inline-block mb-4">
                <!-- {{ Form::open(['url' => 'purchase.searchByDate', 'class' => 'w-100']) }} -->
                {{ Form::open(['route' => 'purchase.searchByDate', 'method' => 'POST', 'class' => 'w-100']) }}
                @csrf
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <div class="form-group">
                    {{ Form::label('SearchByDate', __('Search By Date'), ['class' => 'form-label']) }}
                    {{ Form::date('searchByDate', null, ['class' => 'form-control', 'required' => 'required']) }}
                </div>
                <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>
                {{ Form::close() }}

            </div>
            <a href="{{ route('purchase.create', 0) }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                title="{{ __('Create') }}">
                <i class="ti ti-plus"></i>
            </a>
        @endcan
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
                                    <th> {{ __('OrgInvcNo') }}</th>
                                    <th> {{ __('Supplier Tin') }}</th>
                                    <th>{{ __('supplier BhfId') }}</th>
                                    <th>{{ __('Supplier Name') }}</th>
                                     <th>{{ __('Supplier InvcNo') }}</th>
                                      <th>{{ __('purchase Type Code') }}</th>
                                       <th>{{ __('RceiptTyCd') }}</th>
                                        <th>{{ __('Payment Type Code') }}</th>
                                         <th>{{ __('Purchase Status Code') }}</th>
                                          <th>{{ __('Confirm Date') }}</th>
                                    @if (Gate::check('edit purchase') || Gate::check('delete purchase') || Gate::check('show purchase'))
                                        <th> {{ __('Action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                        </td>
                                        @if (Gate::check('edit purchase') || Gate::check('delete purchase') || Gate::check('show purchase'))
                                            <td class="Action">
                                            </td>
                                        @endif
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
