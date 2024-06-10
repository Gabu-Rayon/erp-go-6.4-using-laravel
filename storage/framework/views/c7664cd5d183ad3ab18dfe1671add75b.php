<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Imported Item')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0"><?php echo e(__('Imported Item')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('importeditems.index')); ?>"><?php echo e(__('Imported Items')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(ucwords($importedItem->srNo)); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <?php echo e(Form::open(['url' => 'importeditems', 'enctype' => 'multipart/form-data'])); ?>

                <div class="row text-center items-center">
                    <div class="form-group col-md-4">
                        <?php echo e(Form::label('bsnsActv', __('Task Code'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('bsnsActv', $importedItem->taskCode, ['class' => 'form-control ', 'required' => 'required', 'placeholder' => $importedItem->taskCode, 'readonly' => true])); ?>

                    </div>

                    <div class="form-group col-md-4">
                        <?php echo e(Form::label('bhfNm', __('Item Name'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('bhfNm', $importedItem->itemName, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>

                    <div class="form-group col-md-4">
                        <?php echo e(Form::label('bhfOpenDt', __('HS Code'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('bhfOpenDt', $importedItem->hsCode, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                    <div class="form-group col-md-4">
                        <?php echo e(Form::label('prvncNm', __('Package Unit Code'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('prvncNm', $importedItem->pkgUnitCode, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                    <div class="form-group col-md-4">
                        <?php echo e(Form::label('dstrtNm', __('Net Weight'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('dstrtNm', $importedItem->netWeight, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                    <div class="form-group col-md-4">
                        <?php echo e(Form::label('scrtNm', __('Invoice Foreign Code'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('sctrNm', $importedItem->invForCode, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                    <div class="form-group col-md-4">
                        <?php echo e(Form::label('locDesc', __('Declaration Date'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('locDesc', $importedItem->declarationDate, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                    <div class="form-group col-md-4">
                        <?php echo e(Form::label('hqYn', __('Origin Nation Code'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('hqYn', $importedItem->orginNationCode, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                    <div class="form-group col-md-4">
                        <?php echo e(Form::label('mgrNm', __('Quantity'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('mgrNm', $importedItem->qty, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                    <div class="form-group col-md-4">
                        <?php echo e(Form::label('mgrTelNo', __('Supplier Name'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('mgrTelNo', $importedItem->supplierName, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                    <div class="form-group col-md-4">
                        <?php echo e(Form::label('mgrEmail', __('nvcFcurExcrt'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('mgrEmail', $importedItem->nvcFcurExcrt, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                    <div class="form-group col-md-4">
                        <?php echo e(Form::label('dvcId', __('Item Sequence'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('dvcId', $importedItem->itemSeq, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                    <div class="form-group col-md-4">
                        <?php echo e(Form::label('sdcId', __('Export Nation Code'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('sdcId', $importedItem->exprtNatCode, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                    <div class="form-group col-md-4">
                        <?php echo e(Form::label('devicesrlno', __('Quantity Code'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('mrcNo', $importedItem->qtyUnitCode, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                    <div class="form-group col-md-4">
                        <?php echo e(Form::label('devicesrlno', __('Agent Name'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('cmcKey', $importedItem->agentName, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                    <div class="form-group col-md-4">
                        <?php echo e(Form::label('devicesrlno', __('Declaration Number'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('cmcKey', $importedItem->declarationNo, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                    <div class="form-group col-md-4">
                        <?php echo e(Form::label('devicesrlno', __('Package'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('cmcKey', $importedItem->package, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                    <div class="form-group col-md-4">
                        <?php echo e(Form::label('devicesrlno', __('Gross Weight'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('cmcKey', $importedItem->grossWeight, ['class' => 'form-control ', 'required' => 'required'])); ?>

                    </div>
                    <div class="form-group col-md-4">
                        <?php echo e(Form::label('devicesrlno', __('Invoice Foreign Currency Amount'), ['class' => 'form-label'])); ?>

                        <?php echo e(Form::text('cmcKey', $importedItem->invForCurrencyAmount, ['class' => 'form-control ', 'required' => 'required'])); ?>

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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/chrisdroid/Desktop/projects/php/erp-go-6.4-using-laravel/resources/views/importeditems/show.blade.php ENDPATH**/ ?>