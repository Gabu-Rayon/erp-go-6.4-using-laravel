

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Get Stock Moved List Information')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0"><?php echo e(__('Get Stock Moved List Information')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('stockmovelist.index')); ?>"><?php echo e(__('Get Stock Move List')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(ucwords($stockMoveList->custTin)); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="item-section py-2">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-12 d-flex align-items-center justify-content-between justify-content-md-end">
                        <input type="button" value="<?php echo e(__('Go Back')); ?>"
                            onclick="location.href = '<?php echo e(route('stockmovelist.index')); ?>';" class="btn btn-primary">
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-4">
                        <h6><?php echo e(__('Customer TIN: ')); ?></h6>
                        <p><?php echo e($stockMoveList->custTin); ?></p>
                    </div>
                    <div class="form-group col-md-4">
                        <h6><?php echo e(__('Customer Branch ID: ')); ?></h6>
                        <p><?php echo e($stockMoveList->custBhfId); ?></p>
                    </div>
                    <div class="form-group col-md-4">
                        <h6><?php echo e(__('SAR Number: ')); ?></h6>
                        <p><?php echo e($stockMoveList->sarNo); ?></p>
                    </div>
                    <div class="form-group col-md-4">
                        <h6><?php echo e(__('Occurrence Date: ')); ?></h6>
                        <p><?php echo e($stockMoveList->ocrnDt); ?></p>
                    </div>
                    <div class="form-group col-md-4">
                        <h6><?php echo e(__('Total Items: ')); ?></h6>
                        <p><?php echo e($stockMoveList->totItemCnt); ?></p>
                    </div>
                    <div class="form-group col-md-4">
                        <h6><?php echo e(__('Status: ')); ?></h6>
                        <p><?php echo e($stockMoveList->status); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <h5 class="d-inline-block mb-4"><?php echo e(__('Product/s Item/s Lists')); ?></h5>
        <?php $__currentLoopData = $stockMoveListItems->groupBy('itemType'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $itemType => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="row">
                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <h6><?php echo e(__('Item Sequence: ')); ?></h6>
                                        <p><?php echo e($item->itemSeq); ?></p>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <h6><?php echo e(__('Item Code: ')); ?></h6>
                                        <p><?php echo e($item->itemCd); ?></p>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <h6><?php echo e(__('Item Classification Code: ')); ?></h6>
                                        <p><?php echo e($item->itemClsCd); ?></p>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <h6><?php echo e(__('Item Name: ')); ?></h6>
                                        <p><?php echo e($item->itemNm); ?></p>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <h6><?php echo e(__('Barcode: ')); ?></h6>
                                        <p><?php echo e($item->bcd); ?></p>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <h6><?php echo e(__('Package Unit Code: ')); ?></h6>
                                        <p><?php echo e($item->pkgUnitCd); ?></p>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <h6><?php echo e(__('Package Quantity: ')); ?></h6>
                                        <p><?php echo e($item->pkg); ?></p>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <h6><?php echo e(__('Quantity Unit Code: ')); ?></h6>
                                        <p><?php echo e($item->qtyUnitCd); ?></p>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <h6><?php echo e(__('Item Expiry Date: ')); ?></h6>
                                        <p><?php echo e($item->itemExprDt); ?></p>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <h6><?php echo e(__('Price: ')); ?></h6>
                                        <p><?php echo e($item->prc); ?></p>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <h6><?php echo e(__('Supply Amount: ')); ?></h6>
                                        <p><?php echo e($item->splyAmt); ?></p>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <h6><?php echo e(__('Total Discount Amount: ')); ?></h6>
                                        <p><?php echo e($item->totDcAmt); ?></p>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <h6><?php echo e(__('Taxable Amount: ')); ?></h6>
                                        <p><?php echo e($item->taxblAmt); ?></p>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <h6><?php echo e(__('Tax Type Code: ')); ?></h6>
                                        <p><?php echo e($item->taxTyCd); ?></p>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <h6><?php echo e(__('Tax Amount: ')); ?></h6>
                                        <p><?php echo e($item->taxAmt); ?></p>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <h6><?php echo e(__('Total Amount: ')); ?></h6>
                                        <p><?php echo e($item->totAmt); ?></p>
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp-go-6.4-using-laravel\resources\views/stockgetmovelist/show.blade.php ENDPATH**/ ?>