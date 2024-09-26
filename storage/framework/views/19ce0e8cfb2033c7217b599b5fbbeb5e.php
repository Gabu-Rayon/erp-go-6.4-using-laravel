
<?php $__env->startPush('script-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Get Stock Move List')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="mb-0 h4 d-inline-block font-weight-400 "><?php echo e(__('Stock Move List')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Get Stock Move List')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
        <div class="d-inline-block mb-4">
            <?php echo e(Form::open(['route' => 'stockmovelist.searchByDate', 'method' => 'POST', 'class' => 'w-100'])); ?>

            <?php echo csrf_field(); ?>
            <div class="form-group">
                <?php echo e(Form::label('SearchByDate', __('Search By Date'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::date('searchByDate', null, ['class' => 'form-control', 'required' => 'required'])); ?>

            </div>
            <button type="submit" class="btn btn-primary sync"><?php echo e(__('Search')); ?></button>
            <?php echo e(Form::close()); ?>

        </div>
        <a href="#" data-size="md" data-bs-toggle="tooltip" title="<?php echo e(__('Import')); ?>"
            data-url="<?php echo e(route('stockmovelist.index')); ?>" data-ajax-popup="true"
            data-title="<?php echo e(__('Import product CSV file')); ?>" class="btn btn-sm btn-primary">
            <i class="ti ti-file-import"></i>
        </a>
        <a href="<?php echo e(route('stockmovelist.index')); ?>" data-bs-toggle="tooltip" title="<?php echo e(__('Export')); ?>"
            class="btn btn-sm btn-primary">
            <i class="ti ti-file-export"></i>
        </a>
        
        <a href="<?php echo e(route('stockmovelist.synchronize')); ?>" class="btn btn-sm btn-primary sync" data-bs-toggle="tooltip"
            title="<?php echo e(__('Synchronize')); ?>">
            Synchronize
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
                                    <th scope="col"><?php echo e(__('CustTin')); ?></th>
                                    <th scope="col"><?php echo e(__('CustBhfId')); ?></th>
                                    <th scope="col"><?php echo e(__('SarNo')); ?></th>
                                    <th scope="col"><?php echo e(__('OcrnDt')); ?></th>
                                    <th scope="col"><?php echo e(__('TotItemCnt')); ?></th>
                                    <th scope="col"><?php echo e(__('Status')); ?></th>
                                    <th scope="col"><?php echo e(__('Action')); ?></th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                <?php $__currentLoopData = $stockMoveList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stockMove): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($stockMove->id); ?></td>
                                        <td><?php echo e($stockMove->custTin); ?></td>
                                        <td><?php echo e($stockMove->custBhfId); ?></td>
                                        <td><?php echo e($stockMove->sarNo); ?></td>
                                        <td><?php echo e($stockMove->ocrnDt); ?></td>
                                        <td><?php echo e($stockMove->totItemCnt); ?></td>
                                        <td><?php echo e($stockMove->status); ?></td>
                                        <td>
                                            <div class="action-btn bg-warning ms-2">
                                                <a href="<?php echo e(route('stockmovelist.show', $stockMove)); ?>"
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp-go-6.4-using-laravel\resources\views/stockgetmovelist/index.blade.php ENDPATH**/ ?>