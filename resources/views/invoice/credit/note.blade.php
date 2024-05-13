{{ Form::open(array('url' => 'creditNote','enctype'=>"multipart/form-data")) }}
    <div class="modal-body">
        <div class="row">
            <div class="form-group col-md-12">
                {{ Form::label('taxpayeridno', __('Tin'),['class'=>'form-label']) }}
                {{ Form::text('taxpayeridno', '', array('class' => 'form-control ','required'=>'required')) }}
            </div>
            <div class="form-group col-md-12">
                {{ Form::label('bhfId', __('BHF ID'),['class'=>'form-label']) }}
                {{ Form::text('bhfId', '', array('class' => 'form-control ','required'=>'required')) }}
            </div>
            <div class="form-group col-md-12">
                {{ Form::label('devicesrlno', __('Device Serial Number'),['class'=>'form-label']) }}
                {{ Form::text('devicesrlno', '', array('class' => 'form-control ','required'=>'required')) }}
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
        <input type="submit" value="{{__('Send')}}" class="btn btn-primary">
    </div>
{{ Form::close() }}