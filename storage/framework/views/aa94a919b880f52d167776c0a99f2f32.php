<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Product & Service Unit')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Unit')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
   <!--  <div class="float-end">
            <a href="#" data-url="<?php echo e(route('product-unit.create')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Create New Unit')); ?>" data-bs-toggle="tooltip" title="<?php echo e(__('Create')); ?>"  class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>
    </div> -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-3">
            <?php echo $__env->make('layouts.account_setup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-9">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('SrNo')); ?></th>
                                    <th><?php echo e(__('Code')); ?></th>
                                    <th><?php echo e(__('Unit/Name')); ?></th>
                                    <th><?php echo e(__('Description')); ?></th>
                                    <th><?php echo e(__('Mapping')); ?></th>
                                    <th><?php echo e(__('Remark')); ?></th>
                                    <th><?php echo e(__('Status')); ?></th>
                                    <th width="10%"><?php echo e(__('Action')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($unit->id); ?></td>

                                    <td><?php echo e($unit->code); ?></td>
                                     <td><?php echo e($unit->name); ?></td>
                                      <td><?php echo e($unit->description); ?></td>
                                       <td><?php echo e($unit->mapping); ?></td>
                                        <td><?php echo e($unit->remark); ?></td>
                                         <td></td>
                                    <td class="Action">
                                        <span>
                                                <div class="action-btn bg-primary ms-2">
                                                    <a href="#" class="mx-3 btn btn-sm align-items-center" data-url="<?php echo e(route('product-unit.edit',$unit->id)); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Edit Unit')); ?>" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>">
                                                <i class="ti ti-pencil text-white"></i>
                                            </a>
                                                </div>
                                                <div class="action-btn bg-danger ms-2">

                                                <?php echo Form::open(['method' => 'DELETE', 'route' => ['product-unit.destroy', $unit->id],'id'=>'delete-form-'.$unit->id]); ?>

                                                    <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('delete-form-<?php echo e($unit->id); ?>').submit();">
                                                        <i class="ti ti-trash text-white"></i>
                                                    </a>
                                                <?php echo Form::close(); ?>

                                                </div>
                                        </span>
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/chris-droid/Desktop/projects/erp-go-6.4-using-laravel/resources/views/productServiceUnit/index.blade.php ENDPATH**/ ?>