<div class="card sticky-top" style="top:30px">
    <div class="list-group list-group-flush" id="useradd-sidenav">
        <a
            href="<?php echo e(route('taxes.index')); ?>"
            class="list-group-item list-group-item-action border-0 <?php echo e((Request::route()->getName() == 'taxes.index' ) ? ' active' : ''); ?>"
            >
                <?php echo e(__('Taxes')); ?>

                <div class="float-end">
                    <i class="ti ti-chevron-right"></i>
                </div>
            </a>
        <a
            href="<?php echo e(route('details.countries')); ?>"
            class="list-group-item list-group-item-action border-0
                <?php echo e((Request::route()->getName() == 'details.countries' )
                    ? ' active'
                    : ''); ?>"
            >
                <?php echo e(__('Countries')); ?>

                <div class="float-end">
                    <i class="ti ti-chevron-right"></i>
                </div>
        </a>

        <a
            href="<?php echo e(route('details.refundreasons')); ?>"
            class="list-group-item list-group-item-action border-0
                <?php echo e((Request::route()->getName() == 'details.refundreasons' )
                    ? ' active'
                    : ''); ?>"
            >
                <?php echo e(__('Refund Reasons')); ?>

                <div class="float-end">
                    <i class="ti ti-chevron-right"></i>
                </div>
        </a>

        <a
            href="<?php echo e(route('details.currencies')); ?>"
            class="list-group-item list-group-item-action border-0
                <?php echo e((Request::route()->getName() == 'details.currencies' )
                    ? ' active'
                    : ''); ?>"
            >
                <?php echo e(__('Currencies')); ?>

                <div class="float-end">
                    <i class="ti ti-chevron-right"></i>
                </div>
        </a>

        <a
            href="<?php echo e(route('details.banks')); ?>"
            class="list-group-item list-group-item-action border-0
                <?php echo e((Request::route()->getName() == 'details.banks' )
                    ? ' active'
                    : ''); ?>"
            >
                <?php echo e(__('Banks')); ?>

                <div class="float-end">
                    <i class="ti ti-chevron-right"></i>
                </div>
        </a>

        <a
            href="<?php echo e(route('details.languages')); ?>"
            class="list-group-item list-group-item-action border-0
                <?php echo e((Request::route()->getName() == 'details.languages' )
                    ? ' active'
                    : ''); ?>"
            >
                <?php echo e(__('Languages')); ?>

                <div class="float-end">
                    <i class="ti ti-chevron-right"></i>
                </div>
        </a>

        <a
            href="<?php echo e(route('details.payment-types')); ?>"
            class="list-group-item list-group-item-action border-0
                <?php echo e((Request::route()->getName() == 'details.payment-types' )
                    ? ' active'
                    : ''); ?>"
            >
                <?php echo e(__('Payment Types')); ?>

                <div class="float-end">
                    <i class="ti ti-chevron-right"></i>
                </div>
        </a>

        <a href="<?php echo e(route('product-category.index')); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((Request::route()->getName() == 'product-category.index' ) ? 'active' : ''); ?>"><?php echo e(__('Category')); ?><div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

        <a href="<?php echo e(route('product-unit.index')); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((Request::route()->getName() == 'product-unit.index' ) ? ' active' : ''); ?>"><?php echo e(__('Unit')); ?><div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

        <a href="<?php echo e(route('custom-field.index')); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((Request::route()->getName() == 'custom-field.index' ) ? 'active' : ''); ?>   "><?php echo e(__('Custom Field')); ?><div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

    </div>
</div>
<?php /**PATH C:\Users\hp\Desktop\projects\erp-go-6.4-using-laravel\resources\views/layouts/account_setup.blade.php ENDPATH**/ ?>