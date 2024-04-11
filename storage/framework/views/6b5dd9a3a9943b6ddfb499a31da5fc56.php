<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Purchase')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Purchase')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
    <script>

        $('.copy_link').click(function (e) {
            e.preventDefault();
            var copyText = $(this).attr('href');

            document.addEventListener('copy', function (e) {
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






        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create purchase')): ?>
            <a href="<?php echo e(route('purchase.create',0)); ?>" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="<?php echo e(__('Create')); ?>">
                <i class="ti ti-plus"></i>
            </a>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>


    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                         <?php if($purchases['statusCode'] === 200 && $purchases['message'] === 'Success'): ?>
        <table>
            <thead>
                <tr>
                    <th>Supplier TIN</th>
                    <th>Supplier Name</th>
                    <th>Invoice Number</th>
                    <th>Sales Date</th>
                    <th>Total Taxable Amount</th>
                    <th>Total Tax Amount</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $purchases['data']['data']['saleList']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $purchase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($purchase['spplrTin']); ?></td>
                    <td><?php echo e($purchase['spplrNm']); ?></td>
                    <td><?php echo e($purchase['spplrInvcNo']); ?></td>
                    <td><?php echo e($purchase['salesDt']); ?></td>
                    <td><?php echo e(number_format($purchase['totTaxblAmt'], 2)); ?></td>
                    <td><?php echo e(number_format($purchase['totTaxAmt'], 2)); ?></td>
                    <td><?php echo e(number_format($purchase['totAmt'], 2)); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Error: Failed to fetch purchases.</p>
    <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp-go-6.4-using-laravel\resources\views/purchase/index.blade.php ENDPATH**/ ?>