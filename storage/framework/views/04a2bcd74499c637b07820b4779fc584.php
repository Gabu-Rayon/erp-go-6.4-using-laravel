<?php echo e(Form::model($branch, ['route' => ['branch.update', $branch->id], 'method' => 'PUT'])); ?>

<div class="modal-body">

    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <?php echo e(Form::label('bhfNm', __('Name'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::text('bhfNm', $branch->bhfNm, ['class' => 'form-control'])); ?>

            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <?php echo e(Form::label('bhfId', __('Branch ID'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::text('bhfId', $branch->bhfId, ['class' => 'form-control'])); ?>

            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <?php echo e(Form::label('tin', __('Branch TIN'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::text('tin', $branch->tin, ['class' => 'form-control'])); ?>

            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <?php echo e(Form::label('bhfSttsCd', __('Branch Status'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::select('bhfSttsCd', ['01' => 'Active', '00' => 'Inactive'], $branch->bhfSttsCd == '01' ? '01' : '00', ['class' => 'form-control'])); ?>

            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <?php echo e(Form::label('prvncNm', __('Province Name'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::text('prvncNm', $branch->prvncNm, ['class' => 'form-control'])); ?>

            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <?php echo e(Form::label('dstrtNm', __('District Name'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::text('dstrtNm', $branch->dstrtNm, ['class' => 'form-control'])); ?>

            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <?php echo e(Form::label('sctrNm', __('SCTR Name'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::text('sctrNm', $branch->sctrNm, ['class' => 'form-control'])); ?>

            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <?php echo e(Form::label('locDesc', __('LOC DESC'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::text('locDesc', $branch->locDesc, ['class' => 'form-control'])); ?>

            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <?php echo e(Form::label('mgrNm', __('Manager Name'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::text('mgrNm', $branch->mgrNm, ['class' => 'form-control'])); ?>

            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <?php echo e(Form::label('mgrTelNo', __('Manager Contact'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::text('mgrTelNo', $branch->mgrTelNo, ['class' => 'form-control'])); ?>

            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <?php echo e(Form::label('mgrEmail', __('Manager Email'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::text('mgrEmail', $branch->mgrEmail, ['class' => 'form-control'])); ?>

            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <?php echo e(Form::label('hqYn', __('HeadQuarter?'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::select('hqYn', ['Y' => 'Yes', 'N' => 'No'], $branch->hqYn == 'Y' ? 'Y' : 'N', ['class' => 'form-control'])); ?>

            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="<?php echo e(__('Update')); ?>" class="btn  btn-primary">
</div>

<?php echo e(Form::close()); ?>

<?php /**PATH C:\xampp\htdocs\erp-go-6.4-using-laravel\resources\views/branch/edit.blade.php ENDPATH**/ ?>