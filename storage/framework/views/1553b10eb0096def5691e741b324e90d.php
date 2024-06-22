<!-- Form for Creating Insurance Plan to Post to Api -->


<?php echo e(Form::open(['url' => 'insurance', 'enctype' => 'multipart/form-data'])); ?>

<div class="modal-body">
    
    <?php
        $settings = \App\Models\Utility::settings();
    ?>
    <?php if(!empty($settings['chat_gpt_key'])): ?>
<div class="text-end">
        <a href="#" data-size="md" class="btn  btn-primary btn-icon btn-sm" data-ajax-popup-over="true" data-url="<?php echo e(route('generate', ['plan'])); ?>"
           data-bs-placement="top" data-title="<?php echo e(__('Generate content with AI')); ?>">
            <i class="fas fa-robot"></i> <span><?php echo e(__('Generate with AI')); ?></span>
        </a>
    </div>
<?php endif; ?>
    
    <div class="row">
        <div class="form-group col-md-6">
            <?php echo e(Form::label('insurance_code', __('Insurance Code'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('insurancecode', null, ['class' => 'form-control font-style', 'placeholder' => __('3447899 '), 'required' => 'required'])); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('insurance_name', __('Insurance Name'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('insurancename', null, ['class' => 'form-control', 'placeholder' => __('Enter Insurance Name')])); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('premium_rate', __('Premium Rate'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::number('premiumrate', null, ['class' => 'form-control', 'placeholder' => __('i.e 100 ,200')])); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('isUsed', __('Used?'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::select('isUsed', [true => 'Yes', false => 'No'], null, ['class' => 'form-control'])); ?>

        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn  btn-primary">
</div>
    <?php echo e(Form::close()); ?> 
<?php /**PATH C:\xampp\htdocs\erp-go-6.4-using-laravel\resources\views/insurance/create.blade.php ENDPATH**/ ?>