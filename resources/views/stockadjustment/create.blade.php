{{ Form::open(array('url' => 'stockadjustment','enctype'=>"multipart/form-data")) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-12">
            {{ Form::label('item', __('Select Item'),['class'=>'form-label']) }}
            {{ Form::select('item', $items, null, ['class' => 'form-control', 'required' => 'required']) }}
        </div>
        <div class="form-group col-md-12">
            {{ Form::label('qty', __('Quantity'),['class'=>'form-label']) }}
            {{ Form::text('qty', '', array('class' => 'form-control ','required'=>'required')) }}
        </div>
        <div class="form-group col-md-12">
            {{ Form::label('releaseType', __('Stored / Release Type'),['class'=>'form-label']) }}
            {{ Form::select('releaseType', $releaseTypes, null, ['class' => 'form-control', 'required' => 'required']) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Send')}}" class="btn btn-primary">
</div>
    {{ Form::close() }}




<script>
    // document.getElementById('attachment').onchange = function () {
    //     var src = URL.createObjectURL(this.files[0])
    //     document.getElementById('image').src = src
    // }
</script>
