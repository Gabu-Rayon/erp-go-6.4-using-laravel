@extends('layouts.admin')

@section('page-title')
    {{ __('Get Stock Moved List Information') }}
@endsection

@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0">{{ __('Get Stock Moved List Information') }}</h5>
    </div>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('stockmovelist.index') }}">{{ __('Get Stock Move List') }}</a></li>
    <li class="breadcrumb-item">{{ ucwords($stockMoveList->custTin) }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="item-section py-2">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-12 d-flex align-items-center justify-content-between justify-content-md-end">
                        <input type="button" value="{{ __('Go Back') }}"
                            onclick="location.href = '{{ route('stockmovelist.index') }}';" class="btn btn-primary">
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-4">
                        <h6>{{ __('Customer TIN: ') }}</h6>
                        <p>{{ $stockMoveList->custTin }}</p>
                    </div>
                    <div class="form-group col-md-4">
                        <h6>{{ __('Customer Branch ID: ') }}</h6>
                        <p>{{ $stockMoveList->custBhfId }}</p>
                    </div>
                    <div class="form-group col-md-4">
                        <h6>{{ __('SAR Number: ') }}</h6>
                        <p>{{ $stockMoveList->sarNo }}</p>
                    </div>
                    <div class="form-group col-md-4">
                        <h6>{{ __('Occurrence Date: ') }}</h6>
                        <p>{{ $stockMoveList->ocrnDt }}</p>
                    </div>
                    <div class="form-group col-md-4">
                        <h6>{{ __('Total Items: ') }}</h6>
                        <p>{{ $stockMoveList->totItemCnt }}</p>
                    </div>
                    <div class="form-group col-md-4">
                        <h6>{{ __('Status: ') }}</h6>
                        <p>{{ $stockMoveList->status }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <h5 class="d-inline-block mb-4">{{ __('Product/s Item/s Lists') }}</h5>
        @foreach ($stockMoveListItems->groupBy('itemType') as $itemType => $items)
            <div class="row">
                @foreach ($items as $index => $item)
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <h6>{{ __('Item Sequence: ') }}</h6>
                                        <p>{{ $item->itemSeq }}</p>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <h6>{{ __('Item Code: ') }}</h6>
                                        <p>{{ $item->itemCd }}</p>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <h6>{{ __('Item Classification Code: ') }}</h6>
                                        <p>{{ $item->itemClsCd }}</p>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <h6>{{ __('Item Name: ') }}</h6>
                                        <p>{{ $item->itemNm }}</p>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <h6>{{ __('Barcode: ') }}</h6>
                                        <p>{{ $item->bcd }}</p>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <h6>{{ __('Package Unit Code: ') }}</h6>
                                        <p>{{ $item->pkgUnitCd }}</p>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <h6>{{ __('Package Quantity: ') }}</h6>
                                        <p>{{ $item->pkg }}</p>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <h6>{{ __('Quantity Unit Code: ') }}</h6>
                                        <p>{{ $item->qtyUnitCd }}</p>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <h6>{{ __('Item Expiry Date: ') }}</h6>
                                        <p>{{ $item->itemExprDt }}</p>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <h6>{{ __('Price: ') }}</h6>
                                        <p>{{ $item->prc }}</p>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <h6>{{ __('Supply Amount: ') }}</h6>
                                        <p>{{ $item->splyAmt }}</p>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <h6>{{ __('Total Discount Amount: ') }}</h6>
                                        <p>{{ $item->totDcAmt }}</p>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <h6>{{ __('Taxable Amount: ') }}</h6>
                                        <p>{{ $item->taxblAmt }}</p>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <h6>{{ __('Tax Type Code: ') }}</h6>
                                        <p>{{ $item->taxTyCd }}</p>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <h6>{{ __('Tax Amount: ') }}</h6>
                                        <p>{{ $item->taxAmt }}</p>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <h6>{{ __('Total Amount: ') }}</h6>
                                        <p>{{ $item->totAmt }}</p>
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
