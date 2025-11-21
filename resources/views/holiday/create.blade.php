{{ Form::open(['route' => ['business-holiday.store', ['business_id' => $business->id]], 'method' => 'post','class'=>'needs-validation','novalidate']) }}
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {{Form::label('title',__('Title'),['class'=>'form-label']) }}
                    {{Form::text('title',null,array('class'=>'form-control','placeholder'=>__('Enter Title'),'required'=>'required'))}}
                    @error('title')
                    <small class="invalid-title" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    {{Form::label('date',__('Start Date'),['class'=>'form-label']) }}
                    {{Form::date('date',null,array('class'=>'form-control','placeholder'=>__('Select Start Date'),'required'=>'required'))}}
                    @error('date')
                    <small class="invalid-date" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group mb-0">
                    {{Form::label('end_date',__('End Date (Optional)'),['class'=>'form-label']) }}
                    {{Form::date('end_date',null,array('class'=>'form-control','placeholder'=>__('Select End Date')))}}
                    <small class="text-muted">{{ __('Leave empty for single day holiday') }}</small>
                    @error('end_date')
                    <small class="invalid-end_date" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                    @enderror
                </div>
            </div>


        </div>
    </div>
    <div class="modal-footer gap-3">
        <button type="button" class="btn m-0 btn-secondary" data-bs-dismiss="modal">{{__('Cancel')}}</button>
        {{Form::submit(__('Create'),array('class'=>'btn m-0 btn-primary'))}}
    </div>
{{Form::close()}}
