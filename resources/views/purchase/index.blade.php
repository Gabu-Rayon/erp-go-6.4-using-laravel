@extends('layouts.admin')
@section('page-title')
    {{ __('Purchase Transaction Information') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Admin') }}</li>
    <li class="breadcrumb-item">{{ __('Purchase Transaction Information') }}</li>
    <li class="breadcrumb-item">{{ __('Add') }}</li>
@endsection
@push('script-page')
    <script>
        $('.copy_link').click(function(e) {
            e.preventDefault();
            var copyText = $(this).attr('href');

            document.addEventListener('copy', function(e) {
                e.clipboardData.setData('text/plain', copyText);
                e.preventDefault();
            }, true);

            document.execCommand('copy');
            show_toastr('success', 'Url copied to clipboard', 'success');
        });
    </script>
@endpush
@section('action-btn')
    <div class="float-end">
            <div class="d-inline-block mb-4">
                {{ Form::open(['route' => 'purchase.synchronize', 'method' => 'POST', 'class' => 'w-100']) }}
                @csrf
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <div class="form-group">
                    {{ Form::label('getpurchaseByDate', __('Search By Date'), ['class' => 'form-label']) }}
                    {{ Form::date('getpurchaseByDate', null, ['class' => 'form-control', 'required' => 'required']) }}
                </div>
                <button type="submit" class="btn btn-primary  sync">{{ __('Search') }}</button>
                {{ Form::close() }}
            </div>
            <a href="{{ route('purchase.create', 0) }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                title="{{ __('Add New Purchase') }}">
                <i class="ti ti-plus"></i>
            </a>
    </div>
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
                                    <th> {{ __('SrNo') }}</th>
                                    <th> {{ __('SpplrTin') }}</th>
                                    <th> {{ __('TotItemCnt') }}</th>
                                    <th>{{ __('CfmDt') }}</th>
                                    <th>{{ __('Is Mapped') }}</th>
                                    <th>{{__('Status')}}</th> 
                                    <th> {{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($purchases as $purchase)
                                    <tr>
                                        <td>{{ $purchase->id }}</td>
                                        <td>{{ $purchase->spplrTin }}</td>
                                        <td>{{ $purchase->totItemCnt }}</td>
                                        <td>{{ $purchase->cfmDt }}</td>
                                        <td>
                                            @if ($purchase->isDBImport == 0)
                                                <!-- Show Pending -->
                                                <span
                                                    class="purchase_status badge bg-secondary p-2 px-3 rounded">pending</span>
                                            @else($purchase->status == 1)
                                                <!-- Show Success -->
                                                <span
                                                    class="purchase_status badge bg-warning p-2 px-3 rounded">Success</span>
                                            @endif
                                        </td>
                                        <td>
                                        @if($purchase->status == 0)
                                            <span class="purchase_status badge bg-secondary p-2 px-3 rounded">Draft</span>
                                        @elseif($purchase->status == 1)
                                            <span class="purchase_status badge bg-warning p-2 px-3 rounded">Sent</span>
                                        @elseif($purchase->status == 2)
                                            <span class="purchase_status badge bg-danger p-2 px-3 rounded">UnPaid</span>
                                        @elseif($purchase->status == 3)
                                            <span class="purchase_status badge bg-info p-2 px-3 rounded">Partialy Paid</span>
                                        @elseif($purchase->status == 4)
                                            <span class="purchase_status badge bg-primary p-2 px-3 rounded">Paid</span>
                                        @endif
                                    </td>
                                        <td class="Action">
                                            <span>
                                                    <div class="action-btn bg-info ms-2">
                                                            <a href="{{ route('purchase.show',\Crypt::encrypt($purchase->id)) }}" class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip" title="{{__('Show')}}" data-original-title="{{__('Detail')}}">
                                                                <i class="ti ti-eye text-white"></i>
                                                            </a>
                                                        </div>
                                                        <div class="action-btn bg-info ms-2">
                                                            <a href="{{ route('purchase.details', ['spplrInvcNo' => $purchase->spplrInvcNo]) }}"
                                                                class="mx-3 btn btn-sm align-items-center"
                                                                data-bs-toggle="tooltip"
                                                                title="{{ __('Map Purchase') }}"
                                                                data-original-title="{{ __('Detail') }}">
                                                                <i class="ti ti-list text-white"></i></a>
                                                        </div>
                                                <!-- @can('edit purchase')
                                                    <div class="action-btn bg-primary ms-2">
                                                        <a href="{{ route('purchase.edit',\Crypt::encrypt($purchase->id)) }}" class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip" title="Edit" data-original-title="{{__('Edit')}}">
                                                            <i class="ti ti-pencil text-white"></i>
                                                        </a>
                                                    </div>
                                                @endcan -->
                                                    <div class="action-btn bg-danger ms-2">
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['purchase.destroy', $purchase->id],'class'=>'delete-form-btn','id'=>'delete-form-'.$purchase->id]) !!}
                                                        <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$purchase->id}}').submit();">
                                                            <i class="ti ti-trash text-white"></i>
                                                        </a>
                                                        {!! Form::close() !!}
                                                    </div>
                                            </span>
                                        </td>
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