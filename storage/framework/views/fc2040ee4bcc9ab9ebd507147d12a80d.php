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
                  <?php echo e(Form::label('name', __('Item Name'), ['class' => 'form-label'])); ?><span class="text-danger">*</span>
                  <?php echo e(Form::text('name', '', ['class' => 'form-control', 'required' => 'required'])); ?>

              </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                  <?php echo e(Form::label('standard_name', __('Item Standard Name'), ['class' => 'form-label'])); ?><span
                      class="text-danger">*</span>
                  <?php echo e(Form::text('standard_name', '', ['class' => 'form-control', 'required' => 'required'])); ?>

              </div>
          </div>

          <div class="col-md-6">
              <div class="form-group">
                  <?php echo e(Form::label('item_code', __('Item Code'), ['class' => 'form-label'])); ?><span
                      class="text-danger">*</span>
                  <?php echo e(Form::text('item_code', '', ['class' => 'form-control', 'required' => 'required'])); ?>

              </div>
          </div>
          <div class="form-group col-md-6">
              <?php echo e(Form::label('product_type_code', __('Item Type Code'), ['class' => 'form-label'])); ?>

              <select name="product_type_code" class="form-control" required="required">
                  <option value="">Select Item Type Code</option>
                  <option value="raw material">Raw Material</option>
                  <option value="finished">Finished</option>
                  <option value="service">Service</option>
              </select>
          </div>
          <div class="form-group col-md-6">
              <?php echo e(Form::label('country_code', __('Country Code'), ['class' => 'form-label'])); ?>

              <select name="country_code" class="form-control" required="required">
                  <option value="">Select Country Code</option>
                  <?php $__currentLoopData = $countries_codes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country_code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($country_code['cd']); ?>"><?php echo e($country_code['cdNm']); ?> -
                          (<?php echo e($country_code['cd']); ?>)
                      </option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
          </div>

          <div class="form-group col-md-6">
              <?php echo e(Form::label('item_classifications', __('Item Classifications Code'), ['class' => 'form-label'])); ?>

              <select name="product_classified_code" class="form-control" required="required">
                  <option value="">Select Item Classifications Code</option>
                  <?php $__currentLoopData = $item_classifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item_classification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($item_classification['itemClsCd']); ?>"><?php echo e($item_classification['itemClsNm']); ?>

                          -
                          (<?php echo e($item_classification['itemClsCd']); ?>)
                      </option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                  <?php echo e(Form::label('batch_no', __('Batch No'), ['class' => 'form-label'])); ?><span
                      class="text-danger">*</span>
                  <?php echo e(Form::text('batch_no', '', ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'BNO2001'])); ?>

              </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                  <?php echo e(Form::label('bar_code', __('Bar Code'), ['class' => 'form-label'])); ?><span
                      class="text-danger">*</span>
                  <?php echo e(Form::text('bar_code', '', ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'BRC2001'])); ?>

              </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                  <?php echo e(Form::label('sale_price', __('Default Unit Price'), ['class' => 'form-label'])); ?><span
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
          <div class="form-group col-md-6">
              <?php echo e(Form::label('tax_type_code', __('Tax Type Code'), ['class' => 'form-label'])); ?>

              <select name="tax_type_code" class="form-control" required="required">
                  <option value="">Select Tax Type Code</option>
                  <?php $__currentLoopData = $taxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($tax['cd']); ?>"><?php echo e($tax['cdNm']); ?> -
                          (<?php echo e($tax['cd']); ?>)
                      </option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
          </div>


          <div class="form-group col-md-6">
              <?php echo e(Form::label('used', __('Used / UnUsed (Y/N) (*)'), ['class' => 'form-label'])); ?>

              <select name="used" class="form-control" required="required">
                  <option value="true">Y</option>
                  <option value="false">N</option>
              </select>
          </div>

          <div class="form-group col-md-6">
              <?php echo e(Form::label('insurance_applicable', __('Insurance Applicable (Y/N) (*)'), ['class' => 'form-label'])); ?>

              <select name="insurance_applicable" class="form-control" required="required">
                  <option value="true">Y</option>
                  <option value="false">N</option>
              </select>
          </div>


          <div class="form-group col-md-6 quantity">
              <?php echo e(Form::label('pkg_unit_code', __('package Unit Code'), ['class' => 'form-label'])); ?><span
                  class="text-danger">*</span>
              <?php echo e(Form::text('pkg_unit_code', null, ['class' => 'form-control', 'placeholder' => 'BR'])); ?>

          </div>
          <div class="form-group col-md-6 quantity">
              <?php echo e(Form::label('qty_unit_code', __('Quantity Unit Code'), ['class' => 'form-label'])); ?><span
                  class="text-danger">*</span>
              <?php echo e(Form::text('qty_unit_code', null, ['class' => 'form-control', 'placeholder' => 'KWT'])); ?>

          </div>
          <div class="form-group col-md-6 quantity">
              <?php echo e(Form::label('quantity', __('Quantity'), ['class' => 'form-label'])); ?><span
                  class="text-danger">*</span>
              <?php echo e(Form::text('quantity', null, ['class' => 'form-control'])); ?>

          </div>
          <div class="form-group col-md-6 quantity">
              <?php echo e(Form::label('safety_quantity', __('Safety Quantity'), ['class' => 'form-label'])); ?><span
                  class="text-danger">*</span>
              <?php echo e(Form::text('safety_quantity', null, ['class' => 'form-control', 'placeholder' => '2000'])); ?>

          </div>

          <div class="form-group col-md-12">
              <?php echo e(Form::label('description', __('Additional Information'), ['class' => 'form-label'])); ?>

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


  <?php $__env->startPush('script-page'); ?>
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

          // Function to filter options based on input value
      </script>
  <?php $__env->stopPush(); ?>
<?php /**PATH C:\xampp\htdocs\erp-go-6.4-using-laravel\resources\views/productservice/create.blade.php ENDPATH**/ ?>