<?php echo e(Form::model($branchUser, ['route' => ['branchuser.update', $branchUser->id], 'method' => 'PUT'])); ?>

<div class="modal-body">

    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <?php echo e(Form::label('branchUserName', __('Name'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::text('branchUserName', $branchUser->branchUserName, ['class' => 'form-control'])); ?>

            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <?php echo e(Form::label('branchUserId', __('User ID'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::text('branchUserId', $branchUser->branchUserId, ['class' => 'form-control'])); ?>

            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <?php echo e(Form::label('address', __('User Address'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::text('address', $branchUser->address, ['class' => 'form-control'])); ?>

            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <?php echo e(Form::label('contactNo', __('Contact No'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::text('contactNo', $branchUser->contactNo, ['class' => 'form-control'])); ?>

            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <?php echo e(Form::label('authenticationCode', __('Authentication Code'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::text('authenticationCode', $branchUser->authenticationCode, ['class' => 'form-control'])); ?>

            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <?php echo e(Form::label('isUsed', __('Is Used?'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::select('isUsed', ['1' => 'Yes', '0' => 'No'], $branchUser->isUsed == '1' ? '1' : '0', ['class' => 'form-control'])); ?>

            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="<?php echo e(__('Update')); ?>" class="btn  btn-primary">
</div>

<?php echo e(Form::close()); ?>

<?php /**PATH C:\Users\Developer\Desktop\apps\erp-go-6.4-using-laravel\resources\views/branchuser/edit.blade.php ENDPATH**/ ?>