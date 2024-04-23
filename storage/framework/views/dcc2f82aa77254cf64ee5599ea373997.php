
<?php
    $dir = asset(Storage::url('uploads/plan'));
?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Insurance Plans')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Insurance Plan')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create plan')): ?>
            <a href="#" data-size="lg" data-url="<?php echo e(route('plans.create')); ?>" data-ajax-popup="true" data-bs-toggle="tooltip" title="<?php echo e(__('Create New Insurance')); ?>" data-title="<?php echo e(__('Create New Insurance')); ?>" class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>
        <?php endif; ?>
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
                                <th>#</th>
                                <th> <?php echo e(__('InsuranceCode')); ?></th>
                                <th> <?php echo e(__('InsuranceName')); ?></th>
                                <th> <?php echo e(__('PremiumRate')); ?></th>
                                <th><?php echo e(__('isUsed')); ?></th>
                            </tr>
                            </thead>
                            <tbody>                                
                             <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="font-style">
                                        <td><?php echo e($plan->id); ?></td>
                                        <td><?php echo e($plan->insuranceCode); ?></td>
                                        <td><?php echo e($plan->insuranceName); ?></td>
                                        <td><?php echo e($plan->premiumRate); ?></td>
                                        <td><?php echo e($plan->isUsed ? 'Y' : 'N'); ?>


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

 

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp-go-6.4-using-laravel\resources\views/plan/index.blade.php ENDPATH**/ ?>