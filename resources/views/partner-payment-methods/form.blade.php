<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name" class="control-label">{{ __('admin-payment-method.name') }}</label>
    <input type="text" name="name" id="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" 
        {{ $errors->has('name') ? 'required' : '' }}>
    @if ($errors->has('name'))
        <p class="text-danger">{{ $errors->first('name') }}</p>
    @endif
</div>

<div class="form-group {{ $errors->has('details') ? 'has-error' : '' }}">
    <label for="details" class="control-label">{{ __('admin-payment-method.details') }}</label>
    <textarea name="details" id="details" class="form-control {{ $errors->has('details') ? 'is-invalid' : '' }}" 
        {{ $errors->has('details') ? 'required' : '' }} rows="2" cols="3"></textarea>
    @if ($errors->has('details'))
        <p class="text-danger">{{ $errors->first('details') }}</p>
    @endif
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ $formMode === 'edit' ? __('admin-payment-method.update') : __('admin-payment-method.create') }}</button>
</div>
