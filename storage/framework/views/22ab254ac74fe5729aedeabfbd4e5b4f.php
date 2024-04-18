<?php $__env->startPush('script-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('API Initialization')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0 "><?php echo e(__('API Initialization')); ?></h5>
    </div>Support
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('API Initialization')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
       <a href="#" data-size="lg" data-url="<?php echo e(route('apiinitialization.create')); ?>" data-ajax-popup="true" data-bs-toggle="tooltip" title="<?php echo e(__('Create')); ?>" data-title="<?php echo e(__('Create API Initialization')); ?>" class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>
    </div>
    <div class="float-end">
       <a href="#" data-size="lg" data-url="<?php echo e(route('apiinitialization.create')); ?>" data-ajax-popup="true" data-bs-toggle="tooltip" title="<?php echo e(__('Add Existing Initialization')); ?>" data-title="<?php echo e(__('Add Existing API Initialization')); ?>" class="btn btn-sm btn-primary">
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
                            <th scope="col"><?php echo e(__('Code')); ?></th>
                            <th scope="col"><?php echo e(__('Name')); ?></th>
                            <th scope="col"><?php echo e(__('DVC SrlNo')); ?></th>
                            <th scope="col"><?php echo e(__('Level')); ?></th>
                            <th scope="col"><?php echo e(__('Mapping')); ?></th>
                            <th scope="col"><?php echo e(__('Action')); ?></th>
                        </tr>
                        </thead>
                        <tbody class="list">
                        <?php $__currentLoopData = $itemclassifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $itemclassification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td><?php echo e($itemclassification->id); ?></td>
                                <td><?php echo e($itemclassification->itemClsCd); ?></td>
                                <td><?php echo e($itemclassification->itemClsNm); ?></td>
                                <td><?php echo e($itemclassification->itemClsLvl); ?></td>
                                <td><?php echo e($itemclassification->taxprNm); ?></td>
                                <td>
                                    <?php if($apiinitialization->hqYn == 'Y'): ?>
                                        <span class="btn btn-sm btn-success">Default</span>
                                    <?php else: ?>
                                        <span></span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <div class="action-btn bg-warning ms-2">
                                        <a
                                            href="#"
                                            class="mx-3 btn btn-sm align-items-center"
                                            data-url="<?php echo e(route('apiinitialization.create',$apiinitialization->id)); ?>"
                                            data-ajax-popup="true" data-bs-toggle="tooltip"
                                            title="<?php echo e(__('API Initialization Details')); ?>"
                                            data-title="<?php echo e(__('API Initialization Details')); ?>"
                                        >
                                            <i class="ti ti-eye text-white"></i>
                                        </a>
                                    </div>
                                    <div class="action-btn bg-info ms-2">
                                        <a href="#" class="mx-3 btn btn-sm  align-items-center" data-url="<?php echo e(route('apiinitialization.create',$apiinitialization->id)); ?>" data-ajax-popup="true"  data-size="lg " data-bs-toggle="tooltip" title="<?php echo e(__('Edit')); ?>"  data-title="<?php echo e(__('Edit API Initialization')); ?>">
                                            <i class="ti ti-pencil text-white"></i>
                                            </a>
                                    </div>
                                </td>
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


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/chrisdroid/Desktop/projects/php/erp-go-6.4-using-laravel/resources/views/itemclassificationcode/index.blade.php ENDPATH**/ ?>