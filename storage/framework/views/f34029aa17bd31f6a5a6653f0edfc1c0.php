<?php echo e(Form::open(array('url' => 'apiinitialization','enctype'=>"multipart/form-data"))); ?>

<div class="modal-body">
    
    <?php
        $plan= \App\Models\Utility::getChatGPTSettings();
    ?>
    <?php if($plan->chatgpt == 1): ?>
    <div class="text-end">
        <a href="#" data-size="md" class="btn  btn-primary btn-icon btn-sm" data-ajax-popup-over="true" data-url="<?php echo e(route('generate',['apiinitialization'])); ?>"
           data-bs-placement="top" data-title="<?php echo e(__('Generate content with AI')); ?>">
            <i class="fas fa-robot"></i> <span><?php echo e(__('Generate with AI')); ?></span>
        </a>
    </div>
    <?php endif; ?>
    
    <div class="row">
        <div class="form-group col-md-12">
            <?php echo e(Form::label('taxpayeridno', __('TaxPayer ID'),['class'=>'form-label'])); ?>

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
    <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn btn-primary">
</div>
    <?php echo e(Form::close()); ?>





<script>
    // document.getElementById('attachment').onchange = function () {
    //     var src = URL.createObjectURL(this.files[0])
    //     document.getElementById('image').src = src
    // }
</script>
<?php /**PATH /home/chrisdroid/Desktop/projects/php/erp-go-6.4-using-laravel/resources/views/apiinitialization/create.blade.php ENDPATH**/ ?>