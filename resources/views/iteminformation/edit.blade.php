
{{ Form::model($iteminformation, array('route' => array('iteminformation.update', $iteminformation->id), 'method' => 'PUT')) }}
<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('itemCd', __('Item Code (*)'),['class'=>'form-label']) }}
                {{ Form::text('itemCd', null, array('class' => 'form-control','placeholder'=>__('Enter Item Code'),'required'=>'required')) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('itemNm', __('Item Name (*)'),['class'=>'form-label']) }}
                {{ Form::text('itemNm', null, array('class' => 'form-control','placeholder'=>__('Enter Item Name'),'required'=>'required')) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('itemStdNm', __('Item Standard Name'),['class'=>'form-label']) }}
                {{ Form::text('itemStdNm', null, array('class' => 'form-control','placeholder'=>__('Enter Item Standard Name'))) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('itemClsCd', __('Item Classification Code (*)'),['class'=>'form-label']) }}
                {{ Form::select('itemClsCd', $itemclassifications, null, array('class' => 'form-control select2','placeholder'=>__('Select Item Classification'),'required'=>'required')) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('itemTyCd', __('Item Type Code (*)'),['class'=>'form-label']) }}
                {{ Form::select('itemTyCd', $itemtypes, null, array('class' => 'form-control select2','placeholder'=>__('Select Item Type Code'),'required'=>'required')) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('orgnNatCd', __('Origin Place Code (*)'),['class'=>'form-label']) }}
                {{ Form::select('orgnNatCd', $countrynames, null, array('class' => 'form-control select2','placeholder'=>__('Select Origin Place Code'),'required'=>'required')) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('pkgUnitCd', __('Item Packaging Code (*)'),['class'=>'form-label']) }}
                {{ Form::text('pkgUnitCd', null, array('class' => 'form-control','placeholder'=>__('Enter Item Packaging Code'), 'required'=>'required')) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('qtyUnitCd', __('Quantity Unit Code (*)'),['class'=>'form-label']) }}
                {{ Form::text('qtyUnitCd', null, array('class' => 'form-control','placeholder'=>__('Enter Quantity Unit Code'), 'required'=>'required')) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('taxTyCd', __('Taxation Type Code (*)'),['class'=>'form-label']) }}
                {{ Form::select('taxTyCd', $taxationtype, null, array('class' => 'form-control select2','placeholder'=>__('Select Taxation Type Code'),'required'=>'required')) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('btchNo', __('Item Batch No'),['class'=>'form-label']) }}
                {{ Form::text('btchNo', null, array('class' => 'form-control','placeholder'=>__('Enter Item Batch No'))) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('bcd', __('Item BarCode'),['class'=>'form-label']) }}
                {{ Form::text('bcd', null, array('class' => 'form-control','placeholder'=>__('Enter Item BarCode'))) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('dftPrc', __('Default Unit Price (*)'),['class'=>'form-label']) }}
                {{ Form::text('dftPrc', null, array('class' => 'form-control','placeholder'=>__('Enter Default Unit Price'), 'required'=>'required')) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('grpPrcL1', __('Group 1 Unit Price'),['class'=>'form-label']) }}
                {{ Form::text('grpPrcL1', null, array('class' => 'form-control','placeholder'=>__('Enter Group 1 Unit Price'))) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('grpPrcL2', __('Group 2 Unit Price'),['class'=>'form-label']) }}
                {{ Form::text('grpPrcL2', null, array('class' => 'form-control','placeholder'=>__('Enter Group 2 Unit Price'))) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('grpPrcL3', __('Group 3 Unit Price'),['class'=>'form-label']) }}
                {{ Form::text('grpPrcL3', null, array('class' => 'form-control','placeholder'=>__('Enter Group 3 Unit Price'))) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('grpPrcL4', __('Group 4 Unit Price'),['class'=>'form-label']) }}
                {{ Form::text('grpPrcL4', null, array('class' => 'form-control','placeholder'=>__('Enter Group 4 Unit Price'))) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('grpPrcL5', __('Group 5 Unit Price'),['class'=>'form-label']) }}
                {{ Form::text('grpPrcL5', null, array('class' => 'form-control','placeholder'=>__('Enter Group 5 Unit Price'))) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('addInfo', __('Additional Information'),['class'=>'form-label']) }}
                {{ Form::text('addInfo', null, array('class' => 'form-control','placeholder'=>__('Additional Information'))) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('isrcAplcbYn', __('Insurance Appicable (Y/N) (*)'),['class'=>'form-label']) }}
                {{ Form::text('isrcAplcbYn', null, array('class' => 'form-control','placeholder'=>__('Insurance Appicable (Y/N)'), 'required'=>'required')) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('useYn', __('Used / UnUsed (Y/N) (*)'),['class'=>'form-label']) }}
                {{ Form::text('useYn', null, array('class' => 'form-control','placeholder'=>__('Used / UnUsed (Y/N)'), 'required'=>'required')) }}
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
</div>

{{Form::close()}}


