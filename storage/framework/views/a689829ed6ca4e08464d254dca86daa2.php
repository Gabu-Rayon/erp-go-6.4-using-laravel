
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('API Initialization')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0"><?php echo e(__('API Initialization')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('apiinitialization.index')); ?>"><?php echo e(__('API Initialization')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(ucwords($apiinitialization->dvcSrlNo)); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-3">
                        <h6>Business Activity</h6>
                        <p><?php echo e($apiinitialization->bsnsActv); ?></p>
                    </div>
                    <div class="form-group col-md-3">
                        <h6>BHF Name</h6>
                        <p><?php echo e($apiinitialization->bhfNm); ?></p>
                    </div>
                    <div class="form-group col-md-3">
                        <h6>BHF Open Date</h6>
                        <p><?php echo e($apiinitialization->bhfOpenDt); ?></p>
                    </div>
                    <div class="form-group col-md-3">
                        <h6>Province</h6>
                        <p><?php echo e($apiinitialization->prvncNm); ?></p>
                    </div>
                    <div class="form-group col-md-3">
                        <h6>District</h6>
                        <p><?php echo e($apiinitialization->dstrtNm); ?></p>
                    </div>
                    <div class="form-group col-md-3">
                        <h6>Tax Locality Name</h6>
                        <p><?php echo e($apiinitialization->sctrNm); ?></p>
                    </div>
                    <div class="form-group col-md-3">
                        <h6>Local Description</h6>
                        <p><?php echo e($apiinitialization->locDesc ? $apiinitialization->locDesc : 'N/A'); ?></p>
                    </div>
                    <div class="form-group col-md-3">
                        <h6>HeadQuarter?</h6>
                        <p><?php echo e($apiinitialization->hqYn == 'Y' ? 'Yes' : 'No'); ?></p>
                    </div>
                    <div class="form-group col-md-3">
                        <h6>Manager Name</h6>
                        <p><?php echo e($apiinitialization->mgrNm); ?></p>
                    </div>
                    <div class="form-group col-md-3">
                        <h6>Manager Contact No</h6>
                        <p><?php echo e($apiinitialization->mgrTelNo); ?></p>
                    </div>
                    <div class="form-group col-md-3">
                        <h6>Manager Email</h6>
                        <p><?php echo e($apiinitialization->mgrEmail); ?></p>
                    </div>
                    <div class="form-group col-md-3">
                        <h6>Device ID</h6>
                        <p><?php echo e($apiinitialization->dvcId); ?></p>
                    </div>
                    <div class="form-group col-md-3">
                        <h6>SDC ID</h6>
                        <p><?php echo e($apiinitialization->sdcId); ?></p>
                    </div>
                    <div class="form-group col-md-3">
                        <h6>MRC NO</h6>
                        <p><?php echo e($apiinitialization->mrcNo); ?></p>
                    </div>
                    <div class="form-group col-md-4">
                        <h6>CMD Key</h6>
                        <p><?php echo e($apiinitialization->cmcKey); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Developer\Desktop\apps\erp-go-6.4-using-laravel\resources\views/apiinitialization/show.blade.php ENDPATH**/ ?>