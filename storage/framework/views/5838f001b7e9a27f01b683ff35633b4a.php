<?php if(!empty($customer)): ?>
    <div class="row">
        <div class="col-md-4">
                <h6><?php echo e(__('Customer Details')); ?></h6>
                <div class="bill-to">
                    <?php if(!empty($customer['name'])): ?>
                    <small>
                        <span>Name: <?php echo e($customer['name']); ?></span><br>
                        <span>TIN: <?php echo e($customer['customerTin']); ?></span><br>
                        <span>Customer No: <?php echo e($customer['customerNo']); ?></span><br>
                        <span>Contact: <?php echo e($customer['contact']); ?></span><br>
                        <span><?php echo e($customer['billing_zip']); ?></span>
                    </small>
                    <?php else: ?>
                        <br> -
                    <?php endif; ?>
                </div>
        </div>
        <div class="col-md-4">
            <h6><?php echo e(__('Bill to')); ?></h6>
            <div class="bill-to">
                <?php if(!empty($customer['billing_name'])): ?>
                <small>
                    <span><?php echo e($customer['billing_name']); ?></span><br>
                    <span><?php echo e($customer['billing_phone']); ?></span><br>
                    <span><?php echo e($customer['billing_address']); ?></span><br>
                    <span><?php echo e($customer['billing_city'] . ' , '.$customer['billing_state'].' , '.$customer['billing_country'].'.'); ?></span><br>
                    <span><?php echo e($customer['billing_zip']); ?></span>
                </small>
                <?php else: ?>
                    <br> -
                <?php endif; ?>
            </div>
        </div>
        <div class="col-md-4">
            <h6><?php echo e(__('Ship to')); ?></h6>
            <div class="bill-to">
                <?php if(!empty($customer['shipping_name'])): ?>
                <small>
                    <span><?php echo e($customer['shipping_name']); ?></span><br>
                    <span><?php echo e($customer['shipping_phone']); ?></span><br>
                    <span><?php echo e($customer['shipping_address']); ?></span><br>
                    <span><?php echo e($customer['shipping_city'] . ' , '.$customer['shipping_state'].' , '.$customer['shipping_country'].'.'); ?></span><br>
                    <span><?php echo e($customer['shipping_zip']); ?></span>
                </small>
                <?php else: ?>
                    <br> -
                <?php endif; ?>
            </div>
        </div>
        <div class="col-md-2">
            <a href="#" id="remove" class="btn btn-sm my-3 btn-danger"><?php echo e(__(' Remove')); ?></a>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH C:\Users\Developer\Desktop\apps\erp-go-6.4-using-laravel\resources\views/invoice/customer_detail.blade.php ENDPATH**/ ?>