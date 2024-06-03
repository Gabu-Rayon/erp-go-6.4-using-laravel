

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Composition List Details')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('compositionlist.index')); ?>"><?php echo e(__('Composition List')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Composition List Details')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5><?php echo e(__('Main Item: ')); ?> <?php echo e(\App\Models\ProductService::where('itemCd', $compositionList->mainItemCode)->first()->itemNm); ?></h5>
            </div>
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table datatable">
                        <thead>
                        <tr>
                            <th scope="col"><?php echo e(__('CompItem Code')); ?></th>
                            <th scope="col"><?php echo e(__('CompItem Name')); ?></th>
                            <th scope="col"><?php echo e(__('CompItem Quantity')); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $compositionItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($item->compoItemCode); ?></td>
                              <td><?php echo e(optional(\App\Models\ProductService::where('itemCd', $item->mainItemCode)->first())->name); ?></td>
                                <td><?php echo e($item->compoItemQty); ?></td>
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp-go-6.4-using-laravel\resources\views/compositionlist/view.blade.php ENDPATH**/ ?>