
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
        <a href="#" data-size="md" data-bs-toggle="tooltip" title="<?php echo e(__('Import')); ?>"
            data-url="<?php echo e(route('productservice.file.import')); ?>" data-ajax-popup="true"
            data-title="<?php echo e(__('Import product CSV file')); ?>" class="btn btn-sm btn-primary">
            <i class="ti ti-file-import"></i>
        </a>
        <a href="<?php echo e(route('productservice.export')); ?>" data-bs-toggle="tooltip" title="<?php echo e(__('Export')); ?>"
            class="btn btn-sm btn-primary">
            <i class="ti ti-file-export"></i>
        </a>
        <a href="<?php echo e(route('productservice.create')); ?>" data-bs-toggle="tooltip" title="<?php echo e(__('Create New Product')); ?>"
            class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>

        <!-- Button to trigger the getItemInformationApi and Synchronize it to my Database() method -->
        <a href="<?php echo e(route('productservice.synchronize')); ?>" class="btn btn-sm btn-primary sync">
            Synchronize
        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class=" mt-2 <?php echo e(isset($_GET['category']) ? 'show' : ''); ?>" id="multiCollapseExample1">
                <div class="card">
                    <div class="card-body">
                        <?php echo e(Form::open(['route' => ['productservice.index'], 'method' => 'GET', 'id' => 'product_service'])); ?>

                        <div class="d-flex align-items-center justify-content-end">
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                <div class="btn-box">
                                    <?php echo e(Form::label('category', __('Category'), ['class' => 'form-label'])); ?>

                                    <?php echo e(Form::select('category', $category, null, ['class' => 'form-control select', 'id' => 'choices-multiple', 'required' => 'required'])); ?>

                                </div>
                            </div>
                            <div class="col-auto float-end ms-2 mt-4">
                                <a href="#" class="btn btn-sm btn-primary"
                                    onclick="document.getElementById('product_service').submit(); return false;"
                                    data-bs-toggle="tooltip" title="<?php echo e(__('apply')); ?>">
                                    <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                </a>
                                <a href="<?php echo e(route('productservice.index')); ?>" class="btn btn-sm btn-danger"
                                    data-bs-toggle="tooltip" title="<?php echo e(__('Reset')); ?>">
                                    <span class="btn-inner--icon"><i class="ti ti-trash-off"></i></span>
                                </a>
                            </div>

                        </div>
                        <?php echo e(Form::close()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
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
                                    <th scope="col"><?php echo e(__('Name')); ?></th>
                                    <th scope="col"><?php echo e(__('Price')); ?></th>
                                    <th scope="col"><?php echo e(__('Action')); ?></th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                <?php $__currentLoopData = $productServices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iteminformation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($iteminformation->id); ?></td>
                                        <td><?php echo e($iteminformation->itemCd); ?></td>
                                        <td><?php echo e($iteminformation->itemClsCd); ?></td>
                                        <td><?php echo e($iteminformation->itemNm); ?></td>
                                        <td><?php echo e($iteminformation->dftPrc); ?></td>
                                        <td>
                                            <div class="action-btn bg-warning ms-2">
                                                <a href="<?php echo e(route('productservice.show', $iteminformation->id)); ?>"
                                                    class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                    data-bs-toggle="tooltip" title="<?php echo e(__('Details')); ?>"><i
                                                        class="ti ti-eye text-white"></i></a>
                                            </div>
                                            <div class="action-btn bg-info ms-2">
                                                <a href="#" class="mx-3 btn btn-sm  align-items-center"
                                                    data-url="<?php echo e(route('productservice.edit', $iteminformation->id)); ?>"
                                                    data-ajax-popup="true" data-size="lg " data-bs-toggle="tooltip"
                                                    title="<?php echo e(__('Edit')); ?>" data-title="<?php echo e(__('Edit Item Info')); ?>">
                                                    <i class="ti ti-pencil text-white"></i>
                                                </a>
                                            </div>
                                        </td>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
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
                                                        <th scope="col"><?php echo e(__('Action')); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody class="list">
                                                    <?php $__currentLoopData = $productServices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iteminformation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td><?php echo e($iteminformation->id); ?></td>
                                                            <td><?php echo e($iteminformation->itemCd); ?></td>
                                                            <td><?php echo e($iteminformation->itemClsCd); ?></td>
                                                            <td></td>
                                                            <td><?php echo e($iteminformation->itemNm); ?></td>
                                                            <td><?php echo e($iteminformation->dftPrc); ?></td>
                                                            <td>
                                                                <div class="action-btn bg-warning ms-2">
                                                                    <a href="<?php echo e(route('productservice.show', $iteminformation->id)); ?>"
                                                                        class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                                        data-bs-toggle="tooltip"
                                                                        title="<?php echo e(__('Details')); ?>"><i
                                                                            class="ti ti-eye text-white"></i></a>
                                                                </div>
                                                                <div class="action-btn bg-info ms-2">
                                                                    <a href="#"
                                                                        class="mx-3 btn btn-sm  align-items-center"
                                                                        data-url="<?php echo e(route('productservice.edit', $iteminformation->id)); ?>"
                                                                        data-ajax-popup="true" data-size="lg "
                                                                        data-bs-toggle="tooltip"
                                                                        title="<?php echo e(__('Edit')); ?>"
                                                                        data-title="<?php echo e(__('Edit Item Info')); ?>">
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp-go-6.4-using-laravel\resources\views/productservice/index.blade.php ENDPATH**/ ?>