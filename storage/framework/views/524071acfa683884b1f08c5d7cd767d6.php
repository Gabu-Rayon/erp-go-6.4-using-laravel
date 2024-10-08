

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Transaction Purchase Sale Details')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('purchase.index')); ?>"><?php echo e(__('Purchase')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Purchase Sale')); ?></li>
    <li class="breadcrumb-item"><?php echo e(__('Details')); ?></li>
<?php $__env->stopSection(); ?>

<?php echo e(\Log::info('PURCHASE')); ?>

<?php echo e(\Log::info($purchase)); ?>


<?php $__env->startSection('content'); ?>
    <div class="row">
        <?php echo e(Form::open(['route' => 'purchase.mapPurchase', 'class' => 'w-100'])); ?>

        <div class="col-12">
            <input type="hidden" name="_token" id="token" value="<?php echo e(csrf_token()); ?>">
            <div class="item-section py-2">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-12 d-flex align-items-center justify-content-between justify-content-md-end">
                        <div class="all-button-box me-2"><input type="submit" value="<?php echo e(__('Map Purchase')); ?>"
                                class="btn  btn-primary">
                            <input type="button" value="<?php echo e(__('Cancel')); ?>"
                                onclick="location.href = '<?php echo e(route('purchase.index')); ?>';" class="btn btn-danger">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <strong>Supplier Tin</strong> : <?php echo e($purchase->spplrTin); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Supplier Name</strong> : <?php echo e($purchase->spplrNm); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Supplier BhfId</strong> : <?php echo e($purchase->spplrBhfId); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Supplier Invoice No</strong>
                            <?php echo e(Form::text('supplierInvcNo', $purchase->spplrInvcNo, ['class' => 'form-control'])); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Supplier Sdcld</strong> : <?php echo e($purchase->spplrSdcld ?? '-'); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Supplier MrcNo</strong> : <?php echo e($purchase->spplMrcNo ?? '-'); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Receipt Type Code</strong> : <?php echo e($purchase->rcptTyCd); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Pmt Type Code</strong> : <?php echo e($purchase->pmtTycCd ?? '-'); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Purchase Type Code</strong> :
                            <?php echo e(Form::text('purchaseTypeCode', null, ['class' => 'form-control'])); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Purchase Status Code</strong> :
                            <?php echo e(Form::text('purchaseStatuCode', null, ['class' => 'form-control'])); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Confirmed Date</strong> : <?php echo e($purchase->cfmDt); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Sales Date</strong> : <?php echo e($purchase->salesDt); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Stock Release Date</strong> : <?php echo e($purchase->stockRlsDt); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Total Item Cnt</strong> : <?php echo e($purchase->totItemCnt); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Taxable Amount A</strong> : <?php echo e($purchase->taxblAmtA); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Taxable Amount B</strong> : <?php echo e($purchase->taxblAmtB); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Taxable Amount C</strong> : <?php echo e($purchase->taxblAmtC); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Taxable Amount D</strong> : <?php echo e($purchase->taxblAmtD); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Taxable Amount E</strong> : <?php echo e($purchase->taxblAmtE); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Tax Rate A</strong> : <?php echo e($purchase->taxRtA); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Tax Rate B</strong> : <?php echo e($purchase->taxRtB); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Tax Rate C</strong> : <?php echo e($purchase->taxRtC); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Tax Rate D</strong> : <?php echo e($purchase->taxRtD); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Tax Rate E</strong> : <?php echo e($purchase->taxRtE); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Tax Amount A</strong> : <?php echo e($purchase->taxAmtA); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Tax Amount B</strong> : <?php echo e($purchase->taxAmtB); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Tax Amount C</strong> : <?php echo e($purchase->taxAmtC); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Tax Amount D</strong> : <?php echo e($purchase->taxAmtD); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Tax Amount E</strong> : <?php echo e($purchase->taxAmtE); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Total Taxable Amount</strong> : <?php echo e($purchase->totTaxblAmt); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Total Tax Amount</strong> : <?php echo e($purchase->totTaxAmt); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Total Amount</strong> : <?php echo e($purchase->totAmt); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <strong>Remark</strong> : <?php echo e($purchase->remark); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <h5 class="d-inline-block mb-4"><?php echo e(__('Product & Services')); ?></h5>
            <?php echo e(\Log::info('PURCHASE ITEMS')); ?>

            <?php echo e(\Log::info($purchaseItems)); ?>

            <?php $__currentLoopData = $purchaseItems->groupBy('itemType'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $itemType => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="row">
                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <strong>Item Sequence No</strong> : <?php echo e($item->itemSeq); ?>

                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Item Code</strong> : <?php echo e($item->itemCd); ?>

                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Item Class Code</strong> : <?php echo e($item->itemClsCd); ?>

                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Item Name</strong> : <?php echo e($item->itemNm); ?>

                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Bar Code</strong> : <?php echo e($item->bcd); ?>

                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Supplier Item Class Code</strong> : <?php echo e($item->itemClsCd); ?>

                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Supplier Item Code</strong> : <?php echo e($item->spplrItemCd); ?>

                                            <?php echo e(Form::text('itemPurchases[' . $index . '][supplierItemCode]', $item->spplrItemCd, ['class' => 'form-control'])); ?>

                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Supplier Item Name</strong> : <?php echo e($item->spplrItemNm); ?>

                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Item Standard Quantity</strong> : <?php echo e($item->itemStdQty); ?>

                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Item Standard Quantity Unit</strong> : <?php echo e($item->itemStdQtyUom); ?>

                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Item Quantity</strong> : <?php echo e($item->itemQty); ?>

                                            <?php echo e(Form::text('itemPurchases[' . $index . '][mapQuantity]', $item->itemQty, ['class' => 'form-control'])); ?>

                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Item Unit of Measurement</strong> : <?php echo e($item->itemUom); ?>

                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Taxation Type Code</strong> : <?php echo e($item->txblTypeCd); ?>

                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Item Unit Price</strong> : <?php echo e($item->itemPrice); ?>

                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Tax Rate</strong> : <?php echo e($item->taxRt); ?>

                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Tax Amount</strong> : <?php echo e($item->taxAmt); ?>

                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Total Amount</strong> : <?php echo e($item->totAmt); ?>

                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>Item Expire Date</strong> : <?php echo e($item->itemExprDt); ?>

                                        </div>
                                        <div class="form-group col-md-4">
                                            <?php echo e(Form::label('mapQuantity', __('Map Quantity'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::number('mapQuantity', null, ['class' => 'form-control productItem'])); ?>

                                        </div>
                                        <div class="form-group col-md-4">
                            <?php echo e(Form::label('itemCode', __('Item Code'), ['class' => 'form-label'])); ?>

                            <span class="text-danger">*</span>
                            <?php echo e(Form::select('itemCode', $ProductService, null, ['class' => 'form-control select2 itemCode', 'required' => 'required'])); ?>

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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp-go-6.4-using-laravel\resources\views/purchase/details.blade.php ENDPATH**/ ?>