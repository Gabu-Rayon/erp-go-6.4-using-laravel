
<?php $__env->startPush('script-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Item Information')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0 "><?php echo e(__('Item Information')); ?></h5>
    </div>Support
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Manage Item Information')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
        <a href="#" data-size="md" data-bs-toggle="tooltip" title="<?php echo e(__('Import')); ?>" data-url="<?php echo e(route('productservice.file.import')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Import product CSV file')); ?>" class="btn btn-sm btn-primary">
            <i class="ti ti-file-import"></i>
        </a>
        <a href="<?php echo e(route('productservice.export')); ?>" data-bs-toggle="tooltip" title="<?php echo e(__('Export')); ?>"
            class="btn btn-sm btn-primary">
            <i class="ti ti-file-export"></i>
        </a>
        <a href="#" data-size="lg" data-url="<?php echo e(route('productservice.create')); ?>" data-ajax-popup="true"
            data-bs-toggle="tooltip" title="<?php echo e(__('Create New Product')); ?>" class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>

        <!-- Button to trigger the getItemInformationApi and Synchronize it to my Database() method -->
        <a href="#" id="synchronizeBtn" data-size="lg" data-url="<?php echo e(route('productservice.synchronize')); ?>"
            data-ajax-popup="true" data-bs-toggle="tooltip" title="<?php echo e(__('Synchronize')); ?>" class="btn btn-sm btn-primary">
            <i class="#">Synchronize</i>
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
                        <th scope="col"><?php echo e(__('SrNo')); ?></th>
                        <th scope="col"><?php echo e(__('Code')); ?></th>
                        <th scope="col"><?php echo e(__('Classification Code')); ?></th>
                        <th scope="col"><?php echo e(__('Type Code')); ?></th>
                        <th scope="col"><?php echo e(__('Name')); ?></th>
                        <th scope="col"><?php echo e(__('Price')); ?></th>
                        <th scope="col" ><?php echo e(__('Action')); ?></th>
                        </tr>
                        </thead>
                        <tbody class="list">
                        <?php $__currentLoopData = $iteminformations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iteminformation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($iteminformation->id); ?></td>
                                <td><?php echo e($iteminformation->itemCd); ?></td>
                                <td><?php echo e($iteminformation->itemClsCd); ?></td>
                                <td></td>
                                <td><?php echo e($iteminformation->itemNm); ?></td>
                                <td><?php echo e($iteminformation->dftPrc); ?></td>
                                <td>
                                    <div class="action-btn bg-warning ms-2">
                                        <a href="<?php echo e(route('productservice.show',$iteminformation->id)); ?>" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="tooltip" title="<?php echo e(__('Details')); ?>"><i class="ti ti-eye text-white"></i></a>
                                    </div>
                                    <div class="action-btn bg-info ms-2">
                                        <a href="#" class="mx-3 btn btn-sm  align-items-center" data-url="<?php echo e(route('productservice.edit',$iteminformation->id)); ?>" data-ajax-popup="true"  data-size="lg " data-bs-toggle="tooltip" title="<?php echo e(__('Edit')); ?>"  data-title="<?php echo e(__('Edit Item Info')); ?>">
                                            <i class="ti ti-pencil text-white"></i>
                                        </a>
                                    </div>                                 
                                </td>
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
                const response = await fetch('http://localhost:8000/productservice/synchronize', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });
            const data = await response.json();
            
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp-go-6.4-using-laravel\resources\views/productservice/index.blade.php ENDPATH**/ ?>