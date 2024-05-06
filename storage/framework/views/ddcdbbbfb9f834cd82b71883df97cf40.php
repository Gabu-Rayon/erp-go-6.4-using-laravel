
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Stock Move')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h6 class="h6 d-inline-block font-weight-400 mb-0"><?php echo e(__('Stock Move')); ?></h6>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('stockinfo.index')); ?>"><?php echo e(__('Stock Move')); ?></a></li>
    <li class="breadcrumb-item">Details</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
    <div class="float-end m-2">
        <a href="<?php echo e(route('stockinfo.index')); ?>" class="btn btn-sm btn-info">
            <?php echo e(__('Back')); ?>

        </a>
    </div>
    <div class="float-end m-2">
        <a href="<?php echo e(route('stockinfo.cancel', $stockMoveList->id)); ?>" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="<?php echo e(__('Cancel')); ?>">
            <?php echo e(__('Cancel')); ?>

        </a>
    </div>
    <div class="float-end m-2">
        <a href="<?php echo e(route('stockinfo.edit', $stockMoveList->id)); ?>" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="<?php echo e(__('Cancel')); ?>">
            <?php echo e(__('Stock Move')); ?>

        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <?php echo e(Form::open(['url' => 'sale', 'enctype' => 'multipart/form-data'])); ?>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3">
                        <h6><?php echo e(__('Customer TIN: ')); ?></h6>
                        <p><?php echo e($stockMoveList->custTin); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Customer Branch ID: ')); ?></h6>
                        <p><?php echo e($stockMoveList->custBhfId); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Sar NO: ')); ?></h6>
                        <p><?php echo e($stockMoveList->sarNo); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('OCRN Date: ')); ?></h6>
                        <p><?php echo e($stockMoveList->ocrnDt); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Total Item Count: ')); ?></h6>
                        <p><?php echo e($stockMoveList->totItemCnt); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Total Taxable Amount: ')); ?></h6>
                        <p><?php echo e($stockMoveList->totTaxblAmt); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Total Tax Amount: ')); ?></h6>
                        <p><?php echo e($stockMoveList->totTaxAmt); ?></h6>
                    </div>
                    <div class="col-md-12">
                        <h6><?php echo e(__('Remark: ')); ?></h6>
                        <p><?php echo e($stockMoveList->remark); ?></h6>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title">Items</h6>
                        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo e(\Log::info($item)); ?>

                        <div class="card-body">
                            <div class="row">
                            <h6 class="card-title text-info text-lg">Item</h6>
                            <div class="col-md-3">
                                <h6><?php echo e(__('Item Sequence No: ')); ?></h6>
                                <p><?php echo e($item->itemSeq); ?></h6>
                            </div>
                            <div class="col-md-3">
                                <h6><?php echo e(__('Classification Code: ')); ?></h6>
                                <p><?php echo e($item->itemClsCd); ?></h6>
                            </div>
                            <div class="col-md-3">
                                <h6><?php echo e(__('Item Code: ')); ?></h6>
                                <p><?php echo e($item->itemCd); ?></h6>
                            </div>
                            <div class="col-md-3">
                                <h6><?php echo e(__('Item Name: ')); ?></h6>
                                <p><?php echo e($item->itemNm); ?></h6>
                            </div>
                            <div class="col-md-3">
                                <h6><?php echo e(__('Bar Code: ')); ?></h6>
                                <p><?php echo e($item->bcd); ?></h6>
                            </div>
                            <div class="col-md-3">
                                <h6><?php echo e(__('Quantity Unit Code: ')); ?></h6>
                                <p><?php echo e($item->qtyUnitCd); ?></h6>
                            </div>
                            <div class="col-md-3">
                                <h6><?php echo e(__('Quantity: ')); ?></h6>
                                <p><?php echo e($item->qty); ?></h6>
                            </div>
                            <div class="col-md-3">
                                <h6><?php echo e(__('Item Expiry Date: ')); ?></h6>
                                <p><?php echo e($item->itemExprDt); ?></h6>
                            </div>
                            <div class="col-md-3">
                                <h6><?php echo e(__('Price: ')); ?></h6>
                                <p><?php echo e($item->prc); ?></h6>
                            </div>
                            <div class="col-md-3">
                                <h6><?php echo e(__('Supply Amount: ')); ?></h6>
                                <p><?php echo e($item->splyAmt); ?></h6>
                            </div>
                            <div class="col-md-3">
                                <h6><?php echo e(__('Total Discount Amount: ')); ?></h6>
                                <p><?php echo e($item->totDcAmt); ?></h6>
                            </div>
                            <div class="col-md-3">
                                <h6><?php echo e(__('Taxable Amount: ')); ?></h6>
                                <p><?php echo e($item->taxblAmt); ?></h6>
                            </div>
                            <div class="col-md-3">
                                <h6><?php echo e(__('Tax Type Code: ')); ?></h6>
                                <p><?php echo e($item->taxTyCd); ?></h6>
                            </div>
                            <div class="col-md-3">
                                <h6><?php echo e(__('Tax Amount: ')); ?></h6>
                                <p><?php echo e($item->taxAmt); ?></h6>
                            </div>
                            <div class="col-md-3">
                                <h6><?php echo e(__('Total Amount: ')); ?></h6>
                                <p><?php echo e($item->totAmt); ?></h6>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Developer\Desktop\apps\erp-go-6.4-using-laravel\resources\views/stockinfo/show.blade.php ENDPATH**/ ?>