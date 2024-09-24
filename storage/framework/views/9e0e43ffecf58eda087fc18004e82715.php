<?php echo e(Form::model($productServiceinformation, ['route' => ['productservice.update', $productServiceinformation], 'method' => 'PUT'])); ?>

<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('itemCode', __('Item Code (*)'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::text('itemCd', null, ['class' => 'form-control', 'placeholder' => __('Enter Item Code'), 'required' => 'required', 'readonly' => 'readonly'])); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('itemName', __('Item Name (*)'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::text('itemNm', null, ['class' => 'form-control', 'placeholder' => __('Enter Item Name'), 'required' => 'required'])); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('itemStrdName', __('Item Standard Name'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::text('itemStdNm', null, ['class' => 'form-control', 'placeholder' => __('Enter Item Standard Name')])); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('itemClassifiCode', __('Item Classification Code (*)'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::select('itemClsCd', $productServiceclassifications, null, ['class' => 'form-control select2', 'placeholder' => __('Select Item Classification'), 'required' => 'required'])); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('itemTypeCode', __('Item Type Code (*)'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::select('itemTyCd', $itemtypes, null, ['class' => 'form-control select2', 'placeholder' => __('Select Item Type Code'), 'required' => 'required'])); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('countryCode', __('Origin Place Code (*)'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::select('orgnNatCd', $countrynames, null, ['class' => 'form-control select2', 'placeholder' => __('Select Origin Place Code'), 'required' => 'required'])); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('pkgUnitCode', __('Item Packaging Code (*)'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::text('pkgUnitCd', null, ['class' => 'form-control', 'placeholder' => __('Enter Item Packaging Code'), 'required' => 'required'])); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('qtyUnitCode', __('Quantity Unit Code (*)'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::text('qtyUnitCd', null, ['class' => 'form-control', 'placeholder' => __('Enter Quantity Unit Code'), 'required' => 'required'])); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('taxTypeCode', __('Taxation Type Code (*)'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::select('taxTyCd', $taxationtype, null, ['class' => 'form-control select2', 'placeholder' => __('Select Taxation Type Code'), 'required' => 'required'])); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('unitPrice', __('Default Unit Price (*)'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::text('dftPrc', null, ['class' => 'form-control', 'placeholder' => __('Enter Default Unit Price'), 'required' => 'required'])); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('group1UnitPrice', __('Group 1 Unit Price'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::text('grpPrcL1', null, ['class' => 'form-control', 'placeholder' => __('Enter Group 1 Unit Price')])); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('group2UnitPrice', __('Group 2 Unit Price'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::text('grpPrcL2', null, ['class' => 'form-control', 'placeholder' => __('Enter Group 2 Unit Price')])); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('group3UnitPrice', __('Group 3 Unit Price'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::text('grpPrcL3', null, ['class' => 'form-control', 'placeholder' => __('Enter Group 3 Unit Price')])); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('group4UnitPrice', __('Group 4 Unit Price'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::text('grpPrcL4', null, ['class' => 'form-control', 'placeholder' => __('Enter Group 4 Unit Price')])); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('group5UnitPrice', __('Group 5 Unit Price'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::text('grpPrcL5', null, ['class' => 'form-control', 'placeholder' => __('Enter Group 5 Unit Price')])); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('saftyQuantity', __('Safety Quantity'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::number('sftyQty', $productServiceinformation->sftyQty, ['class' => 'form-control', 'placeholder' => __('Enter Safty Quantity')])); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('Bar Code', __('Bar Code'), ['class' => 'form-label'])); ?>

               <?php echo e(Form::text('bcd', null, ['class' => 'form-control', 'placeholder' => __('Enter bar Code')])); ?>

            </div>
        </div>
          <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('Batch No', __('Batch No'), ['class' => 'form-label'])); ?>

               <?php echo e(Form::text('btchNo', null, ['class' => 'form-control', 'placeholder' => __('Enter Batch No')])); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('packageQuantity', __('Package Quantity'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::number('packageQuantity', null, ['class' => 'form-control'])); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('isrcAplcbYn', __('Insurance Appicable (Y/N) (*)'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::select('isrcAplcbYn', [true => 'Y', false => 'N'], $productServiceinformation->isrcAplcbYn, ['class' => 'form-control select2', 'required' => 'required'])); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('isUsed', __('Used / UnUsed (Y/N) (*)'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::select('isUsed', [true => 'true', false => 'false'], $productServiceinformation->isUsed, ['class' => 'form-control select2', 'required' => 'required'])); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('addInfo', __('Additional Information'), ['class' => 'form-label'])); ?>


                <?php echo e(Form::textarea('addInfo', $productServiceinformation->addInfo, ['class' => 'form-control', 'placeholder' => __('Additional Information')])); ?>

            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="<?php echo e(__('Update')); ?>" class="btn  btn-primary">
</div>

<?php echo e(Form::close()); ?>

<script>
    document.getElementById('pro_image').onchange = function() {
        var src = URL.createObjectURL(this.files[0])
        document.getElementById('image').src = src
    }
    //hide & show quantity

    $(document).on('click', '.type', function() {
        var type = $(this).val();
        if (type == 'product') {
            $('.quantity').removeClass('d-none')
            $('.quantity').addClass('d-block');
        } else {
            $('.quantity').addClass('d-none')
            $('.quantity').removeClass('d-block');
        }
    });
</script>
<?php /**PATH C:\xampp\htdocs\erp-go-6.4-using-laravel\resources\views/productservice/edit.blade.php ENDPATH**/ ?>