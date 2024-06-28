<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Product & Service Information')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0"><?php echo e(__('Product & Service Information')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('productservice.index')); ?>"><?php echo e(__('Product & Service Information')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(ucwords($productServiceInfo->itemCd)); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3">
                        <h6><?php echo e(__('Name: ')); ?></h6>
                        <p><?php echo e($productServiceInfo->name); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Item SKU: ')); ?></h6>
                        <p><?php echo e($productServiceInfo->sku); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Sale price: ')); ?></h6>
                        <p><?php echo e($productServiceInfo->sale_price); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Purchase Price: ')); ?></h6>
                        <p><?php echo e($productServiceInfo->purchase_price); ?></h6>
                    </div>
                     <div class="col-md-3">
                        <h6><?php echo e(__('Quantity: ')); ?></h6>
                        <p><?php echo e($productServiceInfo->quantity); ?></h6>
                    </div>
                     <div class="col-md-3">
                        <h6><?php echo e(__('Tax Id: ')); ?></h6>
                        <p><?php echo e($taxName); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Category Id: ')); ?></h6>
                        <p><?php echo e($categoryName); ?></h6>
                    </div>
                     <div class="col-md-3">
                        <h6><?php echo e(__('Unit Id: ')); ?></h6>
                        <p><?php echo e($unitName); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Type: ')); ?></h6>
                        <p><?php echo e($productServiceInfo->type); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('sale Chart Account Id: ')); ?></h6>
                        <p><?php echo e($saleChartAccountName); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Expense Chart Account Id: ')); ?></h6>
                        <p><?php echo e($expenseChartAccounName); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Description: ')); ?></h6>
                        <p><?php echo e($productServiceInfo->description); ?></h6>
                    </div>                    
                    <div class="col-md-3">
                        <h6><?php echo e(__('Item Code: ')); ?></h6>
                        <p><?php echo e($productServiceInfo->itemCd); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Task Classification: ')); ?></h6>
                        <p><?php echo e($productServiceInfo->itemClsCd); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Item Type Code:')); ?></h6>
                        <p><?php echo e($productServiceInfo->itemTyCd); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Item Name: ')); ?></h6>
                        <p><?php echo e($productServiceInfo->itemNm); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Origin Place Code: ')); ?></h6>
                        <p><?php echo e($productServiceInfo->orgnNatCd); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Packaging Unit Code:')); ?></h6>
                        <p><?php echo e($productServiceInfo->pkgUnitCd); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Quantity Unit Code:')); ?></h6>
                        <p><?php echo e($productServiceInfo->qtyUnitCd); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Batch No:')); ?></h6>
                        <p><?php echo e($productServiceInfo->btchNo); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Default Price:')); ?></h6>
                        <p><?php echo e($productServiceInfo->dftPrc); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Group 1 Unit Price:')); ?></h6>
                        <p><?php echo e($productServiceInfo->grpPrcL1); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Group 2 Unit Price:')); ?></h6>
                        <p><?php echo e($productServiceInfo->grpPrcL2); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Group 3 Unit Price:')); ?></h6>
                        <p><?php echo e($productServiceInfo->grpPrcL3); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Group 4 Unit Price:')); ?></h6>
                        <p><?php echo e($productServiceInfo->grpPrcL4); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Group 5 Unit Price:')); ?></h6>
                        <p><?php echo e($productServiceInfo->grpPrcL5); ?></h6>
                    </div>
                   <div class="col-md-3">
                        <h6><?php echo e(__('Additional Information :')); ?></h6>
                        <p><?php echo e($productServiceInfo->addInfo); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Safty Quantity :')); ?></h6>
                        <p><?php echo e($productServiceInfo->sftyQty); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Insurance Applicable (Y/N:)')); ?></h6>
                        <p><?php echo e($productServiceInfo->isrcAplcbYn); ?></h6>
                    </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Used/UnUsed :')); ?></h6>
                        <p><?php echo e($productServiceInfo->useYn); ?></h6>
                    </div>
                     <div class="col-md-3">
                    <h6><?php echo e(__('Product Image: ')); ?></h6>
                    <?php if($productServiceInfo->pro_image): ?>
                        <img src="<?php echo e(Storage::url($productServiceInfo->pro_image)); ?>" alt="Product Image" style="max-width: 100%;">
                    <?php else: ?>
                        <p><?php echo e(__('No product image available')); ?></p>
                    <?php endif; ?>
                </div>
                    <div class="col-md-3">
                        <h6><?php echo e(__('Created By: ')); ?></h6>
                        <p><?php echo e($productServiceInfo->created_by); ?></h6>
                    </div>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/erp-go-6.4-using-laravel/resources/views/productservice/show.blade.php ENDPATH**/ ?>