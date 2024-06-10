
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Add Sales Credit Note')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('salescreditnote.index')); ?>"><?php echo e(__('Sales')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(ucwords($sale->traderInvoiceNo)); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
    <script src="<?php echo e(asset('js/jquery-ui.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/jquery.repeater.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card m-3">
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-4">
                    <h5>Invoice Number:</h5>
                    <p><?php echo e($sale->traderInvoiceNo); ?></p>
                </div>
                <div class="form-group col-md-4">
                    <h5>Customer Name:</h5>
                    <p><?php echo e($sale->customerName); ?></p>
                </div>
                <div class="form-group col-md-4">
                    <h5>Total Item Count:</h5>
                    <p><?php echo e(count($items)); ?></p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <?php echo e(Form::open(['url' => 'salescreditnote', 'class' => 'w-100 sales-form'])); ?>

        <div class="col-12">
            <input type="hidden" name="_token" id="token" value="<?php echo e(csrf_token()); ?>">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-3">
                            <?php echo e(Form::label('creditNoteReason', __('Credit Note Reason (*)'),['class'=>'form-label'])); ?>

                            <?php echo e(Form::select('creditNoteReason', $creditNoteReasons, null, ['class' => 'form-control item-name'])); ?>

                        </div>
                        <div class="form-group col-md-3">
                            <?php echo e(Form::label('salesTypeCodes', __('Sales Type Code (*)'),['class'=>'form-label'])); ?>

                            <?php echo e(Form::select('salesTypeCodes', $salesTypeCodes, null, ['class' => 'form-control item-name'])); ?>

                        </div>
                        <?php echo e(\Log::info('PMT TY CDS')); ?>

                        <?php echo e(\Log::info($paymentTypeCodes)); ?>

                        <div class="form-group col-md-3">
                            <?php echo e(Form::label('paymentTypeCodes', __('Payment Type Code (*)'),['class'=>'form-label'])); ?>

                            <?php echo e(Form::select('paymentTypeCodes', $paymentTypeCodes, null, ['class' => 'form-control item-name'])); ?>

                        </div>
                        <div class="form-group col-md-3">
                            <?php echo e(Form::label('invoiceStatusCodes', __('Sales Type'),['class'=>'form-label'])); ?>

                            <?php echo e(Form::select('invoiceStatusCodes', $invoiceStatusCodes, null, ['class' => 'form-control item-name'])); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h6 class="card-title">Items</h6>
                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card-body">
                    <div class="row">
                            <h6 class="card-title text-info text-lg">Item</h6>
                            <div class="col-md-3">
                                <h6><?php echo e(__('Item Name: ')); ?></h6>
                                <p><?php echo e($item->itemName); ?></h6>
                            </div>
                            <div class="col-md-3">
                                <h6><?php echo e(__('Item Code: ')); ?></h6>
                                <p><?php echo e($item->itemCode); ?></h6>
                            </div>
                            <div class="col-md-3">
                                <h6><?php echo e(__('Item Class Code: ')); ?></h6>
                                <p><?php echo e($item->itemClassCode); ?></h6>
                            </div>
                            <div class="col-md-3">
                                <h6><?php echo e(__('Item Type Code: ')); ?></h6>
                                <p><?php echo e($item->itemTypeCode); ?></h6>
                            </div>
                            <div class="col-md-3">
                                <h6><?php echo e(__('Origin Nation Code: ')); ?></h6>
                                <p><?php echo e($item->orgnNatCd); ?></h6>
                            </div>
                            <div class="col-md-3">
                                <h6><?php echo e(__('Tax Type Code: ')); ?></h6>
                                <p><?php echo e($item->taxTypeCode); ?></h6>
                            </div>
                            <div class="col-md-3">
                                <h6><?php echo e(__('Unit Price: ')); ?></h6>
                                <p><?php echo e($item->unitPrice); ?></h6>
                            </div>
                            <div class="col-md-3">
                                <h6><?php echo e(__('ISRCAPLCBYN: ')); ?></h6>
                                <p><?php echo e($item->isrcAplcbYn ? 'True' : 'False'); ?></h6>
                            </div>
                            <div class="col-md-3">
                                <h6><?php echo e(__('Package Unit Code: ')); ?></h6>
                                <p><?php echo e($item->pkgUnitCode); ?></h6>
                            </div>
                            <div class="col-md-3">
                                <h6><?php echo e(__('Package Quantity: ')); ?></h6>
                                <p><?php echo e($item->pkgQuantity); ?></h6>
                            </div>
                            <div class="col-md-3">
                                <h6><?php echo e(__('Quantity Unit Code: ')); ?></h6>
                                <p><?php echo e($item->qtyUnitCd); ?></h6>
                            </div>
                            <div class="col-md-3">
                                <h6><?php echo e(__('Quantity: ')); ?></h6>
                                <p><?php echo e($item->quantity); ?></h6>
                            </div>
                            <div class="col-md-3">
                                <h6><?php echo e(__('Discount Rate: ')); ?></h6>
                                <p><?php echo e($item->discountRate); ?></h6>
                            </div>
                            <div class="col-md-3">
                                <h6><?php echo e(__('Discount Amount: ')); ?></h6>
                                <p><?php echo e($item->discountAmt); ?></h6>
                            </div>
                            <div class="col-md-3">
                                <h6><?php echo e(__('Item Expiry Date: ')); ?></h6>
                                <p><?php echo e($item->itemExprDate); ?></h6>
                            </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" onclick="location.href = '<?php echo e(route('sales.index')); ?>';"
                class="btn btn-light">
            <button type="submit" class="btn  btn-primary thee-one-submit-button"><?php echo e(__('Create')); ?></button>
        </div>
        <?php echo e(Form::close()); ?>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Developer\Desktop\apps\erp-go-6.4-using-laravel\resources\views/salescreditnote/edit.blade.php ENDPATH**/ ?>