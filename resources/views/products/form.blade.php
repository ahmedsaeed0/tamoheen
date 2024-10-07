@if($formMode == 'edit')
    <div class="form-group {{ $errors->has('category_id') ? 'has-error' : '' }}">
        {!! Form::label('category_id', __('admin-product.category'), ['class' => 'control-label']) !!}
        <select class="form-control js-example-basic-multiple" id="category_id" name="category_id">
            <option>{{ __('admin-product.select_category') }}</option>
            @foreach($categories as $key => $value)
                <option value="{{ $key }}" {{ ($product->category_id == $key) ? 'selected' : '' }}>{{ $value }}</option>
            @endforeach
        </select>
        {!! $errors->first('category_id', '<p class="text-danger">:message</p>') !!}
    </div>
@else
    <div class="form-group {{ $errors->has('category_id') ? 'has-error' : '' }}">
        {!! Form::label('category_id', __('admin-product.category'), ['class' => 'control-label']) !!}
        <select class="form-control js-example-basic-multiple" id="category_id" name="category_id">
            <option>{{ __('admin-product.select_category') }}</option>
            @foreach($categories as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
        {!! $errors->first('category_id', '<p class="text-danger">:message</p>') !!}
    </div>
@endif

<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', __('admin-product.name'), ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('name_arabic') ? 'has-error' : ''}}">
    {!! Form::label('name_arabic', __('admin-product.name_arabic'), ['class' => 'control-label']) !!}
    {!! Form::text('name_arabic', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('name_arabic', '<p class="text-danger">:message</p>') !!}
</div>
{{-- <div class="form-group {{ $errors->has('name_urdu') ? 'has-error' : ''}}">
    {!! Form::label('name_urdu', 'Name Urdu', ['class' => 'control-label']) !!}
    {!! Form::text('name_urdu', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('name_urdu', '<p class="text-danger">:message</p>') !!}
</div> --}}
<div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
    {!! Form::label('description', __('admin-product.description'), ['class' => 'control-label']) !!}
    {!! Form::textarea('description', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required', 'rows' => '2', 'cols' => '3'] : ['class' => 'form-control', 'rows' => '2', 'cols' => '3']) !!}
    {!! $errors->first('description', '<p class="text-danger">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('description_arabic') ? 'has-error' : ''}}">
    {!! Form::label('description_arabic', __('admin-product.description_arabic'), ['class' => 'control-label']) !!}
    {!! Form::textarea('description_arabic', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required', 'rows' => '2', 'cols' => '3'] : ['class' => 'form-control', 'rows' => '2', 'cols' => '3']) !!}
    {!! $errors->first('description_arabic', '<p class="text-danger">:message</p>') !!}
</div>
{{-- <div class="form-group {{ $errors->has('description_urdu') ? 'has-error' : ''}}">
    {!! Form::label('description_urdu', 'Description Urdu', ['class' => 'control-label']) !!}
    {!! Form::textarea('description_urdu', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required', 'rows' => '2', 'cols' => '3'] : ['class' => 'form-control', 'rows' => '2', 'cols' => '3']) !!}
    {!! $errors->first('description_urdu', '<p class="text-danger">:message</p>') !!}
</div> --}}
<div class="form-group {{ $errors->has('price') ? 'has-error' : ''}}">
    {!! Form::label('price', __('admin-product.price'), ['class' => 'control-label']) !!}
    {!! Form::text('price', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('price', '<p class="text-danger">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('image') ? 'has-error' : ''}}">
    {!! Form::label('image', __('admin-product.image'), ['class' => 'control-label']) !!}
    {!! Form::file('image', ('' == 'required') ? ['class' => 'form-control', 'required' => 'required', 'id' => 'car_image'] : ['class' => 'form-control', 'id' => 'car_image']) !!}
    {!! $errors->first('image', '<p class="text-danger">:message</p>') !!}
</div>

@if($formMode == 'edit')
    <div class="form-group">
        <img src="{{ asset('storage/'.$product->image->url) }}" alt="" id="carImg">
    </div>
@endif


<div class="form-group">
    {!! Form::submit($formMode === 'edit' ? __('admin-product.update') : __('admin-product.create'), ['class' => 'btn btn-primary']) !!}
</div>
