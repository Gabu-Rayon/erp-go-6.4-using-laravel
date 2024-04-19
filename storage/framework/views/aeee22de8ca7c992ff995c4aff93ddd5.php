<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Project Reports')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0"><?php echo e(__('Project Reports')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('project_report.index')); ?>"><?php echo e(__('Project Report')); ?></a></li>

    <li class="breadcrumb-item"><?php echo e(ucwords($project->project_name)); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css-page'); ?>
    <style>
    .table.dataTable.no-footer {
        border-bottom: none !important;
    }
    .display-none {
        display: none !important;
    }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script-page'); ?>
    <script type="text/javascript" src="<?php echo e(asset('js/html2pdf.bundle.min.js')); ?>"></script>
    <script>

        var filename = $('#filename').val();

        function saveAsPDF() {
            var element = document.getElementById('printableArea');
            var opt = {
                margin: 0.3,
                filename: filename,
                image: {type: 'jpeg', quality: 1},
                html2canvas: {scale: 4, dpi: 72, letterRendering: true},
                jsPDF: {unit: 'in', format: 'A2'}
            };
            html2pdf().set(opt).from(element).save();

        }


        $(document).ready(function () {
            var filename = $('#filename').val();
            $('#reportTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: filename
                    }, {
                        extend: 'csvHtml5',
                        title: filename
                    }, {
                        extend: 'pdfHtml5',
                        title: filename
                    },
                ],
                language: dataTabelLang
            });
        });
</script>
<?php $__env->stopPush(); ?>


