<div class="form-group {{ $errors->has('type') ? 'has-error' : ''}}">
    <label for="type" class="control-label">{{ __('admin-charge.type') }}</label>
    <select name="type" id="type" class="form-control js-example-basic-multiple" {{ $errors->has('type') ? 'required' : '' }}>
        <option value="0">{{ __('admin-charge.trip') }}</option>
        <option value="1">{{ __('admin-charge.shipment') }}</option>
    </select>
    {!! $errors->first('type', '<p class="text-danger">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('charge') ? 'has-error' : ''}}">
    <label for="charge" class="control-label">{{ __('admin-charge.charge') }} (%)</label>
    <input type="text" name="charge" id="charge" class="form-control" value="{{ old('charge') }}" {{ $errors->has('charge') ? 'required' : '' }}>
    {!! $errors->first('charge', '<p class="text-danger">:message</p>') !!}
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">
        {{ $formMode === 'edit' ? __('admin-charge.update') : __('admin-charge.create') }}
    </button>
</div>
