<?php $__env->startPush('script-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Stock Move List')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="mb-0 h4 d-inline-block font-weight-400 "><?php echo e(__('Stock Move List')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Stock Move List')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
        <div class="mb-4 d-inline-block">
            <?php echo e(Form::open(['route' => 'stockmove.searchByDate', 'method' => 'POST', 'class' => 'w-100'])); ?>

            <?php echo csrf_field(); ?>
            <div class="form-group">
                <?php echo e(Form::label('SearchByDate', __('Search By Date'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::date('searchByDate', null, ['class' => 'form-control', 'required' => 'required'])); ?>

            </div>
            <button type="submit" class="btn btn-primary sync"><?php echo e(__('Search')); ?></button>
            <?php echo e(Form::close()); ?>

        </div>
        <!-- <a href="#" data-url="<?php echo e(route('stockinfo.create')); ?>" class="btn btn-sm btn-primary" data-ajax-popup="true" data-bs-toggle="tooltip" title="<?php echo e(__('Update Stock By Invoice Number')); ?>">
                                            Update Stock By Invoice Number
                                        </a> -->
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
                                    <th scope="col"><?php echo e(__('From')); ?></th>
                                    <th scope="col"><?php echo e(__('To')); ?></th>
                                    <th scope="col"><?php echo e(__('Product')); ?></th>
                                    <th scope="col"><?php echo e(__('Quantity')); ?></th>
                                    <th scope="col"><?php echo e(__('Package Quantity')); ?></th>
                                    <th scope="col"><?php echo e(__('Action')); ?></th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                <?php $__currentLoopData = $branchTransfer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transfer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $__currentLoopData = $transfer->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($transfer->fromBranch->name); ?></td>
                                            <td><?php echo e($transfer->toBranch->name); ?></td>
                                            <td><?php echo e($product->name); ?></td>
                                            <td><?php echo e($product->pivot->quantity); ?></td>
                                            <td><?php echo e($product->pivot->package_quantity); ?></td>
                                            <td>
                                                <a href="<?php echo e(route('stockmove.show', $transfer->id)); ?>"
                                                    class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                                                    title="<?php echo e(__('View')); ?>">
                                                    <i class="fas fa-eye fa-sm"></i>
                                                </a>
                                                <a href="<?php echo e(route('stockmove.edit', $transfer->id)); ?>"
                                                    class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                                                    title="<?php echo e(__('Edit')); ?>">
                                                    <i class="fas fa-pencil-alt fa-sm"></i>
                                                </a>
                                                <a href="#"
                                                    data-url="<?php echo e(route('stockmove.destroy', $transfer->id)); ?>"
                                                    data-branch="<?php echo e($transfer->fromBranch->name); ?>"
                                                    data-product="<?php echo e($product->name); ?>"
                                                    class="btn btn-sm btn-danger delete-alert" data-bs-toggle="tooltip"
                                                    title="<?php echo e(__('Delete')); ?>">
                                                    <i class="fas fa-trash fa-sm"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/chris-droid/Desktop/projects/erp-go-6.4-using-laravel/resources/views/stockinfo/index.blade.php ENDPATH**/ ?>