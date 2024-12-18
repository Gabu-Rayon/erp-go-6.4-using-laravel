
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Notices List')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Notices List')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
        <div class="d-inline-block mb-4">
            <?php echo e(Form::open(['route' => 'noticelist.searchByDate', 'method' => 'POST', 'class' => 'w-100'])); ?>

            <?php echo csrf_field(); ?>
            <div class="form-group">
                <?php echo e(Form::label('SearchByDate', __('Search Date (ex- 01-Jan-2022)'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::date('searchByDate', null, ['class' => 'form-control', 'required' => 'required'])); ?>

            </div>
            <button type="submit" class="btn btn-primary sync"><?php echo e(__('Search')); ?></button>
            <?php echo e(Form::close()); ?>

        </div>
       <a href="<?php echo e(route('noticelist.synchronize')); ?>" class="btn btn-sm btn-primary">
            Synchronize
        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('SrNo')); ?></th>
                                    <th><?php echo e(__(' NoticeNo')); ?></th>
                                    <th><?php echo e(__('Title')); ?></th>
                                    <th><?php echo e(__('Cont')); ?></th>
                                    <th><?php echo e(__('registeredName')); ?></th>
                                    <th><?php echo e(__('Url')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $notices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="font-style">
                                        <td><?php echo e($notice->id); ?></td>
                                        <td><?php echo e($notice->noticeNo); ?></td>
                                        <td><?php echo e($notice->title); ?></td>
                                        <td><?php echo e($notice->cont); ?></td>
                                        <td><?php echo e($notice->regrNm); ?></td>
                                        <td class="text-wrap text-truncate" style="max-width: 200px;"><?php echo e($notice->dtlUrl); ?></td>
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp-go-6.4-using-laravel\resources\views/noticelist/index.blade.php ENDPATH**/ ?>