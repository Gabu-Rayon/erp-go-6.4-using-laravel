{{ Form::open(array('url' => 'apiinitialization','enctype'=>"multipart/form-data")) }}
<div class="modal-body">
    {{-- start for ai module--}}
    @php
        $plan= \App\Models\Utility::getChatGPTSettings();
    @endphp
    @if($plan->chatgpt == 1)
    <div class="text-end">
        <a href="#" data-size="md" class="btn  btn-primary btn-icon btn-sm" data-ajax-popup-over="true" data-url="{{ route('generate',['apiinitialization']) }}"
           data-bs-placement="top" data-title="{{ __('Generate content with AI') }}">
            <i class="fas fa-robot"></i> <span>{{__('Generate with AI')}}</span>
        </a>
    </div>
    @endif
    {{-- end for ai module--}}
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                    {{ Form::label('tin', __('Tin (PIN)'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                    {{ Form::text('tin', '', ['class' => 'form-control', 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                    {{ Form::label('bhfId', __('Bhf Id (Branch ID)'), ['class' => 'form-label']) }}<span
                        class="text-danger">*</span>
                    {{ Form::text('bhfId', '', ['class' => 'form-control', 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                    {{ Form::label('dvcSrlNo', __('Dvs Srl No (Device Serial Number)'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                    {{ Form::text('dvcSrlNo', '', ['class' => 'form-control', 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                    {{ Form::label('taxprNm', __('Tax pr Nm (Taxpayer Name)'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                    {{ Form::text('taxprNm', '', ['class' => 'form-control', 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                    {{ Form::label('bsnsActv', __('BsnsActv (Business Activity)'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                    {{ Form::text('bsnsActv', '', ['class' => 'form-control', 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                    {{ Form::label('bhfNm', __('BhfNm (Branch Office Name)'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                    {{ Form::text('bhfNm', '', ['class' => 'form-control', 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                    {{ Form::label('bhfOpenDt', __('BhfOpenDt (yyyyMMdd)'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                    {{ Form::text('bhfOpenDt', '', ['class' => 'form-control', 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                    {{ Form::label('prvncNm', __('PrvncNm (County Name)'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                    {{ Form::text('prvncNm', '', ['class' => 'form-control', 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                    {{ Form::label('dstrtNm', __('DstrtNm (Sub-County Name)'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                    {{ Form::text('dstrtNm', '', ['class' => 'form-control', 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                    {{ Form::label('sctrNm', __('SctrNm (Tax Locality Name)'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                    {{ Form::text('sctrNm', '', ['class' => 'form-control', 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                    {{ Form::label('locDesc', __('LocDesc (Location Description)'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                    {{ Form::text('locDesc', '', ['class' => 'form-control', 'required' => 'required']) }}
            </div>
        </div>
        <div class="form-group col-md-6">
              {{ Form::label('hqYn', __('HQYn (Head Quarter)'), ['class' => 'form-label']) }}
              <select name="hqYn" class="form-control" required="required">
                  <option value="">Yes or No</option>
                  <option value="Y">Y</option>
                  <option value="N">N</option>
              </select>
          </div>
          <div class="col-md-6">
            <div class="form-group">
                    {{ Form::label('mgrNm', __('MgrNm (Manager Name)'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                    {{ Form::text('mgrNm', '', ['class' => 'form-control', 'required' => 'required']) }}
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
                    {{ Form::label('mgrTelNo', __('MgrTelNo (Manager Contract Number)'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                    {{ Form::text('mgrTelNo', '', ['class' => 'form-control', 'required' => 'required']) }}
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
                    {{ Form::label('mgrEmail', __('MgrEmail (Manage Email)'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                    {{ Form::text('mgrEmail', '', ['class' => 'form-control', 'required' => 'required']) }}
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
                    {{ Form::label('dvcId', __('DvcId (Device Id)'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                    {{ Form::text('dvcId', '', ['class' => 'form-control', 'required' => 'required']) }}
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
                    {{ Form::label('sdcId', __('SdcId (Sales Control Unit ID)'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                    {{ Form::text('sdcId', '', ['class' => 'form-control', 'required' => 'required']) }}
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
                    {{ Form::label('mrcNo', __('MrcNo (MRC No)'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                    {{ Form::text('mrcNo', '', ['class' => 'form-control', 'required' => 'required']) }}
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
                    {{ Form::label('cmcKey', __('CmcKey (Communication KEY)'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                    {{ Form::text('cmcKey', '', ['class' => 'form-control', 'required' => 'required']) }}
            </div>
          </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn btn-primary">
</div>
    {{ Form::close() }}




<script>
    // document.getElementById('attachment').onchange = function () {
    //     var src = URL.createObjectURL(this.files[0])
    //     document.getElementById('image').src = src
    // }
</script>