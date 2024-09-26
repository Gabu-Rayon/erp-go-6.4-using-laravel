
<?php $__env->startPush('script-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Stock Branch Transfer List')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="mb-0 h4 d-inline-block font-weight-400 "><?php echo e(__('Stock Branch Transfer List')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Stock Branch Transfer List')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
        <a href="<?php echo e(route('branch.transfer.create', 0)); ?>" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="<?php echo e(__('Add Stock Branch Transfer')); ?>">
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
                                    <th scope="col"><?php echo e(__('SrNo')); ?></th>
                                    <th scope="col"><?php echo e(__('Brnach From')); ?></th>
                                    <th scope="col"><?php echo e(__('Branch To')); ?></th>
                                    <th scope="col"><?php echo e(__('Total items')); ?></th>
                                    <th scope="col"><?php echo e(__('Status')); ?></th>
                                    <th scope="col"><?php echo e(__('Action')); ?></th>
                                </tr>
                            </thead>
                            <tbody class="list">
                            <td></td>
                            <td></td>
                            <td></td>
                                <?php $__currentLoopData = $branchTransfers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branchTransfer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($branchTransfer->id); ?></td>
                                        <td><?php echo e($branchTransfer->from_branch); ?></td>
                                        <td><?php echo e($branchTransfer->to_branch); ?></td>
                                        <td><?php echo e($branchTransfer->totItemCnt); ?></td>
                                         <td><?php echo e($branchTransfer->status); ?></td>
                                        <td>
                                            <div class="action-btn bg-warning ms-2">
                                                <a href="<?php echo e(route('branch.transfer.show', $branchTransfer)); ?>"
                                                    class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                    data-bs-toggle="tooltip" title="<?php echo e(__('Details')); ?>">
                                                    <i class="text-white ti ti-eye"></i>
                                                </a>
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp-go-6.4-using-laravel\resources\views/stockbranchtransfer/index.blade.php ENDPATH**/ ?>