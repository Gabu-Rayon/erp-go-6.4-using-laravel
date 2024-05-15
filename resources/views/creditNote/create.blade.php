{{ Form::open(array('route' => array('invoice.credit.note',$invoice_id),'mothod'=>'post')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group  col-md-6">
            {{ Form::label('date', __('Date Here'),['class'=>'form-label']) }}
            {{Form::date('date',null,array('class'=>'form-control','required'=>'required'))}}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('amount', __('Amount'),['class'=>'form-label']) }}
            {{ Form::number('amount', !empty($invoiceDue)?$invoiceDue->getDue():0, array('class' => 'form-control','required'=>'required','step'=>'0.01')) }}
        </div>
         <div class="form-group col-md-3">
                            {{ Form::label('customerName', __('Customer Name (*)'), ['class' => 'form-label']) }}
                            {{ Form::select('customerName', $customers, null, ['class' => 'form-control customerName', 'required' => 'required']) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('customerTin', __('Customer Tin (*)'),['class'=>'form-label']) }}
                            {{ Form::text('customerTin', '', array('class' => 'form-control customerTin', 'required' => 'required', 'readonly' => true)) }}
                        </div> 
                        <div class="form-group col-md-3">
                            {{ Form::label('customerNo', __('Customer Number'),['class'=>'form-label']) }}
                            {{ Form::text('customerNo', '', array('class' => 'form-control customerNo', 'readonly' => true)) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('customerMobileNo', __('Customer Mobile Number'),['class'=>'form-label']) }}
                            {{ Form::text('customerMobileNo', '', array('class' => 'form-control customerMobileNo', 'readonly' => true)) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('salesType', __('Sales Type'), ['class' => 'form-label']) }}
                            {{ Form::select('salesType', $salesTypeCodes, null, ['class' => 'form-control']) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('paymentType', __('Payment Type'), ['class' => 'form-label']) }}
                            {{ Form::select('paymentType', $paymentTypeCodes, null, ['class' => 'form-control']) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('traderInvoiceNo', __('Trader Invoive No (*)'), ['class' => 'form-label']) }}
                            {{ Form::text('traderInvoiceNo', '', array('class' => 'form-control traderInvoiceNo', 'required' => true)) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('confirmDate', __('Confirm Date (*)'),['class'=>'form-label']) }}
                            {{ Form::datetime('confirmDate', '', array('class' => 'form-control', 'required' => 'required')) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('salesDate', __('Sales Date (*)'),['class'=>'form-label']) }}
                            {{ Form::date('salesDate', '', array('class' => 'form-control', 'required' => 'required')) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('stockReleseDate', __('Stock Release Date'),['class'=>'form-label']) }}
                            {{ Form::datetime('stockReleseDate', '', array('class' => 'form-control')) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('receiptPublishDate', __('Receipt Publish Date (*)'),['class'=>'form-label']) }}
                            {{ Form::datetime('receiptPublishDate', '', array('class' => 'form-control', 'required' => 'required')) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('occurredDate', __('Occurred Date (*)'),['class'=>'form-label']) }}
                            {{ Form::date('occurredDate', '', array('class' => 'form-control', 'required' => 'required')) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('invoiceStatusCode', __('Invoice Status'), ['class' => 'form-label']) }}
                            {{ Form::select('invoiceStatusCode', $invoiceStatusCodes, null, ['class' => 'form-control']) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('isPurchaseAccept', __('Purchase Accepted?'), ['class' => 'form-label']) }}
                            {{ Form::select('isPurchaseAccept', ['true' => 'Yes', 'false' => 'No'], null, ['class' => 'form-control']) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('isStockIOUpdate', __('Stock IO Update?'), ['class' => 'form-label']) }}
                            {{ Form::select('isStockIOUpdate', ['true' => 'Yes', 'false' => 'No'], null, ['class' => 'form-control']) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('mapping', __('Mapping'),['class'=>'form-label']) }}
                            {{ Form::text('mapping', '', array('class' => 'form-control')) }}
                        </div>
                        <div class="form-group col-md-12">
                            {{ Form::label('remark', __('Remark'),['class'=>'form-label']) }}
                            {{ Form::textarea('remark', '', array('class' => 'form-control', 'rows' => '3')) }}
                        </div>
        <div class="form-group col-md-6">
            {{ Form::label('description', __('Description'),['class'=>'form-label']) }}
            {!! Form::textarea('description', '', ['class'=>'form-control','rows'=>'3']) !!}
        </div>   
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Add')}}" class="btn  btn-primary">
</div>
{{ Form::close() }}
