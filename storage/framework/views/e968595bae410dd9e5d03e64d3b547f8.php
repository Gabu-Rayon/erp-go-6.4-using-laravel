
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Purchase')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Insurance insurance')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
            <a href="#" data-size="lg" data-url="<?php echo e(route('insurance.create')); ?>" data-ajax-popup="true"  data-bs-toggle="tooltip" title="<?php echo e(__('Add New Insurance')); ?>"  class="btn btn-sm btn-primary">
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
                                <th>#</th>
                                <th> <?php echo e(__('InsuranceCode')); ?></th>
                                <th> <?php echo e(__('InsuranceName')); ?></th>
                                <th> <?php echo e(__('PremiumRate')); ?></th>
                                <th><?php echo e(__('isUsed')); ?></th>
                            </tr>
                            </thead>
                            <tbody>                                
                             <?php $__currentLoopData = $insurances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $insurance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="font-style">
                                        <td><?php echo e($insurance->id); ?></td>
                                        <td><?php echo e($insurance->insuranceCode); ?></td>
                                        <td><?php echo e($insurance->insuranceName); ?></td>
                                        <td><?php echo e($insurance->premiumRate); ?></td>
                                        <td><?php echo e($insurance->isUsed ? 'Y' : 'N'); ?>


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

 

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\hp\Desktop\projects\erp-go-6.4-using-laravel\resources\views/insurance/index.blade.php ENDPATH**/ ?>