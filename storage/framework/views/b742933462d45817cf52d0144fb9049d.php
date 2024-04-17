<?php $__env->startPush('script-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('API Initialization')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0 "><?php echo e(__('API Initialization')); ?></h5>
    </div>Support
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('API Initialization')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
       <a href="#" data-size="lg" data-url="<?php echo e(route('apiinitialization.create')); ?>" data-ajax-popup="true" data-bs-toggle="tooltip" title="<?php echo e(__('Create')); ?>" data-title="<?php echo e(__('Create API Initialization')); ?>" class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
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
                            <th scope="col"><?php echo e(__('Tax Payer ID')); ?></th>
                            <th scope="col"><?php echo e(__('BHF ID')); ?></th>
                            <th scope="col"><?php echo e(__('Device Serial No')); ?></th>
                            <th scope="col"><?php echo e(__('Tax Payer Name')); ?></th>
                            <th scope="col"><?php echo e(__('Business Activity')); ?></th>
                            <th scope="col"><?php echo e(__('BHF Name')); ?></th>
                            <th scope="col"><?php echo e(__('BHF Open Date')); ?></th>
                            <th scope="col" ><?php echo e(__('Province Number')); ?></th>
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


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/chrisdroid/Desktop/projects/php/erp-go-6.4-using-laravel/resources/views/apiinitialization/index.blade.php ENDPATH**/ ?>