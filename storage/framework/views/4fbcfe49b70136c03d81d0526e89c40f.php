<?php echo e(Form::model($productService, array('route' => array('productstock.update', $productService->id), 'method' => 'PUT'))); ?>

    <div class="modal-body">
        <div class="row">
            <div class="form-group col-md-6">
                <?php echo e(Form::label('Product', __('Product'),['class'=>'form-label'])); ?><br>
                <?php echo e($productService->itemName); ?>

            </div>
            <div class="form-group col-md-6">
                <?php echo e(Form::label('Product', __('Code'),['class'=>'form-label'])); ?><br>
                <?php echo e($productService->itemCode); ?>

            </div>
            <div class="form-group col-md-12">
                <?php echo e(Form::label('quantity', __('Quantity'),['class'=>'form-label'])); ?>

                <span class="text-danger">*</span>
                <?php echo e(Form::number('quantity',"", array('class' => 'form-control','required'=>'required'))); ?>

            </div>
            <div class="form-group col-md-12">
                <?php echo e(Form::label('packageQuantity', __('Package Quantity'),['class'=>'form-label'])); ?>

                <span class="text-danger">*</span>
                <?php echo e(Form::number('packageQuantity',"", array('class' => 'form-control','required'=>'required'))); ?>

            </div>
        </div>
    </div>
    <div class="modal-footer">
        <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn  btn-light" data-bs-dismiss="modal">
        <input type="submit" value="<?php echo e(__('Save')); ?>" class="btn  btn-primary">
    </div>
<?php echo e(Form::close()); ?>

<?php /**PATH C:\xampp\htdocs\erp-go-6.4-using-laravel\resources\views/productstock/edit.blade.php ENDPATH**/ ?>