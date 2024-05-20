
<?php $__env->startPush('script-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Support Reply')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0 "><?php echo e(__('Support Reply')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('support.index')); ?>"><?php echo e(__('Support')); ?></a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Support Reply')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
        <a href="#" data-size="lg" data-url="<?php echo e(route('support.edit',$support->id)); ?>" data-ajax-popup="true"
           data-bs-toggle="tooltip" title="<?php echo e(__('Edit')); ?>" data-title="<?php echo e(__('Edit Support')); ?>" class="btn btn-sm btn-primary">
            <i class="ti ti-pencil"></i>
        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="row gy-4">
                <div class="col-lg-6">
                    <div class="row">
                        <h5 class="mb-3"><?php echo e(__('Reply Ticket')); ?> - <span class="text-primary"><?php echo e($support->ticket_code); ?></span></h5>
                        <div class="card border">
                            <div class="card-body p-0">
                                <div class="p-4 border-bottom">
                                    <?php if($support->priority == 0): ?>
                                        <span class="badge bg-primary mb-2">   <?php echo e(__(\App\Models\Support::$priority[$support->priority])); ?></span>
                                    <?php elseif($support->priority == 1): ?>
                                        <span class="badge bg-info mb-2">   <?php echo e(__(\App\Models\Support::$priority[$support->priority])); ?></span>
                                    <?php elseif($support->priority == 2): ?>
                                        <span class="badge bg-warning mb-2">   <?php echo e(__(\App\Models\Support::$priority[$support->priority])); ?></span>
                                    <?php elseif($support->priority == 3): ?>
                                        <span class="badge bg-danger mb-2">   <?php echo e(__(\App\Models\Support::$priority[$support->priority])); ?></span>
                                    <?php endif; ?>
                                    <div class="d-flex justify-content-between align-items-center ">
                                        <h5><?php echo e($support->subject); ?></h5>
                                        <?php if($support->status == 'Open'): ?>
                                            <span class="badge bg-light-primary p-2 f-w-600 text-primary rounded"> <?php echo e(__('Open')); ?></span>
                                        <?php elseif($support->status == 'Close'): ?>
                                            <span class="badge bg-light-danger p-2 f-w-600 text-danger rounded">   <?php echo e(__('Closed')); ?></span>
                                        <?php elseif($support->status == 'On Hold'): ?>
                                            <span class="badge bg-light-warning p-2 f-w-600 text-warning rounded">   <?php echo e(__('On Hold')); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <p class="mb-0">
                                        <b> <?php echo e(!empty($support->createdBy)?$support->createdBy->name:''); ?></b>
                                        .
                                        <span> <?php echo e(!empty($support->createdBy)?$support->createdBy->email:''); ?></span>
                                        .
                                        <span class="text-muted"><?php echo e(\Auth::user()->dateFormat($support->created_at)); ?></span>
                                    </p>
                                </div>
                                <?php if(!empty($support->description)): ?>
                                    <div class="p-4">
                                        <p class=""><?php echo e($support->description); ?></p>
                                        <?php if(!empty($support->attachment)): ?>
                                        <h6><?php echo e(__('Attachments')); ?> :</h6>
                                        <a href="<?php echo e(asset(Storage::url('uploads/supports')).'/'.$support->attachment); ?>"
                                           download="" class="bg-secondary d-inline-flex p-2 rounded text-white " target="_blank">
                                            <i class="ti ti-download text-white me-2 mt-1" data-bs-toggle="tooltip" ></i>

                                            <?php echo e($support->attachment); ?>

                                        </a>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <?php if($support->status == 'Open'): ?>
                    <div class="row">
                        <div class="card">
                            <div class="card-body">
                               <div class="row ">
                                   <div class="col-6">
                                       <h5 class="mb-3"><?php echo e(__('Comments')); ?></h5>
                                   </div>
                                   <?php
                                       $plan= \App\Models\Utility::getChatGPTSettings();
                                   ?>
                                   <?php if($plan->chatgpt == 1): ?>
                                   <div class="col-6 text-end">
                                       <a href="#" data-size="md" class="btn btn-primary btn-icon btn-sm mb-3 me-2" data-ajax-popup-over="true" id="grammarCheck" data-url="<?php echo e(route('grammar',['grammar'])); ?>"
                                          data-bs-placement="top" data-title="<?php echo e(__('Grammar check with AI')); ?>">
                                           <i class="ti ti-rotate"></i> <span><?php echo e(__('Grammar check with AI')); ?></span>
                                       </a>
                                   </div>
                                   <?php endif; ?>

                               </div>
                                <?php echo e(Form::open(array('route' => array('support.reply.answer',$support->id)))); ?>

                                <textarea class="form-control form-control-light mb-2 grammer_textarea" name="description" placeholder="Your comment" id="example-textarea" rows="3" required=""></textarea>
                                <div class="text-end">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary w-100"> <i class="ti ti-circle-plus me-1 mb-0"></i> <?php echo e(__('Send')); ?></button>
                                    </div>
                                </div>
                                <?php echo e(Form::close()); ?>

                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="col-lg-6">
                    <h5 class="mb-3"><?php echo e(__('Replies')); ?></h5>
                    <?php $__currentLoopData = $replyes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="card border">
                            <div class="card-header row d-flex align-items-center justify-content-between">
                                <div class="header-right col d-flex align-items-start">
                                    <a href="#" class="avatar avatar-sm me-3">
                                        <img alt="" class=" " <?php if(!empty($reply->users) && !empty($reply->users->avatar)): ?> src="<?php echo e(asset(Storage::url('uploads/avatar/')).'/'.$reply->users->avatar); ?>" <?php else: ?>  src="<?php echo e(asset(Storage::url('uploads/avatar/')).'/avatar.png'); ?>" <?php endif; ?>>
                                    </a>
                                    <h6 class="mb-0"><?php echo e(!empty($reply->users)?$reply->users->name:''); ?>

                                        <div class="d-block text-muted"><?php echo e(!empty($reply->users)?$reply->users->email:''); ?></div>
                                    </h6>
                                </div>
                                <p class="col-auto ms-1 mb-0"> <span class="text-muted"><?php echo e($reply->created_at->diffForHumans()); ?></span></p>
                            </div>
                            <div class="card-body">
                                <p class="mb-0"><?php echo e($reply->description); ?></p>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Developer\Desktop\apps\erp-go-6.4-using-laravel\resources\views/support/reply.blade.php ENDPATH**/ ?>