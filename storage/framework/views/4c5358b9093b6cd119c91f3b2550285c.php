
<?php $__env->startPush('script-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Stock Move List')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0 "><?php echo e(__('Stock Move List')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Stock Move List')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
        <a href="#" data-url="<?php echo e(route('stockadjustment.create')); ?>" class="btn btn-sm btn-primary" data-ajax-popup="true" data-bs-toggle="tooltip" title="<?php echo e(__('Add Stock Adjustment')); ?>">
            Add Stock Adjustment
        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table datatable">
                        <thead>
                        <tr>
                            <th scope="col"><?php echo e(__('SrNo')); ?></th>
                            <th scope="col"><?php echo e(__('Item Code')); ?></th>
                            <th scope="col"><?php echo e(__('RSD Quantity')); ?></th>
                            <th scope="col"><?php echo e(__('Registration No')); ?></th>
                            <th scope="col"><?php echo e(__('Registration ID')); ?></th>
                        </tr>
                        </thead>
                        <tbody class="list">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Developer\Desktop\apps\erp-go-6.4-using-laravel\resources\views/stockadjustment/index.blade.php ENDPATH**/ ?>