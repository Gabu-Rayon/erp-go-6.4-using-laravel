
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Product & Services')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Product & Services')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
        <a href="#" data-size="md" data-bs-toggle="tooltip" title="<?php echo e(__('Import')); ?>"
            data-url="<?php echo e(route('productservice.file.import')); ?>" data-ajax-popup="true"
            data-title="<?php echo e(__('Import product CSV file')); ?>" class="btn btn-sm btn-primary">
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
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('SrNo')); ?></th>
                                    <th><?php echo e(__('Code')); ?></th>
                                    <th><?php echo e(__('Classification Code')); ?></th>
                                    <th><?php echo e(__('Type Code')); ?></th>
                                    <th><?php echo e(__('Name')); ?></th>
                                    <th><?php echo e(__('Status')); ?></th>
                                    <th><?php echo e(__('Action')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $itemlists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="font-style">
                                        <td><?php echo e($item->id); ?></td>
                                        <td><?php echo e($item->itemCd); ?></td>
                                        <td><?php echo e($item->itemClsCd); ?></td>
                                        <td><?php echo e($item->itemTyCd); ?></td>
                                        <td><?php echo e($item->itemNm); ?></td>
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
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('synchronizeBtn').addEventListener('click', function() {
                // Show loading spinner
                showLoadingSpinner();
            });

            function showLoadingSpinner() {
                // Create a loading spinner element
                var spinner = document.createElement('div');
                spinner.classList.add('spinner-border', 'text-light');
                spinner.setAttribute('role', 'status');

                // Create a container for the spinner
                var spinnerContainer = document.createElement('div');
                spinnerContainer.classList.add('loading-spinner-container');
                spinnerContainer.appendChild(spinner);

                // Append the spinner container to the body
                document.body.appendChild(spinnerContainer);
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp-go-6.4-using-laravel\resources\views/productservice/index.blade.php ENDPATH**/ ?>