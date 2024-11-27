
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Stock Master Save Request')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="mb-0 h4 d-inline-block font-weight-400 "><?php echo e(__('Stock Master Save Request')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Stock Master Save Request')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
        <a href="<?php echo e(route('save.request.create')); ?>" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
            title="<?php echo e(__('Stock Master Save Request')); ?>">
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
                                    <th scope="col"><?php echo e(__('Item Code')); ?></th>
                                    <th scope="col"><?php echo e(__('RSD Quantity')); ?></th>
                                    <th scope="col"><?php echo e(__('Regr ID')); ?></th>
                                    <th scope="col"><?php echo e(__('Regr Name')); ?></th>
                                    <th scope="col"><?php echo e(__('Modr Name')); ?></th>
                                    <th scope="col"><?php echo e(__('Modr ID')); ?></th>
                                    <th scope="col"><?php echo e(__('TIN')); ?></th>
                                    <th scope="col"><?php echo e(__('Branch ID')); ?></th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                <?php $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reqq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($reqq->itemCd); ?></td>
                                        <td><?php echo e($reqq->rsdQty); ?></td>
                                        <td><?php echo e($reqq->regrId); ?></td>
                                        <td><?php echo e($reqq->regrNm); ?></td>
                                        <td><?php echo e($reqq->modrNm); ?></td>
                                        <td><?php echo e($reqq->modrId); ?></td>
                                        <td><?php echo e($reqq->tin); ?></td>
                                        <td><?php echo e($reqq->bhfId); ?></td>
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp-go-6.4-using-laravel\resources\views/stockmastersaverequest/index.blade.php ENDPATH**/ ?>