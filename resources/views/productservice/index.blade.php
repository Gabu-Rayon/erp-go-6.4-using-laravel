@extends('layouts.admin')
@section('page-title')
    {{ __('Manage Product & Services') }}
@endsection
@push('script-page')
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Product & Services') }}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        <a href="#" data-size="md" data-bs-toggle="tooltip" title="{{ __('Import') }}"
            data-url="{{ route('productservice.file.import') }}" data-ajax-popup="true"
            data-title="{{ __('Import product CSV file') }}" class="btn btn-sm btn-primary">
            <i class="ti ti-file-import"></i>
        </a>
        <a href="{{ route('productservice.export') }}" data-bs-toggle="tooltip" title="{{ __('Export') }}"
            class="btn btn-sm btn-primary">
            <i class="ti ti-file-export"></i>
        </a>

        <a href="#" data-size="lg" data-url="{{ route('productservice.create') }}" data-ajax-popup="true"
            data-bs-toggle="tooltip" title="{{ __('Create New Product') }}" class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>

        <!-- Button to trigger the getItemInformationApi and Synchronize it to my Database() method -->
        <a href="#" id="synchronizeBtn" data-size="lg"
            data-url="{{ route('productservice.synchronize') }}" data-ajax-popup="true" data-bs-toggle="tooltip"
            title="{{ __('Synchronize') }}" class="btn btn-sm btn-primary">
            <i class="#">Synchronize</i>
        </a>
    </div>
@endsection

@section('content')
       <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('SrNo') }}</th>
                                    <th>{{ __('Code') }}</th>
                                    <th>{{ __('Classification Code') }}</th>
                                    <th>{{ __('Type Code') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Stock Qty') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($itemlists as $item)
                                    <tr class="font-style">
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->itemCd }}</td>
                                            <td>{{ $item->itemClsCd }}</td>
                                        <td>{{ $item->itemTyCd }}</td>
                                            <td>{{ $item->itemNm }}</td>
                                        <td>{{ $item->sftQty}}</td>
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
@push('script-page')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('synchronizeBtn').addEventListener('click', function() {
            // Show loading spinner
            showLoadingSpinner();
        });

        function showLoadingSpinner() {
            // Create a loading spinner element
            var spinner = document.createElement('div');
            spinner.classList.add('spinner-border', 'text-light');
            spinner.setAttribute('role', 'status');

            // Create a container for the spinner
            var spinnerContainer = document.createElement('div');
            spinnerContainer.classList.add('loading-spinner-container');
            spinnerContainer.appendChild(spinner);

            // Append the spinner container to the body
            document.body.appendChild(spinnerContainer);
        }
    });
</script>
@endpush
