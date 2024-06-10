
<?php echo e(Form::open(array('url'=>'custom-question','method'=>'post'))); ?>

<div class="modal-body">

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('question',__('Question'),['class'=>'form-label'])); ?>

                <?php echo e(Form::text('question',null,array('class'=>'form-control','placeholder'=>__('Enter question')))); ?>

            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('is_required',__('Is Required'),['class'=>'form-label'])); ?>

                <?php echo e(Form::select('is_required', $is_required,null, array('class' => 'form-control select','required'=>'required'))); ?>

            </div>
        </div>
      
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn  btn-primary">
</div>
<?php echo e(Form::close()); ?>


<?php /**PATH C:\Users\Developer\Desktop\apps\erp-go-6.4-using-laravel\resources\views/customQuestion/create.blade.php ENDPATH**/ ?>