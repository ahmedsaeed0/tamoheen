<div class="form-group {{ $errors->has('user') ? 'has-error' : '' }}">
    <label for="user" class="control-label">{{ __('admin-trip-booking.user') }}</label>
    <input type="text" name="user" id="user" class="form-control {{ $errors->has('user') ? 'is-invalid' : '' }}" 
        {{ $errors->has('user') ? 'required' : '' }}>
    @if ($errors->has('user'))
        <p class="text-danger">{{ $errors->first('user') }}</p>
    @endif
</div>

<div class="form-group {{ $errors->has('trip') ? 'has-error' : '' }}">
    <label for="trip" class="control-label">{{ __('admin-trip-booking.trip') }}</label>
    <input type="text" name="trip" id="trip" class="form-control {{ $errors->has('trip') ? 'is-invalid' : '' }}" 
        {{ $errors->has('trip') ? 'required' : '' }}>
    @if ($errors->has('trip'))
        <p class="text-danger">{{ $errors->first('trip') }}</p>
    @endif
</div>

<div class="form-group {{ $errors->has('title_urdu') ? 'has-error' : '' }}">
    <label for="title_urdu" class="control-label">{{ __('admin-trip-booking.title_urdu') }}</label>
    <input type="text" name="title_urdu" id="title_urdu" class="form-control {{ $errors->has('title_urdu') ? 'is-invalid' : '' }}" 
        {{ $errors->has('title_urdu') ? 'required' : '' }}>
    @if ($errors->has('title_urdu'))
        <p class="text-danger">{{ $errors->first('title_urdu') }}</p>
    @endif
</div>

<div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
    <label for="price" class="control-label">{{ __('admin-trip-booking.price') }}</label>
    <input type="text" name="price" id="price" class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" 
        {{ $errors->has('price') ? 'required' : '' }}>
    @if ($errors->has('price'))
        <p class="text-danger">{{ $errors->first('price') }}</p>
    @endif
</div>

<div class="form-group {{ $errors->has('is_payment_complete') ? 'has-error' : '' }}">
    <label for="is_payment_complete" class="control-label">{{ __('admin-trip-booking.payment_complete') }}</label>
    <input type="text" name="is_payment_complete" id="is_payment_complete" class="form-control {{ $errors->has('is_payment_complete') ? 'is-invalid' : '' }}" 
        {{ $errors->has('is_payment_complete') ? 'required' : '' }}>
    @if ($errors->has('is_payment_complete'))
        <p class="text-danger">{{ $errors->first('is_payment_complete') }}</p>
    @endif
</div>

<div class="form-group {{ $errors->has('number_of_passengers') ? 'has-error' : '' }}">
    <label for="number_of_passengers" class="control-label">{{ __('admin-trip-booking.number_of_passengers') }}</label>
    <input type="text" name="number_of_passengers" id="number_of_passengers" class="form-control {{ $errors->has('number_of_passengers') ? 'is-invalid' : '' }}" 
        {{ $errors->has('number_of_passengers') ? 'required' : '' }}>
    @if ($errors->has('number_of_passengers'))
        <p class="text-danger">{{ $errors->first('number_of_passengers') }}</p>
    @endif
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ $formMode === 'edit' ? 'Update' : 'Create' }}</button>
</div>
