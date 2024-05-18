@extends('layouts.admin')
@push('script-page')
@endpush
@section('page-title')
    {{__('Manage Code List')}}
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0 ">{{__('Code List')}}</h5>
    </div>Support
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Manage Code List')}}</li>
@endsection

@section('action-btn')
<div class="float-end">
    <a href="{{ route('productservice.synccodelist') }}" class="btn btn-sm btn-primary flex justify-center items-center text-center gap-2">
        Synchronize
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
                            <th scope="col">{{__('SrNo')}}</th>
                            <th scope="col">{{__('CDCls')}}</th>
                            <th scope="col">{{__('CDClsNm')}}</th>
                            <th scope="col">{{__('Use')}}</th>
                            <th scope="col">{{__('UserDfnNm1')}}</th>
                            <th scope="col">{{__('LastRequestDate')}}</th>
                        </tr>
                        </thead>
                        <tbody class="list">
                            @foreach($codelists as $codelist)
                                <tr>
                                    <td>{{$codelist->id}}</td>
                                    <td>{{$codelist->cdCls}}</td>
                                    <td>{{$codelist->cdClsNm}}</td>
                                    <td>{{$codelist->useYn}}</td>
                                    <td>{{$codelist->userDfnNm1}}</td>
                                    <td>{{$codelist->created_at}}</td>
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
                const response = await fetch('http://localhost:8000/productservice/synccodelist', {
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