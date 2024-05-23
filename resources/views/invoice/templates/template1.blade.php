@php
    $settings_data = \App\Models\Utility::settingsById($invoice->created_by);
@endphp
<!DOCTYPE html>
<html lang="en" dir="{{$settings_data['SITE_RTL'] == 'on'?'rtl':''}}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">

    <style type="text/css">
        :root {
            --theme-color: {{$color}};
            --white: #ffffff;
            --black: #000000;
        }

        body {
            font-family: 'Lato', sans-serif;
        }

        p,
        li,
        ul,
        ol {
            margin: 0;
            padding: 0;
            list-style: none;
            line-height: 1.5;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table tr th {
            padding: 0.75rem;
            text-align: left;
        }

        table tr td {
            padding: 0.75rem;
            text-align: left;
        }

        table th small {
            display: block;
            font-size: 12px;
        }

        .invoice-preview-main {
            max-width: 700px;
            width: 100%;
            margin: 0 auto;
            background: #ffff;
            box-shadow: 0 0 10px #ddd;
        }

        .invoice-logo {
            max-width: 200px;
            width: 100%;
        }

        .invoice-header table td {
            padding: 15px 30px;
        }

        .text-right {
            text-align: right;
        }

        .no-space tr td {
            padding: 0;
            white-space: nowrap;
        }

        .vertical-align-top td {
            vertical-align: top;
        }

        .view-qrcode {
            max-width: 139px;
            height: 139px;
            width: 100%;
            margin-left: auto;
            margin-top: 15px;
            background: var(--white);
            padding: 13px;
            border-radius: 10px;
        }

        .view-qrcode img {
            width: 100%;
            height: 100%;
        }

        .invoice-body {
            padding: 30px 25px 0;
        }



        table.add-border tr {
            border-top: 1px solid var(--theme-color);
        }

        tfoot tr:first-of-type {
            border-bottom: 1px solid var(--theme-color);
        }

        .total-table tr:first-of-type td {
            padding-top: 0;
        }

        .total-table tr:first-of-type {
            border-top: 0;
        }

        .sub-total {
            padding-right: 0;
            padding-left: 0;
        }

        .border-0 {
            border: none !important;
        }

        .invoice-summary td,
        .invoice-summary th {
            font-size: 13px;
            font-weight: 600;
        }

        .total-table td:last-of-type {
            width: 146px;
        }

        .invoice-footer {
            padding: 15px 20px;
        }

        .itm-description td {
            padding-top: 0;
        }
        html[dir="rtl"] table tr td,
        html[dir="rtl"] table tr th{
            text-align: right;
        }
        html[dir="rtl"]  .text-right{
            text-align: left;
        }
        html[dir="rtl"] .view-qrcode{
            margin-left: 0;
            margin-right: auto;
        }
    </style>

    @if($settings_data['SITE_RTL']=='on')
        <link rel="stylesheet" href="{{ asset('css/bootstrap-rtl.css') }}">
    @endif
</head>

<body class="">
<div class="invoice-preview-main"  id="boxes">
    <div class="invoice-header" style="background: {{$color}};color:{{$font_color}}">
        <table>
            <tbody>
            <tr>
                <td>
                    <img class="invoice-logo" src="{{$img}}" alt="">
                </td>
                <td class="text-right">
                    <h3 style="text-transform: uppercase; font-size: 40px; font-weight: bold;">{{__('INVOICE')}}</h3>
                </td>
            </tr>
            </tbody>
        </table>
        <table class="vertical-align-top">
            <tbody>
            <tr>
                <td>
                    <p>
                        @if($settings['company_name']){{$settings['company_name']}}@endif<br>
                        @if($settings['mail_from_address']){{$settings['mail_from_address']}}@endif<br><br>
                        @if($settings['company_address']){{$settings['company_address']}}@endif
                        @if($settings['company_city']) <br> {{$settings['company_city']}}, @endif
                        @if($settings['company_state']){{$settings['company_state']}}@endif
                        @if($settings['company_zipcode']) - {{$settings['company_zipcode']}}@endif
                        @if($settings['company_country']) <br>{{$settings['company_country']}}@endif
                        @if($settings['company_telephone']){{$settings['company_telephone']}}@endif<br>
                        @if(!empty($settings['registration_number'])){{__('Registration Number')}} : {{$settings['registration_number']}} @endif<br>
                        @if($settings['vat_gst_number_switch'] == 'on')
                            @if(!empty($settings['tax_type']) && !empty($settings['vat_number'])){{$settings['tax_type'].' '. __('Number')}} : {{$settings['vat_number']}} <br>@endif
                        @endif
                    </p>
                </td>
                <td>
                    <table class="no-space" style="width: 45%;margin-left: auto;">
                        <tbody>
                        <tr>
                            <td>{{__('Number')}}:</td>
                            <td class="text-right">{{Utility::invoiceNumberFormat($settings,$invoice->invoice_id)}}</td>
                        </tr>
                        <tr>
                            <td>{{__('Issue Date')}}:</td>
                            <td class="text-right">{{Utility::dateFormat($settings,$invoice->issue_date)}}</td>
                        </tr>

                        <tr>
                            <td><b>{{__('Due Date:')}}</b></td>
                            <td class="text-right">{{Utility::dateFormat($settings,$invoice->due_date)}}</td>
                        </tr>
                        @if(!empty($customFields) && count($invoice->customField)>0)
                            @foreach($customFields as $field)
                                <tr>
                                    <td>{{$field->name}} :</td>
                                    <td> {{!empty($invoice->customField)?$invoice->customField[$field->id]:'-'}}</td>
                                </tr>
                            @endforeach
                        @endif
                        <tr>
                            <td colspan="2">
                                <div class="view-qrcode">
                                    {!! DNS2D::getBarcodeHTML(route('invoice.link.copy',\Crypt::encrypt($invoice->invoice_id)), "QRCODE",2,2) !!}
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="invoice-body">
        <table>
            <tbody>
            <tr>
                <td>
                    <strong style="margin-bottom: 10px; display:block;">{{__('Bill To')}}:</strong>
                    @if(!empty($customer->billing_name))
                        <p>
                            {{!empty($customer->billing_name)?$customer->billing_name:''}}<br>
                            {{!empty($customer->billing_address)?$customer->billing_address:''}}<br>
                            {{!empty($customer->billing_city)?$customer->billing_city:'' .', '}}<br>
                            {{!empty($customer->billing_state)?$customer->billing_state:'',', '}},
                            {{!empty($customer->billing_zip)?$customer->billing_zip:''}}<br>
                            {{!empty($customer->billing_country)?$customer->billing_country:''}}<br>
                            {{!empty($customer->billing_phone)?$customer->billing_phone:''}}<br>
                        </p>
                    @else
                        -
                    @endif
                </td>

                @if($settings['shipping_display']=='on')
                    <td class="text-right">
                        <strong style="margin-bottom: 10px; display:block;">{{__('Ship To')}}:</strong>
                        @if(!empty($customer->shipping_name))
                        <p>
                            {{!empty($customer->shipping_name)?$customer->shipping_name:''}}<br>
                            {{!empty($customer->shipping_address)?$customer->shipping_address:''}}<br>
                            {{!empty($customer->shipping_city)?$customer->shipping_city:'' . ', '}}<br>
                            {{!empty($customer->shipping_state)?$customer->shipping_state:'' .', '}},
                            {{!empty($customer->shipping_zip)?$customer->shipping_zip:''}}<br>
                            {{!empty($customer->shipping_country)?$customer->shipping_country:''}}<br>
                            {{!empty($customer->shipping_phone)?$customer->shipping_phone:''}}<br>
                        </p>
                        @else
                            -
                        @endif
                    </td>
                @endif
            </tr>
        <tr>
                
                @if ($invoice->status == 0)
                    <td
                        class="badge bg-primary"><strong>{{ __('Invoice Status') }} : </strong>{{ __(\App\Models\Invoice::$statues[$invoice->status]) }}</td>
                @elseif($invoice->status == 1)
                    <td
                        class="badge bg-warning"><strong>{{ __('Invoice Status') }} : </strong>{{ __(\App\Models\Invoice::$statues[$invoice->status]) }}</td>
                @elseif($invoice->status == 2)
                    <td
                        class="badge bg-danger"><strong>{{ __('Invoice Status') }} : </strong>{{ __(\App\Models\Invoice::$statues[$invoice->status]) }}</td>
                @elseif($invoice->status == 3)
                    <td
                        class="badge bg-info"><strong>{{ __('Invoice Status') }} : </strong>{{ __(\App\Models\Invoice::$statues[$invoice->status]) }}</td>
                @elseif($invoice->status == 4)
                    <td
                        class="badge bg-primary"><strong>{{ __('Invoice Status') }} : </strong>{{ __(\App\Models\Invoice::$statues[$invoice->status]) }}</td>
                @endif
        </tr>
            </tbody>
        </table>
        <table class="table mb-0 table-striped">
                                            <tr>
                                                <th class="text-dark">{{ __('Product') }}</th>
                                                <th class="text-dark">{{ __('Qty') }}</th>
                                                <th class="text-dark">{{ __('pkgQty') }}</th>
                                                <th class="text-dark">{{ __('Prc') }}</th>
                                                <th class="text-dark">{{ __('Discount') }}</th>
                                                <th class="text-dark">{{ __('Tax') }}</th>
                                                <th class="text-dark">{{ __('Desc') }}</th>
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
                                            @foreach ($items as $key => $iteam)
                                                <td>{{ !empty($iteam->name) ? $iteam->name : '' }}</td>
                                                <td>{{ !empty($iteam->quantity) ? $iteam->quantity : '' }}</td>
                                                <td>{{ !empty($iteam->pkgQuantity) ? $iteam->pkgQuantity : '' }}</td>
                                                <td>Kes {{ $iteam->unitPrice }}</td>
                                                <td>{{ !empty($iteam->discount) ? $iteam->discount : '' }}</td>
                                                <td>
                                                    @php
                                                        $taxData = \Utility::getTaxData();
                                                        $taxRate = floatval($taxData[$iteam->taxTypeCode]);
                                                        $taxTot = ($iteam->price - $iteam->discount) * ($taxRate / 100);
                                                    @endphp
                                                    {{ $taxTot }}
                                                </td>
                                                <td>{{ !empty($iteam->description) ? $iteam->description : '' }}</td>
                                                <td>Kes {{ $iteam->price }}</td>
                                                </tr>
                                            @endforeach
                                            <tfoot>
                                                <tr>
                                                    <td><b>{{ __('Total') }}</b></td>
                                                    <td>
                                                        <b>
                                                            @php
                                                                $qtySum = 0;
                                                                foreach ($items as $iteam) {
                                                                    $qtySum += $iteam->quantity;
                                                                }
                                                            @endphp
                                                            {{ $qtySum }}
                                                        </b>
                                                    </td>
                                                    <td>
                                                        <b>
                                                            @php
                                                                $pkgQtySum = 0;
                                                                foreach ($items as $iteam) {
                                                                    $pkgQtySum += $iteam->pkgQuantity;
                                                                }
                                                            @endphp
                                                            {{ $pkgQtySum }}
                                                        </b>
                                                    </td>
                                                    <td>
                                                        <b>
                                                            @php
                                                                $unitPrcSum = 0;
                                                                foreach ($items as $iteam) {
                                                                    $prc = $iteam->unitPrice * $iteam->pkgQuantity * $iteam->quantity;
                                                                    $unitPrcSum += $prc;
                                                                }
                                                            @endphp
                                                            {{ $unitPrcSum }}
                                                        </b>
                                                    </td>
                                                    <td>
                                                        <b>
                                                            @php
                                                                $discountSum = 0;
                                                                foreach ($items as $iteam) {
                                                                    $discountSum += $iteam->discount;
                                                                }
                                                            @endphp
                                                            {{ $discountSum }}
                                                        </b>
                                                    </td>
                                                    <td>
                                                        <b>
                                                            @php
                                                                $taxSum = 0;
                                                                $taxData = \Utility::getTaxData();
                                                                $taxRate = floatval($taxData[$iteam->taxTypeCode]);
                                                                foreach ($items as $iteam) {
                                                                    $tax = ($iteam->price - $iteam->discount) * ($taxRate / 100);
                                                                    $taxSum += $tax;
                                                                }
                                                            @endphp
                                                            {{ $taxSum }}
                                                        </b>
                                                    </td>
                                                    <td></td>
                                                    <td>
                                                        <b>
                                                            @php
                                                                $tot = 0;
                                                                foreach ($items as $iteam) {
                                                                    $tot += $iteam->price;
                                                                }
                                                            @endphp
                                                            {{ $tot }}
                                                        </b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td class="text-end"><b>{{ __('Sub Total') }}</b></td>
                                                    <td class="text-end">
                                                        {{ \Auth::user()->priceFormat($invoice->getSubTotal()) }}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td class="text-end"><b>{{ __('Discount') }}</b></td>
                                                    <td class="text-end">
                                                        {{ \Auth::user()->priceFormat($invoice->getTotalDiscount()) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td class="text-end"><b>{{ __('Tax') }}</b></td>
                                                    <td class="text-end">
                                                        {{ \Auth::user()->priceFormat($taxSum) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td class="blue-text text-end"><b>{{ __('Total') }}</b></td>
                                                    <td class="blue-text text-end">
                                                        {{ \Auth::user()->priceFormat($invoice->getTotal()) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td class="text-end"><b>{{ __('Paid') }}</b></td>
                                                    <td class="text-end">
                                                        {{ \Auth::user()->priceFormat($invoice->getTotal() - $invoice->getDue() - $invoice->invoiceTotalCreditNote()) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td class="text-end"><b>{{ __('Credit Note') }}</b></td>
                                                    <td class="text-end">
                                                        {{ \Auth::user()->priceFormat($invoice->invoiceTotalCreditNote()) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td class="text-end"><b>{{ __('Due') }}</b></td>
                                                    <td class="text-end">
                                                        {{ \Auth::user()->priceFormat($invoice->getDue()) }}</td>
                                                </tr>
                                            </tfoot>
                                        </table>
        <div class="invoice-footer">
            <b>{{$settings['footer_title']}}</b> <br>
            {!! $settings['footer_notes'] !!}
        </div>
    </div>

</div>
@if(!isset($preview))
    @include('invoice.script');
@endif

</body>

</html>
