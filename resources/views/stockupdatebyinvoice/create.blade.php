{{ Form::open(array('url' => 'stockinfo','enctype'=>"multipart/form-data")) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-12">
            {{ Form::label('invoiceNo', __('Invoice Number'),['class'=>'form-label']) }}
            {{ Form::text('invoiceNo', '', array('class' => 'form-control ','required'=>'required')) }}
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
