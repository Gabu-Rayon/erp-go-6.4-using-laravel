@extends('layouts.admin')
@section('page-title')
    {{ __('Credit Note Detail') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('credit.note') }}">{{ __('Credit Notes') }}</a></li>
    <li class="breadcrumb-item">{{ $creditNote->traderInvoiceNo ?? null }}</li>
@endsection
@php
    $settings = Utility::settings();
@endphp
@push('css-page')
    <style>
        #card-element {
            border: 1px solid #a3afbb !important;
            border-radius: 10px !important;
            padding: 10px !important;
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="invoice">
                        <div class="invoice-print">
                            <div class="row invoice-title mt-2">
                                <div class="col-xs-12 col-sm-12 col-nd-6 col-lg-6 col-12">
                                    <h4>{{ __('Credit Note') }}</h4>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-nd-6 col-lg-6 col-12 text-end">
                                    <h4 class="invoice-number">
                                        {{ $creditNote->traderInvoiceNo ?? null }}</h4>
                                </div>
                                <div class="col-12">
                                    <hr>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-end">
                                    <div class="d-flex align-iteams-center justify-content-end">
                                        <div class="me-4">
                                            <small>
                                                <strong>{{ __('Issue Date') }} :</strong><br>
                                                {{ \Auth::user()->dateFormat($creditNote->salesDate) }}<br><br>
                                            </small>
                                        </div>
                                        <div>
                                            <small>
                                                <strong>{{ __('Occured Date') }} :</strong><br>
                                                {{ \Auth::user()->dateFormat($creditNote->occuredDate) }}<br><br>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col">
                                    <small class="font-style">
                                        <strong>{{ __('Billed To') }} :</strong><br>
                                        @if (!empty($customer->billing_name))
                                            {{ !empty($customer->billing_name) ? $customer->billing_name : '' }}<br>
                                            {{ !empty($customer->billing_address) ? $customer->billing_address : '' }}<br>
                                            {{ !empty($customer->billing_city) ? $customer->billing_city : '' . ', ' }}<br>
                                            {{ !empty($customer->billing_state) ? $customer->billing_state : '' . ', ' }},
                                            {{ !empty($customer->billing_zip) ? $customer->billing_zip : '' }}<br>
                                            {{ !empty($customer->billing_country) ? $customer->billing_country : '' }}<br>
                                            {{ !empty($customer->billing_phone) ? $customer->billing_phone : '' }}<br>
                                            @if ($settings['vat_gst_number_switch'] == 'on')
                                                <strong>{{ __('Tax Number ') }} :
                                                </strong>{{ !empty($customer->tax_number) ? $customer->tax_number : '' }}
                                            @endif
                                        @else
                                            -
                                        @endif

                                    </small>
                                </div>

                                @if (App\Models\Utility::getValByName('shipping_display') == 'on')
                                    <div class="col ">
                                        <small>
                                            <strong>{{ __('Shipped To') }} :</strong><br>
                                            @if (!empty($customer->shipping_name))
                                                {{ !empty($customer->shipping_name) ? $customer->shipping_name : '' }}<br>
                                                {{ !empty($customer->shipping_address) ? $customer->shipping_address : '' }}<br>
                                                {{ !empty($customer->shipping_city) ? $customer->shipping_city : '' . ', ' }}<br>
                                                {{ !empty($customer->shipping_state) ? $customer->shipping_state : '' . ', ' }},
                                                {{ !empty($customer->shipping_zip) ? $customer->shipping_zip : '' }}<br>
                                                {{ !empty($customer->shipping_country) ? $customer->shipping_country : '' }}<br>
                                                {{ !empty($customer->shipping_phone) ? $customer->shipping_phone : '' }}<br>
                                            @else
                                                -
                                            @endif
                                        </small>
                                    </div>
                                @endif
                                <!-- @php
                                    try {
                                        $formattedDate = \Carbon\Carbon::createFromFormat(
                                            'YmdHis',
                                            $creditNote->response_SdcDateTime,
                                        )->format('Y-m-d-H-i-s');
                                    } catch (\Exception $e) {
                                        $formattedDate = 'Invalid date format';
                                    }
                                @endphp
     -->
                                <div class="col ">
                                    <small>
                                        <strong>{{ __('SCU Information') }} :</strong><br>
                                        <p><i>Date : </i>{{ $creditNote->response_sdcDateTime }}</p>
                                        <p><i>Invoice No : </i>{{ $creditNote->response_invoiceNo }}</p>
                                        <p><i>Trader Invoice No : </i>{{ $creditNote->response_tranderInvoiceNo }}</p>
                                        <p><i>Internal Data : </i>{{ $creditNote->response_scuInternalData }}</p>
                                        <p><i>Receipt Signature : </i>{{ $creditNote->response_scuReceiptSignature }}</p>
                                    </small>
                                </div>

                                <div class="col">
                                    <div class="float-end mt-3">
                                        @if (!empty($creditNote->response_scuqrCode))
                                            {!! DNS2D::getBarcodeHTML($creditNote->response_scuqrCode, 'QRCODE', 2, 2) !!}
                                        @else
                                            {{ __('No QR code available') }}
                                        @endif
                                    </div>

                                </div>

                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <small>
                                        <strong>{{ __('CreditNote Reason') }} : {{ $creditNote->creditNoteReason }}
                                    </small>
                                </div>

                                @if (!empty($customFields) && count($creditNote->customField) > 0)
                                    @foreach ($customFields as $field)
                                        <div class="col text-md-right">
                                            <small>
                                                <strong>{{ $field->name }} :</strong><br>
                                                {{ !empty($creditNote->customField) ? $creditNote->customField[$field->id] : '-' }}
                                                <br><br>
                                            </small>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="font-weight-bold">{{ __('Product Summary') }}</div>
                                    <small>{{ __('All items here cannot be deleted.') }}</small>
                                    <div class="table-responsive mt-2">
                                        <table class="table mb-0 table-striped">
                                            <tr>
                                                <th class="text-dark">{{ __('Product') }}</th>
                                                <th class="text-dark">{{ __('Quantity') }}</th>
                                                <th class="text-dark">{{ __('Pkg Quantity') }}</th>
                                                <th class="text-dark">{{ __('Unit Price') }}</th>
                                                <th class="text-dark">{{ __('Discount') }}</th>
                                                <th class="text-dark">{{ __('Tax') }}</th>
                                                <th class="text-dark">{{ __('Description') }}</th>
                                                <th class="text-end text-dark" width="12%">{{ __('Price') }}<br>
                                                    <small
                                                        class="text-danger font-weight-bold">{{ __('after tax & discount') }}</small>
                                                </th>
                                            </tr>
                                            @php
                                                $totalQuantity = 0;
                                                $totalRate = 0;
                                                $totalTaxPrice = 0;
                                                $totalDiscount = 0;
                                                $taxesData = [];
                                            @endphp

                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                            </td>
                                            <td></td>
                                            <td>
                                                @php

                                                @endphp
                                            </td>
                                            <td></td>
                                            <td>
                                                @php

                                                @endphp

                                            </td>
                                            </tr>
                                            <tfoot>
                                                <tr>
                                                    <td><b>{{ __('Total') }}</b></td>
                                                    <td>
                                                        <b>
                                                            @php

                                                            @endphp

                                                        </b>
                                                    </td>
                                                    <td>
                                                        <b>
                                                            @php

                                                            @endphp

                                                        </b>
                                                    </td>
                                                    <td>
                                                        <b>
                                                            @php

                                                            @endphp

                                                        </b>
                                                    </td>
                                                    <td>
                                                        <b>
                                                            @php

                                                            @endphp

                                                        </b>
                                                    </td>
                                                    <td>
                                                        <b>
                                                            @php

                                                            @endphp

                                                        </b>
                                                    </td>
                                                    <td></td>
                                                    <td>
                                                        <b>
                                                            @php

                                                            @endphp

                                                        </b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td class="text-end"><b></b></td>
                                                    <td class="text-end">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td class="text-end"><b></b></td>
                                                    <td class="text-end">

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td class="text-end"><b></b></td>
                                                    <td class="text-end">

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td class="blue-text text-end"><b></b></td>
                                                    <td class="blue-text text-end">

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td class="text-end"><b></b></td>
                                                    <td class="text-end">

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td class="text-end"><b></b></td>
                                                    <td class="text-end">

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td class="text-end"><b></b></td>
                                                    <td class="text-end">

                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <h5 class=" d-inline-block">{{ __('Receipt Summary') }}</h5><br>
                    @if ($userPlan->storage_limit <= $creditNoteUser->storage_limit)
                        <small
                            class="text-danger font-bold">{{ __('Your plan storage limit is over , so you can not see customer uploaded payment receipt') }}</small><br>
                    @endif

                    <div class="table-responsive mt-3">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th class="text-dark">{{ __('Payment Receipt') }}</th>
                                    <th class="text-dark">{{ __('Date') }}</th>
                                    <th class="text-dark">{{ __('Amount') }}</th>
                                    <th class="text-dark">{{ __('Payment Type') }}</th>
                                    <th class="text-dark">{{ __('Account') }}</th>
                                    <th class="text-dark">{{ __('Reference') }}</th>
                                    <th class="text-dark">{{ __('Description') }}</th>
                                    <th class="text-dark">{{ __('Receipt') }}</th>
                                    <th class="text-dark">{{ __('OrderId') }}</th>
                                    @can('delete payment invoice')
                                        <th class="text-dark">{{ __('Action') }}</th>
                                    @endcan
                                </tr>
                            </thead>


                            @php

                            @endphp


                            <tr>
                                <td>


                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                </td>
                                <td></td>
                                <td></td>
                                <td>
                                    --
                                </td>

                                <td>

                                </td>

                                <td>
                                <td>

                                </td>

                            </tr>

                            {{--  start for bank transfer --}}
                            <tr>
                                <td>-</td>
                                <td></td>
                                <td></td>
                                <td><br>
                                </td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>

                                <td>
                                    ---
                                </td>

                                <td>

                                </td>

                                <td></td>
                                <td>

                                </td>

                            </tr>
                            {{--  end for bank transfer --}}
                            <tr>
                                <td colspan="{{ Gate::check('delete invoice product') ? '10' : '9' }}"
                                    class="text-center text-dark">
                                    <p>{{ __('No Data Found') }}</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <h5 class="d-inline-block mb-5">{{ __('Credit Note Summary') }}</h5>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-dark">{{ __('Date') }}</th>
                                    <th class="text-dark" class="">{{ __('Amount') }}</th>
                                    <th class="text-dark" class="">{{ __('Description') }}</th>

                                </tr>
                            </thead>
                            <tr>
                                <td></td>
                                <td class=""></td>
                                <td class=""></td>
                                <td>

                                </td>
                            </tr>

                            <tr>
                                <td colspan="4" class="text-center">
                                    <p class="text-dark">{{ __('No Data Found') }}</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
