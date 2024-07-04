

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Transaction Purchase Sale Details')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('purchase.mappedPurchases')); ?>"><?php echo e(__('mappedPurchases')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('mappedPurchases')); ?></li>
    <li class="breadcrumb-item"><?php echo e(__('Details')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="item-section py-2">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-12 d-flex align-items-center justify-content-between justify-content-md-end">
                            <input type="button" value="<?php echo e(__('Go Back')); ?>"
                                onclick="location.href = '<?php echo e(route('purchase.mappedPurchases')); ?>';" class="btn btn-primary">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <strong>Supplier Tin</strong> : <?php echo e($mappedpurchase->mappedPurchaseId); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Invoice No</strong> : <?php echo e($mappedpurchase->invcNo); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Organization Invoice No</strong> :   <?php echo e($mappedpurchase->invcNo); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Supplier Tin</strong> :  <?php echo e($mappedpurchase->supplrTin); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Supplier BhfId</strong> :  <?php echo e($mappedpurchase->supplrBhfId); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Supplier Name</strong> : <?php echo e($mappedpurchase->supplrName); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Supplier Invoice No</strong> : <?php echo e($mappedpurchase->supplrInvcNo); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Purchase Type Code</strong> : <?php echo e($mappedpurchase->purchaseTypeCode); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Receipt Type Code</strong> : <?php echo e($mappedpurchase->rceiptTyCd); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Payment Type Code</strong> : <?php echo e($mappedpurchase->paymentTypeCode); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Purchase Status Code</strong> : <?php echo e($mappedpurchase->purchaseSttsCd); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Confirmed Date</strong> :  <?php echo e($mappedpurchase->confirmDate); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Purchase Date</strong> :  <?php echo e($mappedpurchase->purchaseDate); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Warehouse Date</strong> : <?php echo e($mappedpurchase->warehouseDt); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Cancel Request Date</strong> : <?php echo e($mappedpurchase->cnclReqDt); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Cancel Date</strong> : <?php echo e($mappedpurchase->cnclDt); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Refund Date</strong> : <?php echo e($mappedpurchase->refundDate); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Total Item Count</strong> : <?php echo e($mappedpurchase->totItemCnt); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Taxable Amount A</strong> :  <?php echo e($mappedpurchase->taxblAmtA); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Taxable Amount A</strong> :  <?php echo e($mappedpurchase->taxblAmtB); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Taxable Amount A</strong> :  <?php echo e($mappedpurchase->taxblAmtC); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Taxable Amount A</strong> :   <?php echo e($mappedpurchase->taxblAmtD); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Tax Rate A</strong> : <?php echo e($mappedpurchase->taxRtA); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Tax Rate B</strong> : <?php echo e($mappedpurchase->taxRtB); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Tax Rate C</strong> :  <?php echo e($mappedpurchase->taxRtC); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Tax Rate D</strong> :  <?php echo e($mappedpurchase->taxRtD); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Tax Amount A</strong> :  <?php echo e($mappedpurchase->taxAmtA); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Tax Amount B</strong> : <?php echo e($mappedpurchase->taxAmtB); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Tax Amount C</strong> : <?php echo e($mappedpurchase->taxAmtC); ?>

                        </div>
                         <div class="form-group col-md-4">
                            <strong>Tax Amount D</strong> : <?php echo e($mappedpurchase->taxAmtD); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Total Taxable Amount</strong> :  <?php echo e($mappedpurchase->totTaxblAmt); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Total Tax Amount</strong> : <?php echo e($mappedpurchase->totTaxAmt); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Total Amount</strong> :   <?php echo e($mappedpurchase->totAmt); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Remark</strong> :  <?php echo e($mappedpurchase->remark); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Result</strong> :  <?php echo e($mappedpurchase->resultDt); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Created Date</strong> :  <?php echo e($mappedpurchase->createdDt); ?>

                        </div>
                         <div class="form-group col-md-4">
                            <strong>Is Upload</strong> :  <?php echo e($mappedpurchase->isUpload); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Is Stock IO Update</strong> :  <?php echo e($mappedpurchase->isStockIOUpdate); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Is Client Stock Update</strong> :  <?php echo e($mappedpurchase->isClientStockUpdate); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>

               <div class="col-12">
            <h5 class="d-inline-block mb-4"><?php echo e(__('Product/s Item/s Lists')); ?></h5>
            <?php $__currentLoopData = $mappedpurchaseItemsList->groupBy('itemType'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $itemType => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="row">
                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <strong>Purchase item List Id</strong> :  <?php echo e($item->purchase_item_list_id); ?>

                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Item Sequence No</strong> :  <?php echo e($item->itemSeq); ?>

                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>item Class Code</strong> :  <?php echo e($item->itemCd); ?>

                                        </div> 
                                        <div class="form-group col-md-4">
                                            <strong>Item Name</strong> :  <?php echo e($item->itemNmme); ?>

                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Bar Code</strong> :  <?php echo e($item->itembcd); ?>

                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Supplier Item Class Code</strong> :  <?php echo e($item->itemClsCd); ?> 
                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Supplier Item Code</strong> :  <?php echo e($item->supplrItemCd); ?>

                                        </div>
                                         <div class="form-group col-md-4">
                                            <strong>Supplier Item Name</strong> :  <?php echo e($item->supplrItemNm); ?>

                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Package Unit Code</strong> :   <?php echo e($item->pkgUnitCd); ?>

                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Package</strong> : <?php echo e($item->pkg); ?>

                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Quantity Unit Code</strong> : <?php echo e($item->qtyUnitCd); ?> 
                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Quantity</strong> : <?php echo e($item->qty); ?>

                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Price</strong> : <?php echo e($item->unitprice); ?>

                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Supply Amount</strong> :  <?php echo e($item->supplyAmt); ?>

                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Discount Rate</strong> :  <?php echo e($item->discountRate); ?>

                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Discount Amount</strong> : <?php echo e($item->discountAmt); ?>

                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Tax Type Code</strong> : <?php echo e($item->taxTyCd); ?>

                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Taxable Amount</strong> : <?php echo e($item->taxblAmt); ?>

                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Tax Amount</strong> :  <?php echo e($item->taxAmt); ?>

                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Total Amount</strong> : <?php echo e($item->totAmt); ?>

                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Item Expire Date</strong> : <?php echo e($item->itemExprDt); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php echo e(Form::close()); ?>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\hp\Desktop\projects\erp-go-6.4-using-laravel\resources\views/purchase/mappedPurchasesDetails.blade.php ENDPATH**/ ?>