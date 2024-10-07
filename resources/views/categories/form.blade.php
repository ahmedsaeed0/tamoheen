<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    {!! Form::label('name', __('admin-category.name'), ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('name_arabic') ? 'has-error' : ''}}">
    {!! Form::label('name_arabic', __('admin-category.name_arabic'), ['class' => 'control-label']) !!}
    {!! Form::text('name_arabic', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('name_arabic', '<p class="text-danger">:message</p>') !!}
</div>
{{-- <div class="form-group {{ $errors->has('name_urdu') ? 'has-error' : ''}}">
    {!! Form::label('name_urdu', 'Name Urdu', ['class' => 'control-label']) !!}
    {!! Form::text('name_urdu', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    {!! $errors->first('name_urdu', '<p class="text-danger">:message</p>') !!}
</div> --}}


<div class="form-group">
    {!! Form::submit($formMode === 'edit' ? __('admin-category.update') : __('admin-category.create'), ['class' => 'btn btn-primary']) !!}
</div>
