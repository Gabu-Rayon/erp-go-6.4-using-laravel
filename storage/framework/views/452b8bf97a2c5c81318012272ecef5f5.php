<?php echo e(Form::open(array('url' => 'stockinfo','enctype'=>"multipart/form-data"))); ?>

<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-12">
            <?php echo e(Form::label('invoiceNo', __('Invoice Number'),['class'=>'form-label'])); ?>

            <?php echo e(Form::text('invoiceNo', '', array('class' => 'form-control ','required'=>'required'))); ?>

        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="<?php echo e(__('Send')); ?>" class="btn btn-primary">
</div>
    <?php echo e(Form::close()); ?>





<script>
    // document.getElementById('attachment').onchange = function () {
    //     var src = URL.createObjectURL(this.files[0])
    //     document.getElementById('image').src = src
    // }
</script>
<?php /**PATH C:\Users\Developer\Desktop\apps\erp-go-6.4-using-laravel\resources\views/stockinfo/create.blade.php ENDPATH**/ ?>