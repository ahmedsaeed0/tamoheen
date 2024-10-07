<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="control-label">{{ __('admin-state.name') }}</label>
    <input type="text" name="name" id="name" class="form-control" 
           value="{{ old('name', isset($state) ? $state->name : '') }}" 
           {{ $formMode === 'edit' ? 'required' : '' }} />
    {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('name_arabic') ? 'has-error' : ''}}">
    <label for="name_arabic" class="control-label">{{ __('admin-state.name_arabic') }}</label>
    <input type="text" name="name_arabic" id="name_arabic" class="form-control" 
           value="{{ old('name_arabic', isset($state) ? $state->name_arabic : '') }}" 
           {{ $formMode === 'edit' ? 'required' : '' }} />
    {!! $errors->first('name_arabic', '<p class="text-danger">:message</p>') !!}
</div>

@if($formMode == 'edit')
    <div class="form-group {{ $errors->has('country_id') ? 'has-error' : '' }}">
        <label for="country_id" class="control-label">{{ __('admin-state.country') }}</label>
        <select class="form-control js-example-basic-multiple" id="country_id" name="country_id">
            <option>{{ __('admin-state.select_country') }}</option>
            @foreach($countries as $key => $value)
                <option value="{{ $key }}" {{ ($state->country_id == $key) ? 'selected' : '' }}>{{ $value }}</option>
            @endforeach
        </select>
        {!! $errors->first('country_id', '<p class="text-danger">:message</p>') !!}
    </div>
@else
    <div class="form-group {{ $errors->has('country_id') ? 'has-error' : '' }}">
        <label for="country_id" class="control-label">{{ __('admin-state.country') }}</label>
        <select class="form-control js-example-basic-multiple" id="country_id" name="country_id">
            <option>{{ __('admin-state.select_country') }}</option>
            @foreach($countries as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
        {!! $errors->first('country_id', '<p class="text-danger">:message</p>') !!}
    </div>
@endif

<div class="form-group">
    <button type="submit" class="btn btn-primary">
        {{ $formMode === 'edit' ? __('admin-state.update') : __('admin-state.create') }}
    </button>
</div>
