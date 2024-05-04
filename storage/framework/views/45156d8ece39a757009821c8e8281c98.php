
<?php $__env->startPush('script-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Sales')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0 "><?php echo e(__('Sales')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Sales')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
        <a href="<?php echo e(route('sales.create',0)); ?>" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="<?php echo e(__('Add Sales')); ?>">
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
                            <th scope="col"><?php echo e(__('Trader Invoice No')); ?></th>
                            <th scope="col"><?php echo e(__('Customer Tin')); ?></th>
                            <th scope="col"><?php echo e(__('Sales Type')); ?></th>
                            <th scope="col"><?php echo e(__('Payments Type')); ?></th>
                            <th scope="col"><?php echo e(__('Status')); ?></th>
                            <th scope="col" ><?php echo e(__('Action')); ?></th>
                        </tr>
                        </thead>
                        <tbody class="list">
                            <?php $__currentLoopData = $sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($sale->id); ?></td>
                                    <td><?php echo e($sale->traderInvoiceNo); ?></td>
                                    <td><?php echo e($sale->customerTin); ?></td>
                                    <td><?php echo e($sale->salesType); ?></td>
                                    <td><?php echo e($sale->paymentType); ?></td>
                                    <td><?php echo e($sale->status); ?></td>
                                    <td>
                                        <div class="action-btn bg-info">
                                            <a href="<?php echo e(route('sales.show',$sale)); ?>" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="tooltip" title="<?php echo e(__('Details')); ?>">
                                                <i class="ti ti-eye text-white"></i>
                                            </a>
                                        </div>
                                        <div class="action-btn bg-success">
                                            <a href="<?php echo e(route('sales.print',$sale)); ?>" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="tooltip" title="<?php echo e(__('Print')); ?>">
                                                <i class="ti ti-printer text-white"></i>
                                            </a>
                                        </div>
                                        <div class="action-btn bg-secondary">
                                            <a href="<?php echo e(route('salescreditnote.edit',$sale)); ?>" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="tooltip" title="<?php echo e(__('Credit Note')); ?>">
                                                <i class="ti ti-book text-white"></i>
                                            </a>
                                        </div>
                                        <div class="action-btn bg-warning">
                                            <a href="<?php echo e(route('sales.edit',$sale)); ?>" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="tooltip" title="<?php echo e(__('Edit')); ?>">
                                                <i class="ti ti-pencil text-white"></i>
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


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp-go-6.4-using-laravel\resources\views/sales/index.blade.php ENDPATH**/ ?>