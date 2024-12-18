@extends('layouts.admin')
@section('page-title')
    {{ __('Manage Credit Notes') }}
@endsection
@push('script-page')
    <script>
        $(document).on('change', '#invoice', function() {

            var id = $(this).val();
            var url = "{{ route('invoice.get') }}";

            $.ajax({
                url: url,
                type: 'get',
                cache: false,
                data: {
                    'id': id,

                },
                success: function(data) {
                    $('#amount').val(data)
                },

            });

        })
    </script>
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Credit Notes') }}</li>
@endsection

@section('action-btn')
    <div class="float-end">
        <a href="{{ route('invoice.custom.credit.note') }}" data-bs-toggle="tooltip" title="{{ __('Add Direct Credit Note') }}"
            data-title="{{ __('Add Direct Credit Note') }}" class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-border-style mt-2">
                    <h5></h5>
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th> {{ __('Invoice') }}</th>
                                    <th> {{ __('Customer') }}</th>
                                    <th> {{ __('Date') }}</th>
                                    <th> {{ __('Amount') }}</th>
                                    <th> {{ __('Description') }}</th>
                                    <th width="10%"> {{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoices as $invoice)
                                    @if (!empty($invoice->creditNote))
                                        @foreach ($invoice->creditNote as $creditNote)
                                            {{ \Log::info($creditNote) }}
                                            <tr>
                                                <td class="Id">
                                                    <a href="{{ route('invoice.show', \Crypt::encrypt($creditNote->invoice)) }}"
                                                        class="btn btn-outline-primary">{{ AUth::user()->invoiceNumberFormat($invoice->invoice_id) }}</a>
                                                </td>
                                                <td>{{ !empty($invoice->customer) ? $invoice->customer->customerName : '-' }}
                                                </td>
                                                <td>{{ Auth::user()->dateFormat($creditNote->salesDate) }}</td>
                                                <td>{{ Auth::user()->priceFormat($creditNote->amount) }}</td>
                                                <td>{{ !empty($creditNote->remark) ? $creditNote->remark : '-' }}</td>
                                                <td>

                                                    <div class="action-btn bg-info ms-2">
                                                        <a href="{{ route('invoice.show.credit.note', \Crypt::encrypt($creditNote->id)) }}"
                                                            class="mx-3 btn btn-sm align-items-center"
                                                            data-bs-toggle="tooltip" title="Show "
                                                            data-original-title="{{ __('Detail') }}">
                                                            <i class="text-white ti ti-eye"></i>
                                                        </a>
                                                    </div>
                                                    <div class="action-btn bg-primary ms-2">
                                                        <a data-url="{{ route('invoice.edit.credit.note', [$creditNote->invoice, $creditNote->id]) }}"
                                                            data-ajax-popup="true"
                                                            data-title="{{ __('Edit Credit Note') }}" href="#"
                                                            class="mx-3 btn btn-sm align-items-center"
                                                            data-bs-toggle="tooltip" title="{{ __('Edit') }}"
                                                            data-original-title="{{ __('Edit') }}">
                                                            <i class="ti ti-pencil text-white"></i>
                                                        </a>
                                                    </div>
                                                    <div class="action-btn bg-danger ms-2">
                                                        {!! Form::open([
                                                            'method' => 'DELETE',
                                                            'route' => ['invoice.delete.credit.note', $creditNote->invoice, $creditNote->id],
                                                            'class' => 'delete-form-btn',
                                                            'id' => 'delete-form-' . $creditNote->id,
                                                        ]) !!}
                                                        <a href="#"
                                                            class="mx-3 btn btn-sm align-items-center bs-pass-para"
                                                            data-bs-toggle="tooltip" title="{{ __('Delete') }}"
                                                            data-original-title="{{ __('Delete') }}"
                                                            data-confirm="{{ __('Are You Sure?') . '|' . __('This action can not be undone. Do you want to continue?') }}"
                                                            data-confirm-yes="document.getElementById('delete-form-{{ $creditNote->id }}').submit();">
                                                            <i class="ti ti-trash text-white"></i>
                                                        </a>
                                                        {!! Form::close() !!}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
