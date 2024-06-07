@extends('layouts.admin')
@section('page-title')
    {{ __('Get Customer By Pin') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Search Customer') }}</li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Add') }}</li>
@endsection

@section('content')
 
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                      <table class="table datatable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th> {{__(' SrNo')}}</th>
                                <th> {{__('Tin')}}</th>
                                <th> {{__('TaxprNm')}}</th>
                                <th>{{__('TaxprSttsCd')}}</th>
                                  <th>{{__('PrvncNm')}}</th>
                                    <th>{{__('DstrtNm')}}</th>
                            </tr>
                            </thead>
                            <tbody>                                
                             @foreach ($customers as $customer)
                                    <tr class="font-style">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
<td></td>

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
