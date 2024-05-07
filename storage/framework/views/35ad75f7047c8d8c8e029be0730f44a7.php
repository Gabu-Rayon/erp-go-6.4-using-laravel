
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Mapped Purchase')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Mapped Purchases')); ?></li>
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
        <!-- Add the form for date search -->
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create purchase')): ?>
            <div class="d-inline-block mb-4">
                <!-- <?php echo e(Form::open(['url' => 'purchase.searchByDate', 'class' => 'w-100'])); ?> -->
                <?php echo e(Form::open(['route' => 'purchase.searchByDate', 'method' => 'GET', 'class' => 'w-100'])); ?>

                <?php echo csrf_field(); ?>
                <input type="hidden" name="_token" id="token" value="<?php echo e(csrf_token()); ?>">
                <div class="form-group">
                    <?php echo e(Form::label('SearchByDate', __('Search By Date'), ['class' => 'form-label'])); ?>

                    <?php echo e(Form::date('searchByDate', null, ['class' => 'form-control', 'required' => 'required'])); ?>

                </div>
                <button type="submit" class="btn btn-primary  sync"><?php echo e(__('Search      ')); ?></button>
                <?php echo e(Form::close()); ?>

            </div>
            <a href="<?php echo e(route('purchase.create', 0)); ?>" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                title="<?php echo e(__('Create')); ?>">
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
                                    <th> <?php echo e(__('ID')); ?></th>
                                    <th> <?php echo e(__('InvcNo')); ?></th>
                                    <th> <?php echo e(__('Purchase Date')); ?></th>
                                    <th> <?php echo e(__('SupplrTin')); ?></th>
                                    <th><?php echo e(__('supplrBhfId')); ?></th>
                                    <th><?php echo e(__('SupplrName')); ?></th>
                                     <th><?php echo e(__('SupplrInvcNo')); ?></th>
                                    <?php if(Gate::check('edit purchase') || Gate::check('delete purchase') || Gate::check('show purchase')): ?>
                                        <th> <?php echo e(__('Action')); ?></th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <?php if(isset($filteredPurchases)): ?>
                            <tbody>
                                <?php $__currentLoopData = $mappedPurchases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $purchase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($purchase->mappedPurchaseId); ?></td>
                                        <td><?php echo e($purchase->invcNo); ?></td>
                                        <td><?php echo e($purchase->purchaseDate); ?></td>
                                        <td><?php echo e($purchase->supplrTin); ?></td>
                                        <td><?php echo e($purchase->supplrBhfId); ?></td>
                                        <td><?php echo e($purchase->supplrName); ?></td>
                                        <td><?php echo e($purchase->supplrInvcNo); ?></td>
                                        <?php if(Gate::check('edit purchase') || Gate::check('delete purchase') || Gate::check('show purchase')): ?>
                                            <td class="Action">
                                                <span>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show purchase')): ?>
                                                        <div class="action-btn bg-info ms-2">
                                                            <a href="<?php echo e(route('mappedPurchases.details', ['mappedPurchaseId' => $purchase->mappedPurchaseId])); ?>"
                                                                class="mx-3 btn btn-sm align-items-center"
                                                                data-bs-toggle="tooltip"
                                                                title="<?php echo e(__('View Map purchase Item Details')); ?>"
                                                                data-original-title="<?php echo e(__('View Map purchase Item Details')); ?>">
                                                                <i class="ti ti-eye text-white"></i></a>
                                                        </div>
                                                    <?php endif; ?>
                                                </span>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            <?php else: ?> if (isset($filteredPurchases))
                            <tbody>
                                <?php $__currentLoopData = $filteredPurchases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $purchase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                     <tr>
                                        <td><?php echo e($purchase->mappedPurchaseId); ?></td>
                                        <td><?php echo e($purchase->invcNo); ?></td>
                                        <td><?php echo e($purchase->orgInvcNo); ?></td>
                                        <td><?php echo e($purchase->supplrTin); ?></td>
                                        <td><?php echo e($purchase->supplrBhfId); ?></td>
                                        <td><?php echo e($purchase->supplrName); ?></td>
                                        <td><?php echo e($purchase->supplrInvcNo); ?></td>
                                        <?php if(Gate::check('edit purchase') || Gate::check('delete purchase') || Gate::check('show purchase')): ?>
                                            <td class="Action">
                                                <span>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show purchase')): ?>
                                                        <div class="action-btn bg-info ms-2">
                                                            <a href="<?php echo e(route('mappedPurchases.details', ['mappedPurchaseId' => $purchase->mappedPurchaseId])); ?>"
                                                                class="mx-3 btn btn-sm align-items-center"
                                                                data-bs-toggle="tooltip"
                                                                title="<?php echo e(__('View Map purchase Item Details')); ?>"
                                                                data-original-title="<?php echo e(__('View Map purchase Item Details')); ?>">
                                                                <i class="ti ti-eye text-white"></i></a>
                                                        </div>
                                                    <?php endif; ?>
                                                </span>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            <?php endif; ?>
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

  sync.addEventListener('click', async function(event) {
    event.preventDefault();

    const searchByDate = document.querySelector('input[name="searchByDate"]').value;

    if (!searchByDate) {
      alert('<?php echo e(__('Please enter a date to search by')); ?>');
      return;
    }

    try {
      showLoadingSpinner(sync);

      const response = await fetch(`<?php echo e(route('purchase.searchByDate')); ?>?searchByDate=${searchByDate}`, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        }
      });

      if (!response.ok) {
        throw new Error('<?php echo e(__('An error occurred while syncing the data')); ?>');
      }

      const data = await response.json();

      if (data.newData.length > 0) {
        showSuccessPopup(`<?php echo e(__('New mapPurchases added to database')); ?> <br> <?php echo e(__('New data count')); ?>: ${data.newData.length}`);
        setTimeout(location.reload, 3000);
      } else {
        showInfoPopup('<?php echo e(__('Database is up to date')); ?>');
      }
    } catch (error) {
      showErrorPopup(error.message);
    } finally {
      removeLoadingSpinner(sync);
    }
  });

  function showLoadingSpinner(element) {
    const loader = document.createElement('div');
    loader.classList.add('spinner-border', 'text-light', 'spinner-border-sm');
    loader.role = 'status';
    element.appendChild(loader);
  }

  function removeLoadingSpinner(element) {
    element.removeChild(element.querySelector('.spinner-border'));
  }

  function showSuccessPopup(message) {
    const popup = createPopup('alert-success', message);
    document.body.appendChild(popup);
    setTimeout(() => document.body.removeChild(popup), 3000);
  }

  function showInfoPopup(message) {
    const popup = createPopup('alert-info', message);
    document.body.appendChild(popup);
    setTimeout(() => document.body.removeChild(popup), 3000);
  }

  function showErrorPopup(message) {
    const popup = createPopup('alert-danger', message);
    document.body.appendChild(popup);
    setTimeout(() => document.body.removeChild(popup), 3000);
  }

  function createPopup(type, message) {
    const popup = document.createElement('div');
    popup.classList.add('alert', type);
    popup.innerHTML = message;
    popup.style.position = 'absolute';
    popup.style.top = '50%';
    popup.style.left = '50%';
    popup.style.transform = 'translate(-50%, -50%)';
    popup.style.zIndex = '9999';
    return popup;
  }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp-go-6.4-using-laravel\resources\views/purchase/mapPurchases.blade.php ENDPATH**/ ?>