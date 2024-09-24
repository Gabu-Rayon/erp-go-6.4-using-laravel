<?php echo e(Form::open(array('url' => 'apiinitialization','enctype'=>"multipart/form-data"))); ?>

    <div class="modal-body">
        <div class="row">
            <div class="form-group col-md-12">
                <?php echo e(Form::label('taxpayeridno', __('Tin'),['class'=>'form-label'])); ?>

                <?php echo e(Form::text('taxpayeridno', '', array('class' => 'form-control ','required'=>'required'))); ?>

            </div>
            <div class="form-group col-md-12">
                <?php echo e(Form::label('bhfId', __('BHF ID'),['class'=>'form-label'])); ?>

                <?php echo e(Form::text('bhfId', '', array('class' => 'form-control ','required'=>'required'))); ?>

            </div>
            <div class="form-group col-md-12">
                <?php echo e(Form::label('devicesrlno', __('Device Serial Number'),['class'=>'form-label'])); ?>

                <?php echo e(Form::text('devicesrlno', '', array('class' => 'form-control ','required'=>'required'))); ?>

            </div>
        </div>
    </div>
    <div class="modal-footer">
        <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn btn-light" data-bs-dismiss="modal">
        <input type="submit" value="<?php echo e(__('Send')); ?>" class="btn btn-primary">
    </div>
<?php echo e(Form::close()); ?>

<?php /**PATH /home/chris-droid/Desktop/projects/erp-go-6.4-using-laravel/resources/views/apiinitialization/create.blade.php ENDPATH**/ ?>