<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
        <a href="#" onclick="saveAsPDF();" class="btn btn-sm btn-primary dwn" data-toggle="tooltip" title="<?php echo e(__('Project Report Download')); ?>">
            <i class="ti ti-download"></i>
        </a>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
    <div class="col-sm-12">
        <div class="row" id="printableArea">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5><?php echo e(__('Overview')); ?></h5>
                        </div>
                        <div class="card-body" style="min-height: 280px;">
                            <div class="row align-items-center">
                                <div class="col-7">
                                    <table class="table" >
                                        <tbody>
                                            <tr class="border-0" >
                                                <th class="border-0" ><?php echo e(__('Project Name')); ?>:</th>
                                                <td class="border-0"> <?php echo e($project->project_name); ?></td>
                                            </tr>
                                            <tr>
                                                <th class="border-0"><?php echo e(__('Project Status')); ?>:</th>
                                                <td class="border-0">

                                                    <?php if($project->status == 'in_progress'): ?>
                                                        <div class="badge  bg-primary p-2 px-3 rounded"> <?php echo e(__('In Progress')); ?></div>
                                                    <?php elseif($project->status == 'on_hold'): ?>
                                                    <div class="badge  bg-secondary p-2 px-3 rounded"><?php echo e(__('On Hold')); ?></div>
                                                    <?php elseif($project->status == 'Canceled'): ?>
                                                    <div class="badge  bg-danger p-2 px-3 rounded"> <?php echo e(__('Canceled')); ?></div>
                                                    <?php else: ?>
                                                        <div class="badge bg-warning p-2 px-3 rounded"><?php echo e(__('Finished')); ?></div>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>

                                            <tr role="row">
                                                <th class="border-0"><?php echo e(__('Start Date')); ?>:</th>
                                                <td class="border-0"><?php echo e(($project->start_date)); ?></td>
                                            </tr>
                                            <tr>
                                                <th class="border-0"><?php echo e(__('End Date')); ?>:</th>
                                                <td class="border-0"><?php echo e(($project->end_date)); ?></td>
                                            </tr>
                                            <tr>
                                                <th class="border-0"><?php echo e(__('Total Members')); ?>:</th>
                                                <td class="border-0"><?php echo e((int) $project->users->count()); ?></td>
                                            </tr>
                                        </tbody>
                                   </table>
                                </div>
                                <div class="col-5 ">
                                            <?php
                                                                                        $task_percentage = $project->project_progress($project , $last_task->id)['percentage'];

                                                $data =trim($task_percentage,'%');
                                                $status = $data > 0 && $data <= 25 ? 'red' : ($data > 25 && $data <= 50 ? 'orange' : ($data > 50 && $data <= 75 ? 'blue' : ($data > 75 && $data <= 100 ? 'green' : '')));
                                            ?>
                                    <div class="circular-progressbar p-0">
                                        <div class="flex-wrapper">
                                            <div class="single-chart">
                                                <svg viewBox="0 0 36 36"
                                                    class="circular-chart orange  <?php echo e($status); ?>">
                                                    <path class="circle-bg" d="M18 2.0845
                                                                a 15.9155 15.9155 0 0 1 0 31.831
                                                                a 15.9155 15.9155 0 0 1 0 -31.831" />
                                                    <path class="circle"
                                                        stroke-dasharray="<?php echo e($data); ?>, 100" d="M18 2.0845
                                                                a 15.9155 15.9155 0 0 1 0 31.831
                                                                a 15.9155 15.9155 0 0 1 0 -31.831" />
                                                    <text x="18" y="20.35"
                                                        class="percentage"><?php echo e($data); ?>%</text>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <?php
                        $mile_percentage = $project->project_milestone_progress()['percentage'];
                        $mile_percentage =trim($mile_percentage,'%');
                    ?>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header" style="padding: 25px 35px !important;">
                            <div class="d-flex justify-content-between align-items-center">

                                <div class="row">
                                    <h5 class="mb-0"><?php echo e(__('Milestone Progress')); ?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <div class="chartjs-size-monitor">
                                    <div class="chartjs-size-monitor-expand">
                                        <div class=""></div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink">
                                        <div class=""></div>
                                    </div>
                                </div>
                                <div id="milestone-chart" class="chart-canvas chartjs-render-monitor" height="150"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <div class="float-end">
                                <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Refferals"><i class=""></i></a>
                            </div>
                            <h5><?php echo e(__('Task Priority')); ?></h5>
                        </div>
                        <div class="card-body"  style="min-height: 280px;">
                            <div class="row align-items-center">
                                <div class="col-12">
                                    <div id='chart_priority'></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header">
                            <div class="float-end">
                                <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Refferals"><i class=""></i></a>
                            </div>
                            <h5><?php echo e(__('Task Status')); ?></h5>
                        </div>
                        <div class="card-body"  style="min-height: 280px;">
                            <div class="row align-items-center">
                                <div class="col-12">
                                    <div id="chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="float-end">
                                  <a href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Refferals"><i class=""></i></a>
                              </div>
                            <h5><?php echo e(__('Hours Estimation')); ?></h5>
                        </div>
                        <div class="card-body"  style="min-height: 280px;">
                            <div class="row align-items-center">
                                <div class="col-12">
                                      <div id="chart-hours"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            $lastStage=\App\Models\TaskStage::where('created_by',\Auth::user()->creatorId())->orderby('id','desc')->first();

            ?>
                <div class="col-md-5">
                    <div class="card ">
                        <div class="card-header">
                            <h5><?php echo e(__('Users')); ?></h5>
                        </div>
                        <div class="card-body table-border-style ">
                            <div class="table-responsive milestone">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th><?php echo e(__('Name')); ?></th>
                                            <th><?php echo e(__('Assigned Tasks')); ?></th>
                                            <th><?php echo e(__('Done Tasks')); ?></th>
                                            <th><?php echo e(__('Logged Hours')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $project->users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $hours_format_number = 0;
                                                $total_hours = 0;
                                                $hourdiff_late = 0;
                                                $esti_late_hour =0;
                                                $esti_late_hour_chart=0;

                                                $total_user_task = App\Models\ProjectTask::where('project_id',$project->id)->whereRaw("FIND_IN_SET(?,  assign_to) > 0", [$user->id])->get()->count();



                                                $all_task = App\Models\ProjectTask::where('project_id',$project->id)->whereRaw("FIND_IN_SET(?,  assign_to) > 0", [$user->id])->get();

                                                $total_complete_task = App\Models\ProjectTask::where('project_id','=',$project->id)->where('stage_id',$lastStage->id)
                                                ->where('assign_to','=',$user->id)->count();

                                                $logged_hours = 0;
                                                $timesheets = App\Models\Timesheet::where('project_id',$project->id)->where('created_by' ,$user->id)->get();
                                            ?>

                                            <?php $__currentLoopData = $timesheets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $timesheet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php

                                                    $hours =  date('H', strtotime($timesheet->time));
                                                    $minutes =  date('i', strtotime($timesheet->time));
                                                    $total_hours = $hours + ($minutes/60) ;
                                                    $logged_hours += $total_hours ;
                                                    $hours_format_number = number_format($logged_hours, 2, '.', '');
                                                ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($user->name); ?></td>
                                                <td><?php echo e($total_user_task); ?></td>
                                                <td><?php echo e($total_complete_task); ?></td>
                                                <td><?php echo e($hours_format_number); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="card ">
                        <div class="card-header">
                            <h5><?php echo e(__('Milestones')); ?></h5>
                        </div>
                        <div class="card-body table-border-style ">
                            <div class="table-responsive milestone">
                                <table class="table" >
                                    <thead>
                                        <tr>
                                            <th> <?php echo e(__('Name')); ?></th>
                                            <th> <?php echo e(__('Progress')); ?></th>
                                            <th> <?php echo e(__('Cost')); ?></th>
                                            <th> <?php echo e(__('Status')); ?></th>
                                            <th> <?php echo e(__('Start Date')); ?></th>
                                            <th> <?php echo e(__('End Date')); ?></th>
                                        </tr>
                                    </thead>
                                     <tbody>
                                           <?php $__currentLoopData = $project->milestones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $milestone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                               <td><?php echo e($milestone->title); ?></td>
                                                <td>
                                                    <div class="progress_wrapper">
                                                            <div class="progress">
                                                                    <div class="progress-bar" role="progressbar"  style="width: <?php echo e($milestone->progress); ?>px;"
                                                                    aria-valuenow="55" aria-valuemin="0" aria-valuemax="100">
                                                                    </div>
                                                            </div>
                                                                    <div class="progress_labels">
                                                                        <div class="total_progress">
                                                                            <strong> <?php echo e($milestone->progress); ?>%</strong>
                                                                        </div>
                                                                    </div>
                                                    </div>
                                                </td>
                                               <td><?php echo e($milestone->cost); ?></td>
                                               <td> <?php if($milestone->status == 'complete'): ?>
                                                                    <label class="badge bg-success p-2 px-3 rounded"><?php echo e(__('Complete')); ?></label>
                                                                <?php else: ?>
                                                       <label class="badge bg-warning p-2 px-3 rounded"><?php echo e(__('Incomplete')); ?></label>
                                                   <?php endif; ?></td>

                                               <td><?php echo e($milestone->start_date); ?></td>
                                               <td><?php echo e($milestone->due_date); ?></td>
                                            </tr>
                                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

        </div>

        <div class="col-sm-12">
            <div class="col-md-12  row d-sm-flex align-items-center justify-content-end">
                <div class="col-1">
                    <button class=" btn btn-primary mx-2 btn-filter apply">
                        <a href="<?php echo e(route('project_report.export',$project->id)); ?>" class="text-white"><?php echo e(__('Export')); ?></a>
                    </button>
                </div>
            </div>
        </div>

        <div class="col-sm-12 mt-3">
                <div class="card">
                    <div class="card-body mt-3 mx-2">
                        <div class="row mt-2">
                            <div class="table-responsive">
                                    <table class="table datatable">
                                        <thead>
                                                <th><?php echo e(__('Task Name')); ?></th>
                                                <th><?php echo e(__('Milestone')); ?></th>
                                                <th><?php echo e(__('Start Date')); ?></th>
                                                <th><?php echo e(__('End Date')); ?></th>
                                                <th><?php echo e(__('Assigned to')); ?></th>
                                                <th> <?php echo e(__('Total Logged Hours')); ?></th>
                                                <th><?php echo e(__('Priority')); ?></th>
                                                <th><?php echo e(__('Stage')); ?></th>

                                            </thead>

                                        <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $hours_format_number = 0;
                                                $total_hours = 0;
                                                $hourdiff_late = 0;
                                                $esti_late_hour =0;
                                                $esti_late_hour_chart=0;

                                                $total_user_task = App\Models\ProjectTask::where('project_id',$project->id)->whereRaw("FIND_IN_SET(?,  assign_to) > 0", [$user->id])->get()->count();

                                                $all_task = App\Models\ProjectTask::where('project_id',$project->id)->whereRaw("FIND_IN_SET(?,  assign_to) > 0", [$user->id])->get();

                                                $total_complete_task = App\Models\ProjectTask::join('task_stages','task_stages.id','=','project_tasks.stage_id')
                                                ->where('task_stages.project_id','=',$project->id)->where('stage_id',4)->where('assign_to','=',$user->id)->get()->count();

                                                $logged_hours = 0;
                                                $timesheets = App\Models\Timesheet::where('project_id',$project->id)->where('task_id' ,$task->id)->get();
                                            ?>
                                            <?php $__currentLoopData = $timesheets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $timesheet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                <?php

                                                    $hours =  date('H', strtotime($timesheet->time));
                                                    $minutes =  date('i', strtotime($timesheet->time));
                                                    $total_hours = $hours + ($minutes/60) ;
                                                    $logged_hours += $total_hours ;
                                                    $hours_format_number = number_format($logged_hours, 2, '.', '');
                                                ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <tbody>

                                            <td>
                                                <a href="#!" data-size="md" data-url="<?php echo e(route('projects.tasks.show',[$project->id,$task->id])); ?>"
                                                   data-ajax-popup="true" class="dropdown-item" data-bs-original-title="<?php echo e(__('View')); ?>">
                                                    <?php echo e($task->name); ?>

                                                </a>
                                            </td>
                                            <td><?php echo e((!empty($task->milestone)) ? $task->milestone->title : '-'); ?></td>
                                            <td><?php echo e($task->start_date); ?></td>
                                            <td><?php echo e($task->end_date); ?></td>
                                            <td>
                                                <div class="avatar-group">
                                                    <?php if($task->users()->count() > 0): ?>
                                                        <?php if($users = $task->users()): ?>
                                                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php if($key<3): ?>
                                                                    <a href="#" class="avatar rounded-circle avatar-sm">
                                                                        <img src="<?php echo e($user->getImgImageAttribute()); ?>" title="<?php echo e($user->name); ?>">
                                                                    </a>
                                                                <?php else: ?>
                                                                    <?php break; ?>
                                                                <?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                                        <?php if(count($users) > 3): ?>
                                                            <a href="#" class="avatar rounded-circle avatar-sm">
                                                                <img src="<?php echo e($user->getImgImageAttribute()); ?>">
                                                            </a>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        <?php echo e(__('-')); ?>

                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td><?php echo e($hours_format_number); ?></td>
                                            <td>
                                                <div class="">
                                                    <span class="badge p-2 px-3 status_badge rounded bg-<?php echo e(\App\Models\ProjectTask::$priority_color[$task->priority]); ?>"><?php echo e(\App\Models\ProjectTask::$priority[$task->priority]); ?></span>
                                                </div>
                                            </td>
                                            <td><?php echo e($task->stage->name); ?></td>


                                            </tbody>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </table>
                                </div>
                        </div>
                    </div>
                </div>
            </div>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
    <script src="<?php echo e(asset('assets/js/datatables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/apexcharts.min.js')); ?>"></script>
    <script>
        var filename = $('#chart-hours').val();

        function saveAsPDF() {
            var element = document.getElementById('printableArea');
            var opt = {
                margin: 0.3,

                image: {
                    type: 'jpeg',
                    quality: 1
                },
                html2canvas: {
                    scale: 4,
                    dpi: 72,
                    letterRendering: true
                },
                jsPDF: {
                    unit: 'in',
                    format: 'A2'
                }
            };
            html2pdf().set(opt).from(element).save();
        }
    </script>

    <script>
    (function () {
        var options = {
            series: [<?php echo json_encode($mile_percentage); ?>],
            chart: {
                height: 475,
                type: 'radialBar',
                offsetY: -20,
                sparkline: {
                    enabled: true
                }
            },
            plotOptions: {
                radialBar: {
                    startAngle: -90,
                    endAngle: 90,
                    track: {
                        background: "#e7e7e7",
                        strokeWidth: '97%',
                        margin: 5, // margin is in pixels
                    },
                    dataLabels: {
                        name: {
                            show: true
                        },
                        value: {
                            offsetY: -50,
                            fontSize: '20px'
                        }
                    }
                }
            },
            grid: {
                padding: {
                    top: -10
                }
            },
            colors: ["#51459d"],
            labels: ['Progress'],
        };
        var chart = new ApexCharts(document.querySelector("#milestone-chart"), options);
        chart.render();
    })();




        var options = {
              series: [{
              data: <?php echo json_encode($arrProcessPer_priority); ?>

            }],
              chart: {
              height: 210,
              type: 'bar',
            },
            colors: ['#6fd943','#ff3a6e','#3ec9d6'],
            plotOptions: {
              bar: {

                columnWidth: '50%',
                distributed: true,
              }
            },
            dataLabels: {
              enabled: false
            },
            legend: {
              show: true
            },
            xaxis: {
              categories: <?php echo json_encode($arrProcess_Label_priority); ?>,
              labels: {
                style: {
                  colors: <?php echo json_encode($chartData['color']); ?>,

                }
              }
            }
            };

            var chart = new ApexCharts(document.querySelector("#chart_priority"), options);
            chart.render();


            var options = {
                series:  <?php echo json_encode($arrProcessPer_status_task); ?>,
                chart: {
                    width: 380,
                    type: 'pie',
                },
                color: <?php echo json_encode($chartData['color']); ?>,
                labels:<?php echo json_encode($arrProcess_Label_status_tasks); ?>,
                responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                    width: 100
                    },
                    legend: {
                    position: 'bottom'

                    }
                }
                }]
            };

            var chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();


            ///===================== Hour Chart =============================================================///
            var options = {
              series: [{
               data: [<?php echo json_encode($esti_logged_hour_chart); ?>,<?php echo json_encode($logged_hour_chart); ?>],

            }],
              chart: {
              height: 210,
              type: 'bar',
            },
            colors: ['#963aff','#ffa21d'],
            plotOptions: {
              bar: {
                   horizontal: true,
                columnWidth: '30%',
                distributed: true,
              }
            },
            dataLabels: {
              enabled: false
            },
            legend: {
              show: true
            },
            xaxis: {
              categories: ["Estimated Hours","Logged Hours "],

            }
            };

            var chart = new ApexCharts(document.querySelector("#chart-hours"), options);
            chart.render();



    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/chrisdroid/Desktop/projects/php/erp-go-6.4-using-laravel/resources/views/project_report/show.blade.php ENDPATH**/ ?>