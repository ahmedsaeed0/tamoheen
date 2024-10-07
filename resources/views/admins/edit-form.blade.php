<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
    {!! Form::label('title', __('admin-users.title'), ['class' => 'control-label']) !!}
    {!! Form::select('title',['' => 'Select Title', '1' => 'Mr', '2' => 'Mrs'], null, ('' == 'required') ? ['class' => 'form-control js-example-basic-multiple', 'required' => 'required'] : ['class' => 'form-control js-example-basic-multiple']) !!}
    {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', __('admin-users.name'), ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
    {!! Form::label('email', __('admin-users.email'), ['class' => 'control-label']) !!}
    {!! Form::text('email', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('identity_type') ? 'has-error' : ''}}">
    {!! Form::label('identity_type', __('admin-users.identity_type'), ['class' => 'control-label']) !!}
    {!! Form::select('identity_type',['' => 'Select Identity Type', '1' => 'NID', '2' => 'Passport'], null, ('' == 'required') ? ['class' => 'form-control js-example-basic-multiple', 'required' => 'required'] : ['class' => 'form-control js-example-basic-multiple']) !!}
    {!! $errors->first('identity_type', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('identity_number') ? 'has-error' : ''}}">
    {!! Form::label('identity_number', __('admin-users.identity_number'), ['class' => 'control-label']) !!}
    {!! Form::text('identity_number', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('identity_number', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('mobile') ? 'has-error' : ''}}">
    {!! Form::label('mobile', __('admin-users.mobile'), ['class' => 'control-label']) !!}
    {!! Form::text('mobile', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('mobile', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('user_image') ? 'has-error' : '' }}">
	{!! Form::label('user_image', __('admin-users.user_image'), ['class' => 'control-label']) !!}
    {!! Form::file('user_image', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required', 'id' => 'user_image'] : ['class' => 'form-control', 'id' => 'user_image']) !!}
    {!! $errors->first('user_image', '<p class="help-block">:message</p>') !!}
</div>

@if($formMode == 'edit')
	<div class="form-group">
		@isset($user->image)
			<img src="{{ asset('storage/'.$user->image->url) }}" alt="" id="userImg">
		@endisset
	</div>
@endif

@if($formMode == 'edit' && $user->hasrole('partner'))
	<div class="form-group {{ $errors->has('address') ? 'has-error' : ''}}">
	    {!! Form::label('address', __('admin-users.address'), ['class' => 'control-label']) !!}
	    {!! Form::text('address', $user->partnerMetas->address, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
	    {!! $errors->first('address', '<p class="help-block">:message</p>') !!}
	</div>

	<div class="form-group {{ $errors->has('license_number') ? 'has-error' : ''}}">
	    {!! Form::label('license_number', __('admin-users.license_number'), ['class' => 'control-label']) !!}
	    {!! Form::text('license_number', $user->partnerMetas->license_number, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
	    {!! $errors->first('license_number', '<p class="help-block">:message</p>') !!}
	</div>

	<div class="form-group {{ $errors->has('license_file') ? 'has-error' : '' }}">
		{!! Form::label('license_file', __('admin-users.license_file'), ['class' => 'control-label']) !!}
	    {!! Form::file('license_file', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required', 'id' => 'license_image'] : ['class' => 'form-control', 'id' => 'license_image']) !!}
	    {!! $errors->first('license_file', '<p class="help-block">:message</p>') !!}
	</div>

	@if($formMode == 'edit')
		<div class="form-group">
			<img src="{{ asset('storage/'.$user->partnerMetas->license_file) }}" alt="" id="userImg">
		</div>
	@endif


@endif


<div class="form-group">
    {!! Form::submit($formMode === 'edit' ? __('admin-users.update') : __('admin-users.create'), ['class' => 'btn btn-primary']) !!}
</div>
