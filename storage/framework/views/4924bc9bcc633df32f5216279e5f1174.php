
<?php echo e(Form::model($iteminformation, array('route' => array('productservice.update', $iteminformation), 'method' => 'PUT'))); ?>

<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('tin', __('TIN (*)'),['class'=>'form-label'])); ?>

                <?php echo e(Form::text('tin', null, array('class' => 'form-control','placeholder'=>__('Enter TIN'),'required'=>'required'))); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('itemCd', __('Item Code (*)'),['class'=>'form-label'])); ?>

                <?php echo e(Form::text('itemCd', null, array('class' => 'form-control','placeholder'=>__('Enter Item Code'),'required'=>'required'))); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('itemNm', __('Item Name (*)'),['class'=>'form-label'])); ?>

                <?php echo e(Form::text('itemNm', null, array('class' => 'form-control','placeholder'=>__('Enter Item Name'),'required'=>'required'))); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('itemStdNm', __('Item Standard Name'),['class'=>'form-label'])); ?>

                <?php echo e(Form::text('itemStdNm', null, array('class' => 'form-control','placeholder'=>__('Enter Item Standard Name')))); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('itemClsCd', __('Item Classification Code (*)'),['class'=>'form-label'])); ?>

                <?php echo e(Form::select('itemClsCd', $itemclassifications, null, array('class' => 'form-control select2','placeholder'=>__('Select Item Classification'),'required'=>'required'))); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('itemTyCd', __('Item Type Code (*)'),['class'=>'form-label'])); ?>

                <?php echo e(Form::select('itemTyCd', $itemtypes, null, array('class' => 'form-control select2','placeholder'=>__('Select Item Type Code'),'required'=>'required'))); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('orgnNatCd', __('Origin Place Code (*)'),['class'=>'form-label'])); ?>

                <?php echo e(Form::select('orgnNatCd', $countrynames, null, array('class' => 'form-control select2','placeholder'=>__('Select Origin Place Code'),'required'=>'required'))); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('pkgUnitCd', __('Item Packaging Code (*)'),['class'=>'form-label'])); ?>

                <?php echo e(Form::text('pkgUnitCd', null, array('class' => 'form-control','placeholder'=>__('Enter Item Packaging Code'), 'required'=>'required'))); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('qtyUnitCd', __('Quantity Unit Code (*)'),['class'=>'form-label'])); ?>

                <?php echo e(Form::text('qtyUnitCd', null, array('class' => 'form-control','placeholder'=>__('Enter Quantity Unit Code'), 'required'=>'required'))); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('taxTyCd', __('Taxation Type Code (*)'),['class'=>'form-label'])); ?>

                <?php echo e(Form::select('taxTyCd', $taxationtype, null, array('class' => 'form-control select2','placeholder'=>__('Select Taxation Type Code'),'required'=>'required'))); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('btchNo', __('Item Batch No'),['class'=>'form-label'])); ?>

                <?php echo e(Form::text('btchNo', null, array('class' => 'form-control','placeholder'=>__('Enter Item Batch No')))); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('bcd', __('Item BarCode'),['class'=>'form-label'])); ?>

                <?php echo e(Form::text('bcd', null, array('class' => 'form-control','placeholder'=>__('Enter Item BarCode')))); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('dftPrc', __('Default Unit Price (*)'),['class'=>'form-label'])); ?>

                <?php echo e(Form::text('dftPrc', null, array('class' => 'form-control','placeholder'=>__('Enter Default Unit Price'), 'required'=>'required'))); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('grpPrcL1', __('Group 1 Unit Price'),['class'=>'form-label'])); ?>

                <?php echo e(Form::text('grpPrcL1', null, array('class' => 'form-control','placeholder'=>__('Enter Group 1 Unit Price')))); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('grpPrcL2', __('Group 2 Unit Price'),['class'=>'form-label'])); ?>

                <?php echo e(Form::text('grpPrcL2', null, array('class' => 'form-control','placeholder'=>__('Enter Group 2 Unit Price')))); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('grpPrcL3', __('Group 3 Unit Price'),['class'=>'form-label'])); ?>

                <?php echo e(Form::text('grpPrcL3', null, array('class' => 'form-control','placeholder'=>__('Enter Group 3 Unit Price')))); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('grpPrcL4', __('Group 4 Unit Price'),['class'=>'form-label'])); ?>

                <?php echo e(Form::text('grpPrcL4', null, array('class' => 'form-control','placeholder'=>__('Enter Group 4 Unit Price')))); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('grpPrcL5', __('Group 5 Unit Price'),['class'=>'form-label'])); ?>

                <?php echo e(Form::text('grpPrcL5', null, array('class' => 'form-control','placeholder'=>__('Enter Group 5 Unit Price')))); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('saftyQuantity', __('Safty Quantity'),['class'=>'form-label'])); ?>

                <?php echo e(Form::number('saftyQuantity', $iteminformation->sftyQty, array('class' => 'form-control','placeholder'=>__('Enter Safty Quantity')))); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('packageQuantity', __('Package Quantity'),['class'=>'form-label'])); ?>

                <?php echo e(Form::number('packageQuantity', null, array('class' => 'form-control'))); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('addInfo', __('Additional Information'),['class'=>'form-label'])); ?>

                <?php echo e(Form::text('addInfo', $iteminformation->addInfo, array('class' => 'form-control','placeholder'=>__('Additional Information')))); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('isrcAplcbYn', __('Insurance Appicable (Y/N) (*)'),['class'=>'form-label'])); ?>

                <?php echo e(Form::select('isrcAplcbYn', [true => 'Y', false => 'N'], $iteminformation->isrcAplcbYn, ['class' => 'form-control', 'required' => 'required'])); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('useYn', __('Used / UnUsed (Y/N) (*)'),['class'=>'form-label'])); ?>

                <?php echo e(Form::select('useYn', [true => 'Y', false => 'N'], $iteminformation->useYn, ['class' => 'form-control', 'required' => 'required'])); ?>

            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="<?php echo e(__('Update')); ?>" class="btn  btn-primary">
</div>

<?php echo e(Form::close()); ?>



<?php /**PATH C:\Users\Developer\Desktop\apps\erp-go-6.4-using-laravel\resources\views/productservice/edit.blade.php ENDPATH**/ ?>