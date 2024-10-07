
<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    {!! html()->label(__('admin-car.model'), 'name')->class('control-label') !!}
    {!! html()->text('name')
        ->class('form-control' . ($errors->has('name') ? ' is-invalid' : ''))
        ->required($errors->has('name')) !!}
    @if ($errors->has('name'))
        <p class="text-danger">{{ $errors->first('name') }}</p>
    @endif
</div>


<div class="form-group {{ $errors->has('name_arabic') ? 'has-error' : ''}}" style="display:none">
    {!! html()->label(__('admin-car.name_arabic'), 'name_arabic')->class('control-label') !!}
    {!! html()->text('name_arabic')
        ->class('form-control' . ($errors->has('name_arabic') ? ' is-invalid' : '')) !!}
    @if ($errors->has('name_arabic'))
        <p class="text-danger">{{ $errors->first('name_arabic') }}</p>
    @endif
</div>


<div class="form-group {{ $errors->has('capacity_of_person') ? 'has-error' : ''}}">
    {!! html()->label(__('admin-car.capacity_of_person'), 'capacity_of_person')->class('control-label') !!}
    {!! html()->text('capacity_of_person')
        ->class('form-control' . ($errors->has('capacity_of_person') ? ' is-invalid' : ''))
        ->required() !!}
    @if ($errors->has('capacity_of_person'))
        <p class="text-danger">{{ $errors->first('capacity_of_person') }}</p>
    @endif
</div>



<div class="form-group {{ $errors->has('capacity_of_bag') ? 'has-error' : ''}}">
    {!! html()->label(__('admin-car.capacity_of_bag'), 'capacity_of_bag')->class('control-label') !!}
    {!! html()->text('capacity_of_bag')
        ->class('form-control' . ($errors->has('capacity_of_bag') ? ' is-invalid' : ''))
        ->required() !!}
    @if ($errors->has('capacity_of_bag'))
        <p class="text-danger">{{ $errors->first('capacity_of_bag') }}</p>
    @endif
</div>


    @if($formMode == 'edit')
    <div class="form-group {{ $errors->has('feature_id') ? 'has-error' : '' }}">
        {!! html()->label(__('admin-car.feature'), 'feature_id')->class('control-label') !!}
        
        {!! html()->select('feature_id[]', $features->pluck(app()->getLocale() == 'ar' ? 'name_arabic' : 'name', 'id'))
            ->multiple()
            ->class('form-control js-example-basic-multiple')
            ->id('feature_id')
             !!}

        @if ($errors->has('feature_id'))
            <p class="text-danger">{{ $errors->first('feature_id') }}</p>
        @endif
    </div>


@else
<div class="form-group {{ $errors->has('feature_id') ? 'has-error' : '' }}">
    {!! html()->label(__('admin-car.feature'), 'feature_id[]')->class('control-label') !!}
    
    {!! html()->select('feature_id[]', 
        $features->pluck(app()->getLocale() == 'ar' ? 'name_arabic' : 'name', 'id'))
        ->multiple()
        ->class('form-control js-example-basic-multiple')
        ->id('feature_id')
        ->placeholder(__('admin-car.select_feature'))
         !!}

    @if ($errors->has('feature_id'))
        <p class="text-danger">{{ $errors->first('feature_id') }}</p>
    @endif
</div>

@endif

<div class="form-group {{ $errors->has('sequence_number') ? 'has-error' : ''}}">
    {!! html()->label(__('admin-car.sequence_number'), 'sequence_number')->class('control-label') !!}
    
    {!! html()->text('sequence_number')
        ->class('form-control' . ($errors->has('sequence_number') ? ' is-invalid' : ''))
        ->required($errors->has('sequence_number')) !!}

    @if ($errors->has('sequence_number'))
        <p class="text-danger">{{ $errors->first('sequence_number') }}</p>
    @endif
