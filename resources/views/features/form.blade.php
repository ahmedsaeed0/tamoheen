<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name" class="control-label">{{ __('admin-feature.name') }}</label>
    <input type="text" name="name" id="name" class="form-control" required="required" value="{{ old('name', isset($feature) ? $feature->name : '') }}">
    {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('name_arabic') ? 'has-error' : '' }}">
    <label for="name_arabic" class="control-label">{{ __('admin-feature.name_arabic') }}</label>
    <input type="text" name="name_arabic" id="name_arabic" class="form-control" required="required" value="{{ old('name_arabic', isset($feature) ? $feature->name_arabic : '') }}">
    {!! $errors->first('name_arabic', '<p class="text-danger">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('is_main') ? 'has-error' : '' }}">
    <label for="is_main" class="control-label">{{ __('admin-feature.is_main') }}</label>
    <select name="is_main" id="is_main" class="form-control js-example-basic-multiple" required="required">
        <option value="0">{{ __('No') }}</option>
        <option value="1" {{ (isset($feature) && $feature->is_main == 1) ? 'selected' : '' }}>{{ __('Yes') }}</option>
    </select>
    {!! $errors->first('is_main', '<p class="text-danger">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('note') ? 'has-error' : '' }}">
    <label for="note" class="control-label">{{ __('admin-feature.note') }}</label>
    <textarea name="note" id="note" class="form-control" rows="2" cols="3" required="required">{{ old('note', isset($feature) ? $feature->note : '') }}</textarea>
    {!! $errors->first('note', '<p class="text-danger">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('icon') ? 'has-error' : '' }}">
    <label for="icon" class="control-label">{{ __('admin-feature.icon') }}</label>
    <input type="file" name="icon" id="icon" class="form-control" {{ $formMode == 'edit' ? '' : 'required="required"' }}>
    {!! $errors->first('icon', '<p class="text-danger">:message</p>') !!}
</div>

@if($formMode == 'edit')
    <div class="form-group">
        @if($feature->image)
            <img src="{{ $feature->image->url }}" alt="" id="carImg">
        @endif
    </div>
@endif

<div class="form-group">
    <button type="submit" class="btn btn-primary">
        {{ $formMode === 'edit' ? __('admin-feature.update') : __('admin-feature.create') }}
    </button>
</div>
