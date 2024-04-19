<?php echo e(Form::open(array('url' => 'compositionlist','enctype'=>"multipart/form-data"))); ?>

<div class="modal-body">
    
    <?php
        $plan= \App\Models\Utility::getChatGPTSettings();
    ?>
    <?php if($plan->chatgpt == 1): ?>
    <div class="text-end">
        <a href="#" data-size="md" class="btn  btn-primary btn-icon btn-sm" data-ajax-popup-over="true" data-url="<?php echo e(route('generate',['compositionlist'])); ?>"
           data-bs-placement="top" data-title="<?php echo e(__('Generate content with AI')); ?>">
            <i class="fas fa-robot"></i> <span><?php echo e(__('Generate with AI')); ?></span>
        </a>
    </div>
    <?php endif; ?>
    
    <div class="row">
        <div class="form-group col-md-12">
            <?php echo e(Form::label('main_item_code', __('Main Item Code'),['class'=>'form-label'])); ?>

            <?php echo e(Form::text('main_item_code', '', array('class' => 'form-control ','required'=>'required'))); ?>

        </div>
        <div class="form-group col-md-12">
            <?php echo e(Form::label('composition_item_code', __('Composition Item Code'),['class'=>'form-label'])); ?>

            <?php echo e(Form::text('composition_item_code[]', '', array('class' => 'form-control ','required'=>'required'))); ?>

        </div>
        <div class="form-group col-md-12">
            <?php echo e(Form::label('composition_item_quantity', __('Composition Item Quantity'),['class'=>'form-label'])); ?>

            <?php echo e(Form::number('composition_item_quantity[]', '', array('class' => 'form-control ','required'=>'required'))); ?>

        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn btn-primary">
</div>
    <?php echo e(Form::close()); ?>


<?php /**PATH C:\xampp\htdocs\erp-go-6.4-using-laravel\resources\views/compositionlist/create.blade.php ENDPATH**/ ?>