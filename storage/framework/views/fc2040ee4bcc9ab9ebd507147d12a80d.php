  <?php echo e(Form::open(['url' => 'productservice', 'enctype' => 'multipart/form-data'])); ?>

  <div class="modal-body">
      
      <?php
          $plan = \App\Models\Utility::getChatGPTSettings();
      ?>
      <?php if($plan->chatgpt == 1): ?>
          <div class="text-end">
              <a href="#" data-size="md" class="btn  btn-primary btn-icon btn-sm" data-ajax-popup-over="true"
                  data-url="<?php echo e(route('generate', ['productservice'])); ?>" data-bs-placement="top"
                  data-title="<?php echo e(__('Generate content with AI')); ?>">
                  <i class="fas fa-robot"></i> <span><?php echo e(__('Generate with AI')); ?></span>
              </a>
          </div>
      <?php endif; ?>
      

      <div class="row">
          <div class="col-md-6">
              <div class="form-group">
                  <?php echo e(Form::label('name', __('Name'), ['class' => 'form-label'])); ?><span class="text-danger">*</span>
                  <?php echo e(Form::text('name', '', ['class' => 'form-control', 'required' => 'required'])); ?>

              </div>
          </div>
           <div class="col-md-6">
              <div class="form-group">
                  <?php echo e(Form::label('standard_name', __('Standard Name'), ['class' => 'form-label'])); ?><span class="text-danger">*</span>
                  <?php echo e(Form::text('standard_name', '', ['class' => 'form-control', 'required' => 'required'])); ?>

              </div>
          </div>

          <div class="col-md-6">
              <div class="form-group">
                  <?php echo e(Form::label('sku', __('SKU'), ['class' => 'form-label'])); ?><span class="text-danger">*</span>
                  <?php echo e(Form::text('sku', '', ['class' => 'form-control', 'required' => 'required'])); ?>

              </div>
          </div>
            <div class="col-md-6">
              <div class="form-group">
                  <?php echo e(Form::label('product_type_code', __('Product Type Code'), ['class' => 'form-label'])); ?><span class="text-danger">*</span>
                  <?php echo e(Form::text('product_type_code', '', ['class' => 'form-control', 'required' => 'required'])); ?>

              </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                  <?php echo e(Form::label('product_classified_code', __('Product Classified Code'), ['class' => 'form-label'])); ?><span class="text-danger">*</span>
                  <?php echo e(Form::text('product_classified_code', '', ['class' => 'form-control', 'required' => 'required'])); ?>

              </div>
          </div>

          <div class="form-group col-md-6">
              <?php echo e(Form::label('country_code', __('Country Code'), ['class' => 'form-label'])); ?>

              <select name="country_code" class="form-control" required="required">
                  <option value="">Select Country Code</option>
                  <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($country['alpha3_code']); ?>"><?php echo e($country['name']); ?> -
                          (<?php echo e($country['alpha3_code']); ?>)</option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                  <?php echo e(Form::label('batch_no', __('Batch No'), ['class' => 'form-label'])); ?><span class="text-danger">*</span>
                  <?php echo e(Form::text('batch_no', '', ['class' => 'form-control', 'required' => 'required','placeholder' =>'BNO2001'])); ?>

              </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                  <?php echo e(Form::label('bar_code', __('Bar Code'), ['class' => 'form-label'])); ?><span class="text-danger">*</span>
                  <?php echo e(Form::text('bar_no', '', ['class' => 'form-control', 'required' => 'required','placeholder' =>'BRC2001'])); ?>

              </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                  <?php echo e(Form::label('sale_price', __('Sale Price'), ['class' => 'form-label'])); ?><span
                      class="text-danger">*</span>
                  <?php echo e(Form::number('sale_price', '', ['class' => 'form-control', 'required' => 'required', 'step' => '0.01'])); ?>

              </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                  <?php echo e(Form::label('group1_unit_price', __('Group 1 Unit Price'), ['class' => 'form-label'])); ?><span
                      class="text-danger">*</span>
                  <?php echo e(Form::number('group1_unit_price', '', ['class' => 'form-control', 'required' => 'required', 'step' => '0.01'])); ?>

              </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                  <?php echo e(Form::label('group2_unit_price', __('Group 2 Unit Price'), ['class' => 'form-label'])); ?><span
                      class="text-danger">*</span>
                  <?php echo e(Form::number('group2_unit_price', '', ['class' => 'form-control', 'required' => 'required', 'step' => '0.01'])); ?>

              </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                  <?php echo e(Form::label('group3_unit_price', __('Group 3 Unit Price'), ['class' => 'form-label'])); ?><span
                      class="text-danger">*</span>
                  <?php echo e(Form::number('group3_unit_price', '', ['class' => 'form-control', 'required' => 'required', 'step' => '0.01'])); ?>

              </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                  <?php echo e(Form::label('group4_unit_price', __('Group 4 Unit Price'), ['class' => 'form-label'])); ?><span
                      class="text-danger">*</span>
                  <?php echo e(Form::number('group4_unit_price', '', ['class' => 'form-control', 'required' => 'required', 'step' => '0.01'])); ?>

              </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                  <?php echo e(Form::label('group5_unit_price', __('Group 5 Unit Price'), ['class' => 'form-label'])); ?><span
                      class="text-danger">*</span>
                  <?php echo e(Form::number('group5_unit_price', '', ['class' => 'form-control', 'required' => 'required', 'step' => '0.01'])); ?>

              </div>
          </div>
                    <div class="col-md-6">
              <div class="form-group">
                  <?php echo e(Form::label('opening_balance', __('Opening Balance'), ['class' => 'form-label'])); ?><span class="text-danger">*</span>
                  <?php echo e(Form::text('opening_balance', '', ['class' => 'form-control', 'required' => 'required','placeholder' =>'4500'])); ?>

              </div>
          </div>
          <div class="form-group col-md-6">
              <?php echo e(Form::label('sale_chartaccount_id', __('Income Account'), ['class' => 'form-label'])); ?>

              <select name="sale_chartaccount_id" class="form-control" required="required">
                  <?php $__currentLoopData = $incomeChartAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $chartAccount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($key); ?>" class="subAccount"><?php echo e($chartAccount); ?></option>
                      <?php $__currentLoopData = $incomeSubAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subAccount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <?php if($key == $subAccount['account']): ?>
                              <option value="<?php echo e($subAccount['id']); ?>" class="ms-5"> &nbsp; &nbsp;&nbsp;
                                  <?php echo e($subAccount['code_name']); ?></option>
                          <?php endif; ?>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                  <?php echo e(Form::label('purchase_price', __('Purchase Price'), ['class' => 'form-label'])); ?><span
                      class="text-danger">*</span>
                  <?php echo e(Form::number('purchase_price', '', ['class' => 'form-control', 'required' => 'required', 'step' => '0.01'])); ?>

              </div>
          </div>
          <div class="form-group col-md-6">
              <?php echo e(Form::label('expense_chartaccount_id', __('Expense Account'), ['class' => 'form-label'])); ?>

              <select name="expense_chartaccount_id" class="form-control" required="required">
                  <?php $__currentLoopData = $expenseChartAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $chartAccount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($key); ?>" class="subAccount"><?php echo e($chartAccount); ?></option>
                      <?php $__currentLoopData = $expenseSubAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subAccount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <?php if($key == $subAccount['account']): ?>
                              <option value="<?php echo e($subAccount['id']); ?>" class="ms-5"> &nbsp; &nbsp;&nbsp;
                                  <?php echo e($subAccount['code_name']); ?></option>
                          <?php endif; ?>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
          </div>

          <div class="form-group col-md-6">
              <?php echo e(Form::label('tax_id', __('Tax'), ['class' => 'form-label'])); ?>

              <?php echo e(Form::select('tax_id[]', $tax, null, ['class' => 'form-control select2', 'id' => 'choices-multiple1', 'multiple'])); ?>

          </div>
          <div class="form-group col-md-6">
              <?php echo e(Form::label('category_id', __('Category'), ['class' => 'form-label'])); ?><span
                  class="text-danger">*</span>
              <?php echo e(Form::select('category_id', $category, null, ['class' => 'form-control select', 'required' => 'required'])); ?>


              <div class=" text-xs">
                  <?php echo e(__('Please add constant category. ')); ?><a
                      href="<?php echo e(route('product-category.index')); ?>"><b><?php echo e(__('Add Category')); ?></b></a>
              </div>
          </div>
          <div class="form-group col-md-6">
              <?php echo e(Form::label('unit_id', __('Unit'), ['class' => 'form-label'])); ?><span class="text-danger">*</span>
              <?php echo e(Form::select('unit_id', $unit, null, ['class' => 'form-control select', 'required' => 'required'])); ?>

          </div>
          <div class="col-md-6 form-group">
              <?php echo e(Form::label('pro_image', __('Product Image'), ['class' => 'form-label'])); ?>

              <div class="choose-file ">
                  <label for="pro_image" class="form-label">
                      <input type="file" class="form-control" name="pro_image" id="pro_image"
                          data-filename="pro_image_create">
                      <img id="image" class="mt-3" style="width:25%;" />

                  </label>
              </div>
          </div>



          <div class="col-md-6">
              <div class="form-group">
                  <div class="btn-box">
                      <label class="d-block form-label"><?php echo e(__('Type')); ?></label>
                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-check form-check-inline">
                                  <input type="radio" class="form-check-input type" id="customRadio5" name="type"
                                      value="product" checked="checked">
                                  <label class="custom-control-label form-label"
                                      for="customRadio5"><?php echo e(__('Product')); ?></label>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-check form-check-inline">
                                  <input type="radio" class="form-check-input type" id="customRadio6" name="type"
                                      value="service">
                                  <label class="custom-control-label form-label"
                                      for="customRadio6"><?php echo e(__('Service')); ?></label>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>

          <div class="form-group col-md-6 quantity">
              <?php echo e(Form::label('quantity', __('Quantity'), ['class' => 'form-label'])); ?><span class="text-danger">*</span>
              <?php echo e(Form::text('quantity', null, ['class' => 'form-control'])); ?>

          </div>
          <div class="form-group col-md-6 quantity">
              <?php echo e(Form::label('safety_quantity', __('Safety Quantity'), ['class' => 'form-label'])); ?><span class="text-danger">*</span>
              <?php echo e(Form::text('safety_quantity', null, ['class' => 'form-control','placeholder'=>'2000'])); ?>

          </div>

          <div class="form-group col-md-12">
              <?php echo e(Form::label('description', __('Description'), ['class' => 'form-label'])); ?>

              <?php echo Form::textarea('description', null, ['class' => 'form-control', 'rows' => '2']); ?>

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



  <script>
      document.getElementById('pro_image').onchange = function() {
          var src = URL.createObjectURL(this.files[0])
          document.getElementById('image').src = src
      }

      //hide & show quantity

      $(document).on('click', '.type', function() {
          var type = $(this).val();
          if (type == 'product') {
              $('.quantity').removeClass('d-none')
              $('.quantity').addClass('d-block');
          } else {
              $('.quantity').addClass('d-none')
              $('.quantity').removeClass('d-block');
          }
      });
  </script>
<?php /**PATH C:\xampp\htdocs\erp-go-6.4-using-laravel\resources\views/productservice/create.blade.php ENDPATH**/ ?>