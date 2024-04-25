<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Purchase Create')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('purchase.index')); ?>"><?php echo e(__('Purchase')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Purchase Create')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <?php echo e(Form::open(array('url' => 'purchase','class'=>'w-100'))); ?>

        <div class="row">
        <?php echo e(Form::open(['url' => 'purchase', 'class' => 'w-100'])); ?>

        <div class="col-12">
            <input type="hidden" name="_token" id="token" value="<?php echo e(csrf_token()); ?>">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-12" id="vender-box">
                            <?php echo e(Form::label('supplierName', __('Supplier Name'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::select('supplierName', $suppliers, null, ['class' => 'form-control select2 suppliers-field', 'required' => 'required', 'hidden' => false])); ?>

                        </div>
                        <div class="form-group col-md-4" id="vender-box">
                            <?php echo e(Form::label('supplierTin', __('Supplier Tin'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::text('supplierTin', null, ['class' => 'form-control tin-field', 'required' => 'required', 'disabled' => true, 'readonly' => true])); ?>

                        </div>
                        <div class="form-group col-md-4" id="vender-box">
                            <?php echo e(Form::label('supplierBhfId', __('Supplier BhfId'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::number('supplierBhfId', null, ['class' => 'form-control bhfid-field', 'required' => 'required', 'disabled' => true, 'readonly' => true])); ?>

                        </div>
                        <div class="form-group col-md-4" id="vender-box">
                            <?php echo e(Form::label('supplierInvNo', __('Supplier Invoice No'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::number('supplierInvNo', null, ['class' => 'form-control invno-field', 'required' => 'required', 'disabled' => true, 'readonly' => true])); ?>

                        </div>
                        <div class="form-group col-md-4" id="vender-box">
                            <?php echo e(Form::label('purchTypeCode', __('Purchase Type Code'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::text('purchTypeCode', null, ['class' => 'form-control bhfid-field'])); ?>

                        </div>
                        <div class="form-group col-md-4" id="vender-box">
                            <?php echo e(Form::label('purchStatusCode', __('Purchase Status Code'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::text('purchStatusCode', null, ['class' => 'form-control invno-field'])); ?>

                        </div>
                        <div class="form-group col-md-4" id="vender-box">
                            <?php echo e(Form::label('pmtTypeCode', __('Payment Type Code'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::text('pmtTypeCode', null, ['class' => 'form-control invno-field'])); ?>

                        </div>
                        <div class="form-group col-md-3">
                            <?php echo e(Form::label('purchDate', __('Purchase Date'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::date('purchDate', null, ['class' => 'form-control', 'required' => 'required'])); ?>

                        </div>
                        <div class="form-group col-md-3">
                            <?php echo e(Form::label('occurredDate', __('Occurred Date'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::date('occurredDate', null, ['class' => 'form-control', 'required' => 'required'])); ?>

                        </div>
                        <div class="form-group col-md-3">
                            <?php echo e(Form::label('confirmDate', __('Confirm Date'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::date('confirmDate', null, ['class' => 'form-control', 'required' => 'required'])); ?>

                        </div>
                        <div class="form-group col-md-3">
                            <?php echo e(Form::label('warehouseDate', __('Warehouse Date'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::date('warehouseDate', null, ['class' => 'form-control', 'required' => 'required'])); ?>

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
                        <div class="col-md-12 d-flex align-items-center justify-content-between justify-content-md-end">
                            <div class="all-button-box me-2">
                                <button type="button" class="btn btn-primary add-item-button">
                                    <i class="ti ti-plus"></i> <?php echo e(__('Add item')); ?>

                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table mb-0" data-repeater-list="items" id="sortable-table">
                            <thead>                            
                            </thead>
                            <tbody class="ui-sortable item-fieldsss" data-repeater-item>                            
                            <tr class="">
                                <td colspan="2">
                                    <?php echo e(Form::label('itemCode', __('Item Code'), ['class' => 'form-label'])); ?>

                                    <?php echo e(Form::select('itemCode', $product_services_Codes, null, ['class' => 'form-control select2 item_code', 'required' => 'required'])); ?>

                                </td>
                                <td colspan="2">
                                       <?php echo e(Form::label('supplritemClsCode', __('Supplier Item Cls Code'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::text('supplieritemClsCode', null, ['class' => 'form-control', 'required' => 'required'])); ?>

                                </td>
                                <td colspan="2">
                                      <?php echo e(Form::label('supplierItemCode', __('Supplier Item Code'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::text('supplrItemCode', null, ['class' => 'form-control', 'required' => 'required'])); ?>

                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                     <?php echo e(Form::label('quantity', __('Quantity'), ['class' => 'form-label'])); ?>

                                     <?php echo e(Form::number('quantity', null, ['class' => 'form-control quantity', 'required' => 'required'])); ?>

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

                                        <?php echo e(Form::number('discountRate', null, ['class' => 'form-control discount-rate-field', 'required' => 'required'])); ?>

                                </td>
                                <td colspan="2">
                                      <?php echo e(Form::label('discountAmt', __('Discount Amt'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::number('DiscountAmt', null, ['class' => 'form-control discount-amount-field', 'required' => 'required', 'disabled' => 'disabled', 'readonly' => true])); ?>

                                </td>
                                <td colspan="2">
                                      <?php echo e(Form::label('itemExprDt', __('item Expire Date'), ['class' => 'form-label'])); ?>

                                      <?php echo e(Form::date('itemExprDt', null, ['class' => 'form-control', 'required' => 'required'])); ?>

                                </td>
                            </tr>
                            <tr>
                                <td class="text-end"><?php echo e(__('Amount')); ?> <br><small class="text-danger font-weight-bold"><?php echo e(__('after tax & discount')); ?></small></td>
                                <td class="text-end amount">
                                    0.00
                                </td>
                                <td>
                                    <a href="#" class="ti ti-trash text-white text-white repeater-action-btn bg-danger ms-2" data-repeater-delete></a>
                                </td>
                            </tr>
                            </tbody>
                            <tfoot>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>    
        <div class="modal-footer">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" onclick="location.href = '<?php echo e(route("purchase.index")); ?>';" class="btn btn-light">
            <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn  btn-primary">
        </div>
    <?php echo e(Form::close()); ?>

    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-page'); ?>
    <script>
        const itemCodeField = document.querySelector('.item_code');
        const tinField = document.querySelector('#supplierTin');
        const unitPriceField = document.querySelector('.unit-price-field');
        const qtyCodeField = document.querySelector('.qty-code-field');
        const suppliersField = document.querySelector('.suppliers-field');
        const bhfidField = document.querySelector('.bhfid-field');
        const invoiceNoField = document.querySelector('.invno-field');
        const discountRateField = document.querySelector('.discount-rate-field');
        const discountAmountField = document.querySelector('.discount-amount-field');
        const addItemButton = document.querySelector('.add-item-button');
        // Listen for click events on the parent container
document.addEventListener('click', function(event) {
    // Check if the clicked element is the "Add item" button
    if (event.target.classList.contains('add-item-button')) {
        // Clone the item section
        const itemSection = document.querySelector('.item-fieldsss');
        const itemSectionClone = itemSection.cloneNode(true);
        const itemSectionParent = itemSection.parentNode;
        itemSectionParent.appendChild(itemSectionClone);

        // Remove IDs to avoid duplication
        itemSectionClone.removeAttribute('id');

        // Attach event listener to the cloned item code field
        const clonedItemCodeField = itemSectionClone.querySelector('.item_code');
        clonedItemCodeField.addEventListener('change', async function () {
            // Handle item code change event
            const itemCode = this.value;
            try {
                const response = await fetch(`http://localhost:8000/getitem/${itemCode}`);
                const data = await response.json();
                const unitPrice = data.data.dftPrc;
                const pkgQuantity = data.data.qtyUnitCd;
                const unitPriceField = itemSectionClone.querySelector('.unit-price-field');
                const qtyCodeField = itemSectionClone.querySelector('.qty-code-field');
                unitPriceField.value = unitPrice;
                qtyCodeField.value = pkgQuantity;
            } catch (error) {
                console.log('ITEM CODE', error);
            }
        });
    }
});


        itemCodeField.addEventListener('change', async function () {
            const itemCode = this.value;
            
            try {
                const response = await fetch(`http://localhost:8000/getitem/${itemCode}`);
                const data = await response.json();
                const unitPrice = data.data.dftPrc;
                const pkgQuantity = data.data.qtyUnitCd;
                
                unitPriceField.value = unitPrice;
                qtyCodeField.value = pkgQuantity;
                } catch (error) {
                    console.log('ITEM CODE', error);
                }
            });
            suppliersField.addEventListener('change', async function () {
                const supplierId = this.value;
                
                try {
                    const response = await fetch(`http://localhost:8000/getsupplier/${supplierId}`);
                    const data = await response.json();
                    const tin = data.data.spplrTin;
                    const bhfid = data.data.spplrBhfId;
                    const invoiceNo = data.data.spplrInvcNo;

                    tinField.value = tin;
                    bhfidField.value = bhfid;
                    invoiceNoField.value = invoiceNo;
                } catch (error) {
                    console.log('SUPPLIER', error);
                }
            });

            discountRateField.addEventListener('change', async function () {
                try {
                    const discountRate = this.value;
                    const unitPrice = unitPriceField.value;
                    const quantity = document.querySelector('.quantity').value;
                    const discountAmount = (unitPrice * quantity) * (discountRate / 100);
                    discountAmountField.value = discountAmount;
                } catch (error) {
                    console.log('DISCOUNT RATE', error);
                }
            });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/chrisdroid/Desktop/projects/php/erp-go-6.4-using-laravel/resources/views/purchase/create.blade.php ENDPATH**/ ?>