</div>

 <p class="form-text text-danger danger">أدخل لاحرف باللغة العربية.</p>
 <div class="row">
    <div class="col-md-4">
        <div class="form-group {{ $errors->has('plate_letter_right') ? 'has-error' : ''}}">
            <div class="d-flex align-items-center">
                {!! html()->label(__('admin-car.plate_letter_right'), 'plate_letter_right')->class('control-label mr-1') !!}
                
                <span data-toggle="tooltip" data-placement="top" data-html="true" title='<img src="{{ asset("front/assets/images/car-number.png") }}" alt="image" height="65">'>
                    <i class="material-icons text-danger tooltip-icon-mg">help</i>
                </span>
            </div>
            
            {!! html()->text('plate_letter_right')
                ->class('form-control' . ($errors->has('plate_letter_right') ? ' is-invalid' : ''))
                ->required($errors->has('plate_letter_right')) !!}
            
            @if ($errors->has('plate_letter_right'))
                <p class="text-danger">{{ $errors->first('plate_letter_right') }}</p>
            @endif
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group {{ $errors->has('plate_letter_middle') ? 'has-error' : '' }}">
            <div class="d-flex align-items-center">
                {!! html()->label(__('admin-car.plate_letter_middle'), 'plate_letter_middle')->class('control-label mr-1') !!}
                <span data-toggle="tooltip" data-placement="top" data-html="true" title='<img src="{{ asset("front/assets/images/car-number.png") }}" alt="image" height="65">'>
                    <i class="material-icons text-danger tooltip-icon-mg">help</i>
                </span>
            </div>
            {!! html()->text('plate_letter_middle')
                ->class('form-control' . ($errors->has('plate_letter_middle') ? ' is-invalid' : ''))
                ->required($errors->has('plate_letter_middle')) !!}
    
            @if ($errors->has('plate_letter_middle'))
                <p class="text-danger">{{ $errors->first('plate_letter_middle') }}</p>
            @endif
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="form-group {{ $errors->has('plate_letter_left') ? 'has-error' : '' }}">
            <div class="d-flex align-items-center">
                {!! html()->label(__('admin-car.plate_letter_left'), 'plate_letter_left')->class('control-label mr-1') !!}
                <span data-toggle="tooltip" data-placement="top" data-html="true" title='<img src="{{ asset("front/assets/images/car-number.png") }}" alt="image" height="65">'>
                    <i class="material-icons text-danger tooltip-icon-mg">help</i>
                </span>
            </div>
            {!! html()->text('plate_letter_left')
                ->class('form-control' . ($errors->has('plate_letter_left') ? ' is-invalid' : ''))
                ->required($errors->has('plate_letter_left')) !!}

            @if ($errors->has('plate_letter_left'))
                <p class="text-danger">{{ $errors->first('plate_letter_left') }}</p>
            @endif
        </div>
    </div>
</div>




<div class="form-group {{ $errors->has('plate_number') ? 'has-error' : '' }}">
    <div class="d-flex align-items-center">
        {!! html()->label(__('admin-car.plate_number'), 'plate_number')->class('control-label mr-1') !!}
        <span data-toggle="tooltip" data-placement="top" data-html="true" title='<img src="{{ asset("/front/assets/images/car-number.png") }}" alt="image" height="65">'>
            <i class="material-icons text-danger tooltip-icon-mg">help</i>
        </span>
    </div>
    {!! html()->text('plate_number')
        ->class('form-control' . ($errors->has('plate_number') ? ' is-invalid' : ''))
        ->required($errors->has('plate_number')) !!}

    @if ($errors->has('plate_number'))
        <p class="text-danger">{{ $errors->first('plate_number') }}</p>
    @endif
</div>



<div class="form-group {{ $errors->has('plate_type') ? 'has-error' : '' }}">
    {!! html()->label(__('admin-car.plate_type'), 'plate_type') !!}
    {!! html()->select('plate_type', [
            '1' => __('admin-car.private'), 
            '2' => __('admin-car.public')
        ], null)
        ->class('form-control js-example-basic-multiple' . ($errors->has('plate_type') ? ' is-invalid' : ''))
        ->required($errors->has('plate_type')) !!}

    @if ($errors->has('plate_type'))
        <p class="text-danger">{{ $errors->first('plate_type') }}</p>
    @endif
</div>


<div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
    {!! html()->label(__('admin-car.image'), 'image') !!}
    {!! html()->file('image[]')
        ->class('form-control' . ($errors->has('image') ? ' is-invalid' : ''))
        ->required($errors->has('image'))
        ->multiple()
        ->id('car_image') !!}

    @if ($errors->has('image'))
        <p class="text-danger">{{ $errors->first('image') }}</p>
    @endif
</div>

@if($formMode == 'edit')
    <div class="form-group">
    @foreach($car->images as $image)
        <img src="{{ $image->url }}" alt="" id="carImg">
    @endforeach
    </div>
@endif

<input type="hidden" value="{{ app()->getLocale() }}" name="language">

<div class="form-group">
    {!! html()->submit($formMode === 'edit' ? __('admin-car.update') : __('admin-car.create'))
        ->class('btn btn-primary') !!}
</div>
