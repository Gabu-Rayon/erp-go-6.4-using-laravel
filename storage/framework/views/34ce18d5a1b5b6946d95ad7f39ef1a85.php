<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Purchase Detail')); ?>

<?php $__env->stopSection(); ?>

<?php
    $settings = Utility::settings();
?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('purchase.index')); ?>"><?php echo e(__('Purchase')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e($purchase->id); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header py-3">
                    <h6 class="h6 m-0"><?php echo e(__('Purchase Detail')); ?></h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for=""><?php echo e(__('Item Sequence')); ?></label>
                                <input type="text" class="form-control" value="<?php echo e($purchase->itemSeq); ?>" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for=""><?php echo e(__('Item Code')); ?></label>
                                <input type="text" class="form-control" value="<?php echo e($purchase->itemCd); ?>" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for=""><?php echo e(__('Item Class Code')); ?></label>
                                <input type="text" class="form-control" value="<?php echo e($purchase->itemClsCd); ?>" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for=""><?php echo e(__('Item Name')); ?></label>
                                <input type="text" class="form-control" value="<?php echo e($purchase->itemNm); ?>" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for=""><?php echo e(__('Bar Code')); ?></label>
                                <input type="text" class="form-control" value="<?php echo e($purchase->bcd); ?>" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for=""><?php echo e(__('Supplier Item Class Code')); ?></label>
                                <input type="text" class="form-control" value="<?php echo e($purchase->spplrItemClsCd); ?>" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for=""><?php echo e(__('Supplier Item Code')); ?></label>
                                <input type="text" class="form-control" value="<?php echo e($purchase->spplrItemCd); ?>" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for=""><?php echo e(__('Package Unit Code')); ?></label>
                                <input type="text" class="form-control" value="<?php echo e($purchase->pkgUnitCd); ?>" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for=""><?php echo e(__('Package Unit Code')); ?></label>
                                <input type="text" class="form-control" value="<?php echo e($purchase->pkgUnitCd); ?>" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for=""><?php echo e(__('Package')); ?></label>
                                <input type="text" class="form-control" value="<?php echo e($purchase->pkg); ?>" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for=""><?php echo e(__('Quantity Unit Code')); ?></label>
                                <input type="text" class="form-control" value="<?php echo e($purchase->qtyUnitCd); ?>" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for=""><?php echo e(__('Quantity')); ?></label>
                                <input type="text" class="form-control" value="<?php echo e($purchase->qty); ?>" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for=""><?php echo e(__('Price')); ?></label>
                                <input type="text" class="form-control" value="<?php echo e($purchase->prc); ?>" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for=""><?php echo e(__('Supply Amount')); ?></label>
                                <input type="text" class="form-control" value="<?php echo e($purchase->splyAmt); ?>" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for=""><?php echo e(__('Discount Rate')); ?></label>
                                <input type="text" class="form-control" value="<?php echo e($purchase->dcRt); ?>" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for=""><?php echo e(__('Discount Amount')); ?></label>
                                <input type="text" class="form-control" value="<?php echo e($purchase->dcAmt); ?>" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for=""><?php echo e(__('Tax Type Code')); ?></label>
                                <input type="text" class="form-control" value="<?php echo e($purchase->taxTyCd); ?>" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for=""><?php echo e(__('Taxable Amount')); ?></label>
                                <input type="text" class="form-control" value="<?php echo e($purchase->taxblAmt); ?>" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for=""><?php echo e(__('Tax Amount')); ?></label>
                                <input type="text" class="form-control" value="<?php echo e($purchase->taxAmt); ?>" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for=""><?php echo e(__('Total Amount')); ?></label>
                                <input type="text" class="form-control" value="<?php echo e($purchase->totAmt); ?>" readonly>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for=""><?php echo e(__('Export Date')); ?></label>
                                <input type="text" class="form-control" value="<?php echo e($purchase->itemExprDt); ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/chrisdroid/Desktop/projects/php/erp-go-6.4-using-laravel/resources/views/purchase/view.blade.php ENDPATH**/ ?>