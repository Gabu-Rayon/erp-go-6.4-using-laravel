
@extends('layouts.admin')
@section('page-title')
    {{ __('Manage Branch') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Branch') }}</li>
@endsection

@section('action-btn')
    <div class="float-end">
        @can('create branch')
            <a href="#" data-url="{{ route('branch.create') }}" data-ajax-popup="true"
                data-title="{{ __('Create New Branch') }}" data-bs-toggle="tooltip" title="{{ __('Create') }}"
                class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>
        @endcan
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-3">
            @include('layouts.hrm_setup')
        </div>
        <div class="col-9">
            <div class="card">
                <div class="card-body table-border-style">

                    <div class="table-responsive">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th>Tin</th>
                                        <th>Branch ID</th>
                                        <th>Branch Name</th>
                                        <th>Branch Status</th>
                                        <th>Province</th>
                                        <th>District</th>
                                        <th>Sector</th>
                                        <th>Manager Name</th>
                                        <th>Manager Tel. No.</th>
                                        <th>Manager Email</th>
                                        <th>HQ</th>
                                    </tr>
                                </thead>
                                <tbody class="font-style">
                                    @foreach ($branches as $branch)
                                        <tr>
                                            <td>{{ $branch['tin'] }}</td>
                                            <td>{{ $branch['bhfId'] }}</td>
                                            <td>{{ $branch['bhfNm'] }}</td>
                                            <td>
                                                @if ($branch['bhfSttsCd'] === '01')
                                                  Active
                                                @else
                                                    Inactive
                                                @endif
                                            </td>
                                            <td>{{ $branch['prvncNm'] }}</td>
                                            <td>{{ $branch['dstrtNm'] }}</td>
                                            <td>{{ $branch['sctrNm'] }}</td>
                                            <td>{{ $branch['mgrNm'] }}</td>
                                            <td>{{ $branch['mgrTelNo'] }}</td>
                                            <td>{{ $branch['mgrEmail'] }}</td>
                                            <td>{{ $branch['hqYn'] === 'Y' ? 'Yes' : 'No' }}</td>
                                            <td class="Action text-end">
                                                <span>
                                                    @can('edit branch')
                                                        <div class="action-btn bg-primary ms-2">

                                                            <a href="#" class="mx-3 btn btn-sm align-items-center"
                                                                data-url="{{ URL::to('branch/' . $branch['bhfId'] . '/edit') }}"
                                                                data-ajax-popup="true" data-title="{{ __('Edit Branch') }}"
                                                                data-bs-toggle="tooltip" title="{{ __('Edit') }}"
                                                                data-original-title="{{ __('Edit') }}"><i
                                                                    class="ti ti-pencil text-white"></i></a>
                                                        </div>
                                                    @endcan
                                                    @can('delete branch')
                                                        <div class="action-btn bg-danger ms-2">
                                                            {!! Form::open([
                                                                'method' => 'DELETE',
                                                                'route' => ['branch.destroy',$branch['bhfId']],
                                                                'id' => 'delete-form-' . $branch['bhfId'],
                                                            ]) !!}

                                                            <a href="#"
                                                                class="mx-3 btn btn-sm align-items-center bs-pass-para"
                                                                data-bs-toggle="tooltip" title="{{ __('Delete') }}"
                                                                data-original-title="{{ __('Delete') }}"
                                                                data-confirm="{{ __('Are You Sure?') . '|' . __('This action can not be undone. Do you want to continue?') }}"
                                                                data-confirm-yes="document.getElementById('delete-form-{{ $branch['bhfId'] }}').submit();"><i
                                                                    class="ti ti-trash text-white text-white"></i></a>
                                                            {!! Form::close() !!}
                                                        </div>
                                                    @endcan
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

