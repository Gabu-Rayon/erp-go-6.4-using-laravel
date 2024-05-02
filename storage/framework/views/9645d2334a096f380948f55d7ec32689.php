
<?php $__env->startPush('script-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Code List')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0 "><?php echo e(__('Code List')); ?></h5>
    </div>Support
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Manage Code List')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
<div class="float-end">
    <button class="btn btn-sm btn-primary sync flex justify-center items-center text-center gap-2">
        <i class="#">Synchronize</i>
    </button>
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
                            <th scope="col"><?php echo e(__('SrNo')); ?></th>
                            <th scope="col"><?php echo e(__('CDCls')); ?></th>
                            <th scope="col"><?php echo e(__('CDClsNm')); ?></th>
                            <th scope="col"><?php echo e(__('Use')); ?></th>
                            <th scope="col"><?php echo e(__('UserDfnNm1')); ?></th>
                            <th scope="col"><?php echo e(__('LastRequestDate')); ?></th>
                        </tr>
                        </thead>
                        <tbody class="list">
                            <?php $__currentLoopData = $codelists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $codelist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($codelist->id); ?></td>
                                    <td><?php echo e($codelist->cdCls); ?></td>
                                    <td><?php echo e($codelist->cdClsNm); ?></td>
                                    <td><?php echo e($codelist->useYn); ?></td>
                                    <td><?php echo e($codelist->userDfnNm1); ?></td>
                                    <td><?php echo e($codelist->created_at); ?></td>
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


<?php $__env->startPush('script-page'); ?>
    <script>
        const sync = document.querySelector('.sync');
        sync.addEventListener('click', async function(){
            try {
                const loader = document.createElement('div');
                loader.classList.add('spinner-border', 'text-light', 'spinner-border-sm');
                loader.role = 'status';
                sync.appendChild(loader);
                const response = await fetch('http://localhost:8000/productservice/synccodelist', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });
            const data = await response.json();

            sync.removeChild(loader);
            
            console.log('success');
            const popup = document.createElement('div');
            popup.classList.add('alert', 'alert-success');
            popup.innerHTML = data.info || data.success || 'Synced Successfully';
            popup.style.position = 'absolute';
            popup.style.top = '50%';
            popup.style.left = '50%';
            popup.style.transform = 'translate(-50%, -50%)';
            popup.style.zIndex = '9999';
            document.body.appendChild(popup);
            setTimeout(() => {
                location.reload();
            }, 3000);
            } catch (error) {
                console.log('error');
                const popup = document.createElement('div');
                popup.classList.add('alert', 'alert-danger');
                popup.innerHTML = data.error || 'Sync Failed';
                popup.style.position = 'absolute';
                popup.style.top = '50%';
                popup.style.left = '50%';
                popup.style.transform = 'translate(-50%, -50%)';
                popup.style.zIndex = '9999';
                document.body.appendChild(popup);
                setTimeout(() => {
                    location.reload();
                }, 3000);
            }
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Developer\Desktop\apps\erp-go-6.4-using-laravel\resources\views/productservice/getcodelist.blade.php ENDPATH**/ ?>