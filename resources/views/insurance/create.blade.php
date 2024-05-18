<!-- Form for Creating Insurance Plan to Post to Api -->


{{ Form::open(['url' => 'insurance', 'enctype' => 'multipart/form-data']) }}
<div class="modal-body">
    {{-- start for ai module --}}
    @php
        $settings = \App\Models\Utility::settings();
    @endphp
    @if (!empty($settings['chat_gpt_key']))
<div class="text-end">
        <a href="#" data-size="md" class="btn  btn-primary btn-icon btn-sm" data-ajax-popup-over="true" data-url="{{ route('generate', ['plan']) }}"
           data-bs-placement="top" data-title="{{ __('Generate content with AI') }}">
            <i class="fas fa-robot"></i> <span>{{ __('Generate with AI') }}</span>
        </a>
    </div>
@endif
    {{-- end for ai module --}}
    <div class="row">
        <div class="form-group col-md-6">
            {{ Form::label('insurance_code', __('Insurance Code'), ['class' => 'form-label']) }}
            {{ Form::text('insurancecode', null, ['class' => 'form-control font-style', 'placeholder' => __('3447899 '), 'required' => 'required']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('insurance_name', __('Insurance Name'), ['class' => 'form-label']) }}
            {{ Form::text('insurancename', null, ['class' => 'form-control', 'placeholder' => __('Enter Insurance Name')]) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('premium_rate', __('Premium Rate'), ['class' => 'form-label']) }}
            {{ Form::number('premiumrate', null, ['class' => 'form-control', 'placeholder' => __('i.e 100 ,200')]) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('isUsed', __('Used?'), ['class' => 'form-label']) }}
            {{ Form::select('isUsed', [true => 'Yes', false => 'No'], null, ['class' => 'form-control']) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Create') }}" class="btn  btn-primary">
</div>
    {{ Form::close() }} 
