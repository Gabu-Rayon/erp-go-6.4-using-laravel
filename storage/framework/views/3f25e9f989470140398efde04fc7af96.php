
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
            <?php echo e(Form::open(['url' => 'apiinitialization', 'enctype' => 'multipart/form-data'])); ?>

            <div class="modal-body">
                
                <?php
                    $plan = \App\Models\Utility::getChatGPTSettings();
                ?>
                <?php if($plan->chatgpt == 1): ?>
                    <div class="text-end">
                        <a href="#" data-size="md" class="btn  btn-primary btn-icon btn-sm"
                            data-ajax-popup-over="true" data-url="<?php echo e(route('generate', ['apiinitialization'])); ?>"
                            data-bs-placement="top" data-title="<?php echo e(__('Generate content with AI')); ?>">
                            <i class="fas fa-robot"></i> <span><?php echo e(__('Generate with AI')); ?></span>
                        </a>
                    </div>
                <?php endif; ?>
                
                <div class="row">
                    <div class="form-group col-md-6">
                        <?php echo e(Form::label('bsnsActv', __('Bsns Actv'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('bsnsActv', $apiinitialization->bsnsActv, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>

                    <div class="form-group col-md-6">
                        <?php echo e(Form::label('bhfNm', __('Bhf Name'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('bhfNm', $apiinitialization->bhfNm, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>

                    <div class="form-group col-md-6">
                        <?php echo e(Form::label('bhfOpenDt', __('bhf Open Date'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('bhfOpenDt', $apiinitialization->bhfOpenDt, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                    <div class="form-group col-md-6">
                        <?php echo e(Form::label('prvncNm', __('Province Name'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('prvncNm', $apiinitialization->prvncNm, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                    <div class="form-group col-md-6">
                        <?php echo e(Form::label('dstrtNm', __('District'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('dstrtNm', $apiinitialization->dstrtNm, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                    <div class="form-group col-md-6">
                        <?php echo e(Form::label('scrtNm', __('Scrt Name'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('sctrNm', $apiinitialization->sctrNm, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                    <div class="form-group col-md-6">
                        <?php echo e(Form::label('locDesc', __('Local Description'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('locDesc', $apiinitialization->locDesc, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                    <div class="form-group col-md-6">
                        <?php echo e(Form::label('hqYn', __('HQ Yn'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('hqYn', $apiinitialization->hqYn, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                    <div class="form-group col-md-6">
                        <?php echo e(Form::label('mgrNm', __('Mgr Name'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('mgrNm', $apiinitialization->mgrNm, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                    <div class="form-group col-md-6">
                        <?php echo e(Form::label('mgrTelNo', __('mgr Tel No'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('mgrTelNo', $apiinitialization->mgrTelNo, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                    <div class="form-group col-md-6">
                        <?php echo e(Form::label('mgrEmail', __('mgrEmail'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('mgrEmail', $apiinitialization->mgrEmail, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                    <div class="form-group col-md-6">
                        <?php echo e(Form::label('dvcId', __('device ID'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('dvcId', $apiinitialization->dvcId, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                    <div class="form-group col-md-6">
                        <?php echo e(Form::label('sdcId', __('SDC ID'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('sdcId', $apiinitialization->sdcId, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                    <div class="form-group col-md-6">
                        <?php echo e(Form::label('devicesrlno', __('MRC NO'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('mrcNo', $apiinitialization->mrcNo, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                    <div class="form-group col-md-6">
                        <?php echo e(Form::label('devicesrlno', __(' CMD Key'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('cmcKey', $apiinitialization->cmcKey, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn btn-light" data-bs-dismiss="modal">
            <input type="submit" value="<?php echo e(__('Send')); ?>" class="btn btn-primary">
        </div>
        <?php echo e(Form::close()); ?>


    </div>
    </div>
    </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp-go-6.4-using-laravel\resources\views/apiinitialization/show.blade.php ENDPATH**/ ?>