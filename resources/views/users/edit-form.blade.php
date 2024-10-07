<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
    <label for="title" class="control-label">{{ __('admin-users.title') }}</label>

    <select name="title" id="title" class="form-control js-example-basic-multiple" required="{{ $errors->has('title') ? 'required' : '' }}" aria-invalid="{{ $errors->has('title') ? 'true' : 'false' }}">
        <option value="">Select Title</option>
        <option value="1">Mr</option>
        <option value="2">Mrs</option>
    </select>

    @if ($errors->has('title'))
        <p class="help-block text-danger">{{ $errors->first('title') }}</p>
    @endif
</div>

<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name" class="control-label">{{ __('admin-users.name') }}</label>

    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required="{{ $errors->has('name') ? 'required' : '' }}" aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}">

    @if ($errors->has('name'))
        <p class="help-block text-danger">{{ $errors->first('name') }}</p>
    @endif
</div>

<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
    <label for="email" class="control-label">{{ __('admin-users.email') }}</label>

    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required="{{ $errors->has('email') ? 'required' : '' }}" aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}">

    @if ($errors->has('email'))
        <p class="help-block text-danger">{{ $errors->first('email') }}</p>
    @endif
</div>

<div class="form-group {{ $errors->has('identity_type') ? 'has-error' : '' }}">
    <label for="identity_type" class="control-label">{{ __('admin-users.identity_type') }}</label>

    <select name="identity_type" id="identity_type" class="form-control js-example-basic-multiple" required="{{ $errors->has('identity_type') ? 'required' : '' }}" aria-invalid="{{ $errors->has('identity_type') ? 'true' : 'false' }}">
        <option value="">Select Identity Type</option>
        <option value="1">NID</option>
        <option value="2">Passport</option>
    </select>

    @if ($errors->has('identity_type'))
        <p class="help-block text-danger">{{ $errors->first('identity_type') }}</p>
    @endif
</div>

<div class="form-group {{ $errors->has('identity_number') ? 'has-error' : '' }}">
    <label for="identity_number" class="control-label">{{ __('admin-users.identity_number') }}</label>

    <input type="text" name="identity_number" id="identity_number" class="form-control {{ $errors->has('identity_number') ? 'is-invalid' : '' }}" value="{{ old('identity_number') }}" required="{{ $errors->has('identity_number') ? 'required' : '' }}" aria-invalid="{{ $errors->has('identity_number') ? 'true' : 'false' }}">

    @if ($errors->has('identity_number'))
        <p class="text-danger">{{ $errors->first('identity_number') }}</p>
    @endif
</div>

<div class="form-group {{ $errors->has('mobile') ? 'has-error' : '' }}">
    <label for="mobile" class="control-label">{{ __('admin-users.mobile') }}</label>

    <input type="text" name="mobile" id="mobile" class="form-control" value="{{ old('mobile') }}" required="{{ $errors->has('mobile') ? 'required' : '' }}" aria-invalid="{{ $errors->has('mobile') ? 'true' : 'false' }}">

    @if ($errors->has('mobile'))
        <p class="text-danger">{{ $errors->first('mobile') }}</p>
    @endif
</div>

<div class="form-group {{ $errors->has('user_image') ? 'has-error' : '' }}">
    <label for="user_image" class="control-label">{{ __('admin-users.user_image') }}</label>

    <input type="file" name="user_image" id="user_image" class="form-control" required="{{ $errors->has('user_image') ? 'required' : '' }}">

    @if ($errors->has('user_image'))
        <p class="text-danger">{{ $errors->first('user_image') }}</p>
    @endif
</div>




@if ($formMode == 'edit')

    <div class="form-group">

        @isset($user->image)

            <img src="{{ $user->image->url }}" alt="" id="userImg">

        @endisset

    </div>

@endif



@if($formMode == 'edit' && $user->hasrole('partner'))

<div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
    <label for="address" class="control-label">{{ __('admin-users.address') }}</label>

    <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $user->partnerMetas->address ?? null) }}" required="{{ $errors->has('address') ? 'required' : '' }}">

    @if ($errors->has('address'))
        <p class="text-danger">{{ $errors->first('address') }}</p>
    @endif
</div>

<div class="form-group {{ $errors->has('license_number') ? 'has-error' : '' }}">
    <label for="license_number" class="control-label">{{ __('admin-users.license_number') }}</label>

    <input type="text" name="license_number" id="license_number" class="form-control" value="{{ old('license_number', $user->partnerMetas->license_number ?? null) }}" required="{{ $errors->has('license_number') ? 'required' : '' }}">

    @if ($errors->has('license_number'))
        <p class="text-danger">{{ $errors->first('license_number') }}</p>
    @endif
</div>

<div class="form-group {{ $errors->has('license_file') ? 'has-error' : '' }}">
    <label for="license_file" class="control-label">{{ __('admin-users.license_file') }}</label>

    <input type="file" name="license_file" id="license_file" class="form-control" required="{{ $errors->has('license_file') ? 'required' : '' }}">

    @if ($errors->has('license_file'))
        <p class="text-danger">{{ $errors->first('license_file') }}</p>
    @endif
</div>





	@if($formMode == 'edit')

		<div class="form-group">

			<img src="{{ $user->partnerMetas->license_file }}" alt="" id="userImg">

		</div>

	@endif





@endif





<div class="form-group">
    <button type="submit" class="btn btn-primary">
        {{ $formMode === 'edit' ? __('admin-users.update') : __('admin-users.create') }}
    </button>
</div>

