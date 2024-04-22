<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('API Initialization')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0"><?php echo e(__('API Initialization')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('apiinitialization.index')); ?>"><?php echo e(__('API Initialization')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(ucwords($apiinitialization->dvcSrlNo)); ?></li>
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
                                <td><?php echo e(__('Tin')); ?></td>
                                <td><?php echo e($apiinitialization->tin); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo e(__('BHD Id')); ?></td>
                                <td><?php echo e($apiinitialization->bhfId); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo e(__('DVC SrlNo')); ?></td>
                                <td><?php echo e($apiinitialization->dvcSrlNo); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo e(__('Taxpr Nm')); ?></td>
                                <td><?php echo e($apiinitialization->taxprNm); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo e(__('Head Quarter')); ?></td>
                                <td><?php echo e($apiinitialization->hqYn); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/chrisdroid/Desktop/projects/erp-go-6.4-using-laravel/resources/views/apiinitialization/show.blade.php ENDPATH**/ ?>