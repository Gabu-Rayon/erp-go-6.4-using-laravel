
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Add Sales Credit Note')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('salescreditnote.index')); ?>"><?php echo e(__('Sales')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(ucwords($invoiceDue->invoice_id)); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-page'); ?>
    <script src="<?php echo e(asset('js/jquery-ui.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/jquery.repeater.min.js')); ?>"></script>
    <script></script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<?php echo e(\Log::info('INVOICE DUE')); ?>

<?php echo e(\Log::info($invoiceDue)); ?>


<?php echo e(Form::open(array('route' => array('invoice.credit.note',$invoice_id),'method'=>'post'))); ?>

    <div class="modal-body">
        <div class="row">
            <div class="form-group col-md-3">
                <?php echo e(Form::label('invoiceNo', __('Invoive No'), ['class' => 'form-label'])); ?>

                <span class="text-danger">*</span>
                <?php echo e(Form::text('invoiceNo', $invoiceDue->response_invoiceNo, array('class' => 'form-control', 'readonly' => true))); ?>

            </div>
            <div class="form-group col-md-3">
                <?php echo e(Form::label('customerName', __('Customer Name'), ['class' => 'form-label'])); ?>

                <span class="text-danger">*</span>
                <?php echo e(Form::text('customerName', $customer->name, array('class' => 'form-control', 'readonly' => true))); ?>

            </div>
            <div class="form-group col-md-3">
                <?php echo e(Form::label('customerID', __('Customer ID'), ['class' => 'form-label'])); ?>

                <span class="text-danger">*</span>
                <?php echo e(Form::text('customerID', $customer->id, array('class' => 'form-control', 'readonly' => true))); ?>

            </div>
            <div class="form-group col-md-3">
                <?php echo e(Form::label('totItemCnt', __('Total Item Count'), ['class' => 'form-label'])); ?>

                <span class="text-danger">*</span>
                <?php echo e(Form::text('totItemCnt', count($invoiceDue->products), array('class' => 'form-control', 'readonly' => true))); ?>

            </div>
            <div class="form-group col-md-3">
                <?php echo e(Form::label('salesType', __('Sales Type'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::select('salesType', $salesTypeCodes, $invoiceDue->saleType, ['class' => 'form-control select2'])); ?>

            </div>
            <div class="form-group col-md-3">
                <?php echo e(Form::label('paymentType', __('Payment Type'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::select('paymentType', $paymentTypeCodes, $invoiceDue->paymentTypeCode, ['class' => 'form-control select2'])); ?>

            </div>
            <div class="form-group col-md-3">
                <?php echo e(Form::label('invoiceStatusCode', __('Invoice Status'), ['class' => 'form-label'])); ?>

                <span class="text-danger">*</span>
                <?php echo e(Form::select('invoiceStatusCode', $invoiceStatusCodes, $invoiceDue->salesSttsCode, ['class' => 'form-control select2', 'required' => true])); ?>

            </div>
            <div class="form-group col-md-3">
                <?php echo e(Form::label('isPurchaseAccept', __('Purchase Accepted?'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::select('isPurchaseAccept', [true => 'Yes', false => 'No'], $invoiceDue->prchrAcptcYn, ['class' => 'form-control select2'])); ?>

            </div>
            <div class="form-group col-md-3">
                <?php echo e(Form::label('traderInvoiceNo', __('Trader Invoice No'), ['class' => 'form-label'])); ?>

                <span class="text-danger">*</span>
                <?php echo e(Form::text('traderInvoiceNo', '', array('class' => 'form-control traderInvoiceNo', 'required' => true))); ?>

            </div>
            <div class="form-group col-md-3">
                <?php echo e(Form::label('confirmDate', __('Confirm Date'),['class'=>'form-label'])); ?>

                <span class="text-danger">*</span>
                <?php echo e(Form::date('confirmDate', $invoiceDue->confirmDate, array('class' => 'form-control', 'required' => 'required'))); ?>

            </div>
            <div class="form-group col-md-3">
                <?php echo e(Form::label('salesDate', __('Sales Date'),['class'=>'form-label'])); ?>

                <span class="text-danger">*</span>
                <?php echo e(Form::date('salesDate', $invoiceDue->salesDate, array('class' => 'form-control', 'required' => 'required'))); ?>

            </div>
            <div class="form-group col-md-3">
                <?php echo e(Form::label('stockReleseDate', __('Stock Release Date'),['class'=>'form-label'])); ?>

                <?php echo e(Form::date('stockReleseDate', $invoiceDue->stockReleaseDate, array('class' => 'form-control'))); ?>

            </div>
            <div class="form-group col-md-3">
                <?php echo e(Form::label('receiptPublishDate', __('Receipt Publish Date'),['class'=>'form-label'])); ?>

                <span class="text-danger">*</span>
                <?php echo e(Form::date('receiptPublishDate', $invoiceDue->receipt_RcptPbctDt, array('class' => 'form-control', 'required' => 'required'))); ?>

            </div>
            <div class="form-group col-md-3">
                <?php echo e(Form::label('occurredDate', __('Occurred Date'),['class'=>'form-label'])); ?>

                <span class="text-danger">*</span>
                <?php echo e(Form::date('occurredDate', '', array('class' => 'form-control', 'required' => 'required'))); ?>

            </div>
            <div class="form-group col-md-3">
                <?php echo e(Form::label('creditNoteDate', __('Credit Note Date'),['class'=>'form-label'])); ?>

                <span class="text-danger">*</span>
                <?php echo e(Form::date('creditNoteDate', '', array('class' => 'form-control'))); ?>

            </div>
            <div class="form-group col-md-3">
                <?php echo e(Form::label('creditNoteReason', __('Credit Note Reason'), ['class' => 'form-label'])); ?>

                <span class="text-danger">*</span>
                <?php echo e(Form::select('creditNoteReason', $creditNoteReasons, null, ['class' => 'form-control select2', 'required' => 'required'])); ?>

            </div>
            <div class="form-group col-md-12">
                <?php echo e(Form::label('remark', __('Remark'),['class'=>'form-label'])); ?>

                <?php echo e(Form::textarea('remark', '', array('class' => 'form-control', 'rows' => '3'))); ?>

            </div>
        </div>
    </div>
    
    <div class="col-12">
        <h5 class="d-inline-block mb-4"><?php echo e(__('Product & Services')); ?></h5>
        <div class="card">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Item</th>
                                <th scope="col">Unit Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Package Quantity</th>
                                <th scope="col">Discount Rate</th>
                                <th scope="col">Discount Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $invoiceDue->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <?php echo e($product->itemName); ?>

                                        <?php echo e(Form::hidden("items[$index][product_id]", $product->id)); ?>

                                    </td>
                                    <td>
                                        <?php echo e(Form::text("items[$index][unitPrice]", $product->price, array('class' => 'form-control', 'required' => true))); ?>

                                    </td>
                                    <td>
                                        <?php echo e(Form::text("items[$index][quantity]", $product->quantity, array('class' => 'form-control', 'required' => true))); ?>

                                    </td>
                                    <td>
                                        <?php echo e(Form::text("items[$index][pkgQuantity]", $product->pkgQuantity, array('class' => 'form-control', 'required' => true))); ?>

                                    </td>
                                    <td>
                                        <?php echo e(Form::text("items[$index][discountRate]", $product->discountRate, array('class' => 'form-control', 'required' => true))); ?>

                                    </td>
                                    <td>
                                        <?php echo e(Form::text("items[$index][discountAmt]", $product->discountAmt, array('class' => 'form-control', 'required' => true))); ?>

                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    

    <div class="modal-footer">
        <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn btn-light" data-bs-dismiss="modal">
        <input type="submit" value="<?php echo e(__('Add')); ?>" class="btn  btn-primary">
    </div>
<?php echo e(Form::close()); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\hp\Desktop\projects\erp-go-6.4-using-laravel\resources\views/creditNote/create.blade.php ENDPATH**/ ?>