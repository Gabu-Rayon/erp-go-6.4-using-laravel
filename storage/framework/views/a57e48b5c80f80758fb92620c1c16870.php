
<?php echo e(Form::open(['url' => 'appraisal', 'method' => 'post'])); ?>

<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('branch', __('Branch*'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::select('branch',$brances,null,array('class'=>'form-control select','required'=>'required'))); ?>

            </div>
        </div>


        <div class="col-md-6 mt-2">
            <div class="form-group">
                <?php echo e(Form::label('employee', __('Employee*'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::select('employee',$employees,null,array('class'=>'form-control select','required'=>'required'))); ?>

            </div>
        </div>


        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('appraisal_date', __('Select Month*'), ['class' => 'col-form-label'])); ?>

                <?php echo e(Form::month('appraisal_date', '', ['class' => 'form-control ','autocomplete'=>'off' ,'required' => 'required'])); ?>

            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('remark', __('Remarks'), ['class' => 'col-form-label'])); ?>

                <?php echo e(Form::textarea('remark', null, ['class' => 'form-control', 'rows' => '3','placeholder'=>'Enter remark'])); ?>

            </div>
        </div>
    </div>
    <div class="row" id="stares">
    </div>
</div>

<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn btn-primary">
</div>
<?php echo e(Form::close()); ?>




<script>

    $('#employee').change(function(){

        var emp_id = $('#employee').val();
        $.ajax({
            url: "<?php echo e(route('empByStar')); ?>",
            type: "post",
            data:{
                "employee": emp_id,
                "_token": "<?php echo e(csrf_token()); ?>",
            },

            cache: false,
            success: function(data) {
                $('#stares').html(data.html);
            }
        })
    });
</script>

<script>
    $('#branch').on('change', function() {
        var branch_id = this.value;

        $.ajax({
            url: "<?php echo e(route('getemployee')); ?>",
            type: "post",
            data:{
                "branch_id": branch_id,
                "_token": "<?php echo e(csrf_token()); ?>",
            },

            cache: false,
            success: function(data) {

                $('#employee').html('<option value="">Select Employee</option>');
                $.each(data.employee, function (key, value) {
                    $("#employee").append('<option value="' + value.id + '">' + value.name + '</option>');
                });

            }
        })


    });
</script>







<?php /**PATH C:\Users\Developer\Desktop\apps\erp-go-6.4-using-laravel\resources\views/appraisal/create.blade.php ENDPATH**/ ?>