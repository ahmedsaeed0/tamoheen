<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="control-label">{{ __('admin-country.name') }}</label>
    <input type="text" name="name" id="name" class="form-control" 
           value="{{ old('name') }}" required>
    {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('name_arabic') ? 'has-error' : ''}}">
    <label for="name_arabic" class="control-label">{{ __('admin-country.name_arabic') }}</label>
    <input type="text" name="name_arabic" id="name_arabic" class="form-control" 
           value="{{ old('name_arabic') }}" required>
    {!! $errors->first('name_arabic', '<p class="text-danger">:message</p>') !!}
</div>

{{-- <div class="form-group {{ $errors->has('name_urdu') ? 'has-error' : ''}}">
    <label for="name_urdu" class="control-label">Name Urdu</label>
    <input type="text" name="name_urdu" id="name_urdu" class="form-control" 
           value="{{ old('name_urdu') }}" required>
    {!! $errors->first('name_urdu', '<p class="text-danger">:message</p>') !!}
</div> --}}

<div class="form-group {{ $errors->has('code') ? 'has-error' : ''}}">
    <label for="code" class="control-label">{{ __('admin-country.code') }}</label>
    <input type="text" name="code" id="code" class="form-control" 
           value="{{ old('code') }}" required>
    {!! $errors->first('code', '<p class="text-danger">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('code_arabic') ? 'has-error' : ''}}">
    <label for="code_arabic" class="control-label">{{ __('admin-country.code_arabic') }}</label>
    <input type="text" name="code_arabic" id="code_arabic" class="form-control" 
           value="{{ old('code_arabic') }}" required>
    {!! $errors->first('code_arabic', '<p class="text-danger">:message</p>') !!}
</div>

{{-- <div class="form-group {{ $errors->has('code_urdu') ? 'has-error' : ''}}">
    <label for="code_urdu" class="control-label">Code Urdu</label>
    <input type="text" name="code_urdu" id="code_urdu" class="form-control" 
           value="{{ old('code_urdu') }}" required>
    {!! $errors->first('code_urdu', '<p class="text-danger">:message</p>') !!}
</div> --}}

<div class="form-group">
    <button type="submit" class="btn btn-primary">
        {{ $formMode === 'edit' ? __('admin-country.update') : __('admin-country.create') }}
    </button>
</div>
