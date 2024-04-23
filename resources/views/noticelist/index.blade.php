@extends('layouts.admin')
@section('page-title')
    {{ __('Manage Notices List') }}
@endsection
@push('script-page')
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Notices List') }}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        <!-- Button to trigger the getNoticeListsApi and Synchronize it to my Database() method -->
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
                                    <th>{{ __(' NoticeNo') }}</th>
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('Cont') }}</th>
                                    <th>{{ __('registeredName') }}</th>
                                    <th>{{ __('Url') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($notices as $notice)
                                    <tr class="font-style">
                                        <td>{{$notice->id }}</td>
                                        <td>{{ $notice->noticeNo }}</td>
                                        <td>{{$notice->title }}</td>
                                        <td>{{$notice->cont }}</td>
                                        <td>{{$notice->regrNm }}</td>
                                        <td>{{$notice->dtlUrl }}</td>
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
                const response = await fetch('http://localhost:8000/noticelist/synchronize', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });
            const data = await response.json();
            
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

