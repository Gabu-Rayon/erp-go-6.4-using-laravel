@extends('layouts.admin')

@section('page-title')
    {{ __('Transaction Purchase Sale Details') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('purchase.index') }}">{{ __('Purchase') }}</a></li>
    <li class="breadcrumb-item">{{ __('Purchase Sale') }}</li>
    <li class="breadcrumb-item">{{ __('Details') }}</li>
@endsection

@section('content')
    <div class="row">
        {{ Form::open(['route' => 'purchase.mapPurchase', 'class' => 'w-100']) }}
        <div class="col-12">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <div class="item-section py-2">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-12 d-flex align-items-center justify-content-between justify-content-md-end">
                        <div class="all-button-box me-2"><input type="submit" value="{{ __('Map Purchase') }}"
                                class="btn  btn-primary">
                            <input type="button" value="{{ __('Cancel') }}"
                                onclick="location.href = '{{ route('purchase.index') }}';" class="btn btn-danger">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <strong>Supplier Tin</strong> : {{ $purchase->spplrTin }}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Supplier Name</strong> : {{ $purchase->spplrNm }}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Supplier BhfId</strong> : {{ $purchase->spplrBhfId }}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Supplier Invoice No</strong> : {{ $purchase->spplrInvcNo }}
                            {{ Form::text('supplierInvcNo', $purchase->spplrInvcNo, ['class' => 'form-control', 'required' => 'required']) }}

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Supplier Sdcld</strong> : {{ $purchase->spplrSdcld }}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Supplier MrcNo</strong> : {{ $purchase->spplMrcNo }}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Receipt Type Code</strong> : {{ $purchase->rcptTyCd }}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Pmt Type Code</strong> : {{ $purchase->pmtTycCd }}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Purchase Type Code</strong> :
                            {{ Form::text('purchaseTypeCode', null, ['class' => 'form-control', 'required' => 'required']) }}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Purchase Status Code</strong> :
                            {{ Form::text('purchaseStatusCode', null, ['class' => 'form-control', 'required' => 'required']) }}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Confirmed Date</strong> : {{ $purchase->cfmDt }}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Sales Date</strong> : {{ $purchase->salesDt }}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Stock Release Date</strong> : {{ $purchase->stockRlsDt }}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Total Item Cnt</strong> : {{ $purchase->totItemCnt }}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Taxable Amount A</strong> : {{ $purchase->taxblAmtA }}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Taxable Amount B</strong> : {{ $purchase->taxblAmtB }}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Taxable Amount C</strong> : {{ $purchase->taxblAmtC }}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Taxable Amount D</strong> : {{ $purchase->taxblAmtD }}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Taxable Amount E</strong> : {{ $purchase->taxblAmtE }}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Tax Rate A</strong> : {{ $purchase->taxRtA }}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Tax Rate B</strong> : {{ $purchase->taxRtB }}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Tax RateC</strong> : {{ $purchase->taxRtC }}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Tax Rate B</strong> : {{ $purchase->taxRtB }}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Tax Rate C</strong> : {{ $purchase->taxRtC }}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Tax Rate D</strong> : {{ $purchase->taxRtD }}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Tax Rate E</strong> : {{ $purchase->taxRtE }}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Tax Amount A</strong> : {{ $purchase->taxAmtA }}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Tax Amount B</strong> : {{ $purchase->taxAmtB }}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Tax Amount C</strong> : {{ $purchase->taxAmtC }}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Tax Amount D</strong> : {{ $purchase->taxAmtD }}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Tax Amount E</strong> : {{ $purchase->taxAmtE }}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Total Taxable Amount</strong> : {{ $purchase->totTaxblAmt }}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Total Tax Amount</strong> : {{ $purchase->totTaxAmt }}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Total Amount</strong> : {{ $purchase->totAmt }}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Remark</strong> : {{ $purchase->remark }}
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <h5 class="d-inline-block mb-4">{{ __('Product & Services') }}</h5>
            @foreach ($purchaseItems->groupBy('itemType') as $itemType => $items)
                <div class="row">
                    @foreach ($items as $index => $item)
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <strong>Item Sequence No</strong> : {{ $item->itemSeq }}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Item Code</strong> : {{ $item->itemCd }}
                                            {{ Form::text('itemCode[]', $item->itemCd, ['class' => 'form-control', 'required' => 'required']) }}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>item Class Code</strong> : {{ $item->itemClsCd }}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Item Name</strong> : {{ $item->itemNm }}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Bar Code</strong> : {{ $item->bcd }}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Supplier Item Class Code</strong> : {{ $item->itemClsCd }}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Supplier Item Code</strong> : {{ $item->spplrItemCd }}
                                            {{ Form::text('supplierItemCode[]', $item->spplrItemCd, ['class' => 'form-control', 'required' => 'required']) }}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Supplier Item Name</strong> : {{ $item->spplrItemNm }}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Package Unit Code</strong> : {{ $item->pkgUnitCd }}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Package</strong> : {{ $item->pkg }}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Quantity Unit Code</strong> : {{ $item->qtyUnitCd }}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Quantity</strong> : {{ $item->qty }}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Price</strong> : {{ $item->prc }}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Supply Amount</strong> : {{ $item->splyAmt }}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Discount Rate</strong> : {{ $item->dcRt }}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Discount Amount</strong> : {{ $item->dcAmt }}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Tax Type Code</strong> : {{ $item->taxTy }}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Taxable Amount</strong> : {{ $item->taxAmt }}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Tax Amount</strong> : {{ $purchase->taxRtA }}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Total Amount</strong> : {{ $item->totAmt }}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Item Expire Date</strong> : {{ $item->itemExprDt }}
                                        </div>
                                        <div class="form-group col-md-4">
                                            {{ Form::label('mappingProduct', __('Mapp Purchase Product To Your Product Stock'), ['class' => 'form-label']) }}
                                            {{ Form::select('productItem', $ProductService, null, ['class' => 'form-control select2 productItem', 'required' => 'required']) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                    @endforeach
                </div>
            @endforeach
        </div>
        {{ Form::close() }}
    </div>
@endsection
