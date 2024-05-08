<?php echo e(Form::model($customer,array('route' => array('customer.update', $customer->id), 'method' => 'PUT'))); ?>

<div class="modal-body">

    <h6 class="sub-title"><?php echo e(__('Basic Info')); ?></h6>
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-4">
            <div class="form-group">
                <?php echo e(Form::label('customerName',__('Customer Name'),array('class'=>'form-label'))); ?>

                <?php echo e(Form::text('customerName',$customer->customerName,array('class'=>'form-control','required'=>'required'))); ?>

            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-4">
            <div class="form-group">
                <?php echo e(Form::label('customerNo',__('Customer No'),array('class'=>'form-label'))); ?>

                <?php echo e(Form::text('customerNo',$customer->customerNo,array('class'=>'form-control','required'=>'required'))); ?>

            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-4">
            <div class="form-group">
                <?php echo e(Form::label('customerTin',__('Customer TIN'),['class'=>'form-label'])); ?>

                <?php echo e(Form::text('customerTin',$customer->customerTin,array('class'=>'form-control'))); ?>

            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-4">
            <div class="form-group">
                <?php echo e(Form::label('telNo',__('Customer Mobile No'),['class'=>'form-label'])); ?>

                <?php echo e(Form::text('telNo',$customer->telNo,array('class'=>'form-control','required'=>'required'))); ?>

            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-4">
            <div class="form-group">
                <?php echo e(Form::label('address',__('Address'),['class'=>'form-label'])); ?>

                <?php echo e(Form::text('address',$customer->address,array('class'=>'form-control','required'=>'required'))); ?>

            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-4">
            <div class="form-group">
                <?php echo e(Form::label('email',__('Email'),['class'=>'form-label'])); ?>

                <?php echo e(Form::text('email',$customer->email,array('class'=>'form-control'))); ?>

            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-4">
            <div class="form-group">
                <?php echo e(Form::label('faxNo',__('Fax No'),['class'=>'form-label'])); ?>

                <?php echo e(Form::text('faxNo',$customer->faxNo,array('class'=>'form-control','required'=>'required'))); ?>

            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-4">
            <div class="form-group">
                <?php echo e(Form::label('isUsed',__('Used?'),['class'=>'form-label'])); ?>

                <?php echo e(Form::select('isUsed',[1 => 'Yes', 0 => 'No'], $customer->isUsed, ['class' => 'form-control'])); ?>

            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                <?php echo e(Form::label('mapping',__('Mapping'),['class'=>'form-label'])); ?>

                <?php echo e(Form::text('mapping',$customer->customerMapping,array('class'=>'form-control'))); ?>

            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                <?php echo e(Form::label('customerIsActive',__('Active?'),['class'=>'form-label'])); ?>

                <?php echo e(Form::select('customerIsActive',[1 => 'Yes', 0 => 'No'], $customer->customerIsActive, ['class' => 'form-control'])); ?>

            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="form-group">
                <?php echo e(Form::label('remark',__('Remark'),['class'=>'form-label'])); ?>

                <?php echo e(Form::textarea('remark',$customer->remark,array('class'=>'form-control', 'rows' => '3'))); ?>

            </div>
        </div>
        <?php if(!$customFields->isEmpty()): ?>
            <div class="col-lg-6 col-md-3 col-sm-4">
                <div class="tab-pane fade show" id="tab-2" role="tabpanel">
                    <?php echo $__env->make('customFields.formBuilder', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <h6 class="sub-title"><?php echo e(__('Billing Address')); ?></h6>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-4">
            <div class="form-group">
                <?php echo e(Form::label('customerBillingName',__('Name'),array('class'=>'','class'=>'form-label'))); ?>

                <?php echo e(Form::text('customerBillingName',$customer->customerBillingName,array('class'=>'form-control customerBillingName'))); ?>

            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-4">
            <div class="form-group">
                <?php echo e(Form::label('customerBillingMobileNo',__('Phone'),array('class'=>'form-label'))); ?>

                <?php echo e(Form::text('customerBillingMobileNo',$customer->customerBillingMobileNo,array('class'=>'form-control'))); ?>

            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('customerBillingAddress',__('Address'),array('class'=>'form-label'))); ?>

                <?php echo e(Form::text('customerBillingAddress',$customer->customerBillingAddress,array('class'=>'form-control'))); ?>

            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-4">
            <div class="form-group">
                <?php echo e(Form::label('customerBillingCity',__('City'),array('class'=>'form-label'))); ?>

                <?php echo e(Form::text('customerBillingCity',$customer->customerBillingCity,array('class'=>'form-control'))); ?>

            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-4">
            <div class="form-group">
                <?php echo e(Form::label('customerBillingState',__('State'),array('class'=>'form-label'))); ?>

                <?php echo e(Form::text('customerBillingState',$customer->customerBillingState,array('class'=>'form-control'))); ?>

            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-4">
            <div class="form-group">
                <?php echo e(Form::label('customerBillingCountry',__('Country'),array('class'=>'form-label'))); ?>

                <?php echo e(Form::text('customerBillingCountry',$customer->customerBillingCountry,array('class'=>'form-control'))); ?>

            </div>
        </div>


        <div class="col-lg-6 col-md-6 col-sm-4">
            <div class="form-group">
                <?php echo e(Form::label('customerBillingZip',__('Zip Code'),array('class'=>'form-label'))); ?>

                <?php echo e(Form::text('customerBillingZip',$customer->customerBillingZip,array('class'=>'form-control'))); ?>


            </div>
        </div>

    </div>

    <?php if(App\Models\Utility::getValByName('shipping_display')=='on'): ?>
        <div class="col-md-12 text-end">
            <input type="button" id="billing_data" value="<?php echo e(__('Shipping Same As Billing')); ?>" class="btn btn-primary">
        </div>
        <h6 class="sub-title"><?php echo e(__('Shipping Address')); ?></h6>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-4">
                <div class="form-group">
                    <?php echo e(Form::label('customerShippingName',__('Name'),array('class'=>'form-label'))); ?>

                    <?php echo e(Form::text('customerShippingName',$customer->customerShippingName,array('class'=>'form-control customerShippingName'))); ?>


                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-4">
                <div class="form-group">
                    <?php echo e(Form::label('customerShippingMobileNo',__('Phone'),array('class'=>'form-label'))); ?>

                    <?php echo e(Form::text('customerShippingMobileNo',$customer->customerShippingMobileNo,array('class'=>'form-control'))); ?>


                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <?php echo e(Form::label('customerShippingAddress',__('Address'),array('class'=>'form-label'))); ?>

                    <label class="form-label" for="example2cols1Input"></label>
                    <div class="input-group">
                        <?php echo e(Form::textarea('customerShippingAddress',$customer->customerShippingAddress,array('class'=>'form-control','rows'=>3))); ?>

                    </div>
                </div>
            </div>


            <div class="col-lg-6 col-md-6 col-sm-4">
                <div class="form-group">
                    <?php echo e(Form::label('customerShippingCity',__('City'),array('class'=>'form-label'))); ?>

                    <?php echo e(Form::text('customerShippingCity',$customer->customerShippingCity,array('class'=>'form-control'))); ?>


                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-4">
                <div class="form-group">
                    <?php echo e(Form::label('customerShippingState',__('State'),array('class'=>'form-label'))); ?>

                    <?php echo e(Form::text('customerShippingState',$customer->customerShippingState,array('class'=>'form-control'))); ?>


                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-4">
                <div class="form-group">
                    <?php echo e(Form::label('customerShippingCountry',__('Country'),array('class'=>'form-label'))); ?>

                    <?php echo e(Form::text('customerShippingCountry',$customer->customerShippingCountry,array('class'=>'form-control'))); ?>


                </div>
            </div>


            <div class="col-lg-6 col-md-6 col-sm-4">
                <div class="form-group">
                    <?php echo e(Form::label('customerShippingZip',__('Zip Code'),array('class'=>'form-label'))); ?>

                    <?php echo e(Form::text('customerShippingZip',$customer->customerShippingZip,array('class'=>'form-control'))); ?>

                </div>
            </div>

        </div>
    <?php endif; ?>

</div>
<div class="modal-footer">
    <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="<?php echo e(__('Update')); ?>" class="btn btn-primary">
</div>
<?php echo e(Form::close()); ?><?php /**PATH C:\Users\Developer\Desktop\apps\erp-go-6.4-using-laravel\resources\views/customer/edit.blade.php ENDPATH**/ ?>