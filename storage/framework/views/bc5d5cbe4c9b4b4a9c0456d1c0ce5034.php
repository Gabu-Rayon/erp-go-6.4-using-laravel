
<?php $__env->startPush('script-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Item Information')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0 "><?php echo e(__('Item Information')); ?></h5>
    </div>Support
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Manage Item Information')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
       <a href="#" data-size="lg" data-url="<?php echo e(route('iteminformation.create')); ?>" data-ajax-popup="true" data-bs-toggle="tooltip" title="<?php echo e(__('Create Item Information')); ?>" data-title="<?php echo e(__('Create Item Information')); ?>" class="btn btn-sm btn-primary">
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
                            <th scope="col"><?php echo e(__('#')); ?></th>
                            <th scope="col"><?php echo e(__('Data')); ?></th>
                            <th scope="col"><?php echo e(__('Data')); ?></th>
                            <th scope="col"><?php echo e(__('Data')); ?></th>
                            <th scope="col"><?php echo e(__('Data')); ?></th>
                            <th scope="col"><?php echo e(__('Data')); ?></th>
                            <th scope="col"><?php echo e(__('Data')); ?></th>
                            <th scope="col" ><?php echo e(__('Data')); ?></th>
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


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp-go-6.4-using-laravel\resources\views/iteminformation/index.blade.php ENDPATH**/ ?>