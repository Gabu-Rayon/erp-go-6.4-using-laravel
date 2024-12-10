
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Credit Note Detail')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('credit.note')); ?>"><?php echo e(__('Credit Notes')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e($creditNote->traderInvoiceNo ?? null); ?></li>
<?php $__env->stopSection(); ?>
<?php
    $settings = Utility::settings();
?>
<?php $__env->startPush('css-page'); ?>
    <style>
        #card-element {
            border: 1px solid #a3afbb !important;
            border-radius: 10px !important;
            padding: 10px !important;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="invoice">
                        <div class="invoice-print">
                            <div class="row invoice-title mt-2">
                                <div class="col-xs-12 col-sm-12 col-nd-6 col-lg-6 col-12">
                                    <h4><?php echo e(__('Credit Note')); ?></h4>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-nd-6 col-lg-6 col-12 text-end">
                                    <h4 class="invoice-number">
                                        <?php echo e($creditNote->traderInvoiceNo ?? null); ?></h4>
                                </div>
                                <div class="col-12">
                                    <hr>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-end">
                                    <div class="d-flex align-iteams-center justify-content-end">
                                        <div class="me-4">
                                            <small>
                                                <strong><?php echo e(__('Issue Date')); ?> :</strong><br>
                                                <?php echo e(\Auth::user()->dateFormat($creditNote->salesDate)); ?><br><br>
                                            </small>
                                        </div>
                                        <div>
                                            <small>
                                                <strong><?php echo e(__('Occured Date')); ?> :</strong><br>
                                                <?php echo e(\Auth::user()->dateFormat($creditNote->occuredDate)); ?><br><br>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col">
                                    <small class="font-style">
                                        <strong><?php echo e(__('Billed To')); ?> :</strong><br>
                                        <?php if(!empty($customer->billing_name)): ?>
                                            <?php echo e(!empty($customer->billing_name) ? $customer->billing_name : ''); ?><br>
                                            <?php echo e(!empty($customer->billing_address) ? $customer->billing_address : ''); ?><br>
                                            <?php echo e(!empty($customer->billing_city) ? $customer->billing_city : '' . ', '); ?><br>
                                            <?php echo e(!empty($customer->billing_state) ? $customer->billing_state : '' . ', '); ?>,
                                            <?php echo e(!empty($customer->billing_zip) ? $customer->billing_zip : ''); ?><br>
                                            <?php echo e(!empty($customer->billing_country) ? $customer->billing_country : ''); ?><br>
                                            <?php echo e(!empty($customer->billing_phone) ? $customer->billing_phone : ''); ?><br>
                                            <?php if($settings['vat_gst_number_switch'] == 'on'): ?>
                                                <strong><?php echo e(__('Tax Number ')); ?> :
                                                </strong><?php echo e(!empty($customer->tax_number) ? $customer->tax_number : ''); ?>

                                            <?php endif; ?>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>

                                    </small>
                                </div>

                                <?php if(App\Models\Utility::getValByName('shipping_display') == 'on'): ?>
                                    <div class="col ">
                                        <small>
                                            <strong><?php echo e(__('Shipped To')); ?> :</strong><br>
                                            <?php if(!empty($customer->shipping_name)): ?>
                                                <?php echo e(!empty($customer->shipping_name) ? $customer->shipping_name : ''); ?><br>
                                                <?php echo e(!empty($customer->shipping_address) ? $customer->shipping_address : ''); ?><br>
                                                <?php echo e(!empty($customer->shipping_city) ? $customer->shipping_city : '' . ', '); ?><br>
                                                <?php echo e(!empty($customer->shipping_state) ? $customer->shipping_state : '' . ', '); ?>,
                                                <?php echo e(!empty($customer->shipping_zip) ? $customer->shipping_zip : ''); ?><br>
                                                <?php echo e(!empty($customer->shipping_country) ? $customer->shipping_country : ''); ?><br>
                                                <?php echo e(!empty($customer->shipping_phone) ? $customer->shipping_phone : ''); ?><br>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </small>
                                    </div>
                                <?php endif; ?>
                                <!-- <?php
                                    try {
                                        $formattedDate = \Carbon\Carbon::createFromFormat(
                                            'YmdHis',
                                            $creditNote->response_SdcDateTime,
                                        )->format('Y-m-d-H-i-s');
                                    } catch (\Exception $e) {
                                        $formattedDate = 'Invalid date format';
                                    }
                                ?>
     -->
                                <div class="col ">
                                    <small>
                                        <strong><?php echo e(__('SCU Information')); ?> :</strong><br>
                                        <p><i>Date : </i><?php echo e($creditNote->response_sdcDateTime); ?></p>
                                        <p><i>Invoice No : </i><?php echo e($creditNote->response_invoiceNo); ?></p>
                                        <p><i>Trader Invoice No : </i><?php echo e($creditNote->response_tranderInvoiceNo); ?></p>
                                        <p><i>Internal Data : </i><?php echo e($creditNote->response_scuInternalData); ?></p>
                                        <p><i>Receipt Signature : </i><?php echo e($creditNote->response_scuReceiptSignature); ?></p>
                                    </small>
                                </div>

                                <div class="col">
                                    <div class="float-end mt-3">
                                        <?php if(!empty($creditNote->response_scuqrCode)): ?>
                                            <?php echo DNS2D::getBarcodeHTML($creditNote->response_scuqrCode, 'QRCODE', 2, 2); ?>

                                        <?php else: ?>
                                            <?php echo e(__('No QR code available')); ?>

                                        <?php endif; ?>
                                    </div>

                                </div>

                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <small>
                                        <strong><?php echo e(__('CreditNote Reason')); ?> : <?php echo e($creditNote->creditNoteReason); ?>

                                    </small>
                                </div>

                                <?php if(!empty($customFields) && count($creditNote->customField) > 0): ?>
                                    <?php $__currentLoopData = $customFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col text-md-right">
                                            <small>
                                                <strong><?php echo e($field->name); ?> :</strong><br>
                                                <?php echo e(!empty($creditNote->customField) ? $creditNote->customField[$field->id] : '-'); ?>

                                                <br><br>
                                            </small>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="font-weight-bold"><?php echo e(__('Product Summary')); ?></div>
                                    <small><?php echo e(__('All items here cannot be deleted.')); ?></small>
                                    <div class="table-responsive mt-2">
                                        <table class="table mb-0 table-striped">
                                            <tr>
                                                <th class="text-dark"><?php echo e(__('Product')); ?></th>
                                                <th class="text-dark"><?php echo e(__('Quantity')); ?></th>
                                                <th class="text-dark"><?php echo e(__('Pkg Quantity')); ?></th>
                                                <th class="text-dark"><?php echo e(__('Unit Price')); ?></th>
                                                <th class="text-dark"><?php echo e(__('Discount')); ?></th>
                                                <th class="text-dark"><?php echo e(__('Tax')); ?></th>
                                                <th class="text-dark"><?php echo e(__('Description')); ?></th>
                                                <th class="text-end text-dark" width="12%"><?php echo e(__('Price')); ?><br>
                                                    <small
                                                        class="text-danger font-weight-bold"><?php echo e(__('after tax & discount')); ?></small>
                                                </th>
                                            </tr>
                                            <?php
                                                $totalQuantity = 0;
                                                $totalRate = 0;
                                                $totalTaxPrice = 0;
                                                $totalDiscount = 0;
                                                $taxesData = [];
                                            ?>

                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                            </td>
                                            <td></td>
                                            <td>
                                                <?php

                                                ?>
                                            </td>
                                            <td></td>
                                            <td>
                                                <?php

                                                ?>

                                            </td>
                                            </tr>
                                            <tfoot>
                                                <tr>
                                                    <td><b><?php echo e(__('Total')); ?></b></td>
                                                    <td>
                                                        <b>
                                                            <?php

                                                            ?>

                                                        </b>
                                                    </td>
                                                    <td>
                                                        <b>
                                                            <?php

                                                            ?>

                                                        </b>
                                                    </td>
                                                    <td>
                                                        <b>
                                                            <?php

                                                            ?>

                                                        </b>
                                                    </td>
                                                    <td>
                                                        <b>
                                                            <?php

                                                            ?>

                                                        </b>
                                                    </td>
                                                    <td>
                                                        <b>
                                                            <?php

                                                            ?>

                                                        </b>
                                                    </td>
                                                    <td></td>
                                                    <td>
                                                        <b>
                                                            <?php

                                                            ?>

                                                        </b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td class="text-end"><b></b></td>
                                                    <td class="text-end">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td class="text-end"><b></b></td>
                                                    <td class="text-end">

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td class="text-end"><b></b></td>
                                                    <td class="text-end">

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td class="blue-text text-end"><b></b></td>
                                                    <td class="blue-text text-end">

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td class="text-end"><b></b></td>
                                                    <td class="text-end">

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td class="text-end"><b></b></td>
                                                    <td class="text-end">

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td class="text-end"><b></b></td>
                                                    <td class="text-end">

                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <h5 class=" d-inline-block"><?php echo e(__('Receipt Summary')); ?></h5><br>
                    <?php if($userPlan->storage_limit <= $creditNoteUser->storage_limit): ?>
                        <small
                            class="text-danger font-bold"><?php echo e(__('Your plan storage limit is over , so you can not see customer uploaded payment receipt')); ?></small><br>
                    <?php endif; ?>

                    <div class="table-responsive mt-3">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th class="text-dark"><?php echo e(__('Payment Receipt')); ?></th>
                                    <th class="text-dark"><?php echo e(__('Date')); ?></th>
                                    <th class="text-dark"><?php echo e(__('Amount')); ?></th>
                                    <th class="text-dark"><?php echo e(__('Payment Type')); ?></th>
                                    <th class="text-dark"><?php echo e(__('Account')); ?></th>
                                    <th class="text-dark"><?php echo e(__('Reference')); ?></th>
                                    <th class="text-dark"><?php echo e(__('Description')); ?></th>
                                    <th class="text-dark"><?php echo e(__('Receipt')); ?></th>
                                    <th class="text-dark"><?php echo e(__('OrderId')); ?></th>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete payment invoice')): ?>
                                        <th class="text-dark"><?php echo e(__('Action')); ?></th>
                                    <?php endif; ?>
                                </tr>
                            </thead>


                            <?php

                            ?>


                            <tr>
                                <td>


                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                </td>
                                <td></td>
                                <td></td>
                                <td>
                                    --
                                </td>

                                <td>

                                </td>

                                <td>
                                <td>

                                </td>

                            </tr>

                            
                            <tr>
                                <td>-</td>
                                <td></td>
                                <td></td>
                                <td><br>
                                </td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>

                                <td>
                                    ---
                                </td>

                                <td>

                                </td>

                                <td></td>
                                <td>

                                </td>

                            </tr>
                            
                            <tr>
                                <td colspan="<?php echo e(Gate::check('delete invoice product') ? '10' : '9'); ?>"
                                    class="text-center text-dark">
                                    <p><?php echo e(__('No Data Found')); ?></p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <h5 class="d-inline-block mb-5"><?php echo e(__('Credit Note Summary')); ?></h5>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-dark"><?php echo e(__('Date')); ?></th>
                                    <th class="text-dark" class=""><?php echo e(__('Amount')); ?></th>
                                    <th class="text-dark" class=""><?php echo e(__('Description')); ?></th>

                                </tr>
                            </thead>
                            <tr>
                                <td></td>
                                <td class=""></td>
                                <td class=""></td>
                                <td>

                                </td>
                            </tr>

                            <tr>
                                <td colspan="4" class="text-center">
                                    <p class="text-dark"><?php echo e(__('No Data Found')); ?></p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp-go-6.4-using-laravel\resources\views/creditNote/view.blade.php ENDPATH**/ ?>