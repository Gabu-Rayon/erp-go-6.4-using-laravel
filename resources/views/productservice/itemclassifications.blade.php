@extends('layouts.admin')
@section('page-title')
    {{ __('Manage Item Classifications') }}
@endsection
@push('script-page')
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Item Classifications') }}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        <button class="btn btn-sm btn-primary sync">
            <i class="#">Synchronize</i>
        </button>
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
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Level') }}</th>
                                    <th>{{ __('useYn') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($itemclassifications as $classification)
                                    <tr class="font-style">
                                        <td>{{$classification->id }}</td>
                                        <td>{{ $classification->itemClsCd }}</td>
                                        <td>{{$classification->itemClsNm}}</td>
                                        <td>{{$classification->itemClsLvl }}</td>
                                        <td>{{$classification->useYn}}</td>
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

@push('script-page')
<script>
        const sync = document.querySelector('.sync');
        sync.addEventListener('click', async function(){
            try {
                const loader = document.createElement('div');
                loader.classList.add('spinner-border', 'text-light', 'spinner-border-sm');
                loader.role = 'status';
                sync.appendChild(loader);
                const response = await fetch('http://localhost:8000/productservice/synchronizeitemclassifications', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });
            const data = await response.json();

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