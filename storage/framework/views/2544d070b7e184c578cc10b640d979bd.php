
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Imported Item')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0"><?php echo e(__('Imported Item')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('importeditems.index')); ?>"><?php echo e(__('Imported Items')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(ucwords($importedItem->taskCode)); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
    <div class="float-end m-2">
        <a href="<?php echo e(route('importeditems.index')); ?>" class="btn btn-sm btn-info">
            <?php echo e(__('Back')); ?>

        </a>
    </div>
    <div class="float-end m-2">
        <a href="<?php echo e(route('importeditems.index')); ?>" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="<?php echo e(__('Cancel Sale')); ?>">
            <?php echo e(__('Cancel')); ?>

        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <?php echo e(Form::open(['url' => 'importeditems', 'enctype' => 'multipart/form-data'])); ?>

                <div class="row">
                    <div class="col-md-3">
                        <h6><?php echo e(__('Item Sequence: ')); ?></h6>
                        <p><?php echo e($importedItem->itemSeq); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Task Code: ')); ?></h6>
                        <p><?php echo e($importedItem->taskCode); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Item Name: ')); ?></h6>
                        <p><?php echo e($importedItem->itemName); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('HS Code: ')); ?></h6>
                        <p><?php echo e($importedItem->hsCode); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Package Unit Code: ')); ?></h6>
                        <p><?php echo e($importedItem->pkgUnitCode); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Net Weight: ')); ?></h6>
                        <p><?php echo e($importedItem->netWeight); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Invoice Foreign Code: ')); ?></h6>
                        <p><?php echo e($importedItem->invForCode); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Declaration Date: ')); ?></h6>
                        <p><?php echo e($importedItem->declarationDate); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Origin Nation Code: ')); ?></h6>
                        <p><?php echo e($importedItem->orginNationCode); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Quantity: ')); ?></h6>
                        <p><?php echo e($importedItem->qty); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Supplier Name: ')); ?></h6>
                        <p><?php echo e($importedItem->supplierName); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('NVCFCUREXCRT: ')); ?></h6>
                        <p><?php echo e($importedItem->nvcFcurExcrt); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Export Nation Code: ')); ?></h6>
                        <p><?php echo e($importedItem->exprtNatCode); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Quantity Unit Code: ')); ?></h6>
                        <p><?php echo e($importedItem->qtyUnitCode); ?></h6>
                    </div>
                   <div class="col-md-3">
                        <h6><?php echo e(__('Agent Name: ')); ?></h6>
                        <p><?php echo e($importedItem->agentName); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Declaration Number: ')); ?></h6>
                        <p><?php echo e($importedItem->declarationNo); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Package: ')); ?></h6>
                        <p><?php echo e($importedItem->package); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Gross Weight: ')); ?></h6>
                        <p><?php echo e($importedItem->grossWeight); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Invoice Foreign Currency Amount: ')); ?></h6>
                        <p><?php echo e($importedItem->invForCurrencyAmount); ?></h6>
                    </div>
                </div>
            </div>
        </div>
        <?php echo e(Form::close()); ?>


    </div>
    </div>
    </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp-go-6.4-using-laravel\resources\views/importeditems/show.blade.php ENDPATH**/ ?>