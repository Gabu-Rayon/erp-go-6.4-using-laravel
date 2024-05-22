
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
        <?php echo e(Form::open(['url' => 'productservice', 'class' => 'w-100', 'enctype' => 'multipart/form-data'])); ?>

        <!-- <?php echo e(Form::open(['url' => 'productservice', 'enctype' => 'multipart/form-data'])); ?> -->
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
                                        <div class="form-group">
                                            <?php echo e(Form::label('sku', __('SKU'), ['class' => 'form-label'])); ?><span
                                                class="text-danger">*</span>
                                            <?php echo e(Form::text('sku', '', ['class' => 'form-control', 'required' => 'required','placeholder' =>'ABC-12345-S-BL'])); ?>

                                        </div>
                                    </td>

                                    <td class="form-group col-md-3">
                                        <div class="form-group">
                                            <?php echo e(Form::label('sale_price', __('Sale Price'), ['class' => 'form-label'])); ?><span
                                                class="text-danger">*</span>
                                            <?php echo e(Form::number('sale_price', '', ['class' => 'form-control', 'required' => 'required', 'step' => '0.01'])); ?>

                                        </div>
                                    </td>
                                    <td class="form-group col-md-3">
                                        <div class="form-group">
                                            <?php echo e(Form::label('purchase_price', __('Purchase Price'), ['class' => 'form-label'])); ?><span
                                                class="text-danger">*</span>
                                            <?php echo e(Form::number('purchase_price', '', ['class' => 'form-control', 'required' => 'required', 'step' => '0.01'])); ?>

                                        </div>
                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('sale_chartaccount_id', __('Income Account'), ['class' => 'form-label'])); ?>

                                        <select name="sale_chartaccount_id" class="form-control" required="required">
                                            <?php $__currentLoopData = $incomeChartAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $chartAccount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($key); ?>" class="subAccount"><?php echo e($chartAccount); ?>

                                                </option>
                                                <?php $__currentLoopData = $incomeSubAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subAccount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($key == $subAccount['account']): ?>
                                                        <option value="<?php echo e($subAccount['id']); ?>" class="ms-5"> &nbsp;
                                                            &nbsp;&nbsp; <?php echo e($subAccount['code_name']); ?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('expense_chartaccount_id', __('Expense Account'), ['class' => 'form-label'])); ?>

                                        <select name="expense_chartaccount_id" class="form-control" required="required">
                                            <?php $__currentLoopData = $expenseChartAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $chartAccount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($key); ?>" class="subAccount"><?php echo e($chartAccount); ?>

                                                </option>
                                                <?php $__currentLoopData = $expenseSubAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subAccount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($key == $subAccount['account']): ?>
                                                        <option value="<?php echo e($subAccount['id']); ?>" class="ms-5"> &nbsp;
                                                            &nbsp;&nbsp; <?php echo e($subAccount['code_name']); ?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </td>

                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('itemCode', __('Item Code'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::text('itemCode', '', ['class' => 'form-control', 'required' => 'required'])); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('itemClassifiCode', __('Item Classification Code'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::select('itemClassifiCode', $itemclassifications, null, ['class' => 'form-control select2', 'placeholder' => __('Select Item Classification'), 'required' => 'required'])); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('itemTypeCode', __('Item Type Code'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::select('itemTypeCode', $itemtypes, null, ['class' => 'form-control select2', 'placeholder' => __('Select Item Type Code'), 'required' => 'required'])); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('itemName', __('Item Name'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::text('itemName', '', ['class' => 'form-control', 'required' => 'required'])); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('itemStrdName', __('Item Std Name'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::text('itemStrdName', '', ['class' => 'form-control', 'required' => 'required'])); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('countryCode', __('Country Code'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::select('countryCode', $countrynames, null, ['class' => 'form-control select2', 'placeholder' => __('Select Origin Place Code'), 'required' => 'required'])); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('pkgUnitCode', __('Package Unit Code'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::text('pkgUnitCode', '', ['class' => 'form-control', 'required' => 'required'])); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('qtyUnitCode', __('Quantity Unit Code'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::text('qtyUnitCode', '', ['class' => 'form-control', 'required' => 'required'])); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('taxTypeCode', __('Tax Type Code'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::select('taxTypeCode', $taxationtype, null, ['class' => 'form-control select2', 'placeholder' => __('Select Taxation Type Code'), 'required' => 'required'])); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('batchNo', __('Batch Number'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::text('batchNo', '', ['class' => 'form-control', 'required' => 'required'])); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('barcode', __('Bar Code'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::text('barcode', '', ['class' => 'form-control', 'required' => 'required','placeholder' =>'9347408001101'])); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('unitPrice', __('Unit Price'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::number('unitPrice', '', ['class' => 'form-control', 'required' => 'required'])); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('group1UnitPrice', __('Group 1 Unit Price'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::number('group1UnitPrice', '', ['class' => 'form-control', 'required' => 'required'])); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('group2UnitPrice', __('Group 2 Unit Price'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::number('group2UnitPrice', '', ['class' => 'form-control', 'required' => 'required'])); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('group3UnitPrice', __('Group 3 Unit Price'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::number('group3UnitPrice', '', ['class' => 'form-control', 'required' => 'required'])); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('group4UnitPrice', __('Group 4 Unit Price'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::number('group4UnitPrice', '', ['class' => 'form-control', 'required' => 'required'])); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('group5UnitPrice', __('Group 5 Unit Price'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::number('group5UnitPrice', '', ['class' => 'form-control', 'required' => 'required'])); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('saftyQuantity', __('Safty Quantity'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::number('saftyQuantity', '', ['class' => 'form-control', 'required' => 'required'])); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('isInrcApplicable', __('Is Inrc Applicable'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::select('isInrcApplicable', ['true' => 'Yes', 'false' => 'No'], null, ['class' => 'form-control', 'required' => 'required'])); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('useYn', __('useYn'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::select('useYn', ['true' => 'Yes', 'false' => 'No'], null, ['class' => 'form-control', 'required' => 'required'])); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('isUsed', __('Is Used'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::select('isUsed', ['true' => 'Yes', 'false' => 'No'], null, ['class' => 'form-control', 'required' => 'required'])); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('quantity', __('Quantity'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::number('quantity', '', ['class' => 'form-control', 'required' => 'required'])); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('packageQuantity', __('Package Quantity'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::number('packageQuantity', '', ['class' => 'form-control', 'required' => 'required'])); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('category_id', __('Category'), ['class' => 'form-label'])); ?><span
                                            class="text-danger">*</span>
                                        <?php echo e(Form::select('category_id', $category, null, ['class' => 'form-control select', 'required' => 'required'])); ?>


                                        <div class=" text-xs">
                                            <?php echo e(__('Please add constant category. ')); ?><a
                                                href="<?php echo e(route('product-category.index')); ?>"><b><?php echo e(__('Add Category')); ?></b></a>
                                        </div>
                                    </td>
                                    <td class="col-md-3 form-group">
                                        <?php echo e(Form::label('pro_image', __('Product/Item Image'), ['class' => 'form-label'])); ?>

                                        <div class="choose-file ">
                                            <label for="pro_image" class="form-label">
                                                <input type="file" class="form-control" name="pro_image" id="pro_image"
                                                    data-filename="pro_image_create">
                                                <img id="image" class="mt-3" style="width:25%;" />
                                            </label>
                                        </div>
                                    </td>
                                    <td class="form-group col-md-3">
                                        <div class="form-group">
                                            <div class="btn-box">
                                                <label class="d-block form-label"><?php echo e(__('Type')); ?></label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-check form-check-inline">
                                                            <input type="radio" class="form-check-input type"
                                                                id="customRadio5" name="type" value="product"
                                                                checked="checked">
                                                            <label class="custom-control-label form-label"
                                                                for="customRadio5"><?php echo e(__('Product')); ?></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-check form-check-inline">
                                                            <input type="radio" class="form-check-input type"
                                                                id="customRadio6" name="type" value="service">
                                                            <label class="custom-control-label form-label"
                                                                for="customRadio6"><?php echo e(__('Service')); ?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="form-group col-md-6">
                                        <?php echo e(Form::label('additionalInfo', __('Additional Info'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::textarea('additionalInfo', '', ['class' => 'form-control', 'required' => 'required'])); ?>

                                    </td>
                                    <?php if(!$customFields->isEmpty()): ?>
                                        <td class="form-group col-md-3">
                                            <div class="tab-pane fade show" id="tab-2" role="tabpanel">
                                                <?php echo $__env->make('customFields.formBuilder', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            </div>
                                        </td>
                                    <?php endif; ?>
                                    <td class="ti ti-trash text-white text-white repeater-action-btn bg-danger ms-2"
                                        data-repeater-delete></td>
                                    <td class="ti ti-trash text-white text-white repeater-action-btn bg-danger ms-2"
                                        data-repeater-delete></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <input type="button" value="<?php echo e(__('Cancel')); ?>"
                onclick="location.href = '<?php echo e(route('purchase.index')); ?>';" class="btn btn-light">
            <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn  btn-primary">
        </div>
        <?php echo e(Form::close()); ?>

    </div>
<?php $__env->stopSection(); ?>
<script>
    document.getElementById('pro_image').onchange = function() {
        var src = URL.createObjectURL(this.files[0])
        document.getElementById('image').src = src
    }

    //hide & show quantity

    $(document).on('click', '.type', function() {
        var type = $(this).val();
        if (type == 'product') {
            $('.quantity').removeClass('d-none')
            $('.quantity').addClass('d-block');
        } else {
            $('.quantity').addClass('d-none')
            $('.quantity').removeClass('d-block');
        }
    });
</script>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp-go-6.4-using-laravel\resources\views/productservice/create.blade.php ENDPATH**/ ?>