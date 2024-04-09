{{Form::open(array('url'=>'branch','method'=>'post'))}}
<div class="modal-body">

    <div class="row">
        <div class="col-12">
           <!--  <div class="form-group">
                {{Form::label('branch_user_id',__('Branch User Id'),['class'=>'form-label'])}}
                {{Form::text('branch_user_id',null,array('class'=>'form-control','placeholder'=>__('345600')))}}
                @error('branch_user_id')
                <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
                @enderror
            </div> -->
            <div class="form-group">
                {{Form::label('branch_user_name',__('Branch User Name'),['class'=>'form-label'])}}
                {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter Branch User Name')))}}
                @error('branch_user_name')
                <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                {{Form::label('password',__('Password'),['class'=>'form-label'])}}
                {{Form::password('password',array('class'=>'form-control','placeholder'=>__('Enter User Password'),'required'=>'required','minlength'=>"6"))}}
                @error('password')
                <small class="invalid-password" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </small>
                @enderror
            </div>

            <div class="form-group">
                {{Form::label('address',__('Address'),['class'=>'form-label'])}}
                {{Form::text('address',null,array('class'=>'form-control','placeholder'=>__('MAIN ST 23')))}}
                @error('address')
                <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                {{Form::label('contact_no',__('Contact No'),['class'=>'form-label'])}}
                {{Form::text('contact',null,array('class'=>'form-control','placeholder'=>__('0720045000')))}}
                @error('contact_no')
                <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                {{Form::label('remark',__('Remarks'),['class'=>'form-label'])}}
                {{Form::text('remark',null,array('class'=>'form-control','placeholder'=>__('Enter Remarks')))}}
                @error('contact_no')
                <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>  
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>
    {{Form::close()}}

