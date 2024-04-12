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
    </script>
@endpush


@section('action-btn')
    <div class="float-end">


        {{--        <a href="{{ route('bill.export') }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="{{__('Export')}}"> --}}
        {{--            <i class="ti ti-file-export"></i> --}}
        {{--        </a> --}}

        @can('create purchase')
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

                        @if ($purchases['statusCode'] === 200 && $purchases['message'] === 'Success')
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th>Supplier TIN</th>
                                        <th>Supplier Name</th>
                                        <th>Supplier BhfId</th>
                                        <th>Invoice Number</th>
                                        <th>Supplier SDC ID</th>
                                        <th>Supplier Merchant No</th>
                                        <th>Supplier Receipt Code</th>
                                        <th>Supplier Pmt Type Code</th>
                                        <th>Supplier Confirm Date</th>
                                        <th>Sales Date</th>
                                        <th>StockRsl Date</th>
                                        <th>Total Item Cnt</th>
                                        <th>Taxable Amount A</th>
                                        <th>Taxable Amount B</th>
                                        <th>Taxable Amount C</th>
                                        <th>Taxable Amount D</th>
                                        <th>Taxable Amount B</th>
                                        <th>Taxable Rate A</th>
                                        <th>Taxable Rate B</th>
                                        <th>Taxable Rate C</th>
                                        <th>Taxable Rate D</th>
                                        <th>Taxable Rate E</th>
                                        <th>Taxable Amount A</th>
                                        <th>Taxable Amount B</th>
                                        <th>Taxable Amount C</th>
                                        <th>Taxable Amount D</th>
                                        <th>Taxable Amount E</th>
                                        <th>Total Taxable Amount</th>
                                        <th>Total Tax Amount</th>
                                        <th>Total Amount</th>
                                        <th>Remark</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    @foreach ($purchases['data']['data']['saleList'] as $purchase)
                                        <tr>
                                            <td>{{ $purchase['spplrTin'] }}</td>
                                            <td>{{ $purchase['spplrNm'] }}</td>
                                            <td>{{ $purchase['spplrBhfId'] }}</td>
                                            <td>{{ $purchase['spplrInvcNo'] }}</td>
                                            <td>{{ $purchase['spplrSdcId'] }}</td>
                                            <td>{{ $purchase['spplrMrcNo'] }}</td>
                                            <td>{{ $purchase['rcptTyCd'] }}</td>
                                            <td>{{ $purchase['pmtTyCd'] }}</td>
                                            <td>{{ $purchase['cfmDt'] }}</td>
                                            <td>{{ $purchase['salesDt'] }}</td>
                                            <td>{{ $purchase['stockRlsDt'] }}</td>
                                            <td>{{ $purchase['totItemCnt'] }}</td>
                                            <td>{{ number_format($purchase['taxblAmtA'], 2) }}</td>
                                            <td>{{ number_format($purchase['taxblAmtB'], 2) }}</td>
                                            <td>{{ number_format($purchase['taxblAmtC'], 2) }}</td>
                                            <td>{{ number_format($purchase['taxblAmtD'], 2) }}</td>
                                            <td>{{ number_format($purchase['taxblAmtE'], 2) }}</td>
                                            <td>{{ number_format($purchase['taxRtA'], 2) }}</td>
                                            <td>{{ number_format($purchase['taxRtB'], 2) }}</td>
                                            <td>{{ number_format($purchase['taxRtC'], 2) }}</td>
                                            <td>{{ number_format($purchase['taxRtD'], 2) }}</td>
                                            <td>{{ number_format($purchase['taxRtE'], 2) }}</td>
                                            <td>{{ number_format($purchase['taxAmtA'], 2) }}</td>
                                            <td>{{ number_format($purchase['taxAmtB'], 2) }}</td>
                                            <td>{{ number_format($purchase['taxAmtC'], 2) }}</td>
                                            <td>{{ number_format($purchase['taxAmtD'], 2) }}</td>
                                            <td>{{ number_format($purchase['taxAmtE'], 2) }}</td>
                                            <td>{{ number_format($purchase['totTaxblAmt'], 2) }}</td>
                                            <td>{{ number_format($purchase['totTaxAmt'], 2) }}</td>
                                            <td>{{ number_format($purchase['totAmt'], 2) }}</td>
                                            <td>{{ $purchase['remark']}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>Error: Failed to fetch purchases.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
