
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Sale')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h6 class="h6 d-inline-block font-weight-400 mb-0"><?php echo e(__('Sale')); ?></h6>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('sales.index')); ?>"><?php echo e(__('Sales')); ?></a></li>
    <li class="breadcrumb-item">Details</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
<div class="float-end m-2">
    <a href="<?php echo e(route('sales.index')); ?>" class="btn btn-sm btn-info">
        <?php echo e(__('Back')); ?>

    </a>
</div>
    <div class="float-end m-2">
        <a href="<?php echo e(route('sales.cancel', $sale->id)); ?>" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="<?php echo e(__('Cancel Sale')); ?>">
            <?php echo e(__('Cancel Sale')); ?>

        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <?php echo e(Form::open(['url' => 'sale', 'enctype' => 'multipart/form-data'])); ?>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3">
                        <h6><?php echo e(__('Customer No: ')); ?></h6>
                        <p><?php echo e($sale->customerNo); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Customer TIN: ')); ?></h6>
                        <p><?php echo e($sale->customerTin); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Customer Name: ')); ?></h6>
                        <p><?php echo e($sale->customerName); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Customer Mobile Number: ')); ?></h6>
                        <p><?php echo e($sale->customerMobileNo); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Sales Type: ')); ?></h6>
                        <p><?php echo e($sale->salesType); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Payment Type: ')); ?></h6>
                        <p><?php echo e($sale->paymentType); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Trader Invoice No: ')); ?></h6>
                        <p><?php echo e($sale->traderInvoiceNo); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Confirm Date: ')); ?></h6>
                        <p><?php echo e($sale->confirmDate); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Sales Date: ')); ?></h6>
                        <p><?php echo e($sale->salesDate); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Stock Release Date: ')); ?></h6>
                        <p><?php echo e($sale->stockReleseDate); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Receipt Publish Date: ')); ?></h6>
                        <p><?php echo e($sale->receiptPublishDate); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Occurred Date: ')); ?></h6>
                        <p><?php echo e($sale->occurredDate); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Invoice Status Code: ')); ?></h6>
                        <p><?php echo e($sale->invoiceStatusCode); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Mapping: ')); ?></h6>
                        <p><?php echo e($sale->mapping); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Purchase Accept: ')); ?></h6>
                        <p><?php echo e($sale->isPurchaseAccept ? 'True' : 'False'); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Stock IO Update: ')); ?></h6>
                        <p><?php echo e($sale->isStockIOUpdate ? 'True' : 'False'); ?></h6>
                    </div>
                    <div class="col-md-12">
                        <h6><?php echo e(__('Remark: ')); ?></h6>
                        <p><?php echo e($sale->remark); ?></h6>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title">Items</h6>
                        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo e(\Log::info($item)); ?>

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
        <?php echo e(Form::close()); ?>


    </div>
    </div>
    </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Developer\Desktop\apps\erp-go-6.4-using-laravel\resources\views/sales/show.blade.php ENDPATH**/ ?>