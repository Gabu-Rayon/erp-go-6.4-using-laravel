
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
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th> <?php echo e(__('itemSeq')); ?></th>
                                <th> <?php echo e(__('itemCd')); ?></th>
                                <th> <?php echo e(__('itemClsCd')); ?></th>
                                <th> <?php echo e(__('itemNm')); ?></th>
                                <th><?php echo e(__('pkgUnitCd')); ?></th>
                                <th><?php echo e(__('qtyUnitCd')); ?></th>
                                <th><?php echo e(__('totAmt')); ?></th>
                                <?php if(Gate::check('edit purchase') || Gate::check('delete purchase') || Gate::check('show purchase')): ?>
                                    <th > <?php echo e(__('Action')); ?></th>
                                <?php endif; ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $purchases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $purchase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($purchase->itemSeq); ?></td>
                                    <td><?php echo e($purchase->itemCd); ?></td>
                                    <td><?php echo e($purchase->itemClsCd); ?></td>
                                    <td><?php echo e($purchase->itemNm); ?></td>
                                    <td><?php echo e($purchase->pkgUnitCd); ?></td>
                                    <td><?php echo e($purchase->qtyUnitCd); ?></td>
                                    <td><?php echo e($purchase->totAmt); ?></td>
                                    <td class="d-flex" style="gap: 1rem;">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show purchase')): ?>
                                            <a href="<?php echo e(route('purchase.show', $purchase->id)); ?>" class="edit-icon btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e(__('Show')); ?>">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit purchase')): ?>
                                            <a href="<?php echo e(route('purchase.edit',$purchase->id)); ?>" class="edit-icon btn btn-sm btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e(__('Edit')); ?>">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete purchase')): ?>
                                            <a href="#" class="delete-icon btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e(__('Delete')); ?>" onclick="deleteData('<?php echo e($purchase->id); ?>')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        <?php endif; ?>
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


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Developer\Desktop\apps\erp-go-6.4-using-laravel\resources\views/purchase/index.blade.php ENDPATH**/ ?>