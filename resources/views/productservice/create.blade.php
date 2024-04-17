  {{ Form::open(['url' => 'productservice', 'enctype' => 'multipart/form-data']) }}
  <div class="modal-body">
      {{-- start for ai module --}}
      @php
          $plan = \App\Models\Utility::getChatGPTSettings();
      @endphp
      @if ($plan->chatgpt == 1)
          <div class="text-end">
              <a href="#" data-size="md" class="btn  btn-primary btn-icon btn-sm" data-ajax-popup-over="true"
                  data-url="{{ route('generate', ['productservice']) }}" data-bs-placement="top"
                  data-title="{{ __('Generate content with AI') }}">
                  <i class="fas fa-robot"></i> <span>{{ __('Generate with AI') }}</span>
              </a>
          </div>
      @endif
      {{-- end for ai module --}}

      <div class="row">
          <div class="col-md-6">
              <div class="form-group">
                  {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                  {{ Form::text('name', '', ['class' => 'form-control', 'required' => 'required']) }}
              </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                  {{ Form::label('standard_name', __('Standard Name'), ['class' => 'form-label']) }}<span
                      class="text-danger">*</span>
                  {{ Form::text('standard_name', '', ['class' => 'form-control', 'required' => 'required']) }}
              </div>
          </div>

          <div class="col-md-6">
              <div class="form-group">
                  {{ Form::label('item_code', __('Item Code'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                  {{ Form::text('item_code', '', ['class' => 'form-control', 'required' => 'required']) }}
              </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                  {{ Form::label('product_type_code', __('Product Type Code'), ['class' => 'form-label']) }}<span
                      class="text-danger">*</span>
                  {{ Form::text('product_type_code', '', ['class' => 'form-control', 'required' => 'required']) }}
              </div>
          </div>
         <!--  <div class="col-md-6">
              <div class="form-group">
                  {{ Form::label('product_classified_code', __('Product Classified Code'), ['class' => 'form-label']) }}<span
                      class="text-danger">*</span>
                  {{ Form::text('product_classified_code', '', ['class' => 'form-control', 'required' => 'required']) }}
              </div>
          </div> -->

          <div class="form-group col-md-6">
              {{ Form::label('country_code', __('Country Code'), ['class' => 'form-label']) }}
              <select name="country_code" class="form-control" required="required">
                  <option value="">Select Country Code</option>
                  @foreach ($countries_codes as $country_code)
                      <option value="{{ $country_code['cd'] }}">{{ $country_code['cd'] }} -
                          ({{ $country_code['cdNm'] }})
                      </option>
                  @endforeach
              </select>
          </div>
          <div class="form-group col-md-6">
              {{ Form::label('item_classifications', __('Item Classifications Code'), ['class' => 'form-label']) }}
              <select name="product_classified_code" class="form-control" required="required">
                  <option value="">Select Item Classifications Code</option>
                  @foreach ($item_classifications as $item_classification)
                      <option value="{{ $item_classification['itemClsCd'] }}">{{ $item_classification['itemClsCd'] }}  -
                          ({{ $item_classification['itemClsNm']}})
                      </option>
                  @endforeach
              </select>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                  {{ Form::label('batch_no', __('Batch No'), ['class' => 'form-label']) }}<span
                      class="text-danger">*</span>
                  {{ Form::text('batch_no', '', ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'BNO2001']) }}
              </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                  {{ Form::label('bar_code', __('Bar Code'), ['class' => 'form-label']) }}<span
                      class="text-danger">*</span>
                  {{ Form::text('bar_code', '', ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'BRC2001']) }}
              </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                  {{ Form::label('sale_price', __('Sale Price'), ['class' => 'form-label']) }}<span
                      class="text-danger">*</span>
                  {{ Form::number('sale_price', '', ['class' => 'form-control', 'required' => 'required', 'step' => '0.01']) }}
              </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                  {{ Form::label('group1_unit_price', __('Group 1 Unit Price'), ['class' => 'form-label']) }}<span
                      class="text-danger">*</span>
                  {{ Form::number('group1_unit_price', '', ['class' => 'form-control', 'required' => 'required', 'step' => '0.01']) }}
              </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                  {{ Form::label('group2_unit_price', __('Group 2 Unit Price'), ['class' => 'form-label']) }}<span
                      class="text-danger">*</span>
                  {{ Form::number('group2_unit_price', '', ['class' => 'form-control', 'required' => 'required', 'step' => '0.01']) }}
              </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                  {{ Form::label('group3_unit_price', __('Group 3 Unit Price'), ['class' => 'form-label']) }}<span
                      class="text-danger">*</span>
                  {{ Form::number('group3_unit_price', '', ['class' => 'form-control', 'required' => 'required', 'step' => '0.01']) }}
              </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                  {{ Form::label('group4_unit_price', __('Group 4 Unit Price'), ['class' => 'form-label']) }}<span
                      class="text-danger">*</span>
                  {{ Form::number('group4_unit_price', '', ['class' => 'form-control', 'required' => 'required', 'step' => '0.01']) }}
              </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                  {{ Form::label('group5_unit_price', __('Group 5 Unit Price'), ['class' => 'form-label']) }}<span
                      class="text-danger">*</span>
                  {{ Form::number('group5_unit_price', '', ['class' => 'form-control', 'required' => 'required', 'step' => '0.01']) }}
              </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                  {{ Form::label('tax_type_code', __('Tax Type Code'), ['class' => 'form-label']) }}<span
                      class="text-danger">*</span>
                  {{ Form::text('tax_type_code', '', ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'VAT,A,B,C']) }}
              </div>
          </div>
                    <div class="form-group col-md-6 quantity">
              {{ Form::label('pkg_unit_code', __('pkg Unit Code'), ['class' => 'form-label']) }}<span
                  class="text-danger">*</span>
              {{ Form::text('pkg_unit_code', null, ['class' => 'form-control', 'placeholder' => 'BR']) }}
          </div>
             <div class="form-group col-md-6 quantity">
              {{ Form::label('qty_unit_code', __('Qty Unit Code'), ['class' => 'form-label']) }}<span
                  class="text-danger">*</span>
              {{ Form::text('qty_unit_code', null, ['class' => 'form-control', 'placeholder' => 'KWT']) }}
          </div>
          <div class="form-group col-md-6 quantity">
              {{ Form::label('quantity', __('Quantity'), ['class' => 'form-label']) }}<span
                  class="text-danger">*</span>
              {{ Form::text('quantity', null, ['class' => 'form-control']) }}
          </div>
          <div class="form-group col-md-6 quantity">
              {{ Form::label('safety_quantity', __('Safety Quantity'), ['class' => 'form-label']) }}<span
                  class="text-danger">*</span>
              {{ Form::text('safety_quantity', null, ['class' => 'form-control', 'placeholder' => '2000']) }}
          </div>

          <div class="form-group col-md-12">
              {{ Form::label('description', __('Description'), ['class' => 'form-label']) }}
              {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => '2']) !!}
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


  <script>
      document.getElementById('pro_image').onchange = function() {
          var src = URL.createObjectURL(this.files[0])
          document.getElementById('image').src = src
      }

      //hide & show quantity

      $(document).on('click', '.type', function() {
          var type = $(this).val();
          if (type == 'product') {
              $('.quantity').removeClass('d-none')
              $('.quantity').addClass('d-block');
          } else {
              $('.quantity').addClass('d-none')
              $('.quantity').removeClass('d-block');
          }
      });
  </script>
