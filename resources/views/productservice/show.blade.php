@extends('layouts.admin')
@section('page-title')
    {{__('Product & Service Information')}}
@endsection

@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0">{{__('Product & Service Information')}}</h5>
    </div>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('productservice.index')}}">{{__('Product & Service Information')}}</a></li>
    <li class="breadcrumb-item">{{ucwords($productServiceInfo->itemCd)}}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3">
                        <h6>{{ __('Name: ') }}</h6>
                        <p>{{ $productServiceInfo->name }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Item SKU: ') }}</h6>
                        <p>{{ $productServiceInfo->sku }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Sale price: ') }}</h6>
                        <p>{{ $productServiceInfo->sale_price }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Purchase Price: ') }}</h6>
                        <p>{{ $productServiceInfo->purchase_price }}</h6>
                    </div>
                     <div class="col-md-3">
                        <h6>{{ __('Quantity: ') }}</h6>
                        <p>{{ $productServiceInfo->quantity }}</h6>
                    </div>
                     <div class="col-md-3">
                        <h6>{{ __('Tax Id: ') }}</h6>
                        <p>{{  $taxName }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Category Id: ') }}</h6>
                        <p>{{ $categoryName }}</h6>
                    </div>
                     <div class="col-md-3">
                        <h6>{{ __('Unit Id: ') }}</h6>
                        <p>{{ $unitName }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Type: ') }}</h6>
                        <p>{{ $productServiceInfo->type }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('sale Chart Account Id: ') }}</h6>
                        <p>{{  $saleChartAccountName }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Expense Chart Account Id: ') }}</h6>
                        <p>{{ $expenseChartAccounName }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Description: ') }}</h6>
                        <p>{{ $productServiceInfo->description }}</h6>
                    </div>                    
                    <div class="col-md-3">
                        <h6>{{ __('Item Code: ') }}</h6>
                        <p>{{ $productServiceInfo->itemCd }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Task Classification: ') }}</h6>
                        <p>{{ $productServiceInfo->itemClsCd }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{__('Item Type Code:')}}</h6>
                        <p>{{ $productServiceInfo->itemTyCd }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Item Name: ') }}</h6>
                        <p>{{ $productServiceInfo->itemNm }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{ __('Origin Place Code: ') }}</h6>
                        <p>{{ $productServiceInfo->orgnNatCd }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{__('Packaging Unit Code:')}}</h6>
                        <p>{{ $productServiceInfo->pkgUnitCd }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{__('Quantity Unit Code:')}}</h6>
                        <p>{{ $productServiceInfo->qtyUnitCd }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{__('Batch No:')}}</h6>
                        <p>{{ $productServiceInfo->btchNo }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{__('Default Price:')}}</h6>
                        <p>{{ $productServiceInfo->dftPrc }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{__('Group 1 Unit Price:')}}</h6>
                        <p>{{ $productServiceInfo->grpPrcL1 }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{__('Group 2 Unit Price:')}}</h6>
                        <p>{{ $productServiceInfo->grpPrcL2 }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{__('Group 3 Unit Price:')}}</h6>
                        <p>{{ $productServiceInfo->grpPrcL3 }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{__('Group 4 Unit Price:')}}</h6>
                        <p>{{ $productServiceInfo->grpPrcL4 }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{__('Group 5 Unit Price:')}}</h6>
                        <p>{{ $productServiceInfo->grpPrcL5 }}</h6>
                    </div>
                   <div class="col-md-3">
                        <h6>{{__('Additional Information :')}}</h6>
                        <p>{{ $productServiceInfo->addInfo }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{__('Safty Quantity :')}}</h6>
                        <p>{{ $productServiceInfo->sftyQty }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{__('Insurance Applicable (Y/N:)')}}</h6>
                        <p>{{ $productServiceInfo->isrcAplcbYn }}</h6>
                    </div>
                    <div class="col-md-3">
                        <h6>{{__('Used/UnUsed :')}}</h6>
                        <p>{{ $productServiceInfo->useYn }}</h6>
                    </div>
                     <div class="col-md-3">
                    <h6>{{ __('Product Image: ') }}</h6>
                    @if ($productServiceInfo->pro_image)
                        <img src="{{ Storage::url($productServiceInfo->pro_image) }}" alt="Product Image" style="max-width: 100%;">
                    @else
                        <p>{{ __('No product image available') }}</p>
                    @endif
                </div>
                    <div class="col-md-3">
                        <h6>{{ __('Created By: ') }}</h6>
                        <p>{{ $productServiceInfo->created_by }}</h6>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
