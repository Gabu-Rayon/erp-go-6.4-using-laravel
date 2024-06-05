@extends('layouts.admin')
@section('page-title')
    {{ __('Purchase List') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Admin') }}</li>
     <li class="breadcrumb-item">{{ __('Purchases') }}</li>
      <li class="breadcrumb-item">{{ __('List') }}</li>
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
        <!-- Add the form for date search -->
        @can('create purchase')
            <div class="d-inline-block mb-4">
                <!-- {{ Form::open(['url' => 'purchase.searchByDate', 'class' => 'w-100']) }} -->
                {{ Form::open(['route' => 'purchase.searchByDate', 'method' => 'GET', 'class' => 'w-100']) }}
                @csrf
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <div class="form-group">
                    {{ Form::label('SearchByDate', __('Search By Date'), ['class' => 'form-label']) }}
                    {{ Form::date('searchByDate', null, ['class' => 'form-control', 'required' => 'required']) }}
                </div>
                <button type="submit" class="btn btn-primary  sync">{{ __('Search      ') }}</button>
                {{ Form::close() }}
            </div>
            <a href="{{ route('purchase.create', 0) }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                title="{{ __('Add New Purchase') }}">
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
                                    <th> {{ __('ID') }}</th>
                                    <th> {{ __('InvcNo') }}</th>
                                    <th> {{ __('Purchase Date') }}</th>
                                    <th> {{ __('SupplrTin') }}</th>
                                    <th>{{ __('supplrBhfId') }}</th>
                                    <th>{{ __('SupplrName') }}</th>
                                     <th>{{ __('SupplrInvcNo') }}</th>
                                    @if (Gate::check('edit purchase') || Gate::check('delete purchase') || Gate::check('show purchase'))
                                        <th> {{ __('Action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            @if (isset($filteredPurchases))
                            <tbody>
                                @foreach ($mappedPurchases as $purchase)
                                    <tr>
                                        <td>{{ $purchase->mappedPurchaseId }}</td>
                                        <td>{{ $purchase->invcNo }}</td>
                                        <td>{{ $purchase->purchaseDate }}</td>
                                        <td>{{ $purchase->supplrTin }}</td>
                                        <td>{{ $purchase->supplrBhfId }}</td>
                                        <td>{{ $purchase->supplrName }}</td>
                                        <td>{{ $purchase->supplrInvcNo }}</td>
                                        @if (Gate::check('edit purchase') || Gate::check('delete purchase') || Gate::check('show purchase'))
                                            <td class="Action">
                                                <span>
                                                    @can('show purchase')
                                                        <div class="action-btn bg-info ms-2">
                                                            <a href="{{ route('mappedPurchases.details', ['mappedPurchaseId' => $purchase->mappedPurchaseId]) }}"
                                                                class="mx-3 btn btn-sm align-items-center"
                                                                data-bs-toggle="tooltip"
                                                                title="{{ __('View Map purchase Item Details') }}"
                                                                data-original-title="{{ __('View Map purchase Item Details') }}">
                                                                <i class="ti ti-eye text-white"></i></a>
                                                        </div>
                                                    @endcan
                                                </span>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                            @else if (isset($filteredPurchases))
                            <tbody>
                                @foreach ($filteredPurchases as $purchase)
                                     <tr>
                                        <td>{{ $purchase->mappedPurchaseId }}</td>
                                        <td>{{ $purchase->invcNo }}</td>
                                        <td>{{ $purchase->orgInvcNo }}</td>
                                        <td>{{ $purchase->supplrTin }}</td>
                                        <td>{{ $purchase->supplrBhfId }}</td>
                                        <td>{{ $purchase->supplrName }}</td>
                                        <td>{{ $purchase->supplrInvcNo }}</td>
                                        @if (Gate::check('edit purchase') || Gate::check('delete purchase') || Gate::check('show purchase'))
                                            <td class="Action">
                                                <span>
                                                    @can('show purchase')
                                                        <div class="action-btn bg-info ms-2">
                                                            <a href="{{ route('mappedPurchases.details', ['mappedPurchaseId' => $purchase->mappedPurchaseId]) }}"
                                                                class="mx-3 btn btn-sm align-items-center"
                                                                data-bs-toggle="tooltip"
                                                                title="{{ __('View Map purchase Item Details') }}"
                                                                data-original-title="{{ __('View Map purchase Item Details') }}">
                                                                <i class="ti ti-eye text-white"></i></a>
                                                        </div>
                                                    @endcan
                                                </span>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>   

@endsection

@push('script-page')
<script>
  const sync = document.querySelector('.sync');

  sync.addEventListener('click', async function(event) {
    event.preventDefault();

    const searchByDate = document.querySelector('input[name="searchByDate"]').value;

    if (!searchByDate) {
      alert('{{ __('Please enter a date to search by') }}');
      return;
    }

    try {
      showLoadingSpinner(sync);

      const response = await fetch(`{{ route('purchase.searchByDate') }}?searchByDate=${searchByDate}`, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        }
      });

      if (!response.ok) {
        throw new Error('{{ __('An error occurred while syncing the data') }}');
      }

      const data = await response.json();

      if (data.newData.length > 0) {
        showSuccessPopup(`{{ __('New mapPurchases added to database') }} <br> {{ __('New data count') }}: ${data.newData.length}`);
        setTimeout(location.reload, 3000);
      } else {
        showInfoPopup('{{ __('Database is up to date. No new mapped purchase data added.') }}');
      }
    } catch (error) {
      showErrorPopup(error.message);
    } finally {
      removeLoadingSpinner(sync);
    }
  });

  function showLoadingSpinner(element) {
    const loader = document.createElement('div');
    loader.classList.add('spinner-border', 'text-light', 'spinner-border-sm');
    loader.role = 'status';
    element.appendChild(loader);
  }

  function removeLoadingSpinner(element) {
    element.removeChild(element.querySelector('.spinner-border'));
  }

  function showSuccessPopup(message) {
    const popup = createPopup('alert-success', message);
    document.body.appendChild(popup);
    setTimeout(() => document.body.removeChild(popup), 3000);
  }

  function showInfoPopup(message) {
    const popup = createPopup('alert-info', message);
    document.body.appendChild(popup);
    setTimeout(() => document.body.removeChild(popup), 3000);
  }

  function showErrorPopup(message) {
    const popup = createPopup('alert-danger', message);
    document.body.appendChild(popup);
    setTimeout(() => document.body.removeChild(popup), 3000);
  }
  function createPopup(type, message) {
    const popup = document.createElement('div');
    popup.classList.add('alert', type);
    popup.innerHTML = message;
    popup.style.position = 'absolute';
    popup.style.top = '50%';
    popup.style.left = '50%';
    popup.style.transform = 'translate(-50%, -50%)';
    popup.style.zIndex = '9999';
    return popup;
  }
</script>
@endpush
