
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Purchase Detail')); ?>

<?php $__env->stopSection(); ?>

<?php
    $settings = Utility::settings();
?>
<?php $__env->startPush('script-page'); ?>
    <script>
        $(document).on('click', '#shipping', function () {
            var url = $(this).data('url');
            var is_display = $("#shipping").is(":checked");
            $.ajax({
                url: url,
                type: 'get',
                data: {
                    'is_display': is_display,
                },
                success: function (data) {
                    // console.log(data);
                }
            });
        })


    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('purchase.index')); ?>"><?php echo e(__('Purchase')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(Auth::user()->purchaseNumberFormat($purchase->purchase_id)); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('send purchase')): ?>
        <?php if($purchase->status!=4): ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row timeline-wrapper">
                                <div class="col-md-6 col-lg-4 col-xl-4">
                                    <div class="timeline-icons"><span class="timeline-dots"></span>
                                        <i class="ti ti-plus text-primary"></i>
                                    </div>
                                    <h6 class="text-primary my-3"><?php echo e(__('Create Purchase')); ?></h6>
                                    <p class="text-muted text-sm mb-3"><i class="ti ti-clock mr-2"></i><?php echo e(__('Created on ')); ?><?php echo e(\Auth::user()->dateFormat($purchase->purchase_date)); ?></p>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit purchase')): ?>
                                        <a href="<?php echo e(route('purchase.edit',\Crypt::encrypt($purchase->id))); ?>" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>"><i class="ti ti-pencil mr-2"></i><?php echo e(__('Edit')); ?></a>

                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-4">
                                    <div class="timeline-icons"><span class="timeline-dots"></span>
                                        <i class="ti ti-mail text-warning"></i>
                                    </div>
                                    <h6 class="text-warning my-3"><?php echo e(__('Send Purchase')); ?></h6>
                                    <p class="text-muted text-sm mb-3">
                                        <?php if($purchase->status!=0): ?>
                                            <i class="ti ti-clock mr-2"></i><?php echo e(__('Sent on')); ?> <?php echo e(\Auth::user()->dateFormat($purchase->send_date)); ?>

                                        <?php else: ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('send purchase')): ?>
                                                <small><?php echo e(__('Status')); ?> : <?php echo e(__('Not Sent')); ?></small>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </p>

                                    <?php if($purchase->status==0): ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('send purchase')): ?>
                                            <a href="<?php echo e(route('purchase.sent',$purchase->id)); ?>" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" data-original-title="<?php echo e(__('Mark Sent')); ?>"><i class="ti ti-send mr-2"></i><?php echo e(__('Send')); ?></a>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-4">
                                    <div class="timeline-icons"><span class="timeline-dots"></span>
                                        <i class="ti ti-report-money text-info"></i>
                                    </div>
                                    <h6 class="text-info my-3"><?php echo e(__('Get Paid')); ?></h6>
                                    <p class="text-muted text-sm mb-3"><?php echo e(__('Status')); ?> : <?php echo e(__('Awaiting payment')); ?> </p>
                                    <?php if($purchase->status!= 0): ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create payment purchase')): ?>
                                            <a href="#" data-url="<?php echo e(route('purchase.payment',$purchase->id)); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Add Payment')); ?>" class="btn btn-sm btn-info" data-original-title="<?php echo e(__('Add Payment')); ?>"><i class="ti ti-report-money mr-2"></i><?php echo e(__('Add Payment')); ?></a> <br>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php if(\Auth::user()->type=='company'): ?>
        <?php if($purchase->status!=0): ?>
            <div class="row justify-content-between align-items-center mb-3">
                <div class="col-md-12 d-flex align-items-center justify-content-between justify-content-md-end">

                    <div class="all-button-box mx-2">
                        <a href="<?php echo e(route('purchase.resent',$purchase->id)); ?>" class="btn btn-sm btn-primary">
                            <?php echo e(__('Resend Purchase')); ?>

                        </a>
                    </div>
                    <div class="all-button-box">
                        <a href="<?php echo e(route('purchase.pdf', Crypt::encrypt($purchase->id))); ?>" target="_blank" class="btn btn-sm btn-primary">
                            <?php echo e(__('Download')); ?>

                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    <?php endif; ?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="invoice">
                        <div class="invoice-print">
                            <div class="row invoice-title mt-2">
                                <div class="col-xs-12 col-sm-12 col-nd-6 col-lg-6 col-12">
                                    <h4><?php echo e(__('Purchase')); ?></h4>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-nd-6 col-lg-6 col-12 text-end">
                                    <h4 class="invoice-number"><?php echo e(Auth::user()->purchaseNumberFormat($purchase->purchase_id)); ?></h4>
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
                                                <strong><?php echo e(__('Issue Date')); ?> :</strong><br>
                                                <?php echo e(\Auth::user()->dateFormat($purchase->purchase_date)); ?><br><br>
                                            </small>
                                        </div>

                                    </div>
                                </div>
                            </div>



                            <div class="row">
                                <div class="col">
                                    <small class="font-style">
                                        <strong><?php echo e(__('Shipped To')); ?> :</strong><br>
                                        <strong>Company </strong>:

                                        <br>
                                    </small>
                                </div>

                                <?php if(App\Models\Utility::getValByName('shipping_display') == 'on'): ?>
                                    <div class="col">
                                        <small>
                                            <strong><?php echo e(__('Shipped From')); ?> :</strong><br>
                                            <strong> SupplierTin </strong>:
                                            <?php echo e(!empty($purchase->spplrTin) ? $purchase->spplrTin : ''); ?>

                                            <br>
                                            <strong> Supplier Name </strong>:
                                            <?php echo e(!empty($purchase->spplrNm) ? $purchase->spplrNm : ''); ?>

                                            <br>
                                            <strong> SupplierBhfId </strong>:
                                            <?php echo e(!empty($purchase->spplrBhfId) ? $purchase->spplrBhfId : ''); ?>

                                            <br>
                                            <strong> Supplier InvoiceNo </strong>:
                                            <?php echo e(!empty($purchase->spplrInvcNo) ? $purchase->spplrInvcNo : ''); ?>

                                            <br>
                                            <strong> Supplier SdcId </strong>:
                                            <?php echo e(!empty($purchase->spplrSdcId) ? $purchase->spplrSdcId : ''); ?>

                                            <br>
                                            <strong> Supplier MrcNo</strong>:
                                            <?php echo e(!empty($purchase->spplrMrcNo) ? $purchase->spplrMrcNo : ''); ?>

                                            <br>
                                        </small>
                                    </div>
                                <?php endif; ?>

                                <div class="col">
                                    <div class="float-end mt-3">

                                        <?php echo DNS2D::getBarcodeHTML(
                                            route('purchase.link.copy', \Illuminate\Support\Facades\Crypt::encrypt($purchase->id)),
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
                                            <span class="purchase_status badge bg-secondary p-2 px-3 rounded">Draft</span>
                                        <?php elseif($purchase->status == 1): ?>
                                            <span class="purchase_status badge bg-warning p-2 px-3 rounded">Sent</span>
                                        <?php elseif($purchase->status == 2): ?>
                                            <span class="purchase_status badge bg-danger p-2 px-3 rounded">UnPaid</span>
                                        <?php elseif($purchase->status == 3): ?>
                                            <span class="purchase_status badge bg-info p-2 px-3 rounded">Partialy Paid</span>
                                        <?php elseif($purchase->status == 4): ?>
                                            <span class="purchase_status badge bg-primary p-2 px-3 rounded">Paid</span>
                                        <?php endif; ?>
                                    </small>
                                </div>


                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="font-bold mb-2"><?php echo e(__('Products Summary')); ?></div>
                                    <small class="mb-2"><?php echo e(__('All items here cannot be deleted.')); ?></small>
                                    <div class="table-responsive mt-3">
                                        <table class="table ">
                                            <tr>
                                                <th class="text-dark" data-width="40">#</th>
                                                <th class="text-dark"><?php echo e(__('Product')); ?></th>
                                                <th class="text-dark"><?php echo e(__('Quantity')); ?></th>
                                                <th class="text-dark"><?php echo e(__('Rate')); ?></th>
                                                <th class="text-dark"><?php echo e(__('Discount')); ?></th>
                                                <th class="text-dark"><?php echo e(__('Tax')); ?></th>
                                                <th class="text-dark"><?php echo e(__('Supply Amount')); ?></th>
                                                <th class="text-end text-dark" width="12%"><?php echo e(__('Price')); ?><br>
                                                    <small
                                                        class="text-danger font-weight-bold"><?php echo e(__('after tax & discount')); ?></small>
                                                </th>
                                                <th></th>
                                            </tr>

                                            <?php echo e(\Log::info('ITEAMS')); ?>

               <?php echo e(\Log::info($iteams)); ?>

                                            <?php $__currentLoopData = $iteams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td> <?php echo e(!empty($item->id) ? $item->id : ''); ?></td>
                                                    <td><?php echo e(!empty($item->itemNm) ? $item->itemNm : ''); ?></td>
                                                    <td><?php echo e(!empty($item->qty) ? $item->qty : ''); ?></td>
                                                    <td>Kes <?php echo e(!empty($item->prc) ? $item->prc : ''); ?></td>
                                                    <td><?php echo e(!empty($item->dcAmt) ? $item->dcAmt : ''); ?></td>
                                                    <td>
                                                        <?php
                                                            // Map taxTyCd to its corresponding description
                                                            $taxDescription = '';
                                                            switch ($item->taxTyCd) {
                                                                case 'A':
                                                                    $taxDescription = 'A-Exmpt';
                                                                    break;
                                                                case 'B':
                                                                    $taxDescription = 'B-VAT 16%';
                                                                    break;
                                                                case 'C':
                                                                    $taxDescription = 'C-Zero Rated';
                                                                    break;
                                                                case 'D':
                                                                    $taxDescription = 'D-Non VAT';
                                                                    break;
                                                                case 'E':
                                                                    $taxDescription = 'E-VAT 8%';
                                                                    break;
                                                                case 'F':
                                                                    $taxDescription = 'F-Non Tax';
                                                                    break;
                                                                default:
                                                                    $taxDescription = ''; // Handle unknown tax codes here
                                                                    break;
                                                            }
                                                        ?>
                                                        <?php echo e($taxDescription); ?>

                                                    </td>
                                                    <td>Kes <?php echo e(!empty($item->splyAmt) ? $item->splyAmt : ''); ?></td>
                                                    <td>Kes <?php echo e(!empty($item->totAmt) ? $item->totAmt : ''); ?></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td class="text-end"><b><?php echo e(__('Sub Total')); ?></b></td>
                                                    <td class="text-end">
                                                     Kes <?php echo e($iteams->sum('prc')); ?> </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td class="text-end"><b><?php echo e(__('Discount')); ?></b></td>
                                                    <td class="text-end">
                                                            Kes <?php echo e($iteams->sum('dcAmt')); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td class="text-end"><b><?php echo e(__('Tax Amount')); ?></b></td>
                                                    <td class="text-end">
                                                        Kes <?php echo e($iteams->sum('taxAmt')); ?> </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td class="blue-text text-end"><b><?php echo e(__('Total')); ?></b></td>
                                                    <td class="blue-text text-end">
                                                         Kes <?php echo e($iteams->sum('prc')); ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td class="text-end"><b><?php echo e(__('Paid')); ?></b></td>
                                                    <td class="text-end">
                                                        <?php echo e(\Auth::user()->priceFormat($purchase->getTotal() - $purchase->getDue())); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td class="text-end"><b><?php echo e(__('Due')); ?></b></td>
                                                    <td class="text-end">
                                                        <?php echo e(\Auth::user()->priceFormat($purchase->getDue())); ?></td>
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
                    <h5 class=" d-inline-block mb-5"><?php echo e(__('Payment Summary')); ?></h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th class="text-dark"><?php echo e(__('Payment Receipt')); ?></th>
                                <th class="text-dark"><?php echo e(__('Date')); ?></th>
                                <th class="text-dark"><?php echo e(__('Amount')); ?></th>
                                <th class="text-dark"><?php echo e(__('Account')); ?></th>
                                <th class="text-dark"><?php echo e(__('Reference')); ?></th>
                                <th class="text-dark"><?php echo e(__('Description')); ?></th>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete payment purchase')): ?>
                                    <th class="text-dark"><?php echo e(__('Action')); ?></th>
                                <?php endif; ?>
                            </tr>
                            </thead>
                            <?php $__empty_1 = true; $__currentLoopData = $purchase->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td>
                                        <?php if(!empty($payment->add_receipt)): ?>
                                            <a href="<?php echo e(asset(Storage::url('uploads/payment')).'/'.$payment->add_receipt); ?>" download="" class="btn btn-sm btn-secondary btn-icon rounded-pill" target="_blank"><span class="btn-inner--icon"><i class="ti ti-download"></i></span></a>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e(\Auth::user()->dateFormat($payment->date)); ?></td>
                                    <td><?php echo e(\Auth::user()->priceFormat($payment->amount)); ?></td>
                                    <td><?php echo e(!empty($payment->bankAccount)?$payment->bankAccount->bank_name.' '.$payment->bankAccount->holder_name:''); ?></td>
                                    <td><?php echo e($payment->reference); ?></td>
                                    <td><?php echo e($payment->description); ?></td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete payment purchase')): ?>
                                    <td class="text-dark">
                                        <div class="action-btn bg-danger ms-2">
                                            <?php echo Form::open(['method' => 'post', 'route' => ['purchase.payment.destroy',$purchase->id,$payment->id],'id'=>'delete-form-'.$payment->id]); ?>

                                            <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip"  title="<?php echo e(__('Delete')); ?>" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('delete-form-<?php echo e($payment->id); ?>').submit();">
                                                <i class="ti ti-trash text-white text-white text-white"></i>
                                                </a>
                                            <?php echo Form::close(); ?>

                                        </div>
                                    </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="7" class="text-center text-dark"><p><?php echo e(__('No Data Found')); ?></p></td>
                                </tr>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp-go-6.4-using-laravel\resources\views/purchase/view.blade.php ENDPATH**/ ?>