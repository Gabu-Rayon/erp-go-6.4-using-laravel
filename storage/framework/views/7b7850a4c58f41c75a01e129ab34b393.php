
<?php $__env->startPush('script-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Composition List')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0 "><?php echo e(__('Composition List')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Composition List')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
       <a href="<?php echo e(route('compositionlist.create')); ?>" data-size="lg" data-bs-toggle="tooltip" title="<?php echo e(__('Create')); ?>" data-title="<?php echo e(__('Create Composition List Form Sample')); ?>" class="btn btn-sm btn-primary">
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
                            <th scope="col"><?php echo e(__('Main Item')); ?></th>
                            <th scope="col"><?php echo e(__('Total CompItems')); ?></th>
                            <th scope="col"><?php echo e(__('Action')); ?></th>
                        </tr>
                        </thead>
                        <tbody class="list">
                        <?php $__currentLoopData = $compositionslistitems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $compositionlistitem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e(\App\Models\ProductService::where('kraItemCode', $compositionlistitem->mainItemCode)->first()->itemNm ?? null); ?> </td>
                                <td><?php echo e($compositionlistitem->compositionItems_count ?? null); ?></td>

                                 <?php if(Gate::check('edit purchase') || Gate::check('delete purchase') || Gate::check('show purchase')): ?>
                                        <td class="Action">
                                            <span>
                                                 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show purchase')): ?>
                                                    <div class="action-btn bg-warning ms-2">
                                                        <a href="<?php echo e(route('compositionlist.show', $compositionlistitem->id)); ?>"
                                                           class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                           data-bs-whatever="<?php echo e(__('View composition list items')); ?>" data-bs-toggle="tooltip"
                                                           data-bs-original-title="<?php echo e(__('View')); ?>"> 
                                                           <span class="text-white"><i class="ti ti-eye"></i></span></a>
                                                    </div>
                                                <?php endif; ?>
                                            </span>
                                        </td>
                                    <?php endif; ?>
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp-go-6.4-using-laravel\resources\views/compositionlist/index.blade.php ENDPATH**/ ?>