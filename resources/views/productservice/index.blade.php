@extends('layouts.admin')
@push('script-page')
@endpush
@section('page-title')
    {{__('Manage Item Information')}}
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0 ">{{__('Item Information')}}</h5>
    </div>Support
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Manage Item Information')}}</li>
@endsection

@section('action-btn')
    <div class="float-end">
        <a href="#" data-size="md" data-bs-toggle="tooltip" title="{{ __('Import') }}" data-url="{{ route('productservice.file.import') }}" data-ajax-popup="true" data-title="{{ __('Import product CSV file') }}" class="btn btn-sm btn-primary">
            <i class="ti ti-file-import"></i>
        </a>
        <a href="{{ route('productservice.export') }}" data-bs-toggle="tooltip" title="{{ __('Export') }}"
            class="btn btn-sm btn-primary">
            <i class="ti ti-file-export"></i>
        </a>
        <a href="{{ route('productservice.create') }}" data-bs-toggle="tooltip" title="{{ __('Create New Product') }}" class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>

        <!-- Button to trigger the getItemInformationApi and Synchronize it to my Database() method -->
        <button class="btn btn-sm btn-primary sync">
            <i class="#">Synchronize</i>
        </button>
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
                        <th scope="col">{{__('SrNo')}}</th>
                        <th scope="col">{{__('Code')}}</th>
                        <th scope="col">{{__('Classification Code')}}</th>
                        <th scope="col">{{__('Type Code')}}</th>
                        <th scope="col">{{__('Name')}}</th>
                        <th scope="col">{{__('Price')}}</th>
                        <th scope="col" >{{__('Action')}}</th>
                        </tr>
                        </thead>
                        <tbody class="list">
                        @foreach ($iteminformations as $iteminformation)
                            <tr>
                                <td>{{ $iteminformation->id }}</td>
                                <td>{{ $iteminformation->itemCd }}</td>
                                <td>{{ $iteminformation->itemClsCd }}</td>
                                <td></td>
                                <td>{{ $iteminformation->itemNm }}</td>
                                <td>{{ $iteminformation->dftPrc }}</td>
                                <td>
                                    <div class="action-btn bg-warning ms-2">
                                        <a href="{{ route('productservice.show',$iteminformation->id) }}" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="tooltip" title="{{__('Details')}}"><i class="ti ti-eye text-white"></i></a>
                                    </div>
                                    <div class="action-btn bg-info ms-2">
                                        <a href="#" class="mx-3 btn btn-sm  align-items-center" data-url="{{ route('productservice.edit',$iteminformation->id) }}" data-ajax-popup="true"  data-size="lg " data-bs-toggle="tooltip" title="{{__('Edit')}}"  data-title="{{__('Edit Item Info')}}">
                                            <i class="ti ti-pencil text-white"></i>
                                        </a>
                                    </div>                                 
                                </td>
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
        const sync = document.querySelector('.sync');
        sync.addEventListener('click', async function(){
            try {
                const loader = document.createElement('div');
                loader.classList.add('spinner-border', 'text-light', 'spinner-border-sm');
                loader.role = 'status';
                sync.appendChild(loader);
                const response = await fetch('http://localhost:8000/productservice/synchronize', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });
            const data = await response.json();
            console.log(data);

            sync.removeChild(loader);
            
            console.log('success');
            const popup = document.createElement('div');
            popup.classList.add('alert', 'alert-success');
            popup.innerHTML = data.info || data.success || 'Synced Successfully';
            popup.style.position = 'absolute';
            popup.style.top = '50%';
            popup.style.left = '50%';
            popup.style.transform = 'translate(-50%, -50%)';
            popup.style.zIndex = '9999';
            document.body.appendChild(popup);
            setTimeout(() => {
                location.reload();
            }, 3000);
            } catch (error) {
                console.log('error');
                const popup = document.createElement('div');
                popup.classList.add('alert', 'alert-danger');
                popup.innerHTML = data.error || 'Sync Failed';
                popup.style.position = 'absolute';
                popup.style.top = '50%';
                popup.style.left = '50%';
                popup.style.transform = 'translate(-50%, -50%)';
                popup.style.zIndex = '9999';
                document.body.appendChild(popup);
                setTimeout(() => {
                    location.reload();
                }, 3000);
            }
        });
    </script>
@endpush
