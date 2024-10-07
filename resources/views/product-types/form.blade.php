<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Html::label(__('admin-product-type.name'), 'name')->class('control-label') !!}

    {!! Html::text('name', old('name'))
        ->class('form-control')
        ->required() !!}

    @if($errors->has('name'))
        <p class="text-danger">{{ $errors->first('name') }}</p>
    @endif
</div>

<div class="form-group {{ $errors->has('name_arabic') ? 'has-error' : ''}}">
    {!! Html::label(__('admin-product-type.name_arabic'), 'name_arabic')->class('control-label') !!}

    {!! Html::text('name_arabic', old('name_arabic'))
        ->class('form-control')
        ->required() !!}

    @if($errors->has('name_arabic'))
        <p class="text-danger">{{ $errors->first('name_arabic') }}</p>
    @endif
</div>


<div class="form-group">
    {!! html()->submit($formMode === 'edit' ? __('admin-product-type.update') : __('admin-product-type.create'))
    ->class('btn btn-primary') !!}

     
</div>

