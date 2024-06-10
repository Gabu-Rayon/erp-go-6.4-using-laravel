<?php if(isset($task)): ?>
    <?php echo e(Form::model($task, array('route' => array('deals.tasks.update', $deal->id, $task->id), 'method' => 'PUT'))); ?>

<?php else: ?>
    <?php echo e(Form::open(array('route' => ['deals.tasks.store',$deal->id]))); ?>

<?php endif; ?>
<div class="modal-body">
    <div class="row">
        <div class="col-12 form-group">
            <?php echo e(Form::label('name', __('Name'),['class'=>'form-label'])); ?>

            <?php echo e(Form::text('name', null, array('class' => 'form-control','required'=>'required'))); ?>

        </div>
        <div class="col-6 form-group">
            <?php echo e(Form::label('date', __('Date'),['class'=>'form-label'])); ?>

            <?php echo e(Form::date('date', null, array('class' => 'form-control','required'=>'required'))); ?>

        </div>
        <div class="col-6 form-group">
            <?php echo e(Form::label('time', __('Time'),['class'=>'form-label'])); ?>

            <?php echo e(Form::time('time', null, array('class' => 'form-control','required'=>'required'))); ?>

        </div>
        <div class="col-6 form-group">
            <?php echo e(Form::label('priority', __('Priority'),['class'=>'form-label'])); ?>

            <select class="form-control select2" name="priority" required id="choices-multiple1">
                <?php $__currentLoopData = $priorities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $priority): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($key); ?>" <?php if(isset($task) && $task->priority == $key): ?> selected <?php endif; ?>><?php echo e(__($priority)); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-6 form-group">
            <?php echo e(Form::label('status', __('Status'),['class'=>'form-label'])); ?>

            <select class="form-control select2" name="status" id="choices-multiple2" required>
                <?php $__currentLoopData = $status; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($key); ?>" <?php if(isset($task) && $task->status == $key): ?> selected <?php endif; ?>><?php echo e(__($st)); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn  btn-light" data-bs-dismiss="modal">
    <?php if(isset($task)): ?>
        <input type="submit" value="<?php echo e(__('Update')); ?>" class="btn  btn-primary">
    <?php else: ?>
        <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn  btn-primary">
    <?php endif; ?>

</div>
<?php echo e(Form::close()); ?>



<script>
    $('#date').daterangepicker({
        locale: {format: 'YYYY-MM-DD'},
        singleDatePicker: true,
    });
    $("#time").timepicker({
        icons: {
            up: 'ti ti-chevron-up',
            down: 'ti ti-chevron-down'
        }
    });
</script>
<?php /**PATH C:\Users\Developer\Desktop\apps\erp-go-6.4-using-laravel\resources\views/deals/tasks.blade.php ENDPATH**/ ?>