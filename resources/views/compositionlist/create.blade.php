{{ Form::open(array('url' => 'compositionlist','enctype'=>"multipart/form-data")) }}
<div class="modal-body">
    {{-- start for ai module--}}
    @php
        $plan= \App\Models\Utility::getChatGPTSettings();
    @endphp
    @if($plan->chatgpt == 1)
    <div class="text-end">
        <a href="#" data-size="md" class="btn  btn-primary btn-icon btn-sm" data-ajax-popup-over="true" data-url="{{ route('generate',['compositionlist']) }}"
           data-bs-placement="top" data-title="{{ __('Generate content with AI') }}">
            <i class="fas fa-robot"></i> <span>{{__('Generate with AI')}}</span>
        </a>
    </div>
    @endif
    {{-- end for ai module--}}
    <div class="row">
        <div class="form-group col-md-12">
            {{ Form::label('main_item_code', __('Main Item Code'),['class'=>'form-label']) }}
            {{ Form::select('main_item_code', $iteminfo, null, array('class' => 'form-control select2','placeholder'=>__('Select Item'),'required'=>'required')) }}
        </div>
        <div class="form-group col-md-12">
            {{ Form::label('composition_item_code', __('Composition Item Code'),['class'=>'form-label']) }}
            {{ Form::text('composition_item_code[]', '', array('class' => 'form-control ','required'=>'required')) }}
        </div>
        <div class="form-group col-md-12">
            {{ Form::label('composition_item_quantity', __('Composition Item Quantity'),['class'=>'form-label']) }}
            {{ Form::number('composition_item_quantity[]', '', array('class' => 'form-control ','required'=>'required')) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn btn-primary">
</div>
    {{ Form::close() }}

