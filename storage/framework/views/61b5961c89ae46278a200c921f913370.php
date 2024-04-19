
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Branches List')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Branches List')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('SrNo')); ?></th>
                                    <th><?php echo e(__('PIN')); ?></th>
                                    <th><?php echo e(__('Branch Name')); ?></th>
                                    <th><?php echo e(__('Manager')); ?></th>
                                    <th><?php echo e(__('Prvnc Name')); ?></th>
                                    <th><?php echo e(__('Default')); ?></th>
                                    <th><?php echo e(__('Sctr Name')); ?></th>
                                    <th><?php echo e(__('Action')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="font-style">
                                        <td><?php echo e($branch->id); ?></td>
                                        <td><?php echo e($branch->tin); ?></td>
                                        <td><?php echo e($branch->bhfNm); ?></td>
                                        <td><?php echo e($branch->bhfSttsCd); ?></td>
                                        <td><?php echo e($branch->prvncNm); ?></td>
                                        <td><?php echo e($branch->hqYn); ?></td>
                                        <td><?php echo e($branch->sctrNm); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp-go-6.4-using-laravel\resources\views/brancheslist/index.blade.php ENDPATH**/ ?>