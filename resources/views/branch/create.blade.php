{{Form::open(array('url'=>'branch','method'=>'post'))}}
    <div class="modal-body">
        <div class="row">
            <div class="form-group col-6">
                {{Form::label('bhfNm',__('Branch Name'),['class'=>'form-label'])}}
                {{Form::text('bhfNm',null,array('class'=>'form-control','placeholder'=>__('Enter Branch Name')))}}
            </div>
            <div class="form-group col-6">
                {{Form::label('bhfId',__('Branch ID'),['class'=>'form-label'])}}
                {{Form::text('bhfId',null,array('class'=>'form-control','placeholder'=>__('Enter Branch ID')))}}
            </div>
            <div class="form-group col-6">
                {{Form::label('tin',__('Branch TIN'),['class'=>'form-label'])}}
                {{Form::text('tin',null,array('class'=>'form-control','placeholder'=>__('Enter Branch TIN')))}}
            </div>
            <div class="form-group col-6">
                {{ Form::label('bhfSttsCd', __('Branch Status'), ['class' => 'form-label']) }}
                {{ Form::select('bhfSttsCd', ['01' => 'Active', '00' => 'Inactive'], null, ['class' => 'form-control']) }}
            </div>
            <div class="form-group col-6">
                {{ Form::label('prvncNm', __('Province Name'), ['class' => 'form-label']) }}
                {{ Form::text('prvncNm', '', ['class' => 'form-control']) }}
            </div>
            <div class="form-group col-6">
                {{ Form::label('dstrtNm', __('District Name'), ['class' => 'form-label']) }}
                {{ Form::text('dstrtNm', '', ['class' => 'form-control']) }}
            </div>
            <div class="form-group col-6">
                {{ Form::label('sctrNm', __('SCTR Name'), ['class' => 'form-label']) }}
                {{ Form::text('sctrNm', '', ['class' => 'form-control']) }}
            </div>
            <div class="form-group col-6">
                {{ Form::label('locDesc', __('LOC DESC'), ['class' => 'form-label']) }}
                {{ Form::text('locDesc', '', ['class' => 'form-control']) }}
            </div>
            <div class="form-group col-6">
                {{ Form::label('mgrNm', __('Manager Name'), ['class' => 'form-label']) }}
                {{ Form::text('mgrNm', '', ['class' => 'form-control']) }}
            </div>
            <div class="form-group col-6">
                {{ Form::label('mgrTelNo', __('Manager Contact'), ['class' => 'form-label']) }}
                {{ Form::text('mgrTelNo', '', ['class' => 'form-control']) }}
            </div>
            <div class="form-group col-6">
                {{ Form::label('mgrEmail', __('Manager Email'), ['class' => 'form-label']) }}
                {{ Form::text('mgrEmail', '', ['class' => 'form-control']) }}
            </div>
            <div class="form-group col-6">
                {{ Form::label('hqYn', __('HeadQuarter?'), ['class' => 'form-label']) }}
                {{ Form::select('hqYn', ['Y' => 'Yes', 'N' => 'No'], null, ['class' => 'form-control']) }}
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
        <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
    </div>
{{Form::close()}}