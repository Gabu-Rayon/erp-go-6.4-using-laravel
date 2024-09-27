<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Stock Master Save Request')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a
            href="<?php echo e(route('stock.master.save.request.index')); ?>"><?php echo e(__('Stock Master Save Request')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Stock Master Save Request')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <?php echo e(Form::open(['url' => 'save/request/store', 'class' => 'w-100'])); ?>

        <div class="col-12">
            <input type="hidden" name="_token" id="token" value="<?php echo e(csrf_token()); ?>">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-3">
                            <?php echo e(Form::label('itemCd', __('Item'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::select('itemCd', $items, null, ['class' => 'form-control select2'])); ?>

                        </div>
                        <div class="form-group col-md-3">
                            <?php echo e(Form::label('rsdQty', __('RSD Qty'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::text('rsdQty', '', ['class' => 'form-control'])); ?>

                        </div>
                        <div class="form-group col-md-3">
                            <?php echo e(Form::label('bhfId', __('Branch'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::select('bhfId', $branches, null, ['class' => 'form-control select2'])); ?>

                        </div>
                        <div class="form-group col-md-3">
                            <?php echo e(Form::label('tin', __('TIN'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::text('tin', '', ['class' => 'form-control'])); ?>

                        </div>
                        <div class="form-group col-md-3">
                            <?php echo e(Form::label('modrId', __('MODR ID'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::text('modrId', '', ['class' => 'form-control'])); ?>

                        </div>
                        <div class="form-group col-md-3">
                            <?php echo e(Form::label('modrNm', __('MODR Name'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::text('modrNm', '', ['class' => 'form-control'])); ?>

                        </div>
                        <div class="form-group col-md-3">
                            <?php echo e(Form::label('regrId', __('REGR ID'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::text('regrId', '', ['class' => 'form-control'])); ?>

                        </div>
                        <div class="form-group col-md-3">
                            <?php echo e(Form::label('regrNm', __('REGR Name'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::text('regrNm', '', ['class' => 'form-control'])); ?>

                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <input type="button" value="<?php echo e(__('Cancel')); ?>"
                    onclick="location.href = '<?php echo e(route('stock.master.save.request.index')); ?>';" class="btn btn-light">
                <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn btn-primary">
            </div>
            <?php echo e(Form::close()); ?>

        </div>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/chris-droid/Desktop/projects/erp-go-6.4-using-laravel/resources/views/stockmastersaverequest/create.blade.php ENDPATH**/ ?>