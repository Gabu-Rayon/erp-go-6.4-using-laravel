
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Add Sales Credit Note')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('salescreditnote.index')); ?>"><?php echo e(__('Sales')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(ucwords($invoiceDue->invoice_id)); ?></li>
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
                var url = `http://localhost:8000/getitem/${item_id}`;
                var el = $(this).closest('[data-clone]');

                if (el.length) {
                    $.ajax({
                        url: url,
                        type: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': jQuery('#token').val()
                        },
                        cache: false,
                        success: function(data) {
                            try {

                                if (!data.data) {
                                    alert("Item information is empty.");
                                } else {
                                    var item = data.data;

                                    if (Object.keys(item).length === 0) {
                                        alert("Item object is empty.");
                                    } else {

                                        el.find('.itemClassCode').val(item.itemClsCd);

                                        el.find('.itemTypeCode').val(item.itemTyCd);

                                        el.find('.itemName').val(item.itemNm);

                                        el.find('.orgnNatCd').val(item.orgnNatCd);

                                        el.find('.taxTypeCode').val(item.taxTyCd);
                                        
                                        el.find('.unitPrice').val(item.dftPrc);

                                        el.find('.isrcAplcbYn').val(item.isrcAplcbYn);

                                        el.find('.pkgUnitCode').val(item.pkgUnitCd);

                                        el.find('.qtyUnitCd').val(item.qtyUnitCd);
                                     
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

    // Initial update of discount amount for existing rows
            $('.repeater-item').each(function() {
                updateDiscountAmount($(this));
            });
        });
    </script>

    <script>
        $(document).on('click', '[data-repeater-delete]', function() {
            $(".price").change();
            $(".discount").change();
        });
    </script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<?php echo e(Form::open(array('route' => array('invoice.credit.note',$invoice_id),'method'=>'post'))); ?>

    <div class="modal-body">
        <div class="row">
            <div class="form-group col-md-3">
                <?php echo e(Form::label('customerName', __('Customer Name (*)'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::select('customerName', $customers, null, ['class' => 'form-control customerName', 'required' => 'required'])); ?>

            </div>
            <div class="form-group col-md-3">
                <?php echo e(Form::label('customerTin', __('Customer Tin (*)'),['class'=>'form-label'])); ?>

                <?php echo e(Form::text('customerTin', '', array('class' => 'form-control customerTin', 'required' => 'required', 'readonly' => true))); ?>

            </div> 
            <div class="form-group col-md-3">
                <?php echo e(Form::label('salesType', __('Sales Type'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::select('salesType', $salesTypeCodes, null, ['class' => 'form-control'])); ?>

            </div>
            <div class="form-group col-md-3">
                <?php echo e(Form::label('paymentType', __('Payment Type'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::select('paymentType', $paymentTypeCodes, null, ['class' => 'form-control'])); ?>

            </div>
            <div class="form-group col-md-3">
                <?php echo e(Form::label('creditNoteReason', __('Credit Note Reason (*)'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::select('creditNoteReason', $creditNoteReasons, null, ['class' => 'form-control', 'required' => 'required'])); ?>

            </div>
            <div class="form-group col-md-3">
                <?php echo e(Form::label('creditNoteDate', __('Credit Note Date (*)'),['class'=>'form-label'])); ?>

                <?php echo e(Form::datetime('creditNoteDate', '', array('class' => 'form-control'))); ?>

            </div>
            <div class="form-group col-md-3">
                <?php echo e(Form::label('traderInvoiceNo', __('Trader Invoive No (*)'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::text('traderInvoiceNo', '', array('class' => 'form-control traderInvoiceNo', 'required' => true))); ?>

            </div>
            <div class="form-group col-md-3">
                <?php echo e(Form::label('confirmDate', __('Confirm Date (*)'),['class'=>'form-label'])); ?>

                <?php echo e(Form::datetime('confirmDate', '', array('class' => 'form-control', 'required' => 'required'))); ?>

            </div>
            <div class="form-group col-md-3">
                <?php echo e(Form::label('salesDate', __('Sales Date (*)'),['class'=>'form-label'])); ?>

                <?php echo e(Form::date('salesDate', '', array('class' => 'form-control', 'required' => 'required'))); ?>

            </div>
            <div class="form-group col-md-3">
                <?php echo e(Form::label('stockReleseDate', __('Stock Release Date'),['class'=>'form-label'])); ?>

                <?php echo e(Form::datetime('stockReleseDate', '', array('class' => 'form-control'))); ?>

            </div>
            <div class="form-group col-md-3">
                <?php echo e(Form::label('receiptPublishDate', __('Receipt Publish Date (*)'),['class'=>'form-label'])); ?>

                <?php echo e(Form::datetime('receiptPublishDate', '', array('class' => 'form-control', 'required' => 'required'))); ?>

            </div>
            <div class="form-group col-md-3">
                <?php echo e(Form::label('occurredDate', __('Occurred Date (*)'),['class'=>'form-label'])); ?>

                <?php echo e(Form::date('occurredDate', '', array('class' => 'form-control', 'required' => 'required'))); ?>

            </div>
            <div class="form-group col-md-3">
                <?php echo e(Form::label('invoiceStatusCode', __('Invoice Status'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::select('invoiceStatusCode', $invoiceStatusCodes, null, ['class' => 'form-control'])); ?>

            </div>
            <div class="form-group col-md-3">
                <?php echo e(Form::label('isPurchaseAccept', __('Purchase Accepted?'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::select('isPurchaseAccept', ['true' => 'Yes', 'false' => 'No'], null, ['class' => 'form-control'])); ?>

            </div>
            <div class="form-group col-md-3">
                <?php echo e(Form::label('isStockIOUpdate', __('Stock IO Update?'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::select('isStockIOUpdate', ['true' => 'Yes', 'false' => 'No'], null, ['class' => 'form-control'])); ?>

            </div>
            <div class="form-group col-md-3">
                <?php echo e(Form::label('mapping', __('Mapping'),['class'=>'form-label'])); ?>

                <?php echo e(Form::text('mapping', '', array('class' => 'form-control'))); ?>

            </div>
            <div class="form-group col-md-6">
                <?php echo e(Form::label('remark', __('Remark'),['class'=>'form-label'])); ?>

                <?php echo e(Form::textarea('remark', '', array('class' => 'form-control', 'rows' => '3'))); ?>

            </div>
            <div class="form-group col-md-6">
                <?php echo e(Form::label('description', __('Description'),['class'=>'form-label'])); ?>

                <?php echo e(Form::textarea('description', '', ['class'=>'form-control','rows'=>'3'])); ?>

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
                        <table class="table mb-0">
                            <thead>
                            </thead>
                            <tbody data-repeater-list="items" id="sortable-table">
                                <tr class="row p-3 ui-sortable" data-repeater-item data-clone>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('item', __('Item (*)'),['class'=>'form-label'])); ?>

                                        <?php echo e(Form::select('item', $itemsToAdd, null, ['class' => 'form-control itemCode', 'required' => 'required'])); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('price', __('Unit Price (*)'),['class'=>'form-label'])); ?>

                                        <?php echo e(Form::number('price', '', array('class' => 'form-control unitPrice', 'required' => 'required'))); ?>

                                        <small>Subject to change by user</small>
                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('pkgQuantity', __('Package Quantity (*)'),['class'=>'form-label'])); ?>

                                        <?php echo e(Form::number('pkgQuantity', '', array('class' => 'form-control pkgQuantity', 'required' => 'required'))); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('quantity', __('Quantity (*)'),['class'=>'form-label'])); ?>

                                        <?php echo e(Form::number('quantity', '', array('class' => 'form-control quantity', 'required' => 'required'))); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('discountRate', __('Discount Rate'),['class'=>'form-label'])); ?>

                                        <?php echo e(Form::number('discountRate', '', array('class' => 'form-control discountRate', 'required' => 'required'))); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('discountAmt', __('Discount Amount'),['class'=>'form-label'])); ?>

                                        <?php echo e(Form::number('discountAmt', '', array('class' => 'form-control discountAmt', 'readonly' => true))); ?>

                                    </td>
                                    <td class="form-group col-md-3">
                                        <?php echo e(Form::label('itemExprDate', __('Item Expiry Date'),['class'=>'form-label'])); ?>

                                        <?php echo e(Form::date('itemExprDate',null,array('class'=>'form-control'))); ?>

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
        <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn btn-light" data-bs-dismiss="modal">
        <input type="submit" value="<?php echo e(__('Add')); ?>" class="btn  btn-primary">
    </div>
<?php echo e(Form::close()); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-page'); ?>
    <script>
        const customerNameField = document.querySelector('.customerName');
        const customerTinField = document.querySelector('.customerTin');
        customerNameField.addEventListener('change', async function () {
            const url = `http://localhost:8000/getcustomerbyname/${this.value}`;
            const response = await fetch(url);
            const { data } = await response.json();
            const { customerTin, customerNo, contact } = data;
            customerTinField.value = customerTin;
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp-go-6.4-using-laravel\resources\views/creditNote/create.blade.php ENDPATH**/ ?>