<?php echo e(Form::open(array('url'=>'leave/changeaction','method'=>'post'))); ?>

<div class="modal-body">
    <div class="row">
        <div class="col-12">
                <table class="table modal-table">
                    <tr role="row">
                        <th><?php echo e(__('Employee')); ?></th>
                        <td><?php echo e(!empty($employee->name)?$employee->name:''); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo e(__('Leave Type ')); ?></th>
                        <td><?php echo e(!empty($leavetype->title)?$leavetype->title:''); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo e(__('Appplied On')); ?></th>
                        <td><?php echo e(\Auth::user()->dateFormat( $leave->applied_on)); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo e(__('Start Date')); ?></th>
                        <td><?php echo e(\Auth::user()->dateFormat($leave->start_date)); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo e(__('End Date')); ?></th>
                        <td><?php echo e(\Auth::user()->dateFormat($leave->end_date)); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo e(__('Leave Reason')); ?></th>
                        <td><?php echo e(!empty($leave->leave_reason)?$leave->leave_reason:''); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo e(__('Status')); ?></th>
                        <td><?php echo e(!empty($leave->status)?$leave->status:''); ?></td>
                    </tr>
                    <input type="hidden" value="<?php echo e($leave->id); ?>" name="leave_id">
                </table>
        </div>
    </div>
</div>
<?php if(\Auth::user()->type == 'company'): ?>
<div class="modal-footer">
    <input type="submit" value="<?php echo e(__('Approval')); ?>" class="btn btn-success" data-bs-dismiss="modal" name="status">
    <input type="submit" value="<?php echo e(__('Reject')); ?>" class="btn btn-danger" name="status">
</div>
<?php endif; ?>
<?php echo e(Form::close()); ?>

<?php /**PATH C:\Users\Developer\Desktop\apps\erp-go-6.4-using-laravel\resources\views/leave/action.blade.php ENDPATH**/ ?>