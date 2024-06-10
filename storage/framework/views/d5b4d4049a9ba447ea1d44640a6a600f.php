
<?php $__env->startPush('script-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Imported Items')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0 "><?php echo e(__('Imported Items')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Imported Items')); ?></li>
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
                            <th scope="col"><?php echo e(__('Task Code')); ?></th>
                            <th scope="col"><?php echo e(__('Declaration Date')); ?></th>
                            <th scope="col"><?php echo e(__('Item Sequence')); ?></th>
                            <th scope="col" ><?php echo e(__('HS Code')); ?></th>
                            <th scope="col" ><?php echo e(__('Item Code')); ?></th>
                            <th scope="col" ><?php echo e(__('Item Classification Code')); ?></th>
                        </tr>
                        </thead>
                        <tbody class="list">
                            <?php $__currentLoopData = $updateImportedItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $updateImportedItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($updateImportedItem->srNo); ?></td>
                                    <td><?php echo e($updateImportedItem->taskCode); ?></td>
                                    <td><?php echo e($updateImportedItem->declarationDate); ?></td>
                                    <td><?php echo e($updateImportedItem->itemSeq); ?></td>
                                    <td><?php echo e($updateImportedItem->hsCode); ?></td>
                                    <td><?php echo e($updateImportedItem->itemClassificationCode); ?></td>
                                    <td><?php echo e($updateImportedItem->itemCode); ?></td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Developer\Desktop\apps\erp-go-6.4-using-laravel\resources\views/importeditems/create.blade.php ENDPATH**/ ?>