@extends('layouts.admin')
@section('page-title')
    {{__('Purchase Detail')}}
@endsection

@php
    $settings = Utility::settings();
@endphp
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('purchase.index')}}">{{__('Purchase')}}</a></li>
    <li class="breadcrumb-item">{{$purchase->spplrInvcNo}}</li>
@endsection

@section('content')

    @can('send purchase')
        @if($purchase->status!=4)
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row timeline-wrapper">
                                <div class="col-md-6 col-lg-4 col-xl-4">
                                    <div class="timeline-icons"><span class="timeline-dots"></span>
                                        <i class="ti ti-plus text-primary"></i>
                                    </div>
                                    <h6 class="text-primary my-3">{{__('Create Purchase')}}</h6>
                                    <p class="text-muted text-sm mb-3"><i class="ti ti-clock mr-2"></i>{{__('Created on ')}}{{\Auth::user()->dateFormat($purchase->purchase_date)}}</p>
                                    @can('edit purchase')
                                        <a href="{{ route('purchase.edit',$purchase->id) }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-original-title="{{__('Edit')}}"><i class="ti ti-pencil mr-2"></i>{{__('Edit')}}</a>

                                    @endcan
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-4">
                                    <div class="timeline-icons"><span class="timeline-dots"></span>
                                        <i class="ti ti-mail text-warning"></i>
                                    </div>
                                    <h6 class="text-warning my-3">{{__('Send Purchase')}}</h6>
                                    <p class="text-muted text-sm mb-3">
                                        @if($purchase->status!=0)
                                            <i class="ti ti-clock mr-2"></i>{{__('Sent on')}} {{\Auth::user()->dateFormat($purchase->send_date)}}
                                        @else
                                            @can('send purchase')
                                                <small>{{__('Status')}} : {{__('Not Sent')}}</small>
                                            @endcan
                                        @endif
                                    </p>

                                    @if($purchase->status==0)
                                        @can('send purchase')
                                            <a href="{{ route('purchase.sent',$purchase->id) }}" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" data-original-title="{{__('Mark Sent')}}"><i class="ti ti-send mr-2"></i>{{__('Send')}}</a>
                                        @endcan
                                    @endif
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-4">
                                    <div class="timeline-icons"><span class="timeline-dots"></span>
                                        <i class="ti ti-report-money text-info"></i>
                                    </div>
                                    <h6 class="text-info my-3">{{__('Get Paid')}}</h6>
                                    <p class="text-muted text-sm mb-3">{{__('Status')}} : {{__('Awaiting payment')}} </p>
                                    @if($purchase->status!= 0)
                                        @can('create payment purchase')
                                            <a href="#" data-url="{{ route('purchase.payment',$purchase->id) }}" data-ajax-popup="true" data-title="{{__('Add Payment')}}" class="btn btn-sm btn-info" data-original-title="{{__('Add Payment')}}"><i class="ti ti-report-money mr-2"></i>{{__('Add Payment')}}</a> <br>
                                        @endcan
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endcan

    @if(\Auth::user()->type=='company')
        @if($purchase->status!=0)
            <div class="row justify-content-between align-items-center mb-3">
                <div class="col-md-12 d-flex align-items-center justify-content-between justify-content-md-end">

                    <div class="all-button-box mx-2">
                        <a href="{{ route('purchase.resent',$purchase->id) }}" class="btn btn-sm btn-primary">
                            {{__('Resend Purchase')}}
                        </a>
                    </div>
                    <div class="all-button-box">
                        <a href="{{ route('purchase.pdf', $purchase->id)}}" target="_blank" class="btn btn-sm btn-primary">
                            {{__('Download')}}
                        </a>
                    </div>
                </div>
            </div>
        @endif

    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="invoice">
                        <div class="invoice-print">
                            <div class="row invoice-title mt-2">
                                <div class="col-xs-12 col-sm-12 col-nd-6 col-lg-6 col-12">
                                    <h4>{{__('Purchase')}}</h4>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-nd-6 col-lg-6 col-12 text-end">
                                    <h4 class="invoice-number">{{ Auth::user()->purchaseNumberFormat($purchase->purchase_id) }}</h4>
                                </div>
                                <div class="col-12">
                                    <hr>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col text-end">
                                    <div class="d-flex align-items-center justify-content-end">
                                        <div class="me-4">
                                            <small>
                                                <strong>{{ __('Issue Date') }} :</strong><br>
                                                {{ \Auth::user()->dateFormat($purchase->cfmDt) }}<br><br>
                                            </small>
                                        </div>

                                    </div>
                                </div>
                            </div>


                           <div class="row">
                                <div class="col">
                                    <small class="font-style">
                                        <strong>{{ __('Shipped To') }} :</strong><br>
                                        <strong>Company </strong>:

                                        <br>
                                    </small>
                                </div>

                                @if (App\Models\Utility::getValByName('shipping_display') == 'on')
                                    <div class="col">
                                        <small>
                                            <strong>{{ __('Shipped From') }} :</strong>
                                            <br>
                                            <strong> SupplierTin </strong>:
                                            {{ !empty($purchase->spplrTin) ? $purchase->spplrTin : '' }}
                                            <br>
                                            <strong> Supplier Name </strong>:
                                            {{ !empty($purchase->spplrNm) ? $purchase->spplrNm : '' }}
                                            <br>
                                            <strong> SupplierBhfId </strong>:
                                            {{ !empty($purchase->spplrBhfId) ? $purchase->spplrBhfId : '' }}
                                            <br>
                                            <strong> Supplier InvoiceNo </strong>:
                                            {{ !empty($purchase->spplrInvcNo) ? $purchase->spplrInvcNo : '' }}
                                            <br>
                                            <strong> Supplier SdcId </strong>:
                                            {{ !empty($purchase->spplrSdcId) ? $purchase->spplrSdcId : '' }}
                                            <br>
                                            <strong> Supplier MrcNo</strong>:
                                            {{ !empty($purchase->spplrMrcNo) ? $purchase->spplrMrcNo : '' }}
                                            <br>
                                        </small>
                                    </div>
                                @endif

                                <div class="col">
                                    <div class="float-end mt-3">

                                        {!! DNS2D::getBarcodeHTML(route('purchase.link.copy',$purchase->id), "QRCODE",2,2) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <small>
                                        <strong>{{ __('Status') }} :</strong><br>
                                        @if ($purchase->status == 0)
                                            <span
                                                class="badge bg-secondary p-2 px-3 rounded">Draft</span>
                                        @elseif($purchase->status == 1)
                                            <span
                                                class="badge bg-warning p-2 px-3 rounded">Sent</span>
                                        @elseif($purchase->status == 2)
                                            <span
                                                class="badge bg-danger p-2 px-3 rounded">Unpaid</span>
                                        @elseif($purchase->status == 3)
                                            <span
                                                class="badge bg-info p-2 px-3 rounded">Partially Paid</span>
                                        @elseif($purchase->status == 4)
                                            <span
                                                class="badge bg-success p-2 px-3 rounded">Paid</span>
                                        @endif
                                    </small>
                                </div>


                            </div>

                                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="font-bold mb-2">{{ __('Products Summary') }}</div>
                                    <small class="mb-2">{{ __('All items here cannot be deleted.') }}</small>
                                    <div class="table-responsive mt-3">
                                        <table class="table ">
                                            <tr>
                                                <th class="text-dark" data-width="40">#</th>
                                                <th class="text-dark">{{ __('Product') }}</th>
                                                <th class="text-dark">{{ __('Quantity') }}</th>
                                                <th class="text-dark">{{ __('Rate') }}</th>
                                                <th class="text-dark">{{ __('Discount') }}</th>
                                                <th class="text-dark">{{ __('Tax') }}</th>
                                                <th class="text-dark">{{ __('Supply Amount') }}</th>
                                                <th class="text-end text-dark" width="12%">{{ __('Price') }}<br>
                                                    <small
                                                        class="text-danger font-weight-bold">{{ __('after tax & discount') }}</small>
                                                </th>
                                                <th></th>
                                            </tr>

                                            @foreach ($purchaseItems as $item)
                                                <tr>
                                                    <td> {{ !empty($item->id) ? $item->id : '' }}</td>
                                                    <td>{{ !empty($item->itemNm) ? $item->itemNm : '' }}</td>
                                                    <td>{{ !empty($item->qty) ? $item->qty : '' }}</td>
                                                    <td>Kes {{ !empty($item->prc) ? $item->prc : '' }}</td>
                                                    <td>{{ !empty($item->dcAmt) ? $item->dcAmt : '' }}</td>
                                                    <td>
                                                        @php
                                                            // Map taxTyCd to its corresponding description
                                                            $taxDescription = '';
                                                            switch ($item->taxTyCd) {
                                                                case 'A':
                                                                    $taxDescription = 'A-Exmpt';
                                                                    break;
                                                                case 'B':
                                                                    $taxDescription = 'B-VAT 16%';
                                                                    break;
                                                                case 'C':
                                                                    $taxDescription = 'C-Zero Rated';
                                                                    break;
                                                                case 'D':
                                                                    $taxDescription = 'D-Non VAT';
                                                                    break;
                                                                case 'E':
                                                                    $taxDescription = 'E-VAT 8%';
                                                                    break;
                                                                case 'F':
                                                                    $taxDescription = 'F-Non Tax';
                                                                    break;
                                                                default:
                                                                    $taxDescription = ''; // Handle unknown tax codes here
                                                                    break;
                                                            }
                                                        @endphp
                                                        {{ $taxDescription }}
                                                    </td>
                                                    <td>Kes {{ !empty($item->splyAmt) ? $item->splyAmt : '' }}</td>
                                                    <td>Kes {{ !empty($item->totAmt) ? $item->totAmt : '' }}</td>
                                                </tr>
                                            @endforeach
                                            <tfoot>
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td class="text-end"><b>{{ __('Sub Total') }}</b></td>
                                                    <td class="text-end">
                                                     Kes {{ $purchaseItems->sum('prc') }} </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td class="text-end"><b>{{ __('Discount') }}</b></td>
                                                    <td class="text-end">
                                                            Kes {{ $purchaseItems->sum('dcAmt') }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td class="text-end"><b>{{ __('Tax Amount') }}</b></td>
                                                    <td class="text-end">
                                                        Kes {{ $purchaseItems->sum('taxAmt') }} </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td class="blue-text text-end"><b>{{ __('Total') }}</b></td>
                                                    <td class="blue-text text-end">
                                                         Kes {{ $purchaseItems->sum('prc') }}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td class="text-end"><b>{{ __('Paid') }}</b></td>
                                                    <td class="text-end">
                                                        {{ \Auth::user()->priceFormat($purchase->getTotal() - $purchase->getDue()) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td class="text-end"><b>{{ __('Due') }}</b></td>
                                                    <td class="text-end">
                                                        {{ \Auth::user()->priceFormat($purchase->getDue()) }}</td>
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
                    <h5 class=" d-inline-block mb-5">{{__('Payment Summary')}}</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th class="text-dark">{{__('Payment Receipt')}}</th>
                                <th class="text-dark">{{__('Date')}}</th>
                                <th class="text-dark">{{__('Amount')}}</th>
                                <th class="text-dark">{{__('Account')}}</th>
                                <th class="text-dark">{{__('Reference')}}</th>
                                <th class="text-dark">{{__('Description')}}</th>
                                @can('delete payment purchase')
                                    <th class="text-dark">{{__('Action')}}</th>
                                @endcan
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
