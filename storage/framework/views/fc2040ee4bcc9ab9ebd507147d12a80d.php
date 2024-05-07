
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Add Product / Service')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('productservice.index')); ?>"><?php echo e(__('Products & Services')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Add Product / Service')); ?></li>
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
        <?php echo e(Form::open(['url' => 'productservice', 'class' => 'w-100'])); ?>

        <div class="col-12">
            <input type="hidden" name="_token" id="token" value="<?php echo e(csrf_token()); ?>">
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
                                <tr class="row p-3">
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('itemCode', __('Item Code'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::text('itemCode', '', array('class' => 'form-control', 'required' => 'required'))); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('itemClassifiCode', __('Item Classification Code'),['class'=>'form-label'])); ?>

                                        <?php echo e(Form::select('itemClassifiCode', $itemclassifications, null, array('class' => 'form-control select2','placeholder'=>__('Select Item Classification'),'required'=>'required'))); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('itemTypeCode', __('Item Type Code'),['class'=>'form-label'])); ?>

                                        <?php echo e(Form::select('itemTypeCode', $itemtypes, null, array('class' => 'form-control select2','placeholder'=>__('Select Item Type Code'),'required'=>'required'))); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('itemName', __('Item Name'),['class'=>'form-label'])); ?>

                                        <?php echo e(Form::text('itemName', '', array('class' => 'form-control', 'required' => 'required'))); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('itemStrdName', __('Item Std Name'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::text('itemStrdName', '', array('class' => 'form-control', 'required' => 'required'))); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('countryCode', __('Country Code'),['class'=>'form-label'])); ?>

                                        <?php echo e(Form::select('countryCode', $countrynames, null, array('class' => 'form-control select2','placeholder'=>__('Select Origin Place Code'),'required'=>'required'))); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('pkgUnitCode', __('Package Unit Code'),['class'=>'form-label'])); ?>

                                        <?php echo e(Form::text('pkgUnitCode', '', array('class' => 'form-control', 'required' => 'required'))); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('qtyUnitCode', __('Quantity Unit Code'),['class'=>'form-label'])); ?>

                                        <?php echo e(Form::text('qtyUnitCode', '', array('class' => 'form-control', 'required' => 'required'))); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('taxTypeCode', __('Tax Type Code'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::select('taxTypeCode', $taxationtype, null, array('class' => 'form-control select2','placeholder'=>__('Select Taxation Type Code'),'required'=>'required'))); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('batchNo', __('Batch Number'),['class'=>'form-label'])); ?>

                                        <?php echo e(Form::text('batchNo', '', array('class' => 'form-control', 'required' => 'required'))); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('barcode', __('Bar Code'),['class'=>'form-label'])); ?>

                                        <?php echo e(Form::text('barcode', '', array('class' => 'form-control', 'required' => 'required'))); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('unitPrice', __('Unit Price'),['class'=>'form-label'])); ?>

                                        <?php echo e(Form::number('unitPrice', '', array('class' => 'form-control', 'required' => 'required'))); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('group1UnitPrice', __('Group 1 Unit Price'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::number('group1UnitPrice', '', array('class' => 'form-control', 'required' => 'required'))); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('group2UnitPrice', __('Group 2 Unit Price'),['class'=>'form-label'])); ?>

                                        <?php echo e(Form::number('group2UnitPrice', '', array('class' => 'form-control', 'required' => 'required'))); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('group3UnitPrice', __('Group 3 Unit Price'),['class'=>'form-label'])); ?>

                                        <?php echo e(Form::number('group3UnitPrice', '', array('class' => 'form-control', 'required' => 'required'))); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('group4UnitPrice', __('Group 4 Unit Price'),['class'=>'form-label'])); ?>

                                        <?php echo e(Form::number('group4UnitPrice', '', array('class' => 'form-control', 'required' => 'required'))); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('group5UnitPrice', __('Group 5 Unit Price'),['class'=>'form-label'])); ?>

                                        <?php echo e(Form::number('group5UnitPrice', '', array('class' => 'form-control', 'required' => 'required'))); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('additionalInfo', __('Additional Info'),['class'=>'form-label'])); ?>

                                        <?php echo e(Form::text('additionalInfo', '', array('class' => 'form-control', 'required' => 'required'))); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('saftyQuantity', __('Safty Quantity'),['class'=>'form-label'])); ?>

                                        <?php echo e(Form::number('saftyQuantity', '', array('class' => 'form-control', 'required' => 'required'))); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('isInrcApplicable', __('Is Inrc Applicable'),['class'=>'form-label'])); ?>

                                        <?php echo e(Form::text('isInrcApplicable', '', array('class' => 'form-control', 'required' => 'required'))); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('isUsed', __('Is Used'),['class'=>'form-label'])); ?>

                                        <?php echo e(Form::text('isUsed', '', array('class' => 'form-control', 'required' => 'required'))); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('quantity', __('Quantity'),['class'=>'form-label'])); ?>

                                        <?php echo e(Form::number('quantity', '', array('class' => 'form-control', 'required' => 'required'))); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('packageQuantity', __('Package Quantity'),['class'=>'form-label'])); ?>

                                        <?php echo e(Form::number('packageQuantity', '', array('class' => 'form-control', 'required' => 'required'))); ?>

                                    </td>
                                    <td class="ti ti-trash text-white text-white repeater-action-btn bg-danger ms-2" data-repeater-delete></td>
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
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp-go-6.4-using-laravel\resources\views/productservice/create.blade.php ENDPATH**/ ?>