<?php $__env->startSection('page-title'); ?>
<?php echo e(__('Purchase Transaction Information')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
<li class="breadcrumb-item"><?php echo e(__('Admin')); ?></li>
<li class="breadcrumb-item"><?php echo e(__('Purchase Transaction Information')); ?></li>
<li class="breadcrumb-item"><?php echo e(__('Add')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
<script>
$('.copy_link').click(function(e) {
    e.preventDefault();
    var copyText = $(this).attr('href');

    document.addEventListener('copy', function(e) {
        e.clipboardData.setData('text/plain', copyText);
        e.preventDefault();
    }, true);

    document.execCommand('copy');
    show_toastr('success', 'Url copied to clipboard', 'success');
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('action-btn'); ?>
<div class="float-end">
    <div class="d-inline-block mb-4">
        <?php echo e(Form::open(['route' => 'purchase.synchronize', 'method' => 'POST', 'class' => 'w-100'])); ?>

        <?php echo csrf_field(); ?>
        <input type="hidden" name="_token" id="token" value="<?php echo e(csrf_token()); ?>">
        <div class="form-group">
            <?php echo e(Form::label('getpurchaseByDate', __('Search By Date'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::date('getpurchaseByDate', null, ['class' => 'form-control', 'required' => 'required'])); ?>

        </div>
        <button type="submit" class="btn btn-primary  sync"><?php echo e(__('Search')); ?></button>
        <?php echo e(Form::close()); ?>

    </div>
    <a href="<?php echo e(route('purchase.create', 0)); ?>" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
        title="<?php echo e(__('Add New Purchase')); ?>">
        <i class="ti ti-plus"></i>
    </a>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th> <?php echo e(__('SrNo')); ?></th>
                                <th> <?php echo e(__('SpplrTin')); ?></th>
                                <th> <?php echo e(__('TotItemCnt')); ?></th>
                                <th><?php echo e(__('CfmDt')); ?></th>
                                <th><?php echo e(__('Is Mapped')); ?></th>
                                <th><?php echo e(__('Status')); ?></th>
                                <th> <?php echo e(__('Action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $purchases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $purchase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <tr>
                                <td><?php echo e($purchase->id); ?></td>
                                <td><?php echo e($purchase->spplrTin); ?></td>
                                <td><?php echo e($purchase->totItemCnt); ?></td>
                                <td><?php echo e($purchase->cfmDt); ?></td>
                                <td>
                                    <?php if($purchase->isDbImport == 0): ?>
                                    <!-- Show Pending -->
                                    <span class="purchase_status badge bg-secondary p-2 px-3 rounded">pending</span>
                                    <?php else: ?>
                                    <!-- Show Success -->
                                    <span class="purchase_status badge bg-warning p-2 px-3 rounded">Completed</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($purchase->status == 0): ?>
                                    <span class="purchase_status badge bg-secondary p-2 px-3 rounded">Draft</span>
                                    <?php elseif($purchase->status == 1): ?>
                                    <span class="purchase_status badge bg-warning p-2 px-3 rounded">Sent</span>
                                    <?php elseif($purchase->status == 2): ?>
                                    <span class="purchase_status badge bg-danger p-2 px-3 rounded">UnPaid</span>
                                    <?php elseif($purchase->status == 3): ?>
                                    <span class="purchase_status badge bg-info p-2 px-3 rounded">Partialy
                                        Paid</span>
                                    <?php elseif($purchase->status == 4): ?>
                                    <span class="purchase_status badge bg-primary p-2 px-3 rounded">Paid</span>
                                    <?php endif; ?>
                                </td>
                                <td class="Action">
                                    <span>
                                        <div class="action-btn bg-info ms-2">
                                            <a href="<?php echo e(route('purchase.show', \Crypt::encrypt($purchase->id))); ?>"
                                                class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip"
                                                title="<?php echo e(__('Show')); ?>"
                                                data-original-title="<?php echo e(__('Detail')); ?>">
                                                <i class="ti ti-eye text-white"></i>
                                            </a>
                                        </div>
                                        <?php if($purchase->isDbImport == 1): ?>
                                        <div class="action-btn bg-info ms-2">
                                            <a href="#" class="mx-3 btn btn-sm align-items-center"
                                                data-bs-toggle="tooltip" title="<?php echo e(__('Already Mapped')); ?>"
                                                data-original-title="<?php echo e(__('Detail')); ?>">
                                                <i class="ti ti-list text-white"></i>
                                            </a>
                                        </div>
                                        <?php elseif($purchase->isDbImport == 0): ?>
                                        <div class="action-btn bg-info ms-2">
                                            <a href="<?php echo e(route('purchase.details', ['spplrInvcNo' => $purchase->spplrInvcNo])); ?>"
                                                class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip"
                                                title="<?php echo e(__('Map Purchase')); ?>"
                                                data-original-title="<?php echo e(__('Detail')); ?>">
                                                <i class="ti ti-list text-white"></i>
                                            </a>
                                        </div>
                                        <?php endif; ?>
                                        <!-- <div class="action-btn bg-primary ms-2">
                                                            <a href="<?php echo e(route('purchase.edit', \Crypt::encrypt($purchase->id))); ?>" class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip" title="Edit" data-original-title="<?php echo e(__('Edit')); ?>">
                                                                <i class="ti ti-pencil text-white"></i>
                                                            </a>
                                                        </div> -->
                                        <div class="action-btn bg-danger ms-2">
                                            <?php echo Form::open([
                                                        'method' => 'DELETE',
                                                        'route' => ['purchase.destroy', $purchase->id],
                                                        'class' => 'delete-form-btn',
                                                        'id' => 'delete-form-' . $purchase->id,
                                                    ]); ?>

                                            <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para"
                                                data-bs-toggle="tooltip" title="<?php echo e(__('Delete')); ?>"
                                                data-original-title="<?php echo e(__('Delete')); ?>"
                                                data-confirm="<?php echo e(__('Are You Sure?') . '|' . __('This action can not be undone. Do you want to continue?')); ?>"
                                                data-confirm-yes="document.getElementById('delete-form-<?php echo e($purchase->id); ?>').submit();">
                                                <i class="ti ti-trash text-white"></i>
                                            </a>
                                            <?php echo Form::close(); ?>

                                        </div>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp-go-6.4-using-laravel\resources\views/purchase/index.blade.php ENDPATH**/ ?>