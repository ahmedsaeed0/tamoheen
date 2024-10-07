<div class="row">

    <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}} col-6">
        <label for="title" class="control-label">{{ __('admin-users.title') }}</label>
        <select name="title" id="title" class="form-control js-example-basic-multiple" {{ $errors->has('title') ? 'required' : '' }}>
            <option value="">{{ __('admin-users.select_title') }}</option>
            <option value="1">{{ __('admin-users.mr') }}</option>
            <option value="2">{{ __('admin-users.mrs') }}</option>
        </select>
        {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
    </div>
    
    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}} col-6">
        <label for="name" class="control-label">{{ __('admin-users.name') }}</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" {{ $errors->has('name') ? 'required' : '' }}>
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
    
    <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}} col-6">
        <label for="email" class="control-label">{{ __('admin-users.email') }}</label>
        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" {{ $errors->has('email') ? 'required' : '' }}>
        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
    </div>
    
    <div class="form-group {{ $errors->has('identity_type') ? 'has-error' : ''}} col-6">
        <label for="identity_type" class="control-label">{{ __('admin-users.identity_type') }}</label>
        <select name="identity_type" id="identity_type" class="form-control js-example-basic-multiple" {{ $errors->has('identity_type') ? 'required' : '' }}>
            <option value="">{{ __('admin-users.select_identity_type') }}</option>
            <option value="1">{{ __('admin-users.nid') }}</option>
            <option value="2">{{ __('admin-users.passport') }}</option>
            <option value="3">{{ __('admin-users.iqma') }}</option>
        </select>
        {!! $errors->first('identity_type', '<p class="help-block">:message</p>') !!}
    </div>
    
    <div class="form-group {{ $errors->has('identity_number') ? 'has-error' : ''}} col-6">
        <label for="identity_number" class="control-label">{{ __('admin-users.identity_number') }}</label>
        <input type="text" name="identity_number" id="identity_number" class="form-control" value="{{ old('identity_number') }}" {{ $errors->has('identity_number') ? 'required' : '' }}>
        {!! $errors->first('identity_number', '<p class="help-block">:message</p>') !!}
    </div>
    
    <div class="form-group {{ $errors->has('brand_name') ? 'has-error' : ''}} col-6">
        <label for="brand_name" class="control-label">{{ __('admin-users.brand_name') }}</label>
        <input type="text" name="brand_name" id="brand_name" class="form-control" value="{{ $user->partnerMetas->brand_name }}" {{ $errors->has('brand_name') ? 'required' : '' }}>
        {!! $errors->first('brand_name', '<p class="help-block">:message</p>') !!}
    </div>
    
    <div class="form-group {{ $errors->has('mobile') ? 'has-error' : ''}} col-12">
        <label for="mobile" class="control-label">{{ __('admin-users.mobile') }}</label>
        <span>Example: +966512345678</span>
        <input type="text" name="mobile" id="mobile" class="form-control" value="{{ old('mobile') }}" {{ $errors->has('mobile') ? 'required' : '' }}>
        {!! $errors->first('mobile', '<p class="help-block">:message</p>') !!}
    </div>
    
    <div class="form-group {{ $errors->has('user_image') ? 'has-error' : '' }} col-6">
        <label for="user_image" class="control-label">{{ __('admin-users.user_image') }}</label>
        <input type="file" name="user_image" id="user_image" class="form-control" {{ $errors->has('user_image') ? 'required' : '' }}>
        {!! $errors->first('user_image', '<p class="help-block">:message</p>') !!}
    </div>
    

@if ($formMode != 'edit')
    <div class="form-group col-6">
        @isset($user->image)
            @php
                $url_mobile = 'https://mobile.tamoheen.com';
                $url_web = 'https://tamoheen.com';

                 $headers=get_headers($url_mobile . '/storage/' . $user->image->url);
                 
                if (stripos($headers[0],"200 OK")) {
                    $url = $url_mobile . '/storage/' . $user->image->url;
                } else {
                    $url = $url_web . '/storage/' . $user->image->url;
                }

            @endphp
            <img src="{{ $url }}" alt="" id="userImg">
        @endisset
    </div>
@endif

@if($formMode == 'edit')
	<div class="form-group col-6">
		@isset($user->image)
			<img src="{{ $user->image->url }}" alt="" id="userImg">
		@endisset
	</div>
@endif

@if($formMode == 'edit' && $user->hasrole('partner'))
	
<div class="form-group {{ $errors->has('address') ? 'has-error' : ''}} col-6">
    <label for="address" class="control-label">{{ __('admin-users.address') }}</label>
    <input type="text" name="address" id="address" class="form-control" value="{{ $user->partnerMetas->address }}" {{ $errors->has('address') ? 'required' : '' }}>
    {!! $errors->first('address', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('referralcode') ? 'has-error' : ''}} col-6">
    <label for="referralcode" class="control-label">{{ __('admin-users.referralcode') }}</label>
    <input type="text" name="referralcode" id="referralcode" class="form-control" value="{{ $user->partnerMetas->referralcode ?? null }}" {{ $user->partnerMetas->referralcode ? 'disabled' : '' }}>
    {!! $errors->first('referralcode', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('license_number') ? 'has-error' : ''}} col-6">
    <label for="license_number" class="control-label">{{ __('admin-users.license_number') }}</label>
    <input type="text" name="license_number" id="license_number" class="form-control" value="{{ $user->partnerMetas->license_number }}" {{ $errors->has('license_number') ? 'required' : '' }}>
    {!! $errors->first('license_number', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('license_file') ? 'has-error' : '' }} col-6">
    <label for="license_file" class="control-label">{{ __('admin-users.license_file') }}</label>
    <input type="file" name="license_file" id="license_image" class="form-control" {{ $errors->has('license_file') ? 'required' : '' }}>
    {!! $errors->first('license_file', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group datepicker-form-group {{ $errors->has('date_of_birth_hijri') ? 'has-error' : '' }} col-6" id="hijri">
    <span>Hijri Date Example: 1420/01/01</span>
    <input type="text" name="date_of_birth_hijri" id="hijri-date-input" class="form-control hijri-date-input datepickerinput" value="{{ $user->partnerMetas->date_of_birth_hijri }}" {{ $errors->has('date_of_birth_hijri') ? 'required' : '' }}>
    {!! $errors->first('date_of_birth_hijri', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group datepicker-form-group {{ $errors->has('date_of_birth_gregorian') ? 'has-error' : '' }} col-6" id="regoin">
    <span>Gregorian Date Example: 06-07-2022</span>
    <input type="date" name="date_of_birth_gregorian" id="gregorian-date-input" class="form-control" value="{{ $user->partnerMetas->date_of_birth_gregorian }}" {{ $errors->has('date_of_birth_gregorian') ? 'required' : '' }}>
    {!! $errors->first('date_of_birth_gregorian', '<p class="help-block">:message</p>') !!}
</div>

    

	


@endif


<div class="form-group">
    <button type="submit" class="btn btn-primary">
        {{ $formMode === 'edit' ? __('admin-users.update') : __('admin-users.create') }}
    </button>
</div>

</div>