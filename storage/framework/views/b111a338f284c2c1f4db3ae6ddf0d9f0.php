
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Purchase Create')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('purchase.index')); ?>"><?php echo e(__('Purchase')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Purchase Create')); ?></li>
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


                                        console.log("Populating tax:", item.taxTyCd);
                                        el.find('.tax').val(item.taxTyCd);

                                        console.log("Populating itemClsCd:", item
                                            .itemClsCd);
                                        el.find('.itemClsCd').val(item.itemClsCd);

                                        console.log("Populating itemNm:", item
                                            .itemNm);
                                        el.find('.itemNm').val(item.itemNm);

                                        console.log("Populating Bcd:", item
                                            .bcd);
                                        el.find('.bcd').val(item.bcd);

                                        console.log("Populating PkgUnitCd:", item
                                            .pkgUnitCd);
                                        el.find('.pkgUnitCd').val(item.pkgUnitCd);

                                        console.log("Populating item Id:", item
                                            .id);
                                        el.find('.id').val(item.id);

                                        // Calculate tax based on taxTyCd
                                        var taxTyCd = item.taxTyCd;
                                        var taxRate = 0;

                                        if (taxTyCd === 'B') {
                                            taxRate = 16; // VAT 16%
                                        } else if (taxTyCd === 'E') {
                                            taxRate = 8; // VAT 8%
                                        }

                                        // Calculate item tax price based on unit price and tax rate
                                        var itemTaxPrice = parseFloat((taxRate / 100) * (item
                                            .dftPrc * 1));
                                        el.find('.itemTaxPrice').val(itemTaxPrice.toFixed(2));

                                        // Update total tax rate and display
                                        el.find('.itemTaxRate').val(taxRate.toFixed(2));

                                        // Trigger change event for affected fields
                                        el.find(
                                                '.itemTaxRate,.discount,.itemTaxPrice,.taxes,.amount'
                                            )
                                            .trigger('change');


                                        // Calculate item tax price based on unit price and tax rate
                                        var itemTaxPrice = parseFloat((taxRate / 100) * (item
                                            .dftPrc * 1));
                                        el.find('.itemTaxPrice').val(itemTaxPrice.toFixed(2));

                                        // Update total tax rate and display
                                        el.find('.itemTaxRate').val(taxRate.toFixed(2));

                                        // Trigger change event for affected fields
                                        $('.itemTaxRate, .discount, .itemTaxPrice,.taxes,.amount')
                                            .trigger(
                                                'change');

                                        // Calculate amount
                                        var amount = parseFloat(item.dftPrc);
                                        // Update total tax rate and display
                                        el.find('.amount').val(taxRate.toFixed(2));

                                        // Calculate subtotal
                                        var subtotal = parseFloat(item.dftPrc);
                                        // Update subtotal field
                                        el.find('.subTotal').val(subtotal.toFixed(2));

                                        // Calculate total amount
                                        var totalAmount = subtotal + parseFloat(itemTaxPrice);
                                        // Update total amount field
                                        el.find('.totalAmount').val(totalAmount.toFixed(2));

                                        // Update total tax field
                                        el.find('.totalTax').val(itemTaxPrice.toFixed(2));
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
            $(document).on('keyup change', '.quantity', function() {
                // var el = $(this).closest('.row');
                var el = $(this).closest('[data-clone]');
                var quantity = parseFloat($(this).val());
                var price = parseFloat($(el.find('.unitPrice')).val());
                var discount = parseFloat($(el.find('.discount')).val()) ||
                    0; // Use default value if discount is not provided
                var totalItemPrice = (quantity * price) - discount;
                var itemTaxRate = parseFloat($(el.find('.itemTaxRate')).val());
                var itemTaxPrice = parseFloat((itemTaxRate / 100) * totalItemPrice);
                $(el.find('.itemTaxPrice')).val(itemTaxPrice.toFixed(2));

                // Calculate total amount including tax
                var totalAmount = itemTaxPrice + totalItemPrice;
                $(el.find('.amount')).html(totalAmount.toFixed(2));

                // Update total tax price
                var totalItemTaxPrice = 0;
                el.siblings().find('.itemTaxPrice').each(function() {
                    totalItemTaxPrice += parseFloat($(this).val());
                });
                el.parent().find('.totalTax').html(totalItemTaxPrice.toFixed(2));

                // Update subtotal and total amount
                var totalItemPrice = 0;
                el.siblings().find('.quantity').each(function(index) {
                    totalItemPrice += parseFloat($('.unitPrice').eq(index).val()) * parseFloat($(
                        this).val());
                });
                el.parent().find('.subTotal').html(totalItemPrice.toFixed(2));
                var totalAmount = totalItemPrice + totalItemTaxPrice;
                el.parent().find('.totalAmount').html(totalAmount.toFixed(2));
            });

            $(document).on('keyup change', '.unitPrice', function() {
                // var el = $(this).closest('.row'); 
                var el = $(this).closest('[data-clone]');
                var price = parseFloat($(this).val());
                var quantity = parseFloat($(el.find('.quantity')).val());
                var discount = parseFloat($(el.find('.discount')).val()) ||
                    0; // Use default value if discount is not provided
                var totalItemPrice = (quantity * price) - discount;

                var itemTaxRate = parseFloat($(el.find('.itemTaxRate')).val());
                var itemTaxPrice = parseFloat((itemTaxRate / 100) * totalItemPrice);
                $(el.find('.itemTaxPrice')).val(itemTaxPrice.toFixed(2));

                // Calculate total amount including tax
                var totalAmount = itemTaxPrice + totalItemPrice;
                $(el.find('.amount')).html(totalAmount.toFixed(2));

                // Update subtotal and total amount
                var totalItemPrice = 0;
                el.siblings().find('.quantity').each(function(index) {
                    totalItemPrice += parseFloat($('.unitPrice').eq(index).val()) * parseFloat($(
                        this).val());
                });
                el.parent().find('.subTotal').html(totalItemPrice.toFixed(2));
                var totalItemTaxPrice = 0;
                el.siblings().find('.itemTaxPrice').each(function() {
                    totalItemTaxPrice += parseFloat($(this).val());
                });
                var totalAmount = totalItemPrice + totalItemTaxPrice;
                el.parent().find('.totalAmount').html(totalAmount.toFixed(2));
            });

            $(document).on('keyup change', '.discount', function() {
                var el = $(this).closest('[data-clone]'); // Find the closest clone form
                var discountRate = parseFloat($(this).val()) || 0;

                var price = parseFloat(el.find('.unitPrice').val());
                var quantity = parseFloat(el.find('.quantity').val());

                var totalItemPrice = (price * quantity) * (1 - discountRate / 100);
                var itemTaxRate = parseFloat(el.find('.itemTaxRate').val());
                var itemTaxPrice = parseFloat((itemTaxRate / 100) * totalItemPrice);
                el.find('.itemTaxPrice').val(itemTaxPrice.toFixed(2));

                var totalAmount = itemTaxPrice + totalItemPrice;
                el.find('.amount').html(totalAmount.toFixed(2));

                // Update total tax price
                var totalItemTaxPrice = 0;
                el.siblings().find('.itemTaxPrice').each(function() { // Find itemTaxPrice only in siblings
                    totalItemTaxPrice += parseFloat($(this).val());
                });
                el.parent().find('.totalTax').html(totalItemTaxPrice.toFixed(2));

                // Update subtotal and total amount
                var totalItemPrice = 0;
                el.siblings().find('.quantity').each(function(index) {
                    totalItemPrice += parseFloat(el.siblings().find('.unitPrice').eq(index).val()) *
                        parseFloat($(this).val());
                });
                el.parent().find('.subTotal').html(totalItemPrice.toFixed(2));

                // Calculate total discount amount
                var totalDiscountAmount = 0;
                el.closest('[data-clone]').find('.quantity').each(function(index) {
                    var discountRate = parseFloat($(this).closest('[data-clone]').find('.discount')
                        .eq(index).val()) || 0;
                    totalDiscountAmount += (parseFloat($(this).closest('[data-clone]').find(
                            '.unitPrice').eq(index).val()) *
                        parseFloat($(this).val())) * (discountRate / 100);
                });

                // Update total discount and Discount Amount input field for the closest cloned form
                el.parent().find('.totalDiscount').html(totalDiscountAmount.toFixed(2));
                el.closest('[data-clone]').find('.discountAmt').val(totalDiscountAmount.toFixed(2));

                // Update total amount
                var totalAmount = totalItemPrice + totalItemTaxPrice;
                el.parent().find('.totalAmount').html(totalAmount.toFixed(2));
            });

            // Initialize Select2 for all select elements with the class 'select2'
            $('.select2').select2({
                templateResult: function(data) {
                    var $option = $(data.element);
                    return $option.data('text') || data.text;
                }
            });
        });

        $(document).ready(function() {
    $(document).on('change', '.supplierName', function() {
        var supplier_Info = $(this).val();
        var url = $(this).data('url');
        var el = $(this).closest('[data-autofill]');

        if (el.length) {
            console.log("Change event triggered for .supplierName[data-autofill]");

            console.log("supplier_Info:", supplier_Info);
            console.log("url:", url);
            console.log("el:", el);

            $.ajax({
                url: url,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': jQuery('#token').val()
                },
                data: {
                    'supplierName': supplier_Info
                },
                cache: false,
                success: function(data) {
                    try {
                        console.log("supplier information:", data);

                        if (!data || Object.keys(data).length === 0) {
                            console.log("Supplier information is empty.");
                        } else {
                            console.log(
                                "Supplier information is not empty. Processing...");

                            var supplier = data.data;

                            console.log("Supplier object:", supplier);

                            console.log("Populating supplierName:", supplier
                                .spplrNm);
                            el.find('.supplierName').val(supplier.spplrNm);

                            console.log("Populating supplierTin:", supplier
                                .spplrTin);
                            el.find('.supplierTin').val(supplier.spplrTin);

                            console.log("Populating supplierBhfId:", supplier
                                .spplrBhfId);
                            el.find('.supplierBhfId').val(supplier.spplrBhfId);

                            console.log("Populating SupplierInvoiceNo:", supplier
                                .spplrInvcNo);
                            el.find('.supplierInvcNo').val(supplier
                                .spplrInvcNo);

                            console.log("Populating supplier Id:", supplier.id);
                            el.find('.id').val(supplier.id);
                        }
                    } catch (error) {
                        console.error("Error processing Supplier Information:", error);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error retrieving Supplier Information:", error);
                }
            });
        }
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
    <div class="row">
        <?php echo e(Form::open(['url' => 'purchase', 'class' => 'w-100'])); ?>

        <div class="col-12">
            <input type="hidden" name="_token" id="token" value="<?php echo e(csrf_token()); ?>">
            <div class="card">
                <div class="card-body" data-autofill>
                    <div class="row">
                        <div class="form-group col-md-4" id="vender-box">
                            <?php echo e(Form::label('SupplierName', __('supplierName'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::select('supplierName', $venders, '', ['class' => 'form-control select2 supplierName', 'data-url' => route('venders.getSupplierInformation'), 'required' => 'required'])); ?>

                        </div>
                            <div class="form-group col-md-4" id="vender-box">
                            <?php echo e(Form::label('supplier_id', __('supplier Id'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::text('supplier_id', null, ['class' => 'form-control id', 'required' => 'required'])); ?>

                        </div>
                        <div class="form-group col-md-4" id="vender-box">
                            <?php echo e(Form::label('supplierTin', __('Supplier Tin'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::text('supplierTin', null, ['class' => 'form-control supplierTin', 'required' => 'required'])); ?>

                        </div>
                        <div class="form-group col-md-4" id="vender-box">
                            <?php echo e(Form::label('supplierBhfId', __('Supplier BhfId'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::text('supplierBhfId', null, ['class' => 'form-control supplierBhfId', 'required' => 'required'])); ?>

                        </div>
                        <div class="form-group col-md-4" id="vender-box">
                            <?php echo e(Form::label('supplierInvcNo', __('Supplier Invoice No'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::text('supplierInvcNo', null, ['class' => 'form-control supplierInvcNo', 'required' => 'required'])); ?>

                        </div>
                        <div class="form-group col-md-4" id="vender-box">
                            <?php echo e(Form::label('purchTypeCode', __('Purchase Type Code'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::select('purchTypeCode', $purchaseTypeCodes, null, ['class' => 'form-control select2 purchTypeCode', 'required' => 'required'])); ?>

                        </div>
                        <div class="form-group col-md-4" id="vender-box">
                            <?php echo e(Form::label('purchStatusCode', __('Purchase Status Code'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::select('purchStatusCode', $purchaseStatusCodes, null, ['class' => 'form-control select2 purchStatusCode', 'required' => 'required'])); ?>

                        </div>
                        <div class="form-group col-md-4" id="vender-box">
                            <?php echo e(Form::label('pmtTypeCode', __('Payment Type Code'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::select('pmtTypeCode', $paymentTypeCodes, null, ['class' => 'form-control select2 pmtTypeCode', 'required' => 'required'])); ?>

                        </div>
                        <div  class="form-group col-md-4" id="vender-box">
                            <?php echo e(Form::label('purchDate', __('Purchase Date'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::date('purchDate', null, ['class' => 'form-control', 'required' => 'required'])); ?>

                        </div>
                        <div  class="form-group col-md-4" id="vender-box">
                            <?php echo e(Form::label('occurredDate', __('Occurred Date'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::date('occurredDate', null, ['class' => 'form-control', 'required' => 'required'])); ?>

                        </div>
                        <div  class="form-group col-md-4" id="vender-box">
                            <?php echo e(Form::label('confirmDate', __('Confirm Date'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::date('confirmDate', null, ['class' => 'form-control', 'required' => 'required'])); ?>

                        </div>
                        <div class="form-group col-md-4" id="vender-box">
                                    <?php echo e(Form::label('category_id', __('Account Category (*)'), ['class' => 'form-label'])); ?>

                                    <?php echo e(Form::select('category_id', $category, null, ['class' => 'form-control', 'required' => 'required'])); ?>

                                </div>
                        <div  class="form-group col-md-4" id="vender-box">
                            <?php echo e(Form::label('warehouseDate', __('Warehouse Date'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::date('warehouseDate', null, ['class' => 'form-control', 'required' => 'required'])); ?>

                        </div>
                        <div class="form-group col-md-4" id="vender-box">
                            <?php echo e(Form::label('warehouse', __('Ware House'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::select('warehouse', $warehouse, null, ['class' => 'form-control select2 warehouse', 'required' => 'required'])); ?>

                        </div>
                        <div  class="form-group col-md-4" id="vender-box">
                            <?php echo e(Form::label('mapping', __('Mapping'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::text('mapping', null, ['class' => 'form-control invno-field'])); ?>

                        </div>
                        <div class="form-group col-md-6" id="vender-box">
                            <?php echo e(Form::label('remark', __('Remark'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::textarea('remark', null, ['class' => 'form-control item_standard_name', 'rows' => '2', 'placeholder' => __('Remark')])); ?>

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
                                    <td width="25%" class="form-group pt-1">
                                        <?php echo e(Form::label('itemCode', __('Item Code'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::select('itemCode', $product_services_Codes, '', ['class' => 'form-control select2 itemCode', 'data-url' => route('productservice.getiteminformation'), 'required' => 'required'])); ?>

                                    </td>                                   
                                </tr>
                                <tr>
                                    <td>
                                        <?php echo e(Form::label('supplritemClsCode', __('Supplier Item Cls Code'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::text('supplrItemClsCode', null, ['class' => 'form-control', 'required' => 'required'])); ?>

                                        <small class="text-dark">Supplier Item Cls Code length must be 8 characters
                                        </small>
                                    </td>
                                    <td>
                                        <?php echo e(Form::label('supplierItemCode', __('Supplier Item Code'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::text('supplrItemCode', null, ['class' => 'form-control supplierItemCode', 'required' => 'required'])); ?>

                                    </td>
                                    <td>
                                        <?php echo e(Form::label('supplrItemName', __('Supplier Item Name'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::text('supplrItemName', null, ['class' => 'form-control supplrItemName', 'required' => 'required'])); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php echo e(Form::label('quantity', __('Quantity'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::number('quantity', null, ['class' => 'form-control quantity', 'required' => 'required', 'placeholder' => __('Quantity'), 'required' => 'required'])); ?>

                                    </td>
                                    <td>
                                        <?php echo e(Form::label('unitPrice', __('Unit Price'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::number('unitPrice', null, ['class' => 'form-control unitPrice', 'required' => 'required', 'placeholder' => __('unitPrice'), 'required' => 'required'])); ?>


                                    </td>
                                    <td>
                                        <?php echo e(Form::label('pkgQuantity', __('Pkg Quantity'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::number('pkgQuantity', null, ['class' => 'form-control pkgQuantity', 'required' => 'required'])); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php echo e(Form::label('discount', __('Discount Rate (%)'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::number('discount', null, ['class' => 'form-control discount', 'required' => 'required'])); ?>

                                    </td>
                                    <td>
                                        <?php echo e(Form::label('discountAmt', __('Discount Amount'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::text('discountAmt', null, ['class' => 'form-control discountAmt', 'required' => 'required'])); ?>

                                    </td>
                                    <td>
                                        <?php echo e(Form::label('itemExprDt', __('item Expire Date'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::date('itemExprDt', null, ['class' => 'form-control itemExprDt', 'required' => 'required'])); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#"
                                            class="ti ti-trash text-white text-white repeater-action-btn bg-danger ms-2"
                                            data-repeater-delete></a>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td></td>
                                    <td><strong><?php echo e(__('Amount')); ?> <br><small
                                                class="text-danger font-weight-bold"><?php echo e(__('after  Tax & discount')); ?></small>
                                            (<?php echo e(\Auth::user()->currencySymbol()); ?>)</strong></td>
                                    <td class="text-end amount">0.00</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td></td>
                                    <td><strong><?php echo e(__('Sub Total')); ?> (<?php echo e(\Auth::user()->currencySymbol()); ?>)</strong>
                                    </td>
                                    <td class="text-end subTotal">0.00</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td></td>
                                    <td><strong><?php echo e(__('Discount')); ?> (<?php echo e(\Auth::user()->currencySymbol()); ?>)</strong></td>
                                    <td class="text-end totalDiscount">0.00</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td></td>
                                    <td><strong><?php echo e(__('Tax')); ?> (<?php echo e(\Auth::user()->currencySymbol()); ?>)</strong></td>
                                    <td class="text-end totalTax">0.00</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td class="blue-text"><strong><?php echo e(__('Total Amount')); ?>

                                            (<?php echo e(\Auth::user()->currencySymbol()); ?>)</strong></td>
                                    <td class="blue-text text-end totalAmount">0.00</td>
                                    <td></td>
                                </tr>
                            </tfoot>
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











<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Developer\Desktop\apps\erp-go-6.4-using-laravel\resources\views/purchase/create.blade.php ENDPATH**/ ?>