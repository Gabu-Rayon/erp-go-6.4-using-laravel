<?php
    $settings_data = \App\Models\Utility::settingsById($invoice->created_by);
?>
<!DOCTYPE html>
<html lang="en" dir="<?php echo e($settings_data['SITE_RTL'] == 'on'?'rtl':''); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">

    <style type="text/css">
        :root {
            --theme-color: <?php echo e($color); ?>;
            --white: #ffffff;
            --black: #000000;
        }

        body {
            font-family: 'Lato', sans-serif;
        }

        p,
        li,
        ul,
        ol {
            margin: 0;
            padding: 0;
            list-style: none;
            line-height: 1.5;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table tr th {
            padding: 0.75rem;
            text-align: left;
        }

        table tr td {
            padding: 0.75rem;
            text-align: left;
        }

        table th small {
            display: block;
            font-size: 12px;
        }

        .invoice-preview-main {
            max-width: 700px;
            width: 100%;
            margin: 0 auto;
            background: #ffff;
            box-shadow: 0 0 10px #ddd;
        }

        .invoice-logo {
            max-width: 200px;
            width: 100%;
        }

        .invoice-header table td {
            padding: 15px 30px;
        }

        .text-right {
            text-align: right;
        }

        .no-space tr td {
            padding: 0;
            white-space: nowrap;
        }

        .vertical-align-top td {
            vertical-align: top;
        }

        .view-qrcode {
            max-width: 139px;
            height: 139px;
            width: 100%;
            margin-left: auto;
            margin-top: 15px;
            background: var(--white);
            padding: 13px;
            border-radius: 10px;
        }

        .view-qrcode img {
            width: 100%;
            height: 100%;
        }

        .invoice-body {
            padding: 30px 25px 0;
        }



        table.add-border tr {
            border-top: 1px solid var(--theme-color);
        }

        tfoot tr:first-of-type {
            border-bottom: 1px solid var(--theme-color);
        }

        .total-table tr:first-of-type td {
            padding-top: 0;
        }

        .total-table tr:first-of-type {
            border-top: 0;
        }

        .sub-total {
            padding-right: 0;
            padding-left: 0;
        }

        .border-0 {
            border: none !important;
        }

        .invoice-summary td,
        .invoice-summary th {
            font-size: 13px;
            font-weight: 600;
        }

        .total-table td:last-of-type {
            width: 146px;
        }

        .invoice-footer {
            padding: 15px 20px;
        }

        .itm-description td {
            padding-top: 0;
        }
        html[dir="rtl"] table tr td,
        html[dir="rtl"] table tr th{
            text-align: right;
        }
        html[dir="rtl"]  .text-right{
            text-align: left;
        }
        html[dir="rtl"] .view-qrcode{
            margin-left: 0;
            margin-right: auto;
        }
    </style>

    <?php if($settings_data['SITE_RTL']=='on'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('css/bootstrap-rtl.css')); ?>">
    <?php endif; ?>
</head>

<body class="">
<div class="invoice-preview-main"  id="boxes">
    <div class="invoice-header" style="background: <?php echo e($color); ?>;color:<?php echo e($font_color); ?>">
        <table>
            <tbody>
            <tr>
                <td>
                    <img class="invoice-logo" src="<?php echo e($img); ?>" alt="">
                </td>
                <td class="text-right">
                    <h3 style="text-transform: uppercase; font-size: 40px; font-weight: bold;"><?php echo e(__('INVOICE')); ?></h3>
                </td>
            </tr>
            </tbody>
        </table>
        <table class="vertical-align-top">
            <tbody>
            <tr>
                <td>
                    <p>
                        <?php if($settings['company_name']): ?><?php echo e($settings['company_name']); ?><?php endif; ?><br>
                        <?php if($settings['mail_from_address']): ?><?php echo e($settings['mail_from_address']); ?><?php endif; ?><br><br>
                        <?php if($settings['company_address']): ?><?php echo e($settings['company_address']); ?><?php endif; ?>
                        <?php if($settings['company_city']): ?> <br> <?php echo e($settings['company_city']); ?>, <?php endif; ?>
                        <?php if($settings['company_state']): ?><?php echo e($settings['company_state']); ?><?php endif; ?>
                        <?php if($settings['company_zipcode']): ?> - <?php echo e($settings['company_zipcode']); ?><?php endif; ?>
                        <?php if($settings['company_country']): ?> <br><?php echo e($settings['company_country']); ?><?php endif; ?>
                        <?php if($settings['company_telephone']): ?><?php echo e($settings['company_telephone']); ?><?php endif; ?><br>
                        <?php if(!empty($settings['registration_number'])): ?><?php echo e(__('Registration Number')); ?> : <?php echo e($settings['registration_number']); ?> <?php endif; ?><br>
                        <?php if($settings['vat_gst_number_switch'] == 'on'): ?>
                            <?php if(!empty($settings['tax_type']) && !empty($settings['vat_number'])): ?><?php echo e($settings['tax_type'].' '. __('Number')); ?> : <?php echo e($settings['vat_number']); ?> <br><?php endif; ?>
                        <?php endif; ?>
                    </p>
                </td>
                <td>
                    <table class="no-space" style="width: 45%;margin-left: auto;">
                        <tbody>
                        <tr>
                            <td><?php echo e(__('Number')); ?>:</td>
                            <td class="text-right"><?php echo e(Utility::invoiceNumberFormat($settings,$invoice->invoice_id)); ?></td>
                        </tr>
                        <tr>
                            <td><?php echo e(__('Issue Date')); ?>:</td>
                            <td class="text-right"><?php echo e(Utility::dateFormat($settings,$invoice->issue_date)); ?></td>
                        </tr>

                        <tr>
                            <td><b><?php echo e(__('Due Date:')); ?></b></td>
                            <td class="text-right"><?php echo e(Utility::dateFormat($settings,$invoice->due_date)); ?></td>
                        </tr>
                        <?php if(!empty($customFields) && count($invoice->customField)>0): ?>
                            <?php $__currentLoopData = $customFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($field->name); ?> :</td>
                                    <td> <?php echo e(!empty($invoice->customField)?$invoice->customField[$field->id]:'-'); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                        <tr>
                            <td colspan="2">
                                <div class="view-qrcode">
                                        <?php echo DNS2D::getBarcodeHTML($invoice->qrCodeURL, 'QRCODE', 2, 2); ?>

                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="invoice-body">
        <table>
            <tbody>
            <tr>
                <td>
                    <strong style="margin-bottom: 10px; display:block;"><?php echo e(__('Bill To')); ?>:</strong>
                    <?php if(!empty($customer->billing_name)): ?>
                        <p>
                            <?php echo e(!empty($customer->billing_name)?$customer->billing_name:''); ?><br>
                            <?php echo e(!empty($customer->billing_address)?$customer->billing_address:''); ?><br>
                            <?php echo e(!empty($customer->billing_city)?$customer->billing_city:'' .', '); ?><br>
                            <?php echo e(!empty($customer->billing_state)?$customer->billing_state:'',', '); ?>,
                            <?php echo e(!empty($customer->billing_zip)?$customer->billing_zip:''); ?><br>
                            <?php echo e(!empty($customer->billing_country)?$customer->billing_country:''); ?><br>
                            <?php echo e(!empty($customer->billing_phone)?$customer->billing_phone:''); ?><br>
                        </p>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>

                <?php if($settings['shipping_display']=='on'): ?>
                    <td class="text-right">
                        <strong style="margin-bottom: 10px; display:block;"><?php echo e(__('Ship To')); ?>:</strong>
                        <?php if(!empty($customer->shipping_name)): ?>
                        <p>
                            <?php echo e(!empty($customer->shipping_name)?$customer->shipping_name:''); ?><br>
                            <?php echo e(!empty($customer->shipping_address)?$customer->shipping_address:''); ?><br>
                            <?php echo e(!empty($customer->shipping_city)?$customer->shipping_city:'' . ', '); ?><br>
                            <?php echo e(!empty($customer->shipping_state)?$customer->shipping_state:'' .', '); ?>,
                            <?php echo e(!empty($customer->shipping_zip)?$customer->shipping_zip:''); ?><br>
                            <?php echo e(!empty($customer->shipping_country)?$customer->shipping_country:''); ?><br>
                            <?php echo e(!empty($customer->shipping_phone)?$customer->shipping_phone:''); ?><br>
                        </p>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                <?php endif; ?>
            </tr>
        <tr>
                
                <?php if($invoice->status == 0): ?>
                    <td
                        class="badge bg-primary"><strong><?php echo e(__('Invoice Status')); ?> : </strong><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></td>
                <?php elseif($invoice->status == 1): ?>
                    <td
                        class="badge bg-warning"><strong><?php echo e(__('Invoice Status')); ?> : </strong><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></td>
                <?php elseif($invoice->status == 2): ?>
                    <td
                        class="badge bg-danger"><strong><?php echo e(__('Invoice Status')); ?> : </strong><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></td>
                <?php elseif($invoice->status == 3): ?>
                    <td
                        class="badge bg-info"><strong><?php echo e(__('Invoice Status')); ?> : </strong><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></td>
                <?php elseif($invoice->status == 4): ?>
                    <td
                        class="badge bg-primary"><strong><?php echo e(__('Invoice Status')); ?> : </strong><?php echo e(__(\App\Models\Invoice::$statues[$invoice->status])); ?></td>
                <?php endif; ?>
        </tr>
            </tbody>
        </table>
        <table class="table mb-0 table-striped">
                                            <tr>
                                                <th class="text-dark"><?php echo e(__('Product')); ?></th>
                                                <th class="text-dark"><?php echo e(__('Qty')); ?></th>
                                                <th class="text-dark"><?php echo e(__('pkgQty')); ?></th>
                                                <th class="text-dark"><?php echo e(__('Prc')); ?></th>
                                                <th class="text-dark"><?php echo e(__('Discount')); ?></th>
                                                <th class="text-dark"><?php echo e(__('Tax')); ?></th>
                                                <th class="text-dark"><?php echo e(__('Desc')); ?></th>
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
                                            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $iteam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <td><?php echo e(!empty($iteam->name) ? $iteam->name : ''); ?></td>
                                                <td><?php echo e(!empty($iteam->quantity) ? $iteam->quantity : ''); ?></td>
                                                <td><?php echo e(!empty($iteam->pkgQuantity) ? $iteam->pkgQuantity : ''); ?></td>
                                                <td>Kes <?php echo e($iteam->unitPrice); ?></td>
                                                <td><?php echo e(!empty($iteam->discount) ? $iteam->discount : ''); ?></td>
                                                <td>
                                                    <?php
                                                        $taxData = \Utility::getTaxData();
                                                        $taxRate = floatval($taxData[$iteam->taxTypeCode]);
                                                        $taxTot = ($iteam->price - $iteam->discount) * ($taxRate / 100);
                                                    ?>
                                                    <?php echo e($taxTot); ?>

                                                </td>
                                                <td><?php echo e(!empty($iteam->description) ? $iteam->description : ''); ?></td>
                                                <td>Kes <?php echo e($iteam->price); ?></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <tfoot>
                                                <tr>
                                                    <td><b><?php echo e(__('Total')); ?></b></td>
                                                    <td>
                                                        <b>
                                                            <?php
                                                                $qtySum = 0;
                                                                foreach ($items as $iteam) {
                                                                    $qtySum += $iteam->quantity;
                                                                }
                                                            ?>
                                                            <?php echo e($qtySum); ?>

                                                        </b>
                                                    </td>
                                                    <td>
                                                        <b>
                                                            <?php
                                                                $pkgQtySum = 0;
                                                                foreach ($items as $iteam) {
                                                                    $pkgQtySum += $iteam->pkgQuantity;
                                                                }
                                                            ?>
                                                            <?php echo e($pkgQtySum); ?>

                                                        </b>
                                                    </td>
                                                    <td>
                                                        <b>
                                                            <?php
                                                                $unitPrcSum = 0;
                                                                foreach ($items as $iteam) {
                                                                    $prc = $iteam->unitPrice * $iteam->pkgQuantity * $iteam->quantity;
                                                                    $unitPrcSum += $prc;
                                                                }
                                                            ?>
                                                            <?php echo e($unitPrcSum); ?>

                                                        </b>
                                                    </td>
                                                    <td>
                                                        <b>
                                                            <?php
                                                                $discountSum = 0;
                                                                foreach ($items as $iteam) {
                                                                    $discountSum += $iteam->discount;
                                                                }
                                                            ?>
                                                            <?php echo e($discountSum); ?>

                                                        </b>
                                                    </td>
                                                    <td>
                                                        <b>
                                                            <?php
                                                                $taxSum = 0;
                                                                $taxData = \Utility::getTaxData();
                                                                $taxRate = floatval($taxData[$iteam->taxTypeCode]);
                                                                foreach ($items as $iteam) {
                                                                    $tax = ($iteam->price - $iteam->discount) * ($taxRate / 100);
                                                                    $taxSum += $tax;
                                                                }
                                                            ?>
                                                            <?php echo e($taxSum); ?>

                                                        </b>
                                                    </td>
                                                    <td></td>
                                                    <td>
                                                        <b>
                                                            <?php
                                                                $tot = 0;
                                                                foreach ($items as $iteam) {
                                                                    $tot += $iteam->price;
                                                                }
                                                            ?>
                                                            <?php echo e($tot); ?>

                                                        </b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td class="text-end"><b><?php echo e(__('Sub Total')); ?></b></td>
                                                    <td class="text-end">
                                                        <?php echo e(\Auth::user()->priceFormat($invoice->getSubTotal())); ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td class="text-end"><b><?php echo e(__('Discount')); ?></b></td>
                                                    <td class="text-end">
                                                        <?php echo e(\Auth::user()->priceFormat($invoice->getTotalDiscount())); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td class="text-end"><b><?php echo e(__('Tax')); ?></b></td>
                                                    <td class="text-end">
                                                        <?php echo e(\Auth::user()->priceFormat($taxSum)); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td class="blue-text text-end"><b><?php echo e(__('Total')); ?></b></td>
                                                    <td class="blue-text text-end">
                                                        <?php echo e(\Auth::user()->priceFormat($invoice->getTotal())); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td class="text-end"><b><?php echo e(__('Paid')); ?></b></td>
                                                    <td class="text-end">
                                                        <?php echo e(\Auth::user()->priceFormat($invoice->getTotal() - $invoice->getDue() - $invoice->invoiceTotalCreditNote())); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td class="text-end"><b><?php echo e(__('Credit Note')); ?></b></td>
                                                    <td class="text-end">
                                                        <?php echo e(\Auth::user()->priceFormat($invoice->invoiceTotalCreditNote())); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td class="text-end"><b><?php echo e(__('Due')); ?></b></td>
                                                    <td class="text-end">
                                                        <?php echo e(\Auth::user()->priceFormat($invoice->getDue())); ?></td>
                                                </tr>
                                            </tfoot>
                                        </table>
        <div class="invoice-footer">
            <b><?php echo e($settings['footer_title']); ?></b> <br>
            <?php echo $settings['footer_notes']; ?>

        </div>
    </div>

</div>
<?php if(!isset($preview)): ?>
    <?php echo $__env->make('invoice.script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>;
<?php endif; ?>

</body>

</html>
<?php /**PATH C:\Users\hp\Desktop\projects\erp-go-6.4-using-laravel\resources\views/invoice/templates/template1.blade.php ENDPATH**/ ?>