@extends('layouts.admin')

@section('page-title')
    {{ __('Transaction Purchase Sale Details') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('purchase.mappedPurchases') }}">{{ __('mappedPurchases') }}</a></li>
    <li class="breadcrumb-item">{{ __('mappedPurchases') }}</li>
    <li class="breadcrumb-item">{{ __('Details') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="item-section py-2">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-12 d-flex align-items-center justify-content-between justify-content-md-end">
                            <input type="button" value="{{ __('Go Back') }}"
                                onclick="location.href = '{{ route('purchase.mappedPurchases') }}';" class="btn btn-primary">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <strong>Supplier Tin</strong> : {{ $mappedpurchase->mappedPurchaseId}}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Invoice No</strong> : {{ $mappedpurchase->invcNo}}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Organization Invoice No</strong> :   {{ $mappedpurchase->invcNo}}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Supplier Tin</strong> :  {{ $mappedpurchase->supplrTin}}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Supplier BhfId</strong> :  {{ $mappedpurchase->supplrBhfId}}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Supplier Name</strong> : {{ $mappedpurchase->supplrName}}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Supplier Invoice No</strong> : {{ $mappedpurchase->supplrInvcNo}}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Purchase Type Code</strong> : {{ $mappedpurchase->purchaseTypeCode}}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Receipt Type Code</strong> : {{ $mappedpurchase->rceiptTyCd}}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Payment Type Code</strong> : {{ $mappedpurchase->paymentTypeCode}}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Purchase Status Code</strong> : {{ $mappedpurchase->purchaseSttsCd}}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Confirmed Date</strong> :  {{ $mappedpurchase->confirmDate}}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Purchase Date</strong> :  {{ $mappedpurchase->purchaseDate}}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Warehouse Date</strong> : {{ $mappedpurchase->warehouseDt}}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Cancel Request Date</strong> : {{ $mappedpurchase->cnclReqDt}}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Cancel Date</strong> : {{ $mappedpurchase->cnclDt}}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Refund Date</strong> : {{ $mappedpurchase->refundDate}}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Total Item Count</strong> : {{ $mappedpurchase->totItemCnt}}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Taxable Amount A</strong> :  {{ $mappedpurchase->taxblAmtA}}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Taxable Amount A</strong> :  {{ $mappedpurchase->taxblAmtB}}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Taxable Amount A</strong> :  {{ $mappedpurchase->taxblAmtC}}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Taxable Amount A</strong> :   {{ $mappedpurchase->taxblAmtD}}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Tax Rate A</strong> : {{ $mappedpurchase->taxRtA}}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Tax Rate B</strong> : {{ $mappedpurchase->taxRtB}}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Tax Rate C</strong> :  {{ $mappedpurchase->taxRtC}}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Tax Rate D</strong> :  {{ $mappedpurchase->taxRtD}}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Tax Amount A</strong> :  {{ $mappedpurchase->taxAmtA}}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Tax Amount B</strong> : {{ $mappedpurchase->taxAmtB}}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Tax Amount C</strong> : {{ $mappedpurchase->taxAmtC}}
                        </div>
                         <div class="form-group col-md-4">
                            <strong>Tax Amount D</strong> : {{ $mappedpurchase->taxAmtD}}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Total Taxable Amount</strong> :  {{ $mappedpurchase->totTaxblAmt}}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Total Tax Amount</strong> : {{ $mappedpurchase->totTaxAmt}}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Total Amount</strong> :   {{ $mappedpurchase->totAmt}}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Remark</strong> :  {{ $mappedpurchase->remark}}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Result</strong> :  {{ $mappedpurchase->resultDt}}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Created Date</strong> :  {{ $mappedpurchase->createdDt}}
                        </div>
                         <div class="form-group col-md-4">
                            <strong>Is Upload</strong> :  {{ $mappedpurchase->isUpload}}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Is Stock IO Update</strong> :  {{ $mappedpurchase->isStockIOUpdate}}
                        </div>
                        <div class="form-group col-md-4">
                            <strong>Is Client Stock Update</strong> :  {{ $mappedpurchase->isClientStockUpdate}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

               <div class="col-12">
            <h5 class="d-inline-block mb-4">{{ __('Product/s Item/s Lists') }}</h5>
            @foreach ($mappedpurchaseItemsList->groupBy('itemType') as $itemType => $items)
                <div class="row">
                    @foreach ($items as $index => $item)
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <strong>Purchase item List Id</strong> :  {{ $item->purchase_item_list_id }}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Item Sequence No</strong> :  {{ $item->itemSeq }}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>item Class Code</strong> :  {{ $item->itemCd }}
                                        </div> 
                                        <div class="form-group col-md-4">
                                            <strong>Item Name</strong> :  {{ $item->itemNmme }}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Bar Code</strong> :  {{ $item->itembcd }}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Supplier Item Class Code</strong> :  {{ $item->itemClsCd }} 
                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Supplier Item Code</strong> :  {{ $item->supplrItemCd }}
                                        </div>
                                         <div class="form-group col-md-4">
                                            <strong>Supplier Item Name</strong> :  {{ $item->supplrItemNm }}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Package Unit Code</strong> :   {{ $item->pkgUnitCd }}
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
                                            <strong>Price</strong> : {{ $item->unitprice }}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Supply Amount</strong> :  {{ $item->supplyAmt }}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Discount Rate</strong> :  {{ $item->discountRate}}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Discount Amount</strong> : {{ $item->discountAmt}}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Tax Type Code</strong> : {{ $item->taxTyCd}}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Taxable Amount</strong> : {{ $item->taxblAmt }}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Tax Amount</strong> :  {{ $item->taxAmt }}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Total Amount</strong> : {{ $item->totAmt }}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Item Expire Date</strong> : {{ $item->itemExprDt }}
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
