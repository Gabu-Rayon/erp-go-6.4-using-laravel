{{ Form::model($branchUser, ['route' => ['branchuser.update', $branchUser->id], 'method' => 'PUT']) }}
<div class="modal-body">

    <div class="row">
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('branchUserName', __('Name'), ['class' => 'form-label']) }}
                {{ Form::text('branchUserName', $branchUser->branchUserName, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('branchUserId', __('User ID'), ['class' => 'form-label']) }}
                {{ Form::text('branchUserId', $branchUser->branchUserId, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('address', __('User Address'), ['class' => 'form-label']) }}
                {{ Form::text('address', $branchUser->address, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('contactNo', __('Contact No'), ['class' => 'form-label']) }}
                {{ Form::text('contactNo', $branchUser->contactNo, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('authenticationCode', __('Authentication Code'), ['class' => 'form-label']) }}
                {{ Form::text('authenticationCode', $branchUser->authenticationCode, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('isUsed', __('Is Used?'), ['class' => 'form-label']) }}
                {{ Form::select('isUsed', ['1' => 'Yes', '0' => 'No'], $branchUser->isUsed == '1' ? '1' : '0', ['class' => 'form-control']) }}
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Update') }}" class="btn  btn-primary">
</div>

{{ Form::close() }}
