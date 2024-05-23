<?php
    $logo = asset(Storage::url('uploads/logo/'));
    $company_favicon = Utility::getValByName('company_favicon');
    $setting = \App\Models\Utility::colorset();

    $color = 'theme-3';
    if (!empty($setting)) {
        $color = $setting;
    }

    $SITE_RTL = Cookie::get('SITE_RTL');
    if ($SITE_RTL == '') {
        $SITE_RTL = 'off';
    }

    $currantLang = Cookie::get('LANGUAGE');
    if (!isset($currantLang)) {
        $currantLang = 'en';
    }

    $cust_theme_bg = Cookie::get('cust_theme_bg');
    if ($cust_theme_bg == '') {
        $cust_theme_bg = 'on';
    }

    $cust_darklayout = Cookie::get('cust_darklayout');
    if ($cust_darklayout == '') {
        $cust_darklayout = 'off';

        $getseo = App\Models\Utility::getSeoSetting();

        $metatitle = isset($getseo['meta_title']) ? $getseo['meta_title'] : '';
        $metsdesc = isset($getseo['meta_desc']) ? $getseo['meta_desc'] : '';
        $meta_image = \App\Models\Utility::get_file('uploads/meta/');
        $meta_logo = isset($getseo['meta_image']) ? $getseo['meta_image'] : '';
        $get_cookie = \App\Models\Utility::getCookieSetting();
    }
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <title><?php echo e(__('ERPGo')); ?></title>

    <meta name="title" content="<?php echo e($metatitle); ?>">
    <meta name="description" content="<?php echo e($metsdesc); ?>">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo e(env('APP_URL')); ?>">
    <meta property="og:title" content="<?php echo e($metatitle); ?>">
    <meta property="og:description" content="<?php echo e($metsdesc); ?>">
    <meta property="og:image" content="<?php echo e($meta_image . $meta_logo); ?>">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo e(env('APP_URL')); ?>">
    <meta property="twitter:title" content="<?php echo e($metatitle); ?>">
    <meta property="twitter:description" content="<?php echo e($metsdesc); ?>">
    <meta property="twitter:image" content="<?php echo e($meta_image . $meta_logo); ?>">


    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>

    <!-- Meta -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    
    <link rel="icon"
        href="<?php echo e($logo . '/' . (isset($company_favicon) && !empty($company_favicon) ? $company_favicon : 'favicon.png')); ?>"
        type="image" sizes="16x16">

    <!-- Favicon icon -->
    
    <!-- Calendar-->
    <?php echo $__env->yieldPushContent('css-page'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/main.css')); ?>">

    <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/flatpickr.min.css')); ?>">

    <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/animate.min.css')); ?>">



    <!-- font css -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/tabler-icons.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/feather.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/fontawesome.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/material.css')); ?>">

    <!--bootstrap switch-->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/bootstrap-switch-button.min.css')); ?>">

    <!-- vendor css -->
    <?php if($SITE_RTL == 'on'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-rtl.css')); ?>">
    <?php endif; ?>
    <?php if($cust_darklayout == 'on'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-dark.css')); ?>">
    <?php else: ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>" id="main-style-link">
    <?php endif; ?>

    <link rel="stylesheet" href="<?php echo e(asset('assets/css/customizer.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/custom.css')); ?>" id="main-style-link">

    <?php echo $__env->yieldPushContent('css-page'); ?>
</head>

<body class="<?php echo e($color['invoice_color']); ?>">
    <header class="header header-transparent" id="header-main">

    </header>

    <div class="main-content container">

        <div class="row justify-content-between align-items-center mb-3">
            <div class="col-md-12 d-flex align-items-center justify-content-between justify-content-md-end">

                <div class="all-button-box mx-2">

                    <a href="<?php echo e(route('purchase.pdf', \Crypt::encrypt($purchase->id))); ?>" target="_blank"
                        class="btn btn-primary mt-3">
                        <?php echo e(__('Download')); ?>

                    </a>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="invoice">
                            <div class="invoice-print">
                                <div class="row invoice-title mt-2">
                                    <div class="col-xs-12 col-sm-12 col-nd-6 col-lg-6 col-12">
                                        <h2><?php echo e(__('Purchase')); ?></h2>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-nd-6 col-lg-6 col-12 text-end">
                                        <h3 class="invoice-number float-right"></h3>

                                    </div>
                                    <div class="col-12">
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col text-end">
                                        <div class="d-flex align-items-center justify-content-end">

                                            <div class="me-4">
                                                <small>
                                                    <strong><?php echo e(__('Purchase Date')); ?> :</strong><br>
                                                    <?php echo e($user->dateFormat($purchase->purchase_date)); ?><br><br>
                                                </small>
                                            </div>
                                            
                                            
                                            
                                            

                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <?php if(!empty($vendor->billing_name)): ?>
                                        <div class="col">
                                            <small class="font-style">
                                                <strong><?php echo e(__('Billed To')); ?> :</strong><br>
                                                <?php echo e(!empty($vendor->billing_name) ? $vendor->billing_name : ''); ?><br>
                                                <?php echo e(!empty($vendor->billing_phone) ? $vendor->billing_phone : ''); ?><br>
                                                <?php echo e(!empty($vendor->billing_address) ? $vendor->billing_address : ''); ?><br>
                                                <?php echo e(!empty($vendor->billing_zip) ? $vendor->billing_zip : ''); ?><br>
                                                <?php echo e(!empty($vendor->billing_city) ? $vendor->billing_city : '' . ', '); ?>

                                                <?php echo e(!empty($vendor->billing_state) ? $vendor->billing_state : '', ', '); ?>

                                                <?php echo e(!empty($vendor->billing_country) ? $vendor->billing_country : ''); ?>

                                            </small>
                                        </div>
                                    <?php endif; ?>
                                    <?php if(\Utility::getValByName('shipping_display') == 'on'): ?>
                                        <div class="col">
                                            <small>
                                                <strong><?php echo e(__('Shipped To')); ?> :</strong><br>
                                                <?php echo e(!empty($vendor->shipping_name) ? $vendor->shipping_name : ''); ?><br>
                                                <?php echo e(!empty($vendor->shipping_phone) ? $vendor->shipping_phone : ''); ?><br>
                                                <?php echo e(!empty($vendor->shipping_address) ? $vendor->shipping_address : ''); ?><br>
                                                <?php echo e(!empty($vendor->shipping_zip) ? $vendor->shipping_zip : ''); ?><br>
                                                <?php echo e(!empty($vendor->shipping_city) ? $vendor->shipping_city : '' . ', '); ?>

                                                <?php echo e(!empty($vendor->shipping_state) ? $vendor->shipping_state : '', ', '); ?>

                                                <?php echo e(!empty($vendor->shipping_country) ? $vendor->shipping_country : ''); ?>

                                            </small>
                                        </div>
                                    <?php endif; ?>
                                    <div class="col">
                                        <div class="float-end mt-3">
                                            <?php echo DNS2D::getBarcodeHTML(
                                                route('bill.link.copy', \Illuminate\Support\Facades\Crypt::encrypt($purchase->id)),
                                                'QRCODE',
                                                2,
                                                2,
                                            ); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col">
                                        <small>
                                            <strong><?php echo e(__('Status')); ?> :</strong><br>
                                            <?php if($purchase->status == 0): ?>
                                                <span
                                                    class="badge bg-primary"><?php echo e(__(\App\Models\Bill::$statues[$purchase->status])); ?></span>
                                            <?php elseif($purchase->status == 1): ?>
                                                <span
                                                    class="badge bg-warning"><?php echo e(__(\App\Models\Bill::$statues[$purchase->status])); ?></span>
                                            <?php elseif($purchase->status == 2): ?>
                                                <span
                                                    class="badge bg-danger"><?php echo e(__(\App\Models\Bill::$statues[$purchase->status])); ?></span>
                                            <?php elseif($purchase->status == 3): ?>
                                                <span
                                                    class="badge bg-info"><?php echo e(__(\App\Models\Bill::$statues[$purchase->status])); ?></span>
                                            <?php elseif($purchase->status == 4): ?>
                                                <span
                                                    class="badge bg-success"><?php echo e(__(\App\Models\Bill::$statues[$purchase->status])); ?></span>
                                            <?php endif; ?>
                                        </small>
                                    </div>



                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <div class="font-weight-bold"><?php echo e(__('Product Summary')); ?></div>
                                        <small><?php echo e(__('All items here cannot be deleted.')); ?></small>
                                        <div class="table-responsive mt-2">
                                            <table class="table table-striped">
                                                <tr>
                                                    <th class="text-dark"><?php echo e(__('Product')); ?></th>
                                                    <th class="text-dark"><?php echo e(__('Quantity')); ?></th>
                                                    <th class="text-dark"><?php echo e(__('Pkg Quantity')); ?></th>
                                                    <th class="text-dark"><?php echo e(__('Unit Price')); ?></th>
                                                    <th class="text-dark"><?php echo e(__('Tax')); ?></th>
                                                    <th class="text-dark">
                                                        <?php echo e(__('Discount')); ?>


                                                    </th>
                                                    <th class="text-dark"><?php echo e(__('Description')); ?></th>
                                                    <th class="text-end text-dark" width="12%">
                                                        <?php echo e(__('Price')); ?><br>
                                                        <small
                                                            class="text-danger "><?php echo e(__('after tax & discount')); ?></small>
                                                    </th>
                                                </tr>
                                                <?php
                                                    $totalQuantity = 0;
                                                    $totalPkgQuantity = 0;
                                                    $totalRate = 0;
                                                    $totalTaxPrice = 0;
                                                    $totalDiscount = 0;
                                                    $taxesData = [];
                                                    
                                                    foreach ($iteams as $key => $iteam) {
                                                        $totalQuantity += $iteam->quantity;
                                                        $totalPkgQuantity += $iteam->pkg;
                                                        $totalTaxPrice += $iteam->tax;
                                                        $totalDiscount += $iteam->discount;
                                                    }
                                                ?>

                                                <?php $__currentLoopData = $iteams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $iteam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php echo e(\Log::info('iteammnm')); ?>

                                                    <?php echo e(\Log::info($iteam)); ?>

                                                    <tr>
                                                        <td><?php echo e(!empty($iteam) ? $iteam->itemNm : ''); ?>

                                                        </td>
                                                        <td><?php echo e($iteam->quantity); ?></td>
                                                        <td><?php echo e($iteam->pkg); ?></td>
                                                        <td>KES <?php echo e($iteam->price); ?></td>
                                                        <td>KES <?php echo e($iteam->tax); ?></td>
                                                        <td>KES <?php echo e($iteam->discount); ?></td>
                                                        <td><?php echo e(!empty($iteam->description) ? $iteam->description : '-'); ?>

                                                        </td>
                                                        <td class="text-end">KES <?php echo e($iteam->price * $iteam->quantity * $iteam->pkg); ?></td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <tfoot>
                                                    <tr>
                                                        <td><b><?php echo e(__('Total')); ?></b></td>
                                                        <td><b><?php echo e($totalQuantity); ?></b></td>
                                                        <td><b><?php echo e($totalPkgQuantity); ?></b></td>
                                                        <td><b></b></td>
                                                        <td><b>KES <?php echo e($totalTaxPrice); ?></b></td>
                                                        <td>
                                                            <b>KES <?php echo e(($totalDiscount)); ?></b>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6"></td>
                                                        <td class="text-end"><b><?php echo e(__('Sub Total')); ?></b></td>
                                                        <td class="text-end">KES <?php echo e(($purchase->getSubTotal())); ?></td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="6"></td>
                                                        <td class="text-end"><b><?php echo e(__('Discount')); ?></b></td>
                                                        <td class="text-end">
                                                            KES <?php echo e(($purchase->getTotalDiscount())); ?>

                                                        </td>
                                                    </tr>

                                                    <?php if(!empty($taxesData)): ?>
                                                        <?php $__currentLoopData = $taxesData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taxName => $taxPrice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td colspan="6"></td>
                                                                <td class="text-end"><b><?php echo e($taxName); ?></b></td>
                                                                <td class="text-end">
                                                                    KES <?php echo e(($taxPrice)); ?></td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                    <tr>
                                                        <td colspan="6"></td>
                                                        <td class="blue-text text-end"><b><?php echo e(__('Total')); ?></b></td>
                                                        <td class="blue-text text-end">KES <?php echo e(($purchase->getTotal())); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6"></td>
                                                        <td class="text-end"><b><?php echo e(__('Paid')); ?></b></td>
                                                        <td class="text-end">
                                                            KES <?php echo e(($purchase->getTotal() - $purchase->getDue())); ?>

                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="6"></td>
                                                        <td class="text-end"><b><?php echo e(__('Due')); ?></b></td>
                                                        <td class="text-end">KES <?php echo e(($purchase->getDue())); ?></td>
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

    </div>

    <footer id="footer-main">
        <div class="footer-dark">
            <div class="container">
                <div class="row align-items-center justify-content-md-between py-4 mt-4 delimiter-top">
                    <div class="col-md-6">
                        <div class="copyright text-sm font-weight-bold text-center text-md-left">
                            <?php echo e(!empty($companySettings['footer_text']) ? $companySettings['footer_text']->value : ''); ?>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <ul class="nav justify-content-center justify-content-md-end mt-3 mt-md-0">
                            <li class="nav-item">
                                <a class="nav-link" href="#" target="_blank">
                                    <i class="fab fa-dribbble"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" target="_blank">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" target="_blank">
                                    <i class="fab fa-github"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" target="_blank">
                                    <i class="fab fa-facebook"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>


    <?php if($message = Session::get('success')): ?>
        <script>
            show_toastr('success', '<?php echo $message; ?>');
        </script>
    <?php endif; ?>
    <?php if($message = Session::get('error')): ?>
        <script>
            show_toastr('error', '<?php echo $message; ?>');
        </script>
    <?php endif; ?>


    <?php if($get_cookie['enable_cookie'] == 'on'): ?>
        <?php echo $__env->make('layouts.cookie_consent', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
<?php /**PATH C:\Users\Developer\Desktop\apps\erp-go-6.4-using-laravel\resources\views/purchase/customer_bill.blade.php ENDPATH**/ ?>