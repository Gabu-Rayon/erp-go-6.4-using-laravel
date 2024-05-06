<?php echo e(Form::open(array('url' => 'updateimporteditems','enctype'=>"multipart/form-data"))); ?>

    <div class="modal-body">
        <div class="row">
            <div class="form-group col-md-12">
                <?php echo e(Form::label('importedItemName', __('Imported Item Name'),['class'=>'form-label'])); ?>

                <?php echo e(Form::select('importedItemName', $importedItems, null, ['class' => 'form-control item-name'])); ?>

            </div>
            <div class="form-group col-md-12">
                <?php echo e(Form::label('item', __('Item Name'),['class'=>'form-label'])); ?>

                <?php echo e(Form::select('item', $items, null, ['class' => 'form-control item-name'])); ?>

            </div>
            <div class="form-group col-md-12">
                <?php echo e(Form::label('importItemStatusCode', __('Import Item Status Code'),['class'=>'form-label'])); ?>

                <?php echo e(Form::select('importItemStatusCode', $importItemStatusCode, null, ['class' => 'form-control item-name'])); ?>

            </div>
        </div>
    </div>
    <div class="modal-footer">
        <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn btn-light" data-bs-dismiss="modal">
        <input type="submit" value="<?php echo e(__('Send')); ?>" class="btn btn-primary">
    </div>
<?php echo e(Form::close()); ?>

<?php /**PATH C:\Users\Developer\Desktop\apps\erp-go-6.4-using-laravel\resources\views/updateimportitem/create.blade.php ENDPATH**/ ?>