
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Item Classifications')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Item Classifications')); ?></li>
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
                                    <th><?php echo e(__('Code')); ?></th>
                                    <th><?php echo e(__('Name')); ?></th>
                                    <th><?php echo e(__('Level')); ?></th>
                                    <th><?php echo e(__('useYn')); ?></th>
                                    <th><?php echo e(__('Action')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $itemclassfications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="font-style">
                                        <td><?php echo e($classification->id); ?></td>
                                        <td><?php echo e($classification->itemClsCd); ?></td>
                                        <td><?php echo e($classification->itemClsNm); ?></td>
                                        <td><?php echo e($classification->itemClsLvl); ?></td>
                                        <td><?php echo e($classification->useYn); ?></td>
                                        <td></td>
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


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp-go-6.4-using-laravel\resources\views/productservice/itemclassfications.blade.php ENDPATH**/ ?>