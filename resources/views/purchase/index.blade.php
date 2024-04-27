@extends('layouts.admin')
@section('page-title')
    {{__('Manage Purchase')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Purchase')}}</li>
@endsection
@push('script-page')
    <script>

        $('.copy_link').click(function (e) {
            e.preventDefault();
            var copyText = $(this).attr('href');

            document.addEventListener('copy', function (e) {
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


{{--        <a href="{{ route('bill.export') }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="{{__('Export')}}">--}}
{{--            <i class="ti ti-file-export"></i>--}}
{{--        </a>--}}

        @can('create purchase')
            <a href="{{ route('purchase.create',0) }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="{{__('Create')}}">
                <i class="ti ti-plus"></i>
            </a>
        @endcan
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
                                <th> {{__('itemSeq')}}</th>
                                <th> {{__('itemCd')}}</th>
                                <th> {{__('itemClsCd')}}</th>
                                <th> {{__('itemNm')}}</th>
                                <th>{{__('pkgUnitCd')}}</th>
                                <th>{{__('qtyUnitCd')}}</th>
                                <th>{{__('totAmt')}}</th>
                                @if(Gate::check('edit purchase') || Gate::check('delete purchase') || Gate::check('show purchase'))
                                    <th > {{__('Action')}}</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($purchases as $purchase)
                                <tr>
                                    <td>{{ $purchase->itemSeq }}</td>
                                    <td>{{ $purchase->itemCd }}</td>
                                    <td>{{ $purchase->itemClsCd }}</td>
                                    <td>{{ $purchase->itemNm }}</td>
                                    <td>{{ $purchase->pkgUnitCd }}</td>
                                    <td>{{ $purchase->qtyUnitCd }}</td>
                                    <td>{{ $purchase->totAmt }}</td>
                                    <td class="d-flex" style="gap: 1rem;">
                                        @can('show purchase')
                                            <a href="{{ route('purchase.show', $purchase->id) }}" class="edit-icon btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('Show')}}">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @endcan
                                        @can('edit purchase')
                                            <a href="{{ route('purchase.edit',$purchase->id) }}" class="edit-icon btn btn-sm btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('Edit')}}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                        @endcan
                                        @can('delete purchase')
                                            <a href="#" class="delete-icon btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('Delete')}}" onclick="deleteData('{{ $purchase->id }}')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        @endcan
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

