
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
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <?php echo e(Form::open(['url' => 'purchase', 'class' => 'w-100'])); ?>

        <div class="row">
            <?php echo e(Form::open(['url' => 'purchase', 'class' => 'w-100'])); ?>

            <div class="col-12">
                <input type="hidden" name="_token" id="token" value="<?php echo e(csrf_token()); ?>">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-4" id="vender-box">
                                <?php echo e(Form::label('supplierTin', __('Supplier Tin'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('supplierTin', null, ['class' => 'form-control tin-field', 'required' => 'required'])); ?>

                            </div>
                            <div class="form-group col-md-4" id="vender-box">
                                <?php echo e(Form::label('supplierBhfId', __('Supplier BhfId'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('supplierBhfId', null, ['class' => 'form-control bhfid-field', 'required' => 'required'])); ?>

                            </div>
                            <div class="form-group col-md-4" id="vender-box">
                                <?php echo e(Form::label('supplierInvcNo', __('Supplier Invoice No'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('supplierInvcNo', null, ['class' => 'form-control invno-field', 'required' => 'required'])); ?>

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
                            <div class="form-group col-md-3">
                                <?php echo e(Form::label('purchDate', __('Purchase Date'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('purchDate', null, ['class' => 'form-control', 'required' => 'required'])); ?>

                            </div>
                            <div class="form-group col-md-3">
                                <?php echo e(Form::label('occurredDate', __('Occurred Date'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('occurredDate', null, ['class' => 'form-control', 'required' => 'required'])); ?>

                            </div>
                            <div class="form-group col-md-3">
                                <?php echo e(Form::label('confirmDate', __('Confirm Date'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('confirmDate', null, ['class' => 'form-control', 'required' => 'required'])); ?>

                            </div>
                            <div class="form-group col-md-3">
                                <?php echo e(Form::label('warehouseDate', __('Warehouse Date'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('warehouseDate', null, ['class' => 'form-control', 'required' => 'required'])); ?>

                            </div>
                            <div class="form-group col-md-6" id="vender-box">
                                <?php echo e(Form::label('remark', __('Remark'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('remark', null, ['class' => 'form-control invno-field'])); ?>

                            </div>
                            <div class="form-group col-md-6" id="vender-box">
                                <?php echo e(Form::label('mapping', __('Mapping'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('mapping', null, ['class' => 'form-control invno-field'])); ?>

                            </div>
                        </div>
                        <div class="col-12">
                            <h5 class=" d-inline-block mb-4"><?php echo e(__('Product & Services')); ?></h5>
                            <div class="card repeater">
                                <div class="item-section py-2">
                                    <div class="row justify-content-between align-items-center">
                                        <div
                                            class="col-md-12 d-flex align-items-center justify-content-between justify-content-md-end">
                                            <div class="all-button-box me-2">

                                                <!-- Button when user click it will append all the data from form input below to the table below then empty the form for user to add new item then after adding new item click again empty the form append  data in the form below then empty the form as many time as they can  -->
                                                <button type="button" class="btn btn-primary add-item-button">
                                                    <i class="ti ti-plus"></i> <?php echo e(__('Add item')); ?>

                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body table-border-style">
                                    <div class="table-responsive">
                                        <table class="table mb-0" data-repeater-list="items">
                                            <thead>
                                            </thead>
                                            <tbody class="ui-sortable item-fieldsss" data-repeater-item>
                                                <tr class="">
                                                    <td colspan="2">
                                                        <?php echo e(Form::label('itemCode', __('Item Code'), ['class' => 'form-label'])); ?>

                                                        <?php echo e(Form::select('itemCode', $product_services_Codes, null, ['class' => 'form-control select2 item_code', 'required' => 'required', 'id' => 'itemCode'])); ?>

                                                    </td>
                                                    <td colspan="2">
                                                        <?php echo e(Form::label('supplritemClsCode', __('Supplier Item Cls Code'), ['class' => 'form-label'])); ?>

                                                        <?php echo e(Form::text('supplieritemClsCode', null, ['class' => 'form-control', 'required' => 'required', 'id' => 'supplieritemClsCode'])); ?>

                                                    </td>
                                                    <td colspan="2">
                                                        <?php echo e(Form::label('supplierItemCode', __('Supplier Item Code'), ['class' => 'form-label'])); ?>

                                                        <?php echo e(Form::text('supplrItemCode', null, ['class' => 'form-control', 'required' => 'required', 'id' => 'supplrItemCode'])); ?>

                                                    </td>
                                                    <td colspan="2">

                                                        <?php echo e(Form::label('supplierItemName', __('Supplier Item Name'), ['class' => 'form-label'])); ?>

                                                        <?php echo e(Form::text('supplierItemName', null, ['class' => 'form-control', 'required' => 'required', 'id' => 'supplierItemName'])); ?>

                                    </div>
                                    </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <?php echo e(Form::label('quantity', __('Quantity'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::number('quantity', null, ['class' => 'form-control quantity', 'required' => 'required', 'id' => 'quantity'])); ?>

                                        </td>
                                        <td colspan="2">
                                            <?php echo e(Form::label('unitPrice', __('Unit Price'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::number('unitPrice', null, ['class' => 'form-control unit-price-field', 'required' => 'required', 'disabled' => true, 'readonly' => true, 'id' => 'unit_price'])); ?>

                                        </td>
                                        <td colspan="2">
                                            <?php echo e(Form::label('pkgQuantity', __('Pkg Quantity Code'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::text('pkgQuantity', null, ['class' => 'form-control qty-code-field', 'required' => 'required', 'disabled' => true, 'readonly' => true, 'id' => 'pkg_quantity'])); ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <?php echo e(Form::label('discountRate', __('Discount Rate (%)'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::number('discountRate', null, ['class' => 'form-control discount-rate-field', 'required' => 'required', 'id' => 'discountRate'])); ?>

                                        </td>
                                        <td colspan="2">
                                            <?php echo e(Form::label('discountAmt', __('Discount Amt'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::number('DiscountAmt', null, ['class' => 'form-control discount-amount-field', 'required' => 'required', 'disabled' => 'disabled', 'readonly' => true, 'id' => 'DiscountAmt'])); ?>

                                        </td>
                                        <td colspan="2">
                                            <?php echo e(Form::label('itemExprDt', __('item Expire Date'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::date('itemExprDt', null, ['class' => 'form-control', 'required' => 'required', 'id' => 'itemExprDt'])); ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-end">
                                        </td>
                                        <td class="text-end amount">
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                    </tbody>
                                    <!-- Append the data input from the form above below and empty the form in order to add new one  as many time as user can  -->
                                    <div class="card-body table-border-style">
                                        <div class="table-responsive">
                                            <table class="table mb-0" data-repeater-list="items" id="sortable-table">
                                                <thead>
                                                    <tr>
                                                        <th>Item Code</th>
                                                        <th>SpplrItemCode</th>
                                                        <th>SpplrItemCode</th>
                                                        <th>SpplrItemName</th>
                                                        <th>Qty</th>
                                                        <th>UnitPrc</th>
                                                        <th>PkgQtyCode</th>
                                                        <th>DscntRate</th>
                                                        <th>DscntAmt</th>
                                                        <th>ItemEpxrDate</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="ui-sortable" data-repeater-item>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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

            <?php $__env->startPush('script-page'); ?>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const itemCodeField = document.querySelector('.item_code');
                        const unitPriceField = document.querySelector('.unit-price-field');
                        const pkgQuantityField = document.querySelector('.qty-code-field');
                        const discountRateField = document.querySelector('.discount-rate-field');
                        const discountAmountField = document.querySelector('.discount-amount-field');

                        itemCodeField.addEventListener('change', async function() {
                            const itemCode = this.value;

                            try {
                                const response = await fetch(`http://localhost:8000/getitem/${itemCode}`);
                                const data = await response.json();

                                if (data.status === 'success') {
                                    const {
                                        dftPrc,
                                        qtyUnitCd
                                    } = data.data;
                                    unitPriceField.value = dftPrc;
                                    pkgQuantityField.value = qtyUnitCd;
                                } else {
                                    console.error('Item not found');
                                }
                            } catch (error) {
                                console.error('Error fetching item:', error);
                            }
                        });

                        discountRateField.addEventListener('change', function() {
                            try {
                                const discountRate = parseFloat(this.value);
                                const unitPrice = parseFloat(unitPriceField.value);
                                const quantity = parseFloat(document.querySelector('.quantity').value);
                                const discountAmount = (unitPrice * quantity) * (discountRate / 100);
                                discountAmountField.value = discountAmount.toFixed(2);
                            } catch (error) {
                                console.error('Error calculating discount amount:', error);
                            }
                        });
                    });



                    /*****************************************************
                     * 
                     * 
                     * 
                     */

                    $(document).ready(function() {
                        const addItemButton = $('.add-item-button');
                        const itemTable = $('#sortable-table tbody.ui-sortable'); // Target for appending data

                        // Function to create a new table row with form data
                        function createTableRow(itemCodeData, supplieritemClsCode, supplierItemCode, supplierItemName, quantity,
                            unitPrice,
                            pkgQuantity, discountRate, discountAmount, itemExprDt) {
                            const newRow = ` <tr>
            <td>${itemCodeData}</td>
            <td>${supplieritemClsCode}</td>
            <td>${supplierItemCode}</td>
            <td>${supplierItemName}</td>
            <td>${quantity}</td>
            <td>${unitPrice}</td>
            <td>${pkgQuantity}</td>
            <td>${discountRate}</td>
            <td>${discountAmount}</td>
            <td>${itemExprDt}</td>
            <td>
                <a href="#" class="ti ti-trash text-white text-white repeater-action-btn bg-danger ms-2" data-repeater-delete></a>
            </td>
            </tr>
        `;
                            return newRow;
                        }

                        // Add click event listener to the 'Add Item' button
                        addItemButton.click(function() {
                            // Get form data
                            const itemCodeData = $('#itemCode').val(); // Assuming this is a select element
                            const supplieritemClsCode = $('#supplieritemClsCode').val();
                            const supplierItemCode = $('#supplrItemCode').val();
                            const supplierItemName = $('#supplierItemName').val();
                            const quantity = $('#quantity').val();
                            const unitPrice = $('#unit_price').val();
                            const pkgQuantity = $('#pkg_quantity').val();
                            const discountRate = $('#discountRate').val();
                            const discountAmount = $('#DiscountAmt').val();
                            const itemExprDt = $('#itemExprDt').val();

                            // Validate form data (optional)
                            if (!itemCodeData || !supplieritemClsCode || !supplierItemCode || !supplierItemName || !
                                quantity || !unitPrice ||
                                !pkgQuantity || !discountRate || !discountAmount || !itemExprDt) {
                                alert('Please fill in all required fields!');
                                return;
                            }

                            // Create new table row with data
                            const newTableRow = createTableRow(itemCodeData, supplieritemClsCode, supplierItemCode,
                                supplierItemName,
                                quantity, unitPrice, pkgQuantity, discountRate, discountAmount, itemExprDt);

                            // Append the new row to the table
                            itemTable.append(newTableRow);

                            // Clear form fields (optional)
                            $('#itemCode').val('');
                            $('#supplieritemClsCode').val('');
                            $('#supplrItemCode').val('');
                            $('#supplierItemName').val('');
                            $('#quantity').val('');
                            $('#unit_price').val('');
                            $('#pkg_quantity').val('');
                            $('#discountRate').val('');
                            $('#DiscountAmt').val('');
                            $('#itemExprDt').val('');
                        });
                    });
                </script>
            <?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp-go-6.4-using-laravel\resources\views/purchase/create.blade.php ENDPATH**/ ?>