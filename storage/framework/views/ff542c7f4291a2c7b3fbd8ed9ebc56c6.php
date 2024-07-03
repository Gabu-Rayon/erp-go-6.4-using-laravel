<?php echo e(Form::open(array('url'=>'branch','method'=>'post'))); ?>

    <div class="modal-body">
        <div class="row">
            <div class="form-group col-6">
                <?php echo e(Form::label('bhfNm',__('Branch Name'),['class'=>'form-label'])); ?>

                <?php echo e(Form::text('bhfNm',null,array('class'=>'form-control','placeholder'=>__('Enter Branch Name')))); ?>

            </div>
            <div class="form-group col-6">
                <?php echo e(Form::label('bhfId',__('Branch ID'),['class'=>'form-label'])); ?>

                <?php echo e(Form::text('bhfId',null,array('class'=>'form-control','placeholder'=>__('Enter Branch ID')))); ?>

            </div>
            <div class="form-group col-6">
                <?php echo e(Form::label('tin',__('Branch TIN'),['class'=>'form-label'])); ?>

                <?php echo e(Form::text('tin',null,array('class'=>'form-control','placeholder'=>__('Enter Branch TIN')))); ?>

            </div>
            <div class="form-group col-6">
                <?php echo e(Form::label('bhfSttsCd', __('Branch Status'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::select('bhfSttsCd', ['01' => 'Active', '00' => 'Inactive'], null, ['class' => 'form-control'])); ?>

            </div>
            <div class="form-group col-6">
                <?php echo e(Form::label('prvncNm', __('Province Name'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::text('prvncNm', '', ['class' => 'form-control'])); ?>

            </div>
            <div class="form-group col-6">
                <?php echo e(Form::label('dstrtNm', __('District Name'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::text('dstrtNm', '', ['class' => 'form-control'])); ?>

            </div>
            <div class="form-group col-6">
                <?php echo e(Form::label('sctrNm', __('SCTR Name'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::text('sctrNm', '', ['class' => 'form-control'])); ?>

            </div>
            <div class="form-group col-6">
                <?php echo e(Form::label('locDesc', __('LOC DESC'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::text('locDesc', '', ['class' => 'form-control'])); ?>

            </div>
            <div class="form-group col-6">
                <?php echo e(Form::label('mgrNm', __('Manager Name'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::text('mgrNm', '', ['class' => 'form-control'])); ?>

            </div>
            <div class="form-group col-6">
                <?php echo e(Form::label('mgrTelNo', __('Manager Contact'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::text('mgrTelNo', '', ['class' => 'form-control'])); ?>

            </div>
            <div class="form-group col-6">
                <?php echo e(Form::label('mgrEmail', __('Manager Email'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::text('mgrEmail', '', ['class' => 'form-control'])); ?>

            </div>
            <div class="form-group col-6">
                <?php echo e(Form::label('hqYn', __('HeadQuarter?'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::select('hqYn', ['Y' => 'Yes', 'N' => 'No'], null, ['class' => 'form-control'])); ?>

            </div>
        </div>
    </div>
    <div class="modal-footer">
        <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn btn-light" data-bs-dismiss="modal">
        <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn  btn-primary">
    </div>
<?php echo e(Form::close()); ?><?php /**PATH C:\xampp\htdocs\erp-go-6.4-using-laravel\resources\views/branch/create.blade.php ENDPATH**/ ?>