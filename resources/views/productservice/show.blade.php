@extends('layouts.admin')
@section('page-title')
    {{__('Item Information')}}
@endsection

@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0">{{__('Item Information')}}</h5>
    </div>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('productservice.index')}}">{{__('Item Information')}}</a></li>
    <li class="breadcrumb-item">{{ucwords($iteminformation->itemCd)}}</li>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>{{__('Item Code')}}</td>
                                <td>{{ $iteminformation->itemCd }}</td>
                            </tr>
                            <tr>
                                <td>{{__('Item Classification Code')}}</td>
                                <td>{{ $iteminformation->itemClsCd }}</td>
                            </tr>
                            <tr>
                                <td>{{__('Item Type Code')}}</td>
                                <td>{{ $iteminformation->itemTyCd }}</td>
                            </tr>
                            <tr>
                                <td>{{__('Item Name')}}</td>
                                <td>{{ $iteminformation->itemNm }}</td>
                            </tr>
                            <tr>
                                <td>{{__('Origin Place Code')}}</td>
                                <td>{{ $iteminformation->orgnNatCd }}</td>
                            </tr>
                            <tr>
                                <td>{{__('Packaging Unit Code')}}</td>
                                <td>{{ $iteminformation->pkgUnitCd }}</td>
                            </tr>
                            <tr>
                                <td>{{__('Quantity Unit Code')}}</td>
                                <td>{{ $iteminformation->qtyUnitCd }}</td>
                            </tr>
                            <tr>
                                <td>{{__('Batch No')}}</td>
                                <td>{{ $iteminformation->btchNo }}</td>
                            </tr>
                            <tr>
                                <td>{{__('Batch No')}}</td>
                                <td>{{ $iteminformation->bcd }}</td>
                            </tr>
                            <tr>
                                <td>{{__('Default Price')}}</td>
                                <td>{{ $iteminformation->dftPrc }}</td>
                            </tr>
                            <tr>
                                <td>{{__('Group 1 Unit Price')}}</td>
                                <td>{{ $iteminformation->grpPrcL1 }}</td>
                            </tr>
                            <tr>
                                <td>{{__('Group 2 Unit Price')}}</td>
                                <td>{{ $iteminformation->grpPrcL2 }}</td>
                            </tr>
                            <tr>
                                <td>{{__('Group 3 Unit Price')}}</td>
                                <td>{{ $iteminformation->grpPrcL3 }}</td>
                            </tr>
                            <tr>
                                <td>{{__('Group 4 Unit Price')}}</td>
                                <td>{{ $iteminformation->grpPrcL4 }}</td>
                            </tr>
                            <tr>
                                <td>{{__('Group 5 Unit Price')}}</td>
                                <td>{{ $iteminformation->grpPrcL5 }}</td>
                            </tr>
                            <tr>
                                <td>{{__('Additional Information')}}</td>
                                <td>{{ $iteminformation->addInfo }}</td>
                            </tr>
                            <tr>
                                <td>{{__('Safty Quantity')}}</td>
                                <td>{{ $iteminformation->sftyQty }}</td>
                            </tr>
                            <tr>
                                <td>{{__('Insurance Applicable (Y/N)')}}</td>
                                <td>{{ $iteminformation->isrcAplcbYn }}</td>
                            </tr>
                            <tr>
                                <td>{{__('Used/UnUsed')}}</td>
                                <td>{{ $iteminformation->useYn }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection