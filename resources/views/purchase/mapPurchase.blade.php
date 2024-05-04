@extends('layouts.admin')
@section('page-title')
    {{ __('Manage Purchase') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Purchase') }}</li>
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

        $.ajax({
            url: "{{ route('purchase.searchByDate') }}",
            type: "GET",
            data: {
                date: searchByDate
            },
            success: function(data) {
                // Update table with fetched data
                $('#purchase-table tbody').html(data);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
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
                        <table class="table datatable" id ="purchase-table">
                            <thead>
                                <tr>
                                    <th> {{ __('SrNo') }}</th>
                                    <th> {{ __('SpplrTin') }}</th>
                                    <th> {{ __('SpplrNm') }}</th>
                                    <th> {{ __('TotItemCnt') }}</th>
                                    <th>{{ __('CfmDt') }}</th>
                                    <th>{{ __('IsDBImport') }}</th>
                                    @if (Gate::check('edit purchase') || Gate::check('delete purchase') || Gate::check('show purchase'))
                                        <th> {{ __('Action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($purchasesSearchedByDates))
                                    @foreach ($purchasesSearchedByDates as $purchase)
                                        <tr>
                                            <td>{{ $purchase->id }}</td>
                                            <td>{{ $purchase->spplrTin }}</td>
                                            <td>{{ $purchase->spplrNm }}</td>
                                            <td>{{ $purchase->totItemCnt }}</td>
                                            <td>{{ $purchase->cfmDt }}</td>
                                            <td>
                                                @if ($purchase->isDBImport == 0)
                                                    <!-- Show Pending -->
                                                    <span
                                                        class="purchase_status badge bg-secondary p-2 px-3 rounded">pending</span>
                                                @else($purchase->status == 1)
                                                    <!-- Show Success -->
                                                    <span
                                                        class="purchase_status badge bg-warning p-2 px-3 rounded">Success</span>
                                                @endif
                                            </td>
                                            @if (Gate::check('edit purchase') || Gate::check('delete purchase') || Gate::check('show purchase'))
                                                <td class="Action">
                                                    <span>

                                                        @can('show purchase')
                                                            <div class="action-btn bg-info ms-2">
                                                                <a href="{{ route('purchase.show', ['id' => $purchase->id]) }}"
                                                                    class="mx-3 btn btn-sm align-items-center"
                                                                    data-bs-toggle="tooltip" title="{{ __('Show') }}"
                                                                    data-original-title="{{ __('Detail') }}">
                                                                    <i class="ti ti-eye text-white"></i>
                                                                </a>
                                                            </div>
                                                        @endcan
                                                        @can('show purchase')
                                                            <div class="action-btn bg-info ms-2">
                                                                <a href="{{ route('purchase.details', ['spplrInvcNo' => $purchase->spplrInvcNo]) }}"
                                                                    class="mx-3 btn btn-sm align-items-center"
                                                                    data-bs-toggle="tooltip"
                                                                    title="{{ __('Map purchase Item to add to Purchase') }}"
                                                                    data-original-title="{{ __('Detail') }}">
                                                                    <i class="ti ti-list text-white"></i></a>
                                                            </div>
                                                        @endcan
                                                        @can('edit purchase')
                                                            <div class="action-btn bg-primary ms-2">
                                                                <a href="{{ route('purchase.edit', \Crypt::encrypt($purchase->id)) }}"
                                                                    class="mx-3 btn btn-sm align-items-center"
                                                                    data-bs-toggle="tooltip" title="Edit"
                                                                    data-original-title="{{ __('Edit') }}">
                                                                    <i class="ti ti-pencil text-white"></i>
                                                                </a>
                                                            </div>
                                                        @endcan
                                                        @can('delete purchase')
                                                            <div class="action-btn bg-danger ms-2">
                                                                {!! Form::open([
                                                                    'method' => 'DELETE',
                                                                    'route' => ['purchase.destroy', $purchase->id],
                                                                    'class' => 'delete-form-btn',
                                                                    'id' => 'delete-form-' . $purchase->id,
                                                                ]) !!}
                                                                <a href="#"
                                                                    class="mx-3 btn btn-sm align-items-center bs-pass-para"
                                                                    data-bs-toggle="tooltip" title="{{ __('Delete') }}"
                                                                    data-original-title="{{ __('Delete') }}"
                                                                    data-confirm="{{ __('Are You Sure?') . '|' . __('This action can not be undone. Do you want to continue?') }}"
                                                                    data-confirm-yes="document.getElementById('delete-form-{{ $purchase->id }}').submit();">
                                                                    <i class="ti ti-trash text-white"></i>
                                                                </a>
                                                                {!! Form::close() !!}
                                                            </div>
                                                        @endcan
                                                    </span>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @else
                                    @foreach ($purchases as $purchase)
                                        <tr>
                                            <td>{{ $purchase->id }}</td>
                                            <td>{{ $purchase->spplrTin }}</td>
                                            <td>{{ $purchase->spplrNm }}</td>
                                            <td>{{ $purchase->totItemCnt }}</td>
                                            <td>{{ $purchase->cfmDt }}</td>
                                            <td>
                                                @if ($purchase->isDBImport == 0)
                                                    <!-- Show Pending -->
                                                    <span
                                                        class="purchase_status badge bg-secondary p-2 px-3 rounded">pending</span>
                                                @else($purchase->status == 1)
                                                    <!-- Show Success -->
                                                    <span
                                                        class="purchase_status badge bg-warning p-2 px-3 rounded">Success</span>
                                                @endif
                                            </td>
                                            @if (Gate::check('edit purchase') || Gate::check('delete purchase') || Gate::check('show purchase'))
                                                <td class="Action">
                                                    <span>

                                                        @can('show purchase')
                                                            <div class="action-btn bg-info ms-2">
                                                                <a href="{{ route('purchase.show', ['id' => $purchase->id]) }}"
                                                                    class="mx-3 btn btn-sm align-items-center"
                                                                    data-bs-toggle="tooltip" title="{{ __('Show') }}"
                                                                    data-original-title="{{ __('Detail') }}">
                                                                    <i class="ti ti-eye text-white"></i>
                                                                </a>
                                                            </div>
                                                        @endcan
                                                        @can('show purchase')
                                                            <div class="action-btn bg-info ms-2">
                                                                <a href="{{ route('purchase.details', ['spplrInvcNo' => $purchase->spplrInvcNo]) }}"
                                                                    class="mx-3 btn btn-sm align-items-center"
                                                                    data-bs-toggle="tooltip"
                                                                    title="{{ __('Map purchase Item to add to Purchase') }}"
                                                                    data-original-title="{{ __('Detail') }}">
                                                                    <i class="ti ti-list text-white"></i></a>
                                                            </div>
                                                        @endcan
                                                        @can('edit purchase')
                                                            <div class="action-btn bg-primary ms-2">
                                                                <a href="{{ route('purchase.edit', \Crypt::encrypt($purchase->id)) }}"
                                                                    class="mx-3 btn btn-sm align-items-center"
                                                                    data-bs-toggle="tooltip" title="Edit"
                                                                    data-original-title="{{ __('Edit') }}">
                                                                    <i class="ti ti-pencil text-white"></i>
                                                                </a>
                                                            </div>
                                                        @endcan
                                                        @can('delete purchase')
                                                            <div class="action-btn bg-danger ms-2">
                                                                {!! Form::open([
                                                                    'method' => 'DELETE',
                                                                    'route' => ['purchase.destroy', $purchase->id],
                                                                    'class' => 'delete-form-btn',
                                                                    'id' => 'delete-form-' . $purchase->id,
                                                                ]) !!}
                                                                <a href="#"
                                                                    class="mx-3 btn btn-sm align-items-center bs-pass-para"
                                                                    data-bs-toggle="tooltip" title="{{ __('Delete') }}"
                                                                    data-original-title="{{ __('Delete') }}"
                                                                    data-confirm="{{ __('Are You Sure?') . '|' . __('This action can not be undone. Do you want to continue?') }}"
                                                                    data-confirm-yes="document.getElementById('delete-form-{{ $purchase->id }}').submit();">
                                                                    <i class="ti ti-trash text-white"></i>
                                                                </a>
                                                                {!! Form::close() !!}
                                                            </div>
                                                        @endcan
                                                    </span>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
