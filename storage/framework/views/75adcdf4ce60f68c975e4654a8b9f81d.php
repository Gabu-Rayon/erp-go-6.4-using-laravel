
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Add Direct Credit Note')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('credit.note')); ?>"><?php echo e(__('Credit Notes')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Add Direct Credit Note')); ?></li>
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

        $(document).ready(function() {
            $(document).on('change', '.itemCode', function() {
                var item_id = $(this).val();
                var url = $(this).data('url');
                var el = $(this).closest('[data-clone]');

                if (el.length) {
                    console.log("Change event triggered for.itemCode[data-clone]");

                    console.log("item_id:", item_id);
                    console.log("url:", url);
                    console.log("el:", el);

                    $.ajax({
                        url: url,
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': jQuery('#token').val()
                        },
                        data: {
                            'itemCode': item_id
                        },
                        cache: false,
                        success: function(data) {
                            try {
                                console.log("Item information:", data.data);

                                if (!data.data) {
                                    console.log("Item information is empty.");
                                } else {
                                    console.log("Item information is not empty. Processing...");

                                    var item = data.data;

                                    console.log("Item object:", item);

                                    if (Object.keys(item).length === 0) {
                                        console.log("Item object is empty.");
                                    } else {
                                        console.log(
                                            "Item object is not empty. Populating fields..."
                                        );

                                        // Populate fields only for the current cloned form
                                        console.log("Populating unitPrice:", item.dftPrc);
                                        el.find('.unitPrice').val(item.dftPrc);
                                    }
                                }
                            } catch (error) {
                                console.error("Error processing item information:", error);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Error retrieving item information:", error);
                        }
                    });
                }
            });
        });
    </script>
    <script>
        $(document).on('click', '[data-repeater-delete]', function() {
            $(".itemCode").change();
            $(".price").change();
            $(".quantity").change();
        });
    </script>
    <script>
          function calculateDiscountAmount(unitPrice, packageQuantity, quantity, discountRate) {
        // Calculate the total price before discount
        var totalPrice = unitPrice * quantity * packageQuantity;

        // Calculate the discounted price
        var discountAmount = totalPrice * (discountRate / 100);

        return discountAmount;
    }

    // Function to update discount amount field
    function updateDiscountAmount(row) {
        // Get values of required fields
        var unitPrice = parseFloat(row.find('.unitPrice').val());
        var packageQuantity = parseFloat(row.find('.pkgQuantity').val());
        var quantity = parseFloat(row.find('.quantity').val());
        var discountRate = parseFloat(row.find('.discountRate').val());

        // Calculate discount amount
        var discountAmt = calculateDiscountAmount(unitPrice, packageQuantity, quantity, discountRate) || 0;

        // Update discount amount field
        row.find('.discountAmt').val(discountAmt.toFixed(2));
    }

    // Event listener for change in unitPrice, pkgQuantity, quantity, and discountRate fields
    $(document).on('keyup change', '.unitPrice, .pkgQuantity, .quantity, .discountRate', function() {
        // Find the closest row containing the changed field
        var row = $(this).closest('tr');

        // Update discount amount for the row
        updateDiscountAmount(row);
    });
    </script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <?php echo e(Form::open(['route' => ['invoice.custom.credit.note'], 'method' => 'post'])); ?>

        <div class="col-12">
            <input type="hidden" name="_token" id="token" value="<?php echo e(csrf_token()); ?>">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <?php echo e(Form::label('customerName', __('Customer Name (*)'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::select('customerName', $customer, null, ['class' => 'form-control customerName', 'required' => 'required'])); ?>

                        </div>
                        <div class="form-group col-md-6">
                            <?php echo e(Form::label('customerTin', __('Customer Tin (*)'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::text('customerTin', '', ['class' => 'form-control customerTin', 'required' => 'required'])); ?>

                        </div>
                        <div class="form-group col-md-6">
                            <?php echo e(Form::label('invoice', __('Customer Name (*)'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::select('invoice', $invoices, null, ['class' => 'form-control invoice', 'required' => 'required'])); ?>

                        </div>
                        <div class="form-group  col-md-6">
                            <?php echo e(Form::label('orgInvoiceNo', __('Org Invoice No'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::number('orgInvoiceNo', null, ['class' => 'form-control', 'required' => 'required'])); ?>


                        </div>
                        <div class="form-group col-md-6">
                            <?php echo e(Form::label('traderInvoiceNo', __('Trader Invoice No(*)'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::number('traderInvoiceNo', null, ['class' => 'form-control', 'required' => 'required'])); ?>

                        </div>
                        <div class="form-group col-md-6">
                            <?php echo e(Form::label('salesType', __('Sales Type(*)'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::select('salesType', $salesTypeCodes, null, ['class' => 'form-control'])); ?>

                        </div>
                        <div class="form-group col-md-6">
                            <?php echo e(Form::label('paymentType', __('Payment Type'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::select('paymentType', $paymentTypeCodes, null, ['class' => 'form-control'])); ?>

                        </div>
                        <div class="form-group col-md-6">
                            <?php echo e(Form::label('creditNoteDate', __('Credit Note Date (*)'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::date('creditNoteDate', '', ['class' => 'form-control creditNoteDate', 'required' => true])); ?>

                        </div>
                        <div class="form-group col-md-6">
                            <?php echo e(Form::label('confirmDate', __('Confirm Date (*)'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::date('confirmDate', '', ['class' => 'form-control', 'required' => 'required'])); ?>

                        </div>
                        <div class="form-group col-md-6">
                            <?php echo e(Form::label('salesDate', __('Sales Date (*)'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::date('salesDate', '', ['class' => 'form-control', 'required' => 'required'])); ?>

                        </div>
                        <div class="form-group col-md-6">
                            <?php echo e(Form::label('stockReleseDate', __('Stock Release Date'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::date('stockReleseDate', '', ['class' => 'form-control'])); ?>

                        </div>
                        <div class="form-group col-md-6">
                            <?php echo e(Form::label('receiptPublishDate', __('Receipt Publish Date (*)'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::date('receiptPublishDate', '', ['class' => 'form-control', 'required' => 'required'])); ?>

                        </div>
                        <div class="form-group col-md-6">
                            <?php echo e(Form::label('occurredDate', __('Occurred Date (*)'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::date('occurredDate', '', ['class' => 'form-control', 'required' => 'required'])); ?>

                        </div>
                        <div class="form-group col-md-6">
                            <?php echo e(Form::label('creditNoteReason', __('Credit Note Reason(*)'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::select('creditNoteReason', $creditNoteReasons, null, ['class' => 'form-control'])); ?>

                        </div>
                        <div class="form-group col-md-6">
                            <?php echo e(Form::label('invoiceStatusCode', __('Invoice Status'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::select('invoiceStatusCode', $invoiceStatusCodes, null, ['class' => 'form-control'])); ?>

                        </div>
                        <div class="form-group col-md-6">
                            <?php echo e(Form::label('isPurchaseAccept', __('Purchase Accepted?'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::select('isPurchaseAccept', ['true' => 'Yes', 'false' => 'No'], null, ['class' => 'form-control'])); ?>

                        </div>
                        <div class="form-group col-md-6">
                            <?php echo e(Form::label('isStockIOUpdate', __('Stock IO Update?'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::select('isStockIOUpdate', ['true' => 'Yes', 'false' => 'No'], null, ['class' => 'form-control'])); ?>

                        </div>
                        <div class="form-group col-md-6">
                            <?php echo e(Form::label('mapping', __('Mapping'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::text('mapping', '', ['class' => 'form-control'])); ?>

                        </div>
                        <div class="form-group col-md-6">
                            <?php echo e(Form::label('amount', __('Amount(*)'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::number('amount', '', ['class' => 'form-control'])); ?>

                        </div>
                        <div class="form-group col-md-12">
                            <?php echo e(Form::label('remark', __('Remark'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::textarea('remark', '', ['class' => 'form-control', 'rows' => '3'])); ?>

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
                                <tr class="row p-3">
                                    <td class="form-group col-md-4">
                                        <?php echo e(Form::label('itemCode', __('Item Code'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::select('itemCode', $product_services_Codes, '', ['class' => 'form-control select2 itemCode', 'data-url' => route('invoice.custom.credit.getiteminformation'), 'required' => 'required'])); ?>


                                    </td>
                                    <td class="form-group col-md-4">
                                        <?php echo e(Form::label('unitPrice', __('Unit Price'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::number('unitPrice', '', ['class' => 'form-control unitPrice', 'required' => true])); ?>


                                    </td>
                                    <td class="form-group col-md-4">
                                        <?php echo e(Form::label('quantity', __('Quantity'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::number('quantity', '', ['class' => 'form-control quantity', 'required' => true])); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('pkgQuantity', __('Package Quantity (*)'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::number('pkgQuantity', '', ['class' => 'form-control pkgQuantity', 'required' => 'required'])); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('discountRate', __('Discount Rate'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::number('discountRate', '', ['class' => 'form-control discountRate', 'required' => 'required'])); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('discountAmt', __('Discount Amount'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::number('discountAmt', '', ['class' => 'form-control discountAmt', 'readonly' => true])); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('itemExprDate', __('Item Expiry Date'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::date('itemExprDate', null, ['class' => 'form-control'])); ?>

                                    </td>
                                    <td class="ti ti-trash text-white text-white repeater-action-btn bg-danger ms-2"
                                        data-repeater-delete>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" onclick="location.href = '<?php echo e(route('credit.note')); ?>';"
                class="btn btn-light">
            <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn  btn-primary">
        </div>
        <?php echo e(Form::close()); ?>

    </div>
<?php $__env->stopSection(); ?>
</div>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp-go-6.4-using-laravel\resources\views/creditNote/custom_create.blade.php ENDPATH**/ ?>