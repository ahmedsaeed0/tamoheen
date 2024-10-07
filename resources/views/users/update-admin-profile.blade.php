<div class="form-group select-asif {{ $errors->has('title') ? 'has-error' : '' }}">
    <label for="title" class="control-label">{{ __('admin-users.title') }}</label>
    <select name="title" id="title" class="form-control js-example-basic-multiple" {{ $errors->has('title') ? 'required' : '' }}>
        <option value="">Select Title</option>
        <option value="1">{{ __('admin-users.mr') }}</option>
        <option value="2">{{ __('admin-users.mrs') }}</option>
    </select>
    {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group select-asif {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name" class="control-label">{{ __('admin-users.name') }}</label>
    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" {{ $errors->has('name') ? 'required' : '' }}>
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group select-asif {{ $errors->has('mobile') ? 'has-error' : '' }}">
    <label for="mobile" class="control-label">{{ __('admin-users.mobile') }}</label>
    <input type="text" name="mobile" id="mobile" class="form-control" value="{{ old('mobile') }}" {{ $errors->has('mobile') ? 'required' : '' }}>
    {!! $errors->first('mobile', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group select-asif {{ $errors->has('email') ? 'has-error' : '' }}">
    <label for="email" class="control-label">{{ __('admin-users.email') }}</label>
    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" {{ $errors->has('email') ? 'required' : '' }}>
    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group select-asif {{ $errors->has('password') ? 'has-error' : '' }}">
    <label for="password" class="control-label">{{ __('admin-users.password') }}</label>
    <input type="text" name="password" id="password" class="form-control" {{ $errors->has('password') ? 'required' : '' }}>
    {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group select-asif {{ $errors->has('user_image') ? 'has-error' : '' }}">
    <label for="user_image" class="control-label">{{ __('admin-users.user_image') }}</label>
    <input type="file" name="user_image" id="user_image" class="form-control" {{ $errors->has('user_image') ? 'required' : '' }}>
    {!! $errors->first('user_image', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group select-asif">
    <button type="submit" class="btn btn-primary">{{ $formMode === 'edit' ? 'Update' : 'Create' }}</button>
</div>
