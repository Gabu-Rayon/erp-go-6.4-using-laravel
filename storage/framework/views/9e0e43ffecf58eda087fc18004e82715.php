
<?php echo e(Form::model($productServiceinformation, array('route' => array('productservice.update',$productServiceinformation), 'method' => 'PUT'))); ?>

<div class="modal-body">
    <div class="row">
         <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('name', __('Name'),['class'=>'form-label'])); ?><span class="text-danger">*</span>
                <?php echo e(Form::text('name',null, array('class' => 'form-control','required'=>'required'))); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('sku', __('SKU'),['class'=>'form-label'])); ?><span class="text-danger">*</span>
                <?php echo e(Form::text('sku', null, array('class' => 'form-control','required'=>'required'))); ?>

            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('sale_price', __('Sale Price'),['class'=>'form-label'])); ?><span class="text-danger">*</span>
                <?php echo e(Form::number('sale_price', null, array('class' => 'form-control','required'=>'required','step'=>'0.01'))); ?>

            </div>
        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('sale_chartaccount_id', __('Income Account'),['class'=>'form-label'])); ?>

            
            <select name="sale_chartaccount_id" class="form-control" required="required">
                <?php $__currentLoopData = $incomeChartAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $chartAccount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($key); ?>" class="subAccount" <?php echo e(($productServiceinformation->sale_chartaccount_id == $key) ? 'selected' : ''); ?>><?php echo e($chartAccount); ?></option>
                    <?php $__currentLoopData = $incomeSubAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subAccount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($key == $subAccount['account']): ?>
                            <option value="<?php echo e($subAccount['id']); ?>" class="ms-5" <?php echo e(($productServiceinformation->sale_chartaccount_id == $subAccount['id']) ? 'selected' : ''); ?>> &nbsp; &nbsp;&nbsp; <?php echo e($subAccount['code_name']); ?></option>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('purchase_price', __('Purchase Price'),['class'=>'form-label'])); ?><span class="text-danger">*</span>
                <?php echo e(Form::number('purchase_price', null, array('class' => 'form-control','required'=>'required','step'=>'0.01'))); ?>

            </div>
        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('expense_chartaccount_id', __('Expense Account'),['class'=>'form-label'])); ?>

            
            <select name="expense_chartaccount_id" class="form-control" required="required">
                <?php $__currentLoopData = $expenseChartAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $chartAccount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($key); ?>" class="subAccount" <?php echo e(($productServiceinformation->expense_chartaccount_id == $key) ? 'selected' : ''); ?>><?php echo e($chartAccount); ?></option>
                    <?php $__currentLoopData = $expenseSubAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subAccount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($key == $subAccount['account']): ?>
                            <option value="<?php echo e($subAccount['id']); ?>" class="ms-5" <?php echo e(($productServiceinformation->expense_chartaccount_id == $subAccount['id']) ? 'selected' : ''); ?>> &nbsp; &nbsp;&nbsp; <?php echo e($subAccount['code_name']); ?></option>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="form-group  col-md-6">
            <?php echo e(Form::label('tax_id', __('Tax'),['class'=>'form-label'])); ?>

            <?php echo e(Form::select('tax_id[]', $tax,null, array('class' => 'form-control select2','id'=>'choices-multiple1','multiple'=>''))); ?>

        </div>

        <div class="form-group  col-md-6">
            <?php echo e(Form::label('category_id', __('Category'),['class'=>'form-label'])); ?><span class="text-danger">*</span>
            <?php echo e(Form::select('category_id', $category,null, array('class' => 'form-control select','required'=>'required'))); ?>

        </div>
        <div class="form-group  col-md-6">
            <?php echo e(Form::label('unit_id', __('Unit'),['class'=>'form-label'])); ?><span class="text-danger">*</span>
            <?php echo e(Form::select('unit_id', $unit,null, array('class' => 'form-control select','required'=>'required'))); ?>

        </div>
              <div class="form-group col-md-6 quantity <?php echo e($productServiceinformation->type=='service' ? 'd-none':''); ?>">
            <?php echo e(Form::label('quantity', __('Quantity'),['class'=>'form-label'])); ?><span class="text-danger">*</span>
            <?php echo e(Form::text('quantity',null, array('class' => 'form-control','required'=>'required'))); ?>

        </div>
       
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

                <?php echo e(Form::select('itemClsCd',$productServiceclassifications , null, array('class' => 'form-control select2','placeholder'=>__('Select Item Classification'),'required'=>'required'))); ?>

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

                <?php echo e(Form::number('saftyQuantity',$productServiceinformation->sftyQty, array('class' => 'form-control','placeholder'=>__('Enter Safty Quantity')))); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('packageQuantity', __('Package Quantity'),['class'=>'form-label'])); ?>

                <?php echo e(Form::number('packageQuantity', null, array('class' => 'form-control'))); ?>

            </div>
        </div>
                   <div class="form-group col-md-6">
            <?php echo e(Form::label('sale_chartaccount_id', __('Income Account'),['class'=>'form-label'])); ?>

            
            <select name="sale_chartaccount_id" class="form-control" required="required">
                <?php $__currentLoopData = $incomeChartAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $chartAccount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($key); ?>" class="subAccount" <?php echo e(($productServiceinformation->sale_chartaccount_id == $key) ? 'selected' : ''); ?>><?php echo e($chartAccount); ?></option>
                    <?php $__currentLoopData = $incomeSubAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subAccount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($key == $subAccount['account']): ?>
                            <option value="<?php echo e($subAccount['id']); ?>" class="ms-5" <?php echo e(($productServiceinformation->sale_chartaccount_id == $subAccount['id']) ? 'selected' : ''); ?>> &nbsp; &nbsp;&nbsp; <?php echo e($subAccount['code_name']); ?></option>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('isrcAplcbYn', __('Insurance Appicable (Y/N) (*)'),['class'=>'form-label'])); ?>

                <?php echo e(Form::select('isrcAplcbYn', [true => 'Y', false => 'N'],$productServiceinformation->isrcAplcbYn, ['class' => 'form-control', 'required' => 'required'])); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('useYn', __('Used / UnUsed (Y/N) (*)'),['class'=>'form-label'])); ?>

                <?php echo e(Form::select('useYn', [true => 'Y', false => 'N'],$productServiceinformation->useYn, ['class' => 'form-control', 'required' => 'required'])); ?>

            </div>
        </div>
        <div class="col-md-6 form-group">
            <?php echo e(Form::label('pro_image',__('Product Image'),['class'=>'form-label'])); ?>

            <div class="choose-file ">
                <label for="pro_image" class="form-label">
                    <input type="file" class="form-control" name="pro_image" id="pro_image" data-filename="pro_image_create">
                    <img id="image"  class="mt-3" width="100" src="<?php if($productServiceinformation->pro_image): ?><?php echo e(asset(Storage::url('uploads/pro_image/'.$productServiceinformation->pro_image))); ?><?php else: ?><?php echo e(asset(Storage::url('uploads/pro_image/user-2_1654779769.jpg'))); ?><?php endif; ?>" />
                </label>
            </div>
        </div>
                  <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('addInfo', __('Additional Information'),['class'=>'form-label'])); ?>


                <?php echo e(Form::textarea('addInfo',$productServiceinformation->addInfo, array('class' => 'form-control','placeholder'=>__('Additional Information')))); ?>

            </div>
        </div>
         <div class="col-md-6">
            <div class="form-group">
            <?php echo e(Form::label('description', __('Description'),['class'=>'form-label'])); ?>

            <?php echo e(Form::textarea('addInfo',$productServiceinformation->description, array('class' => 'form-control','placeholder'=>__('Description')))); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="d-block form-label"><?php echo e(__('Type')); ?></label>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input type" id="customRadio5" name="type" value="product" <?php if($productServiceinformation->type=='product'): ?> checked <?php endif; ?> >
                            <label class="custom-control-label form-label" for="customRadio5"><?php echo e(__('Product')); ?></label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input type" id="customRadio6" name="type" value="service" <?php if($productServiceinformation->type=='service'): ?> checked <?php endif; ?> >
                            <label class="custom-control-label form-label" for="customRadio6"><?php echo e(__('Service')); ?></label>
                        </div>
                    </div>
                </div>
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
    document.getElementById('pro_image').onchange = function () {
        var src = URL.createObjectURL(this.files[0])
        document.getElementById('image').src = src
    }
    //hide & show quantity

    $(document).on('click', '.type', function ()
    {
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