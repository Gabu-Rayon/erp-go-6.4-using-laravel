  <div id="success-alert" class="alert alert-success alert-dismissible fade show" style="display: none;" role="alert">
  Composition List created successfully
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

  <?php echo e(Form::open(array('url'=>'postcompositionlist','method'=>'post'))); ?>

  <div class="modal-body">
      
      <?php
          $plan = \App\Models\Utility::getChatGPTSettings();
      ?>
      <?php if($plan->chatgpt == 1): ?>
          <div class="text-end">
              <a href="#" data-size="md" class="btn  btn-primary btn-icon btn-sm" data-ajax-popup-over="true"
                  data-url="<?php echo e(route('generate', ['compositionlist'])); ?>" data-bs-placement="top"
                  data-title="<?php echo e(__('Generate content with AI')); ?>">
                  <i class="fas fa-robot"></i> <span><?php echo e(__('Generate with AI')); ?></span>
              </a>
          </div>
      <?php endif; ?>

      

      <div class="row">
          <div class="col-md-6">
              <div class="form-group">
                  <?php echo e(Form::label('main_item_code', __('Main Item Code'), ['class' => 'form-label'])); ?><span class="text-danger">*</span>
                  <?php echo e(Form::text('main_item_code', '', ['class' => 'form-control', 'required' => 'required'])); ?>

              </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                  <?php echo e(Form::label('composition_item_code', __('Composition Item Code'), ['class' => 'form-label'])); ?><span
                      class="text-danger">*</span>
                  <?php echo e(Form::text('composition_item_code', '', ['class' => 'form-control', 'required' => 'required'])); ?>

              </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                  <?php echo e(Form::label('composition_tem_quantity', __('Composition Item Quantity'), ['class' => 'form-label'])); ?><span
                      class="text-danger">*</span>
                  <?php echo e(Form::number('composition_item_quantity', '', ['class' => 'form-control', 'required' => 'required', 'step' => '0'])); ?>

              </div>
          </div>        

          <?php if(!$customFields->isEmpty()): ?>
              <div class="col-lg-6 col-md-6 col-sm-6">
                  <div class="tab-pane fade show" id="tab-2" role="tabpanel">
                      <?php echo $__env->make('customFields.formBuilder', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                  </div>
              </div>
          <?php endif; ?>
      </div>
  </div>
  <div class="modal-footer">
      <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn  btn-light" data-bs-dismiss="modal">
      <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn  btn-primary">
  </div>
  <?php echo e(Form::close()); ?>



 
<?php /**PATH C:\xampp\htdocs\erp-go-6.4-using-laravel\resources\views/compositionlist/create.blade.php ENDPATH**/ ?>