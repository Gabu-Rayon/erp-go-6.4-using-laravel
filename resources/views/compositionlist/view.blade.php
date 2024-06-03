@extends('layouts.admin')

@section('page-title')
    {{ __('Composition List Details') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('compositionlist.index') }}">{{ __('Composition List') }}</a></li>
    <li class="breadcrumb-item">{{ __('Composition List Details') }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>{{ __('Main Item: ') }} {{ \App\Models\ProductService::where('itemCd', $compositionList->mainItemCode)->first()->itemNm }}</h5>
            </div>
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table datatable">
                        <thead>
                        <tr>
                            <th scope="col">{{ __('CompItem Code') }}</th>
                            <th scope="col">{{ __('CompItem Name') }}</th>
                            <th scope="col">{{ __('CompItem Quantity') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($compositionItems as $item)
                            <tr>
                                <td>{{ $item->compoItemCode }}</td>
                              <td>{{ optional(\App\Models\ProductService::where('itemCd', $item->mainItemCode)->first())->name }}</td>
                                <td>{{ $item->compoItemQty }}</td>
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
