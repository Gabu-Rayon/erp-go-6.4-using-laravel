   {{Form::open(array('url'=>'postcompositionlist','method'=>'post'))}}
  <div class="modal-body">
      {{-- start for ai module --}}
      @php
          $plan = \App\Models\Utility::getChatGPTSettings();
      @endphp
      @if ($plan->chatgpt == 1)
          <div class="text-end">
              <a href="#" data-size="md" class="btn  btn-primary btn-icon btn-sm" data-ajax-popup-over="true"
                  data-url="{{ route('generate', ['compositionlist']) }}" data-bs-placement="top"
                  data-title="{{ __('Generate content with AI') }}">
                  <i class="fas fa-robot"></i> <span>{{ __('Generate with AI') }}</span>
              </a>
          </div>
      @endif

      {{-- end for ai module --}}

      <div class="row">
          <div class="col-md-6">
              <div class="form-group">
                  {{ Form::label('main_item_code', __('Main Item Code'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                  {{ Form::text('main_item_code', '', ['class' => 'form-control', 'required' => 'required']) }}
              </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                  {{ Form::label('composition_item_code', __('Composition Item Code'), ['class' => 'form-label']) }}<span
                      class="text-danger">*</span>
                  {{ Form::text('composition_item_code', '', ['class' => 'form-control', 'required' => 'required']) }}
              </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                  {{ Form::label('composition_tem_quantity', __('Composition Item Quantity'), ['class' => 'form-label']) }}<span
                      class="text-danger">*</span>
                  {{ Form::number('composition_item_quantity', '', ['class' => 'form-control', 'required' => 'required', 'step' => '0']) }}
              </div>
          </div>        

          @if (!$customFields->isEmpty())
              <div class="col-lg-6 col-md-6 col-sm-6">
                  <div class="tab-pane fade show" id="tab-2" role="tabpanel">
                      @include('customFields.formBuilder')
                  </div>
              </div>
          @endif
      </div>
  </div>
  <div class="modal-footer">
      <input type="button" value="{{ __('Cancel') }}" class="btn  btn-light" data-bs-dismiss="modal">
      <input type="submit" value="{{ __('Create') }}" class="btn  btn-primary">
  </div>
  {{ Form::close() }}


 
