

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Map Imported Product')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('importeditems.index')); ?>"><?php echo e(__('Imported Product')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Map Imported Product')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <?php echo e(Form::open(['url' => 'mapimporteditem', 'method' => 'POST', 'class' => 'w-100'])); ?>

        <div class="col-12">
            <input type="hidden" name="_token" id="token" value="<?php echo e(csrf_token()); ?>">
            <div class="card">
                <div class="card-body" data-autofill>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <?php echo e(Form::label('importedItemName', __('Imported Product Name'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::select('importedItemName', $importedItems, null, ['class' => 'form-control select2 item-name'])); ?>

                        </div>
                        <div class="form-group col-md-6">
                            <?php echo e(Form::label('item', __('My Item(s) Name'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::select('item', $items, null, ['class' => 'form-control select2 item-name'])); ?>

                        </div>
                        <div class="form-group col-md-6">
                            <?php echo e(Form::label('importItemStatusCode', __('Import Product Status Code'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::select('importItemStatusCode', $importItemStatusCode, null, ['class' => 'form-control select2 item-name'])); ?>

                        </div>
                        <div class="form-group col-md-12">
                            <?php echo e(Form::label('remark', __('Remark(*)'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::textarea('remark', '', ['class' => 'form-control', 'placeholder' => 'Enter your remarks...', 'required' => 'required'])); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" onclick="location.href = '<?php echo e(route('importeditems.index')); ?>';" class="btn btn-light">
            <input type="submit" value="<?php echo e(__('Save')); ?>" class="btn btn-primary">
        </div>
        <?php echo e(Form::close()); ?>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp-go-6.4-using-laravel\resources\views/importeditems/mapImportedItem.blade.php ENDPATH**/ ?>