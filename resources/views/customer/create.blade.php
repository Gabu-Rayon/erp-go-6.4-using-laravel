{{Form::open(array('url'=>'customer','method'=>'post'))}}
<div class="modal-body">

    <h6 class="sub-title">{{__('Basic Info')}}</h6>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group">
                {{Form::label('customerNo',__('Customer Number'),['class'=>'form-label'])}}
                <span class="text-danger">*</span>
                {{Form::text('customerNo',null,array('class'=>'form-control', 'required'=>'required','placeholder' =>'CUST00001'))}}
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group">
                {{Form::label('customerTin',__('Tin'),array('class'=>'form-label')) }}
                <span class="text-danger">*</span>
                {{Form::text('customerTin',null,array('class'=>'form-control','required'=>'required'))}}
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group">
                {{Form::label('customerName',__('Name'),['class'=>'form-label'])}}
                <span class="text-danger">*</span>
                {{Form::text('customerName',null,array('class'=>'form-control','required'=>'required'))}}
            </div>
        </div>
         <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group">
                {{Form::label('address',__('Address'),array('class'=>'form-label')) }}
                {{Form::text('address',null,array('class'=>'form-control'))}}
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group">
                {{Form::label('telNo',__('Tel No'),['class'=>'form-label'])}}
                {{Form::text('telNo',null,array('class'=>'form-control'))}}
            </div>
        </div>
         <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group">
                {{Form::label('email',__('Email'),array('class'=>'form-label')) }}
                {{Form::text('email',null,array('class'=>'form-control'))}}
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group">
                {{Form::label('faxNo',__('Fax No'),['class'=>'form-label'])}}
                {{Form::text('faxNo',null,array('class'=>'form-control'))}}
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="form-group">
                {{Form::label('isUsed',__('Is Used'),['class'=>'form-label'])}}
                {{Form::select('isUsed', [true => 'Yes', false => 'No'], null, ['class' => 'form-control select2'])}}
            </div>
        </div>
         <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="form-group">
                {{Form::label('remark',__('Remark'),array('class'=>'form-label')) }}
                {{Form::textarea('remark',null,array('class'=>'form-control','rows'=>3))}}
            </div>
        </div>
        @if(!$customFields->isEmpty())
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="tab-pane fade show" id="tab-2" role="tabpanel">
                    @include('customFields.formBuilder')
                </div>
            </div>
        @endif
    </div>

    <h6 class="sub-title">{{__('Billing Address')}}</h6>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{Form::label('billing_name',__('Name'),array('class'=>'','class'=>'form-label')) }}
                {{Form::text('billing_name',null,array('class'=>'form-control'))}}
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{Form::label('billing_phone',__('Phone'),array('class'=>'form-label')) }}
                {{Form::text('billing_phone',null,array('class'=>'form-control'))}}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('billing_address',__('Address'),array('class'=>'form-label')) }}
                {{Form::textarea('billing_address',null,array('class'=>'form-control','rows'=>3))}}

            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{Form::label('billing_city',__('City'),array('class'=>'form-label')) }}
                {{Form::text('billing_city',null,array('class'=>'form-control'))}}

            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{Form::label('billing_state',__('State'),array('class'=>'form-label')) }}
                {{Form::text('billing_state',null,array('class'=>'form-control'))}}
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{Form::label('billing_country',__('Country'),array('class'=>'form-label')) }}
                {{Form::text('billing_country',null,array('class'=>'form-control'))}}
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{Form::label('billing_zip',__('Zip Code'),array('class'=>'form-label')) }}
                {{Form::text('billing_zip',null,array('class'=>'form-control'))}}

            </div>
        </div>

    </div>

    @if(App\Models\Utility::getValByName('shipping_display')=='on')
        <div class="col-md-12 text-end">
            <input type="button" id="billing_data" value="{{__('Shipping Same As Billing')}}" class="btn btn-primary">
        </div>
        <h6 class="sub-title">{{__('Shipping Address')}}</h6>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                    {{Form::label('shipping_name',__('Name'),array('class'=>'form-label')) }}
                    {{Form::text('shipping_name',null,array('class'=>'form-control'))}}

                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                    {{Form::label('shipping_phone',__('Phone'),array('class'=>'form-label')) }}
                    {{Form::text('shipping_phone',null,array('class'=>'form-control'))}}

                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    {{Form::label('shipping_address',__('Address'),array('class'=>'form-label')) }}
                    <label class="form-label" for="example2cols1Input"></label>
                    {{Form::textarea('shipping_address',null,array('class'=>'form-control','rows'=>3))}}

                </div>
            </div>


            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                    {{Form::label('shipping_city',__('City'),array('class'=>'form-label')) }}
                    {{Form::text('shipping_city',null,array('class'=>'form-control'))}}

                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                    {{Form::label('shipping_state',__('State'),array('class'=>'form-label')) }}
                    {{Form::text('shipping_state',null,array('class'=>'form-control'))}}

                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                    {{Form::label('shipping_country',__('Country'),array('class'=>'form-label')) }}
                    {{Form::text('shipping_country',null,array('class'=>'form-control'))}}

                </div>
            </div>


            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                    {{Form::label('shipping_zip',__('Zip Code'),array('class'=>'form-label')) }}
                    {{Form::text('shipping_zip',null,array('class'=>'form-control'))}}

                </div>
            </div>

        </div>
    @endif

</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn btn-primary">
</div>
{{Form::close()}}
