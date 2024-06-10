
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
        <?php echo e(Form::model($apiinitialization,array('route' => array('apiinitialization.update', $apiinitialization->id), 'method' => 'PUT'))); ?>

            <div class="modal-body">
                <div class="row">
                <div class="form-group col-md-3">
                                <?php echo e(Form::label('tin', __('TIN (PIN) (*)'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('tin', $apiinitialization->tin, array('class' => 'form-control','required'=>'required'))); ?>

                            </div>
                            <div class="form-group col-md-3">
                                <?php echo e(Form::label('bhfNm', __('Branch Office Name'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::select('bhfId', $branches, $apiinitialization->bhfNm, ['class' => 'form-control branchNameField'])); ?>

                            </div>
                            <div class="form-group col-md-3">
                                <?php echo e(Form::label('bhfId', __('Branch ID (*)'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('bhfId', $apiinitialization->bhfId, array('class' => 'form-control branchIdField','required'=>'required','readonly'=>true))); ?>

                            </div>
                            <div class="form-group col-md-3">
                                <?php echo e(Form::label('dvcSrlNo', __('Device Serial Number (*)'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('dvcSrlNo', $apiinitialization->dvcSrlNo, array('class' => 'form-control','required'=>'required'))); ?>

                            </div>
                            <div class="form-group col-md-3">
                                <?php echo e(Form::label('taxprNm', __('Taxpayer Name (*)'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('taxprNm', $apiinitialization->taxprNm, array('class' => 'form-control','required'=>'required'))); ?>

                            </div>
                            <div class="form-group col-md-3">
                                <?php echo e(Form::label('bsnsActv', __('Business Activity'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('bsnsActv', $apiinitialization->bsnsActv, array('class' => 'form-control'))); ?>

                            </div>
                            <div class="form-group col-md-3">
                                <?php echo e(Form::label('bhfOpenDt', __('Branch Open Date'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::date('bhfOpenDt', $apiinitialization->bhfOpenDt, ['class' => 'form-control'])); ?>

                            </div>
                            <div class="form-group col-md-3">
                                <?php echo e(Form::label('prvncNm', __('County Name'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('prvncNm', $apiinitialization->prvncNm, array('class' => 'form-control'))); ?>

                            </div>
                            <div class="form-group col-md-3">
                                <?php echo e(Form::label('dstrtNm', __('Sub County Name'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('dstrtNm', $apiinitialization->dstrtNm, array('class' => 'form-control'))); ?>

                            </div>
                            <div class="form-group col-md-3">
                                <?php echo e(Form::label('sctrNm', __('Tax Locality Name'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('sctrNm', $apiinitialization->sctrNm, array('class' => 'form-control'))); ?>

                            </div>
                            <div class="form-group col-md-3">
                                <?php echo e(Form::label('locDesc', __('Local Description'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('locDesc', $apiinitialization->locDesc, array('class' => 'form-control'))); ?>

                            </div>
                            <div class="form-group col-md-3">
                                <?php echo e(Form::label('hqYn', __('HeadQuarter?'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::select('hqYn', ['Y' => 'Yes', 'N' => 'No'], $apiinitialization->hqYn, ['class' => 'form-control hqYnField'])); ?>

                            </div>
                            <div class="form-group col-md-3">
                                <?php echo e(Form::label('mgrNm', __('Manager Name'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('mgrNm', $apiinitialization->mgrNm, array('class' => 'form-control mgrNmField'))); ?>

                            </div>
                            <div class="form-group col-md-3">
                                <?php echo e(Form::label('mgrTelNo', __('Manager Contact No'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('mgrTelNo', $apiinitialization->mgrTelNo, array('class' => 'form-control mgrTelNoField'))); ?>

                            </div>
                            <div class="form-group col-md-3">
                                <?php echo e(Form::label('mgrEmail', __('Manager Email'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('mgrEmail', $apiinitialization->mgrEmail, array('class' => 'form-control mgrEmailField'))); ?>

                            </div>
                            <div class="form-group col-md-3">
                                <?php echo e(Form::label('dvcId', __('Device ID (*)'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('dvcId', $apiinitialization->dvcId, array('class' => 'form-control','required'=>'required'))); ?>

                            </div>
                            <div class="form-group col-md-4">
                                <?php echo e(Form::label('sdcId', __('Sales Control Unit ID (*)'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('sdcId', $apiinitialization->sdcId, array('class' => 'form-control','required'=>'required'))); ?>

                            </div>
                            <div class="form-group col-md-4">
                                <?php echo e(Form::label('mrcNo', __('MRC No (*)'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('mrcNo', $apiinitialization->mrcNo, array('class' => 'form-control','required'=>'required'))); ?>

                            </div>
                            <div class="form-group col-md-4">
                                <?php echo e(Form::label('cmcKey', __('CMC Key'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('cmcKey', $apiinitialization->cmcKey, array('class' => 'form-control'))); ?>

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


<?php $__env->startPush('script-page'); ?>
    <script>
        const branchNameField = document.querySelector('.branchNameField');
        const branchIdField = document.querySelector('.branchIdField');
        const hqYnField = document.querySelector('.hqYnField');
        const mgrNmField = document.querySelector('.mgrNmField');
        const mgrTelNoField = document.querySelector('.mgrTelNoField');
        const mgrEmailField = document.querySelector('.mgrEmailField');
        branchNameField.addEventListener('change', async function () {
            const url = `http://localhost:8000/getbranchbyname/${this.value}`;
            const response = await fetch(url);
            const { data } = await response.json();
            branchIdField.value = data.bhfId;
            hqYnField.value = data.hqYn;
            mgrNmField.value = data.mgrNm;
            mgrTelNoField.value = data.mgrTelNo;
            mgrEmailField.value = data.mgrEmail;
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Developer\Desktop\apps\erp-go-6.4-using-laravel\resources\views/apiinitialization/edit.blade.php ENDPATH**/ ?>