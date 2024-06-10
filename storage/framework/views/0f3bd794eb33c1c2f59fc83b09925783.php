
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Item Information')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0"><?php echo e(__('Item Information')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('productservice.getiteminformation')); ?>"><?php echo e(__('Item Information')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(ucwords($iteminformation->itemCd)); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td><?php echo e(__('Item Code')); ?></td>
                                <td><?php echo e($iteminformation->itemCd); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo e(__('Item Classification Code')); ?></td>
                                <td><?php echo e($iteminformation->itemClsCd); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo e(__('Item Type Code')); ?></td>
                                <td><?php echo e($iteminformation->itemTyCd); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo e(__('Item Name')); ?></td>
                                <td><?php echo e($iteminformation->itemNm); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo e(__('Origin Place Code')); ?></td>
                                <td><?php echo e($iteminformation->orgnNatCd); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo e(__('Packaging Unit Code')); ?></td>
                                <td><?php echo e($iteminformation->pkgUnitCd); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo e(__('Quantity Unit Code')); ?></td>
                                <td><?php echo e($iteminformation->qtyUnitCd); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo e(__('Batch No')); ?></td>
                                <td><?php echo e($iteminformation->btchNo); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo e(__('Batch No')); ?></td>
                                <td><?php echo e($iteminformation->bcd); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo e(__('Default Price')); ?></td>
                                <td><?php echo e($iteminformation->dftPrc); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo e(__('Group 1 Unit Price')); ?></td>
                                <td><?php echo e($iteminformation->grpPrcL1); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo e(__('Group 2 Unit Price')); ?></td>
                                <td><?php echo e($iteminformation->grpPrcL2); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo e(__('Group 3 Unit Price')); ?></td>
                                <td><?php echo e($iteminformation->grpPrcL3); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo e(__('Group 4 Unit Price')); ?></td>
                                <td><?php echo e($iteminformation->grpPrcL4); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo e(__('Group 5 Unit Price')); ?></td>
                                <td><?php echo e($iteminformation->grpPrcL5); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo e(__('Additional Information')); ?></td>
                                <td><?php echo e($iteminformation->addInfo); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo e(__('Safty Quantity')); ?></td>
                                <td><?php echo e($iteminformation->sftyQty); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo e(__('Insurance Applicable (Y/N)')); ?></td>
                                <td><?php echo e($iteminformation->isrcAplcbYn); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo e(__('Used/UnUsed')); ?></td>
                                <td><?php echo e($iteminformation->useYn); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp-go-6.4-using-laravel\resources\views/iteminformation/show.blade.php ENDPATH**/ ?>