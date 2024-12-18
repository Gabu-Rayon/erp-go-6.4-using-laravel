@extends('layouts.admin')
@section('page-title')
    {{ __('Manage Invoices') }}
@endsection
@push('script-page')
    <script>
        function copyToClipboard(element) {

            var copyText = element.id;
            navigator.clipboard.writeText(copyText);
            // document.addEventListener('copy', function (e) {
            //     e.clipboardData.setData('text/plain', copyText);
            //     e.preventDefault();
            // }, true);
            //
            // document.execCommand('copy');
            show_toastr('success', 'Url copied to clipboard', 'success');
        }
    </script>
@endpush


@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Invoice') }}</li>
@endsection

@section('action-btn')
    <div class="float-end">
        <div class="mb-4 d-inline-block">
            {{ Form::open(['route' => 'invoice.no.getSalesByTraderInvoiceNo', 'method' => 'POST', 'class' => 'w-100']) }}
            @csrf
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <div class="form-group">
                {{ Form::label('SalesByTraderInvoiceNo', __('Get Sales By Trader Invoice No'), ['class' => 'form-label']) }}
                {{ Form::text('SalesByTraderInvoiceNo', null, ['class' => 'form-control', 'placeholder' => '1', 'required' => 'required']) }}
            </div>
            <button type="submit" class="btn btn-primary sync">{{ __('Search') }}</button>
            {{ Form::close() }}
        </div>
        <a class="btn btn-sm btn-primary" data-bs-toggle="collapse" href="#multiCollapseExample1" role="button"
            aria-expanded="false" aria-controls="multiCollapseExample1" data-bs-toggle="tooltip"
            title="{{ __('Filter') }}"><i class="ti ti-filter"></i>
        </a>

        <a href="{{ route('invoice.export') }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
            title="{{ __('Export') }}">
            <i class="ti ti-file-export"></i>
        </a>
        <a href="{{ route('invoice.create', 0) }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
            title="{{ __('Create') }}">
            <i class="ti ti-plus"></i>
        </a>
    </div>
@endsection



