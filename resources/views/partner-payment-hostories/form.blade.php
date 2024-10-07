<div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
    <label for="user_id" class="control-label">User Id</label>
    <input type="text" name="user_id" id="user_id" class="form-control" value="{{ old('user_id', $partnerpaymenthostory->user_id ?? '') }}" {{ $errors->has('user_id') ? 'required' : '' }}>
    {!! $errors->first('user_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('booking_id') ? 'has-error' : '' }}">
    <label for="booking_id" class="control-label">Booking Id</label>
    <input type="text" name="booking_id" id="booking_id" class="form-control" value="{{ old('booking_id', $partnerpaymenthostory->booking_id ?? '') }}" {{ $errors->has('booking_id') ? 'required' : '' }}>
    {!! $errors->first('booking_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
    <label for="price" class="control-label">Price</label>
    <input type="text" name="price" id="price" class="form-control" value="{{ old('price', $partnerpaymenthostory->price ?? '') }}" {{ $errors->has('price') ? 'required' : '' }}>
    {!! $errors->first('price', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
    <label for="type" class="control-label">Type</label>
    <input type="text" name="type" id="type" class="form-control" value="{{ old('type', $partnerpaymenthostory->type ?? '') }}" {{ $errors->has('type') ? 'required' : '' }}>
    {!! $errors->first('type', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ $formMode === 'edit' ? 'Update' : 'Create' }}</button>
</div>
