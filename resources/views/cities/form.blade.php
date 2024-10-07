 <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name" class="control-label">{{ __('admin-city.name') }}</label>
    <input type="text" name="name" value="{{ old('name', $city->name ?? '') }}" class="form-control" required>
    {!! $errors->first('name', '<p class="text-danger help-block">:message</p>') !!}
</div>


<div class="form-group {{ $errors->has('name_arabic') ? 'has-error' : '' }}">
    <label for="name_arabic" class="control-label">{{ __('admin-city.name_arabic') }}</label>
    <input type="text" name="name_arabic" value="{{ old('name_arabic', $city->name_arabic ?? '') }}" class="form-control" required>
    {!! $errors->first('name_arabic', '<p class="text-danger help-block">:message</p>') !!}
</div>



<div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
    <label for="description" class="control-label">{{ __('admin-city.description') }}</label>
    
    <textarea name="description" class="form-control mytextarea" rows="2" required>{{ old('description', $city->description ?? '') }}</textarea>
    {!! $errors->first('description', '<p class="text-danger help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('description_arabic') ? 'has-error' : '' }}">
    <label for="description_arabic" class="control-label">{{ __('admin-city.description_arabic') }}</label>
    <textarea name="description_arabic" class="form-control mytextarea" rows="2" required>{{ old('description_arabic', $city->description_arabic ?? '') }}</textarea>
    {!! $errors->first('description_arabic', '<p class="text-danger help-block">:message</p>') !!}
</div>





<div class="form-group {{ $errors->has('state_id') ? 'has-error' : '' }}">
    <label for="state_id" class="control-label">{{ __('admin-city.state') }}</label>

    <select class="form-control js-example-basic-multiple" id="state_id" name="state_id">
        <option value="">{{ __('admin-city.select_state') }}</option>

        @foreach($states as $key => $value)
            <option value="{{ $key }}" {{ (isset($city) && $city->state_id == $key) ? 'selected' : '' }}>{{ $value }}</option>
        @endforeach
    </select>

    {!! $errors->first('state_id', '<p class="text-danger help-block">:message</p>') !!}
</div>




<div class="form-group {{ $errors->has('order_by') ? 'has-error' : '' }}">
    <label for="order_by" class="control-label">{{ __('admin-city.order_by') }}</label>
    <select name="order_by" class="form-control js-example-basic-multiple">
        <option value="0">---Select Order By---</option>
        @for($i = 1; $i <= 9; $i++)
            <option value="{{ $i }}" {{ old('order_by', $city->order_by ?? '') == $i ? 'selected' : '' }}>{{ $i }}</option>
        @endfor
    </select>
    {!! $errors->first('order_by', '<p class="help-block">:message</p>') !!}
</div>



<div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
    <label for="image" class="control-label">{{ __('admin-city.image') }}</label>
    <input type="file" name="image[]" class="form-control" multiple id="car_image">
    {!! $errors->first('image', '<p class="text-danger help-block">:message</p>') !!}
</div>



@if($formMode == 'edit')

    <div class="form-group">

    @foreach($city->images as $image)

        <img src="{{ $image->url }}" alt="" id="carImg">

    @endforeach

    </div>

@endif





<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ $formMode === 'edit' ? __('admin-city.update') : __('admin-city.create') }}</button>
</div>
