
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
            function calculateSubtotal() {
                var inputs = $(".amount");
                var subTotal = 0;
                for (var i = 0; i < inputs.length; i++) {
                    subTotal += parseFloat($(inputs[i]).text());
                }
                
                var discounts = $(".discountAmount");
                var totalDiscount = 0;
                for (var i = 0; i < discounts.length; i++) {
                    totalDiscount += parseFloat($(discounts[i]).val()) || parseFloat(0);
                }
                
                var taxAmounts = $(".taxAmount");
                var totalTax = 0;
                for (var i = 0; i < taxAmounts.length; i++) {
                    totalTax += parseFloat($(taxAmounts[i]).val()) || parseFloat(0);
                }
                
                const stot = (subTotal + totalDiscount) - totalTax;
                $('.subTotal').html(stot.toFixed(2));
                $('.totalAmount').html(subTotal.toFixed(2));
            }
            
            function calculateTotalDiscount() {
                var discounts = $(".discountAmount");
                var totalDiscount = 0;
                for (var i = 0; i < discounts.length; i++) {
                    totalDiscount += parseFloat($(discounts[i]).val()) || parseFloat(0);
                }
                $('.totalDiscount').html(totalDiscount.toFixed(2));
            }
            
            function calculateTotalTax() {
                var taxAmounts = $(".taxAmount");
                var totalTax = 0;
                for (var i = 0; i < taxAmounts.length; i++) {
                    totalTax += parseFloat($(taxAmounts[i]).val()) || parseFloat(0);
                }
                $('.totalTax').html(totalTax.toFixed(2));
            }
            
            calculateSubtotal();
            calculateTotalDiscount();
            calculateTotalTax();
            
            $(document).on('change', '.quantity, .unitPrice, .pkgQuantity, .discount, .taxCode', function() {
                calculateSubtotal();
                calculateTotalDiscount();
                calculateTotalTax();
            });
            
            $(document).on('click', '[data-repeater-delete]', function () {
                calculateSubtotal();
                calculateTotalDiscount();
                calculateTotalTax();
            });
            
            $(document).on('change', '.itemCode', async function() {
                const el = $(this);
                const id = $(this).val();
                console.log('ITEM CD: ', id);
                const url = `http://localhost:8000/getitem/${id}`;

                const response = await fetch(url);
                const { data } = await response.json();

                const { dftPrc, taxTyCd } = data;


                $(el).closest('tr').find('.unitPrice').val(dftPrc);

                const taxationtypes= <?php echo json_encode($taxationtype); ?>;
                console.log(taxationtypes);
                $(el).closest('tr').find('.taxCode').val(taxationtypes[taxTyCd]);

                const quantity = parseFloat($(el).closest('tr').find('.quantity').val()) || parseFloat(0);
                const unitPrice = parseFloat($(el).closest('tr').find('.unitPrice').val()) || parseFloat(0);
                const discountRate = parseFloat($(el).closest('tr').find('.discount').val()) || parseFloat(0);
                const taxCode = parseFloat($(el).closest('tr').find('.taxCode').val()) || parseFloat(0);
                const pkgQuantity = parseFloat($(el).closest('tr').find('.pkgQuantity').val()) || parseFloat(0);
                const subtotal = quantity * unitPrice * pkgQuantity;
                const discountAmount = subtotal * (discountRate / 100);
                const totalAmount = subtotal - discountAmount;
                const taxAmount = totalAmount * (taxCode / 100);
                const finalAmount = totalAmount + taxAmount;

                $(el).closest('tr').find('.taxAmount').val(parseFloat(taxAmount));
                $(el).closest('tr').find('.discountAmount').val(parseFloat(discountAmount));
                $(el).closest('tr').find('.amount').html(parseFloat(finalAmount));

            });

            $(document).on('keyup change', '.quantity', function() {
                const el = $(this);
                const quantity = parseFloat($(this).val()) || parseFloat(0);
                const unitPrice = parseFloat($(el).closest('tr').find('.unitPrice').val()) || parseFloat(0);
                const discountRate = parseFloat($(el).closest('tr').find('.discount').val()) || parseFloat(0);
                const taxCode = parseFloat($(el).closest('tr').find('.taxCode').val()) || parseFloat(0);
                const pkgQuantity = parseFloat($(el).closest('tr').find('.pkgQuantity').val()) || parseFloat(0);
                const subtotal = quantity * unitPrice * pkgQuantity;
                const discountAmount = subtotal * (discountRate / 100);
                const totalAmount = subtotal - discountAmount;
                const taxAmount = totalAmount * (taxCode / 100);
                const finalAmount = totalAmount + taxAmount;
            
                $(el).closest('tr').find('.taxAmount').val(parseFloat(taxAmount));
                $(el).closest('tr').find('.discountAmount').val(parseFloat(discountAmount));
                $(el).closest('tr').find('.amount').html(parseFloat(finalAmount));
            });

            $(document).on('keyup change', '.taxCode', function() {
                const el = $(this);
                const taxCode = parseFloat($(this).val()) || parseFloat(0);
                const unitPrice = parseFloat($(el).closest('tr').find('.unitPrice').val()) || parseFloat(0);
                const discountRate = parseFloat($(el).closest('tr').find('.discount').val()) || parseFloat(0);
                const quantity = parseFloat($(el).closest('tr').find('.quantity').val()) || parseFloat(0);
                const pkgQuantity = parseFloat($(el).closest('tr').find('.pkgQuantity').val()) || parseFloat(0);
                const subtotal = quantity * unitPrice * pkgQuantity;
                const discountAmount = subtotal * (discountRate / 100);
                const totalAmount = subtotal - discountAmount;
                const taxAmount = totalAmount * (taxCode / 100);
                const finalAmount = totalAmount + taxAmount;
            
                $(el).closest('tr').find('.taxAmount').val(parseFloat(taxAmount));
                $(el).closest('tr').find('.discountAmount').val(parseFloat(discountAmount));
                $(el).closest('tr').find('.amount').html(parseFloat(finalAmount));
            });

            $(document).on('keyup change', '.unitPrice', function() {
                const el = $(this);
                const unitPrice = parseFloat($(this).val()) || parseFloat(0);
                const quantity = parseFloat($(el).closest('tr').find('.quantity').val()) || parseFloat(0);
                const discountRate = parseFloat($(el).closest('tr').find('.discount').val()) || parseFloat(0);
                const taxCode = parseFloat($(el).closest('tr').find('.taxCode').val()) || parseFloat(0);
                const pkgQuantity = parseFloat($(el).closest('tr').find('.pkgQuantity').val()) || parseFloat(0);
                const subtotal = quantity * unitPrice * pkgQuantity;
                const discountAmount = subtotal * (discountRate / 100);
                const totalAmount = subtotal - discountAmount;
                const taxAmount = totalAmount * (taxCode / 100);
                const finalAmount = totalAmount + taxAmount;
            
                $(el).closest('tr').find('.taxAmount').val(parseFloat(taxAmount));
                $(el).closest('tr').find('.discountAmount').val(parseFloat(discountAmount));
                $(el).closest('tr').find('.amount').html(parseFloat(finalAmount));
            });

            $(document).on('keyup change', '.discount', function() {


                const el = $(this);
                const discountRate = parseFloat($(this).val()) || parseFloat(0);
                const quantity = parseFloat($(el).closest('tr').find('.quantity').val()) || parseFloat(0);
                const unitPrice = parseFloat($(el).closest('tr').find('.unitPrice').val()) || parseFloat(0);
                const taxCode = parseFloat($(el).closest('tr').find('.taxCode').val()) || parseFloat(0);
                const pkgQuantity = parseFloat($(el).closest('tr').find('.pkgQuantity').val()) || parseFloat(0);
                const subtotal = quantity * unitPrice * pkgQuantity;
                const discountAmount = subtotal * (discountRate / 100);
                const totalAmount = subtotal - discountAmount;
                const taxAmount = totalAmount * (taxCode / 100);
                const finalAmount = totalAmount + taxAmount;
            
                $(el).closest('tr').find('.taxAmount').val(parseFloat(taxAmount));
                $(el).closest('tr').find('.discountAmount').val(parseFloat(discountAmount));
                $(el).closest('tr').find('.amount').html(parseFloat(finalAmount));
            });

            $(document).on('keyup change', '.pkgQuantity', function() {


                const el = $(this);
                const pkgQuantity = parseFloat($(this).val()) || parseFloat(0);
                const quantity = parseFloat($(el).closest('tr').find('.quantity').val()) || parseFloat(0);
                const unitPrice = parseFloat($(el).closest('tr').find('.unitPrice').val()) || parseFloat(0);
                const taxCode = parseFloat($(el).closest('tr').find('.taxCode').val()) || parseFloat(0);
                const discountRate = parseFloat($(el).closest('tr').find('.discount').val()) || parseFloat(0);
                const subtotal = quantity * unitPrice * pkgQuantity;
                const discountAmount = subtotal * (discountRate / 100);
                const totalAmount = subtotal - discountAmount;
                const taxAmount = totalAmount * (taxCode / 100);
                const finalAmount = totalAmount + taxAmount;

                $(el).closest('tr').find('.taxAmount').val(parseFloat(taxAmount));
                $(el).closest('tr').find('.discountAmount').val(parseFloat(discountAmount));
                $(el).closest('tr').find('.amount').html(parseFloat(finalAmount));
                });

                
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

                                        el.find('.spplrSdcId').val(supplier
                                        .spplrSdcId);

                                        el.find('.spplrMrcNo').val(supplier
                                        .spplrMrcNo);

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
                            <?php echo e(Form::label('spplrSdcId', __('Supplier SDC ID'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::text('spplrSdcId', null, ['class' => 'form-control spplrSdcId', 'required' => 'required'])); ?>

                        </div>
                        <div class="form-group col-md-4" id="vender-box">
                            <?php echo e(Form::label('spplrMrcNo', __('Supplier MRC No'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::text('spplrMrcNo', null, ['class' => 'form-control spplrMrcNo', 'required' => 'required'])); ?>

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
                        <div class="form-group col-md-4" id="vender-box">
                            <?php echo e(Form::label('rcptTyCd', __('Receipt Type Code'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::select('rcptTyCd', $ReceiptTypesCodes, null, ['class' => 'form-control select2 pmtTypeCode', 'required' => 'required'])); ?>

                        </div>
                        <div class="form-group col-md-4" id="vender-box">
                            <?php echo e(Form::label('purchDate', __('Purchase Date'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::date('purchDate', null, ['class' => 'form-control', 'required' => 'required'])); ?>

                        </div>
                        <div class="form-group col-md-4" id="vender-box">
                            <?php echo e(Form::label('occurredDate', __('Occurred Date'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::date('occurredDate', null, ['class' => 'form-control', 'required' => 'required'])); ?>

                        </div>
                        <div class="form-group col-md-4" id="vender-box">
                            <?php echo e(Form::label('confirmDate', __('Confirm Date'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::date('confirmDate', null, ['class' => 'form-control', 'required' => 'required'])); ?>

                        </div>
                        <div class="form-group col-md-4" id="vender-box">
                            <?php echo e(Form::label('category_id', __('Account Category (*)'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::select('category_id', $category, null, ['class' => 'form-control', 'required' => 'required'])); ?>

                        </div>
                        <div class="form-group col-md-4" id="vender-box">
                            <?php echo e(Form::label('warehouseDate', __('Warehouse Date'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::date('warehouseDate', null, ['class' => 'form-control', 'required' => 'required'])); ?>

                        </div>
                        <div class="form-group col-md-4" id="vender-box">
                            <?php echo e(Form::label('warehouse', __('Ware House'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::select('warehouse', $warehouse, null, ['class' => 'form-control select2 warehouse', 'required' => 'required'])); ?>

                        </div>
                        <div class="form-group col-md-4" id="vender-box">
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
                                <a href="#" data-repeater-create="" class="btn btn-primary" data-bs-toggle="modal" data-target="#add-bank">
                                    <i class="ti ti-plus"></i> <?php echo e(__('Add item')); ?>

                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-border-style mt-2">
                    <div class="table-responsive">
                        <table class="table  mb-0 table-custom-style" data-repeater-list="items" id="sortable-table">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('Items')); ?></th>
                                    <th><?php echo e(__('Quantity')); ?></th>
                                    <th><?php echo e(__('Price')); ?> </th>
                                    <th><?php echo e(__('Discount')); ?></th>
                                    <th><?php echo e(__('Tax')); ?> (%)</th>
                                    <th class="text-end">
                                        <?php echo e(__('Amount')); ?>

                                        <br>
                                        <small class="text-danger font-weight-bold"><?php echo e(__('after tax & discount')); ?></small>
                                    </th>
                                    <th></th>
                                </tr>
                            </thead>
                            
                            <tbody class="ui-sortable" data-repeater-item>
                                <tr>
                                    <td width="25%" class="form-group pt-0">
                                        <?php echo e(Form::select('item', $product_services,'', array('class' => 'form-control select2 itemCode','data-url'=>route('invoice.product'),'required'=>'required'))); ?>

                                    </td>
                                    <td>
                                        <div class="form-group price-input input-group search-form">
                                            <?php echo e(Form::text('quantity','', array('class' => 'form-control quantity','required'=>'required','placeholder'=>__('Qty'),'required'=>'required'))); ?>

                                            <?php echo e(Form::text('pkgQuantity','', array('class' => 'form-control pkgQuantity','required'=>'required','placeholder'=>__('Pkg Qty'),'required'=>'required'))); ?>

                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group price-input input-group search-form">
                                            <?php echo e(Form::text('price','', array('class' => 'form-control unitPrice','required'=>'required','placeholder'=>__('Price'),'required'=>'required'))); ?>

                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group price-input input-group search-form">
                                            <?php echo e(Form::text('discount','', array('class' => 'form-control discount','required'=>'required','placeholder'=>__('Discount')))); ?>

                                            <?php echo e(Form::text('discountAmount','', array('class' => 'form-control discountAmount','required'=>'required','placeholder'=>__('Discount')))); ?>

                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group price-input input-group search-form">
                                        <?php echo e(Form::text('tax', '', array('class' => 'form-control taxCode', 'required' => 'required','placeholder' => __('Tax')))); ?>

                                        <?php echo e(Form::text('taxAmount', '', array('class' => 'form-control taxAmount', 'required' => 'required','placeholder' => __('Tax Amt')))); ?>

                                        </div>
                                    </td>
                                    <td class="text-end amount">0.00</td>
                                    <td>
                                        <a href="#" class="ti ti-trash text-white repeater-action-btn bg-danger ms-2 bs-pass-para" data-repeater-delete></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div class="form-group">
                                            <?php echo e(Form::textarea('description', null, ['class'=>'form-control pro_description','rows'=>'2','placeholder'=>__('Description')])); ?>

                                        </div>
                                    </td>
                                    <td colspan="2">
                                        <div class="form-group">
                                        <?php echo e(Form::label('itemExprDate', __('item Expire Date'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::date('itemExprDate', null, ['class' => 'form-control itemExprDt', 'required' => 'required'])); ?>

                                        </div>
                                    </td>
                                    <td colspan="5"></td>
                                </tr>
                                <tr>
                                    <td class="form-group col-4">
                                        <?php echo e(Form::label('supplrItemName', __('Supplier Item Name'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::text('supplrItemName', '', array('class' => 'form-control', 'required' => 'required'))); ?>

                                    </td>
                                    <td class="form-group col-4">
                                        <?php echo e(Form::label('supplrItemCode', __('Supplier Item Code'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::text('supplrItemCode', '', array('class' => 'form-control', 'required' => 'required'))); ?>

                                    </td>
                                    <td class="form-group col-4">
                                        <?php echo e(Form::label('supplrItemClsCode', __('Supplier Item Class Code'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::text('supplrItemClsCode', '', array('class' => 'form-control', 'required' => 'required'))); ?>

                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td></td>
                                <td><strong><?php echo e(__('Sub Total')); ?> (<?php echo e(\Auth::user()->currencySymbol()); ?>)</strong></td>
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
                                <td class="blue-text"><strong><?php echo e(__('Total Amount')); ?> (<?php echo e(\Auth::user()->currencySymbol()); ?>)</strong></td>
                                <td class="text-end totalAmount blue-text"></td>
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp-go-6.4-using-laravel\resources\views/purchase/create.blade.php ENDPATH**/ ?>