{{ Form::model($branch, ['route' => ['branch.update', $branch->id], 'method' => 'PUT']) }}
<div class="modal-body">

    <div class="row">
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('bhfNm', __('Name'), ['class' => 'form-label']) }}
                {{ Form::text('bhfNm', $branch->bhfNm, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('bhfId', __('Branch ID'), ['class' => 'form-label']) }}
                {{ Form::text('bhfId', $branch->bhfId, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('tin', __('Branch TIN'), ['class' => 'form-label']) }}
                {{ Form::text('tin', $branch->tin, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('bhfSttsCd', __('Branch Status'), ['class' => 'form-label']) }}
                {{ Form::select('bhfSttsCd', ['01' => 'Active', '00' => 'Inactive'], $branch->bhfSttsCd == '01' ? '01' : '00', ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('prvncNm', __('Province Name'), ['class' => 'form-label']) }}
                {{ Form::text('prvncNm', $branch->prvncNm, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('dstrtNm', __('District Name'), ['class' => 'form-label']) }}
                {{ Form::text('dstrtNm', $branch->dstrtNm, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('sctrNm', __('SCTR Name'), ['class' => 'form-label']) }}
                {{ Form::text('sctrNm', $branch->sctrNm, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('locDesc', __('LOC DESC'), ['class' => 'form-label']) }}
                {{ Form::text('locDesc', $branch->locDesc, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('mgrNm', __('Manager Name'), ['class' => 'form-label']) }}
                {{ Form::text('mgrNm', $branch->mgrNm, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('mgrTelNo', __('Manager Contact'), ['class' => 'form-label']) }}
                {{ Form::text('mgrTelNo', $branch->mgrTelNo, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('mgrEmail', __('Manager Email'), ['class' => 'form-label']) }}
                {{ Form::text('mgrEmail', $branch->mgrEmail, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('hqYn', __('HeadQuarter?'), ['class' => 'form-label']) }}
                {{ Form::select('hqYn', ['Y' => 'Yes', 'N' => 'No'], $branch->hqYn == 'Y' ? 'Y' : 'N', ['class' => 'form-control']) }}
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Update') }}" class="btn  btn-primary">
</div>

{{ Form::close() }}
