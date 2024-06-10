

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Add Existing API Initialization')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('apiinitialization.index')); ?>"><?php echo e(__('API Initializations')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Add Existing API Initialization')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <?php echo e(Form::open(['url' => 'apiinitialization/storeexisting', 'class' => 'w-100'])); ?>

            <div class="col-12">
                <input type="hidden" name="_token" id="token" value="<?php echo e(csrf_token()); ?>">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-3">
                                <?php echo e(Form::label('tin', __('TIN (PIN) (*)'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('tin', '', array('class' => 'form-control','required'=>'required'))); ?>

                            </div>
                            <div class="form-group col-md-3">
                                <?php echo e(Form::label('bhfNm', __('Branch Office Name'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::select('bhfId', $branches, null, ['class' => 'form-control branchNameField'])); ?>

                            </div>
                            <div class="form-group col-md-3">
                                <?php echo e(Form::label('bhfId', __('Branch ID (*)'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('bhfId', '', array('class' => 'form-control branchIdField','required'=>'required','readonly'=>true))); ?>

                            </div>
                            <div class="form-group col-md-3">
                                <?php echo e(Form::label('dvcSrlNo', __('Device Serial Number (*)'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('dvcSrlNo', '', array('class' => 'form-control','required'=>'required'))); ?>

                            </div>
                            <div class="form-group col-md-3">
                                <?php echo e(Form::label('taxPrNm', __('Taxpayer Name (*)'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('taxPrNm', '', array('class' => 'form-control','required'=>'required'))); ?>

                            </div>
                            <div class="form-group col-md-3">
                                <?php echo e(Form::label('bsnsActv', __('Business Activity'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('bsnsActv', '', array('class' => 'form-control'))); ?>

                            </div>
                            <div class="form-group col-md-3">
                                <?php echo e(Form::label('bhfOpenDt', __('Branch Open Date'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::date('bhfOpenDt', null, ['class' => 'form-control'])); ?>

                            </div>
                            <div class="form-group col-md-3">
                                <?php echo e(Form::label('prvncNm', __('County Name'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('prvncNm', '', array('class' => 'form-control'))); ?>

                            </div>
                            <div class="form-group col-md-3">
                                <?php echo e(Form::label('dstrtNm', __('Sub County Name'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('dstrtNm', '', array('class' => 'form-control'))); ?>

                            </div>
                            <div class="form-group col-md-3">
                                <?php echo e(Form::label('sctrNm', __('Tax Locality Name'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('sctrNm', '', array('class' => 'form-control'))); ?>

                            </div>
                            <div class="form-group col-md-3">
                                <?php echo e(Form::label('locDesc', __('Local Description'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('locDesc', '', array('class' => 'form-control'))); ?>

                            </div>
                            <div class="form-group col-md-3">
                                <?php echo e(Form::label('hqYn', __('HeadQuarter?'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::select('hqYn', ['Y' => 'Yes', 'N' => 'No'], null, ['class' => 'form-control hqYnField', 'readonly' => true])); ?>

                            </div>
                            <div class="form-group col-md-3">
                                <?php echo e(Form::label('mgrNm', __('Manager Name'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('mgrNm', '', array('class' => 'form-control mgrNmField', 'readonly' => true))); ?>

                            </div>
                            <div class="form-group col-md-3">
                                <?php echo e(Form::label('mgrTelNo', __('Manager Contact No'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('mgrTelNo', '', array('class' => 'form-control mgrTelNoField', 'readonly' => true))); ?>

                            </div>
                            <div class="form-group col-md-3">
                                <?php echo e(Form::label('mgrEmail', __('Manager Email'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('mgrEmail', '', array('class' => 'form-control mgrEmailField', 'readonly' => true))); ?>

                            </div>
                            <div class="form-group col-md-3">
                                <?php echo e(Form::label('dvcId', __('Device ID (*)'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('dvcId', '', array('class' => 'form-control','required'=>'required'))); ?>

                            </div>
                            <div class="form-group col-md-4">
                                <?php echo e(Form::label('sdcId', __('Sales Control Unit ID (*)'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('sdcId', '', array('class' => 'form-control','required'=>'required'))); ?>

                            </div>
                            <div class="form-group col-md-4">
                                <?php echo e(Form::label('mrcNo', __('MRC No (*)'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('mrcNo', '', array('class' => 'form-control','required'=>'required'))); ?>

                            </div>
                            <div class="form-group col-md-4">
                                <?php echo e(Form::label('cmcKey', __('CMC Key'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('cmcKey', '', array('class' => 'form-control'))); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input
                    type="button"
                    value="<?php echo e(__('Cancel')); ?>"
                    onclick="location.href = '<?php echo e(route('purchase.index')); ?>';"
                    class="btn btn-light"
                    >
                <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn  btn-primary">
            </div>
        <?php echo e(Form::close()); ?>

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
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Developer\Desktop\apps\erp-go-6.4-using-laravel\resources\views/apiinitialization/addexisting.blade.php ENDPATH**/ ?>