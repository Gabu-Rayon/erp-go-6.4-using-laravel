{{ Form::open(array('url' => 'mappimporteditems','enctype'=>"multipart/form-data")) }}
    <div class="modal-body">
        <div class="row">
            <div class="form-group col-md-6">
                {{ Form::label('importedItemName', __('Imported Item Name'),['class'=>'form-label']) }}
                {{ Form::select('importedItemName', $importedItems, null, ['class' => 'form-control item-name']) }}
            </div>
            <div class="form-group col-md-6">
                {{ Form::label('item', __('Item Name'),['class'=>'form-label']) }}
                {{ Form::select('item', $items, null, ['class' => 'form-control item-name']) }}
            </div>
            <div class="form-group col-md-6">
                {{ Form::label('importItemStatusCode', __('Import Item Status Code'),['class'=>'form-label']) }}
                {{ Form::select('importItemStatusCode', $importItemStatusCode, null, ['class' => 'form-control item-name']) }}
            </div>
            <div class="form-group col-md-6">
                {{ Form::label('remark', __('Remark'),['class'=>'form-label']) }}
                {{ Form::text('remark', '', array('class' => 'form-control ','required'=>'required')) }}
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
        <input type="submit" value="{{__('Send')}}" class="btn btn-primary">
    </div>
{{ Form::close() }}
