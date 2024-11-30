
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Branch Stock Transfer')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('branch.transfer.index')); ?>"><?php echo e(__('Stock Branch Transfer List')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Branch Stock Transfer')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
    <script src="<?php echo e(asset('js/jquery-ui.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/jquery.repeater.min.js')); ?>"></script>
    <script>
        var selector = "body";
        if ($(selector + " .repeater").length) {
            var $dragAndDrop = $("body .repeater tbody").sortable({
                handle: '.sort-handler'
            });
            var $repeater = $(selector + ' .repeater').repeater({
                initEmpty: false,
                defaultValues: {
                    'status': 1
                },
                show: function() {
                    $(this).slideDown();
                    var file_uploads = $(this).find('input.multi');
                    if (file_uploads.length) {
                        $(this).find('input.multi').MultiFile({
                            max: 3,
                            accept: 'png|jpg|jpeg',
                            max_size: 2048
                        });
                    }
                    $('.select2').select2();
                },
                hide: function(deleteElement) {
                    if (confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                        $(this).remove();

                        var inputs = $(".amount");
                        var subTotal = 0;
                        for (var i = 0; i < inputs.length; i++) {
                            subTotal = parseFloat(subTotal) + parseFloat($(inputs[i]).html());
                        }
                        $('.subTotal').html(subTotal.toFixed(2));
                        $('.totalAmount').html(subTotal.toFixed(2));
                    }
                },
                ready: function(setIndexes) {
                    $dragAndDrop.on('drop', setIndexes);
                },
                isFirstItemUndeletable: true
            });
            var value = $(selector + " .repeater").attr('data-value');
            if (typeof value != 'undefined' && value.length != 0) {
                value = JSON.parse(value);
                $repeater.setList(value);
            }

        }
       
    </script>

    <script>
        $(document).on('click', '[data-repeater-delete]', function() {
            $(".price").change();
            $(".discount").change();
        });
    </script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <?php echo e(Form::open(['url' => 'branch/transfer/stock/store', 'class' => 'w-100'])); ?>

        <div class="col-12">
            <input type="hidden" name="_token" id="token" value="<?php echo e(csrf_token()); ?>">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <?php echo e(Form::label('branchId', __('Branch From(*)'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::select('branchFrom', $branches, null, ['class' => 'form-control select2'])); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <?php echo e(Form::label('branchId', __('Branch To (*)'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::select('branchTo', $branches, null, ['class' => 'form-control select2'])); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <?php echo e(Form::label('occurredDate', __('Occurred Date(*)'),['class'=>'form-label'])); ?>

                            <?php echo e(Form::date('occurredDate', null, ['class' => 'form-control select2'])); ?>

                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <h5 class=" d-inline-block mb-4"><?php echo e(__('Product & Services')); ?></h5>
            <div class="card repeater">
                <div class="item-section py-2">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-md-12 d-flex align-items-center justify-content-between justify-content-md-end">
                            <div class="all-button-box me-2">
                                <a href="#" data-repeater-create="" class="btn btn-primary" data-bs-toggle="modal"
                                    data-target="#add-bank">
                                    <i class="ti ti-plus"></i> <?php echo e(__('Add item')); ?>

                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table mb-0" data-repeater-list="items" id="sortable-table">
                            <thead>
                            </thead>
                            <tbody class="ui-sortable" data-repeater-item data-clone>
                                <tr>
                                    <td class="form-group col-md-4">
                                        <?php echo e(Form::label('item', __('Item'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::select('itemCode', $items, null, ['class' => 'form-control select2'])); ?>

                                    </td>
                                    <td class="form-group col-md-4">
                                        <?php echo e(Form::label('quantity', __('Quantity'),['class'=>'form-label'])); ?>

                                        <?php echo e(Form::text('quantity', '', array('class' => 'form-control', 'required' => 'required'))); ?>

                                    </td>
                                    <td class="form-group col-md-4">
                                        <?php echo e(Form::label('pkgQuantity', __('PackageQuantity'),['class'=>'form-label'])); ?>

                                        <?php echo e(Form::text('pkgQuantity', '', array('class' => 'form-control', 'required' => 'required'))); ?>

                                    </td>
                                    <td class="ti ti-trash text-white repeater-action-btn bg-danger ms-2" data-repeater-delete></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" onclick="location.href = '<?php echo e(route('purchase.index')); ?>';"
                class="btn btn-light">
            <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn  btn-primary">
        </div>
        <?php echo e(Form::close()); ?>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp-go-6.4-using-laravel\resources\views/stockbranchtransfer/create.blade.php ENDPATH**/ ?>