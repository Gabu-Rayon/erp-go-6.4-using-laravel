
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Get Customer By Pin')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Search Customer')); ?></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Add')); ?></li>
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
                                <th> <?php echo e(__(' SrNo')); ?></th>
                                <th> <?php echo e(__('Tin')); ?></th>
                                <th> <?php echo e(__('TaxprNm')); ?></th>
                                <th><?php echo e(__('TaxprSttsCd')); ?></th>
                                  <th><?php echo e(__('PrvncNm')); ?></th>
                                    <th><?php echo e(__('DstrtNm')); ?></th>
                            </tr>
                            </thead>
                            <tbody>                                
                             <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="font-style">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp-go-6.4-using-laravel\resources\views/customer/customerbypin.blade.php ENDPATH**/ ?>