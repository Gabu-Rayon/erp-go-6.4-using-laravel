<?php $__env->startPush('script-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('API Initialization')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0 "><?php echo e(__('API Initialization')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('API Initialization')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
        <a href="#" data-url="<?php echo e(route('apiinitialization.create')); ?>" class="btn btn-sm btn-primary" data-ajax-popup="true" data-bs-toggle="tooltip" title="<?php echo e(__('Create New Initialization')); ?>">
            Initialization New
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
                            <th scope="col"><?php echo e(__('Tin')); ?></th>
                            <th scope="col"><?php echo e(__('BHD Id')); ?></th>
                            <th scope="col"><?php echo e(__('DVC SrlNo')); ?></th>
                            <th scope="col"><?php echo e(__('Taxpr Nm')); ?></th>
                            <th scope="col"><?php echo e(__('Head Quarter')); ?></th>
                            <th scope="col" ><?php echo e(__('Action')); ?></th>
                        </tr>
                        </thead>
                        <tbody class="list">
                            <?php $__currentLoopData = $apiinitializations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $apiinitialization): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($apiinitialization->tin); ?></td>
                                    <td><?php echo e($apiinitialization->bhfId); ?></td>
                                    <td><?php echo e($apiinitialization->dvcSrlNo); ?></td>
                                    <td><?php echo e($apiinitialization->taxprNm); ?></td>
                                    <td><?php echo e($apiinitialization->hqYn); ?></td>
                                    <td>
                                        <div class="action-btn bg-warning ms-2">
                                            <a href="<?php echo e(route('apiinitialization.show',$apiinitialization->id)); ?>" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="tooltip" title="<?php echo e(__('Details')); ?>"><i class="ti ti-eye text-white"></i></a>
                                        </div>
                                    </td>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/chrisdroid/Desktop/projects/php/erp-go-6.4-using-laravel/resources/views/apiinitialization/index.blade.php ENDPATH**/ ?>