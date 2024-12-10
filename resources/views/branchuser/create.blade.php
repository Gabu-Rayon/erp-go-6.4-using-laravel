{{ Form::open(['url' => 'branchuser', 'method' => 'post']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-6">
            {{ Form::label('branchUserName', __('Branch User Name'), ['class' => 'form-label']) }}
            {{ Form::text('branchUserName', null, ['class' => 'form-control', 'placeholder' => __('Enter Branch User Name')]) }}
            @error('branch_user_name')
                <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group col-6">
            {{ Form::label('password', __('Password'), ['class' => 'form-label']) }}
            {{ Form::password('password', ['class' => 'form-control', 'placeholder' => __('Enter User Password'), 'required' => 'required', 'minlength' => '6']) }}
            @error('password')
                <small class="invalid-password" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </small>
            @enderror
        </div>

        <div class="form-group col-6">
            {{ Form::label('address', __('Address'), ['class' => 'form-label']) }}
            {{ Form::text('address', null, ['class' => 'form-control', 'placeholder' => __('MAIN ST 23')]) }}
            @error('address')
                <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- make this select of branches    we use name and id  --}}
        <div class="form-group col-6">
            {{ Form::label('branch_id', __('Branch'), ['class' => 'form-label']) }}
            {{ Form::select('branch_id', $branches, null, ['class' => 'form-control', 'placeholder' => __('Select a branch')]) }}
            @error('branch_id')
                <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
            @enderror
        </div>




        <div class="form-group col-6">
            {{ Form::label('contactNo', __('Contact No'), ['class' => 'form-label']) }}
            {{ Form::text('contactNo', null, ['class' => 'form-control', 'placeholder' => __('0720045000')]) }}
            @error('contact_no')
                <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group col-12">
            {{ Form::label('remark', __('Remarks'), ['class' => 'form-label']) }}
            {{ Form::textarea('remark', null, ['class' => 'form-control', 'placeholder' => __('Enter Remarks'), 'rows' => 3]) }}

            @error('contact_no')
                <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Create') }}" class="btn  btn-primary">
</div>
{{ Form::close() }}
