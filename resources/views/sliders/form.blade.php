
<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
    {!! Html::label(__('admin-sliders.title'), 'title')->class('control-label') !!}
    
    {!! Html::text('title', old('title', $slider->title ?? null))
        ->class('form-control')
        ->required() !!}
    
    @if($errors->has('title'))
        <p class="text-danger">{{ $errors->first('title') }}</p>
    @endif
</div>


<div class="form-group {{ $errors->has('title_arabic') ? 'has-error' : ''}}">
    {!! Html::label(__('admin-sliders.title_arabic'), 'title_arabic')->class('control-label') !!}

    {!! Html::text('title_arabic', old('title_arabic', $slider->title_arabic ?? null))
        ->class('form-control')
        ->required() !!}

    @if($errors->has('title_arabic'))
        <p class="text-danger">{{ $errors->first('title_arabic') }}</p>
    @endif
</div>


<div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
    {!! Html::label(__('admin-sliders.description'), 'description')->class('control-label') !!}

    {!! Html::textarea('description', old('description', $slider->description ?? null))
        ->class('form-control')
        ->rows(2)
        ->cols(3)
        ->required() !!}

    @if($errors->has('description'))
        <p class="text-danger">{{ $errors->first('description') }}</p>
    @endif
</div>



<div class="form-group {{ $errors->has('description_arabic') ? 'has-error' : ''}}">
    {!! Html::label(__('admin-sliders.description_arabic'), 'description_arabic')->class('control-label') !!}

    {!! Html::textarea('description_arabic', old('description_arabic', $slider->description_arabic ?? null))
        ->class('form-control')
        ->rows(2)
        ->cols(3)
        ->required() !!}

    @if($errors->has('description_arabic'))
        <p class="text-danger">{{ $errors->first('description_arabic') }}</p>
    @endif
</div>






<div class="form-group {{ $errors->has('image') ? 'has-error' : ''}}">
    {!! Html::label(__('admin-sliders.image'), 'image')->class('control-label') !!}

    {!! Html::file('image', ('' == 'required') ? ['class' => 'form-control', 'required' => 'required', 'id' => 'car_image'] : ['class' => 'form-control', 'id' => 'car_image']) !!}

    @if($errors->has('image'))
        <p class="text-danger">{{ $errors->first('image') }}</p>
    @endif
</div>




@if($formMode == 'edit')

    @if($slider->image != null)

        <div class="form-group">

            <img src="{{ $slider->image->url }}" alt="" style="width: 100px; height: 100px;">

        </div>

    @endif

@endif





<div class="form-group">

    {!! Html::submit($formMode === 'edit' ? __('admin-sliders.update') : __('admin-sliders.create'), ['class' => 'btn btn-primary']) !!}

</div>

