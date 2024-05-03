
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Edit Sale')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0"><?php echo e(__('Edit Sale')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('sales.index')); ?>"><?php echo e(__('Sales')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(ucwords($sale->id)); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <?php echo e(Form::open(['url' => 'sales', 'enctype' => 'multipart/form-data'])); ?>

            <div class="modal-body">
                <div class="row">
                <div class="form-group col-md-3">
                        <?php echo e(Form::label('customerNo', __('Customer No'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('customerNo', $sale->customerNo, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>

                    <div class="form-group col-md-3">
                        <?php echo e(Form::label('customerTin', __('Customer Tin'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('customerTin', $sale->customerTin, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>

                    <div class="form-group col-md-3">
                        <?php echo e(Form::label('customerName', __('Customer Name'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('customerName', $sale->customerName, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                    <div class="form-group col-md-3">
                        <?php echo e(Form::label('customerMobileNo', __('Customer Mobile Number'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('customerMobileNo', $sale->customerMobileNo, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                    <div class="form-group col-md-3">
                        <?php echo e(Form::label('salesType', __('Sales Type'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('salesType', $sale->salesType, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                    <div class="form-group col-md-3">
                        <?php echo e(Form::label('paymentType', __('Payment Type'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('paymentType', $sale->paymentType, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                    <div class="form-group col-md-3">
                        <?php echo e(Form::label('traderInvoiceNo', __('Trader Invoice Number'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('traderInvoiceNo', $sale->traderInvoiceNo, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                    <div class="form-group col-md-3">
                        <?php echo e(Form::label('confirmDate', __('Confirm Date'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('confirmDate', $sale->confirmDate, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                    <div class="form-group col-md-3">
                        <?php echo e(Form::label('salesDate', __('Sales Date'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('salesDate', $sale->salesDate, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                    <div class="form-group col-md-3">
                        <?php echo e(Form::label('stockReleseDate', __('Stock Release Date'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('stockReleseDate', $sale->stockReleseDate, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                    <div class="form-group col-md-3">
                        <?php echo e(Form::label('receiptPublishDate', __('Receipt Publish Date'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('receiptPublishDate', $sale->receiptPublishDate, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                    <div class="form-group col-md-3">
                        <?php echo e(Form::label('occurredDate', __('Occurred Date'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('occurredDate', $sale->occurredDate, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                    <div class="form-group col-md-3">
                        <?php echo e(Form::label('invoiceStatusCode', __('Invoice Status Code'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('invoiceStatusCode', $sale->invoiceStatusCode, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                    <div class="form-group col-md-3">
                        <?php echo e(Form::label('mapping', __('Mapping'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('mapping', $sale->mapping, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                    <div class="form-group col-md-3">
                        <?php echo e(Form::label('isPurchaseAccept', __('Purchase Accept'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('isPurchaseAccept', $sale->isPurchaseAccept, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                    <div class="form-group col-md-3">
                        <?php echo e(Form::label('isStockIOUpdate', __('Stock IO Update'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('isStockIOUpdate', $sale->isStockIOUpdate, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                    <div class="form-group col-md-12">
                        <?php echo e(Form::label('remark', __('Remark'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::textarea('remark', $sale->remark, ['class' => 'form-control ', 'required' => 'required', 'rows' => 2])); ?>

                    </div>
                    <div class="form-group col-md-3">
                        <?php echo e(Form::label('totalItemCount', __('Total Item Count'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('totalItemCount', '', ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                    <div class="form-group col-md-3">
                        <?php echo e(Form::label('totalTaxableAmount', __('Total Taxable Amount'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('totalTaxableAmount', '', ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                    <div class="form-group col-md-3">
                        <?php echo e(Form::label('totalTaxAmount', __('Total Tax Amount'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('totalTaxAmount', '', ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                    <div class="form-group col-md-3">
                        <?php echo e(Form::label('totalAmount', __('Total Amount'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('totalAmount', '', ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn btn-light" data-bs-dismiss="modal">
            <input type="submit" value="<?php echo e(__('Edit')); ?>" class="btn btn-primary">
        </div>
        <?php echo e(Form::close()); ?>


    </div>
    </div>
    </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Developer\Desktop\apps\erp-go-6.4-using-laravel\resources\views/sales/edit.blade.php ENDPATH**/ ?>