@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="mt-2 " id="multiCollapseExample1">
                <div class="card">
                    <div class="card-body">
                        {{ Form::open(['route' => ['invoice.index'], 'method' => 'GET', 'id' => 'customer_submit']) }}
                        <div class="row d-flex align-items-center justify-content-end">
                            <div class="mr-2 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                <div class="btn-box">
                                    {{ Form::label('issue_date', __('Issue Date'), ['class' => 'form-label']) }}
                                    {{ Form::date('issue_date', isset($_GET['issue_date']) ? $_GET['issue_date'] : '', ['class' => 'form-control month-btn', 'id' => 'pc-daterangepicker-1']) }}
                                </div>
                            </div>
                            <div class="mr-2 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                <div class="btn-box">
                                    {{ Form::label('customer', __('Customer'), ['class' => 'form-label']) }}
                                    {{ Form::select('customer', $customer, isset($_GET['customer']) ? $_GET['customer'] : '', ['class' => 'form-control select']) }}
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                <div class="btn-box">
                                    {{ Form::label('status', __('Status'), ['class' => 'form-label']) }}
                                    {{ Form::select('status', ['' => 'Select Status'] + $status, isset($_GET['status']) ? $_GET['status'] : '', ['class' => 'form-control select']) }}
                                </div>
                            </div>
                            <div class="col-auto mt-4 float-end ms-2">
                                <a href="#" class="btn btn-sm btn-primary"
                                    onclick="document.getElementById('customer_submit').submit(); return false;"
                                    data-toggle="tooltip" data-original-title="{{ __('apply') }}">
                                    <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                </a>
                                <a href="{{ route('invoice.index') }}" class="btn btn-sm btn-danger" data-toggle="tooltip"
                                    data-original-title="{{ __('Reset') }}">
                                    <span class="btn-inner--icon"><i class="ti ti-trash-off text-white-off"></i></span>
                                </a>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <h5></h5>
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th> {{ __('Invoice') }}</th>
                                    {{--                                @if (!\Auth::guard('customer')->check()) --}}
                                    {{--                                    <th>{{ __('Customer') }}</th> --}}
                                    {{--                                @endif --}}
                                    <th>{{ __('Issue Date') }}</th>
                                    <th>{{ __('Due Date') }}</th>
                                    <th>{{ __('Due Amount') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Stock IO') }}</th>
                                    <th>{{ __('Action') }}</th>
                                    {{-- <th>
                                <td class="barcode">
                                    {!! DNS1D::getBarcodeHTML($invoice->sku, "C128",1.4,22) !!}
                                    <p class="pid">{{$invoice->sku}}</p>
                                </td>
                            </th> --}}
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($invoices as $invoice)
                                    <tr>
                                        <td class="Id">
                                            <a href="{{ route('invoice.show', \Crypt::encrypt($invoice->id)) }}"
                                                class="btn btn-outline-primary">{{ Auth::user()->invoiceNumberFormat($invoice->invoice_id) }}</a>
                                        </td>
                                        <td>{{ Auth::user()->dateFormat($invoice->issue_date) }}</td>
                                        <td>
                                            @if ($invoice->due_date < date('Y-m-d'))
                                                <p class="mt-3 text-danger">
                                                    {{ \Auth::user()->dateFormat($invoice->due_date) }}
                                                </p>
                                            @else
                                                {{ \Auth::user()->dateFormat($invoice->due_date) }}
                                            @endif
                                        </td>
                                        <td>{{ \Auth::user()->priceFormat($invoice->getDue()) }}</td>
                                        <td>
                                            @if ($invoice->status == 0)
                                                <span
                                                    class="p-2 px-3 rounded status_badge badge bg-secondary">{{ __(\App\Models\Invoice::$statues[$invoice->status]) }}</span>
                                            @elseif($invoice->status == 1)
                                                <span
                                                    class="p-2 px-3 rounded status_badge badge bg-warning">{{ __(\App\Models\Invoice::$statues[$invoice->status]) }}</span>
                                            @elseif($invoice->status == 2)
                                                <span
                                                    class="p-2 px-3 rounded status_badge badge bg-danger">{{ __(\App\Models\Invoice::$statues[$invoice->status]) }}</span>
                                            @elseif($invoice->status == 3)
                                                <span
                                                    class="p-2 px-3 rounded status_badge badge bg-info">{{ __(\App\Models\Invoice::$statues[$invoice->status]) }}</span>
                                            @elseif($invoice->status == 4)
                                                <span
                                                    class="p-2 px-3 rounded status_badge badge bg-primary">{{ __(\App\Models\Invoice::$statues[$invoice->status]) }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($invoice->isKRASynchronized == 0 || $invoice->isStockIOUpdate == 0)
                                                <span
                                                    class="p-2 px-3 rounded status_badge badge bg-danger">Unsynchronized</span>
                                            @elseif ($invoice->isKRASynchronized == 1 && $invoice->isStockIOUpdate == 1)
                                                <span
                                                    class="p-2 px-3 rounded status_badge badge bg-primary">Synchronized</span>
                                            @endif
                                        </td>

                                        <td class="Action">
                                            <span>
                                                @php $invoiceID= Crypt::encrypt($invoice->id); @endphp

                                                <div class="action-btn bg-warning ms-2">
                                                    <a href="#" id="{{ route('invoice.link.copy', [$invoiceID]) }}"
                                                        class="mx-3 btn btn-sm align-items-center"
                                                        onclick="copyToClipboard(this)" data-bs-toggle="tooltip"
                                                        title="{{ __('Copy Invoice') }}"
                                                        data-original-title="{{ __('Copy Invoice') }}"><i
                                                            class="text-white ti ti-link"></i></a>
                                                </div>
                                                <div class="action-btn bg-primary ms-2">
                                                    {!! Form::open([
                                                        'method' => 'get',
                                                        'route' => ['invoice.duplicate', $invoice->id],
                                                        'id' => 'duplicate-form-' . $invoice->id,
                                                    ]) !!}

                                                    <a href="#"
                                                        class="mx-3 btn btn-sm align-items-center bs-pass-para"
                                                        data-toggle="tooltip" data-original-title="{{ __('Duplicate') }}"
                                                        data-bs-toggle="tooltip" title="Duplicate Invoice"
                                                        data-original-title="{{ __('Delete') }}"
                                                        data-confirm="You want to confirm this action. Press Yes to continue or Cancel to go back"
                                                        data-confirm-yes="document.getElementById('duplicate-form-{{ $invoice->id }}').submit();">
                                                        <i class="text-white ti ti-copy"></i>
                                                        {!! Form::open([
                                                            'method' => 'get',
                                                            'route' => ['invoice.duplicate', $invoice->id],
                                                            'id' => 'duplicate-form-' . $invoice->id,
                                                        ]) !!}
                                                        {!! Form::close() !!}
                                                    </a>
                                                </div>
                                                {{--                                                        @if (\Auth::guard('customer')->check()) --}}
                                                {{--                                                            <div class="action-btn bg-info ms-2"> --}}
                                                {{--                                                                    <a href="{{ route('customer.invoice.show', \Crypt::encrypt($invoice->id)) }}" --}}
                                                {{--                                                                       class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip" title="Show " --}}
                                                {{--                                                                       data-original-title="{{ __('Detail') }}"> --}}
                                                {{--                                                                        <i class="text-white ti ti-eye"></i> --}}
                                                {{--                                                                    </a> --}}
                                                {{--                                                                </div> --}}
                                                {{--                                                        @else --}}
                                                <div class="action-btn bg-info ms-2">
                                                    <a href="{{ route('invoice.show', \Crypt::encrypt($invoice->id)) }}"
                                                        class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip"
                                                        title="Show " data-original-title="{{ __('Detail') }}">
                                                        <i class="text-white ti ti-eye"></i>
                                                    </a>
                                                </div>
                                                {{--                                                        @endif --}}
                                                <div class="action-btn bg-primary ms-2">
                                                    <a href="{{ route('invoice.edit', \Crypt::encrypt($invoice->id)) }}"
                                                        class="mx-3 btn btn-sm align-items-center"
                                                        data-bs-toggle="tooltip" title="Edit "
                                                        data-original-title="{{ __('Edit') }}">
                                                        <i class="text-white ti ti-pencil"></i>
                                                    </a>
                                                </div>
                                                <div class="action-btn bg-danger ms-2">
                                                    {!! Form::open([
                                                        'method' => 'DELETE',
                                                        'route' => ['invoice.destroy', $invoice->id],
                                                        'id' => 'delete-form-' . $invoice->id,
                                                    ]) !!}
                                                    <a href="#"
                                                        class="mx-3 btn btn-sm align-items-center bs-pass-para "
                                                        data-bs-toggle="tooltip" title="{{ __('Delete') }}"
                                                        data-original-title="{{ __('Delete') }}"
                                                        data-confirm="{{ __('Are You Sure?') . '|' . __('This action can not be undone. Do you want to continue?') }}"
                                                        data-confirm-yes="document.getElementById('delete-form-{{ $invoice->id }}').submit();">
                                                        <i class="text-white ti ti-trash"></i>
                                                    </a>
                                                    {!! Form::close() !!}
                                                </div>
                                            </span>
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
