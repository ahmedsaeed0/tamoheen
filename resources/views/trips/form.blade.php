@if($formMode == 'edit')


<div class="form-group {{ $errors->has('city_from_id') ? 'has-error' : '' }}">
    {!! html()->label(__('admin-trip.from'), 'city_from_id')->class('control-label') !!}
    
    {!! html()->select('city_from_id', $cities->pluck(app()->getLocale() == 'ar' ? 'name_arabic' : 'name', 'id'))
        ->options([null => __('admin-trip.select_from_city')])
        ->id('city_from_id')
        ->class('form-control js-example-basic-multiple')
        ->required()
        ->selected($trip->city_from_id) !!}
    
    {!! $errors->first('city_from_id', '<p class="text-danger">:message</p>') !!}
</div>

@else
<div class="form-group {{ $errors->has('city_from_id') ? 'has-error' : '' }}">
    {!! html()->label(__('admin-trip.from'), 'city_from_id')->class('control-label') !!}
    
    {!! html()->select('city_from_id')
        ->class('form-control js-example-basic-multiple')
        ->id('city_from_id')
        ->required()
        ->options(
            $cities->pluck(
                app()->getLocale() == 'ar' ? 'name_arabic' : 'name', 'id'
            )->prepend(__('admin-trip.select_from_city'), '')
        ) !!}
    
    {!! $errors->first('city_from_id', '<p class="text-danger">:message</p>') !!}
</div>

@endif

@if($formMode == 'edit')
<div class="form-group {{ $errors->has('city_to_id') ? 'has-error' : '' }}">
    {!! html()->label(__('admin-trip.to'), 'city_to_id')->class('control-label') !!}
    
    {!! html()->select('city_to_id', $cities->pluck(app()->getLocale() == 'ar' ? 'name_arabic' : 'name', 'id'))
        ->options([null => __('admin-trip.select_to_city')])
        ->id('city_to_id')
        ->class('form-control js-example-basic-multiple')
        ->required()
        ->selected($trip->city_to_id) !!}
    
    {!! $errors->first('city_to_id', '<p class="text-danger">:message</p>') !!}
</div>

@else
<div class="form-group {{ $errors->has('city_to_id') ? 'has-error' : '' }}">
    {!! html()->label(__('admin-trip.to'), 'city_to_id')->class('control-label') !!}
    
    {!! html()->select('city_to_id')
        ->class('form-control js-example-basic-multiple')
        ->id('city_to_id')
        ->required()
        ->options(
            $cities->pluck(
                app()->getLocale() == 'ar' ? 'name_arabic' : 'name', 'id'
            )->prepend(__('admin-trip.select_to_city'), '')
        ) !!}
    
    {!! $errors->first('city_to_id', '<p class="text-danger">:message</p>') !!}
</div>

@endif

@if($formMode == 'edit')
<div class="form-group {{ $errors->has('car_id') ? 'has-error' : '' }}">
    {!! html()->label(__('admin-trip.car'), 'car_id')->class('control-label') !!}
    
    {!! html()->select('car_id', $cars->pluck(app()->getLocale() == 'ar' ? 'name_arabic' : 'name', 'id'))
        ->options([null => __('admin-trip.select_car')])
        ->id('car_id')
        ->class('form-control js-example-basic-multiple')
        ->required()
        ->selected($trip->car_id) !!}
    
    {!! $errors->first('car_id', '<p class="text-danger">:message</p>') !!}
</div>

@else
<div class="form-group {{ $errors->has('car_id') ? 'has-error' : '' }}">
    {!! html()->label(__('admin-trip.car'), 'car_id')->class('control-label') !!}

    {!! html()->select('car_id')
        ->class('form-control js-example-basic-multiple')
        ->id('car_id')
        ->required()
        ->options(
            $cars->pluck(
                app()->getLocale() == 'ar' ? 'name_arabic' : 'name', 'id'
            )->prepend(__('admin-trip.select_car'), '')
        ) !!}

    {!! $errors->first('car_id', '<p class="text-danger">:message</p>') !!}
</div>

@endif

@if($formMode == 'edit')
<div class="form-group {{ $errors->has('feature_id') ? 'has-error' : '' }}">
    {!! html()->label(__('admin-trip.feature'), 'feature_id')->class('control-label') !!}
    
    {!! html()->select('feature_id', $features->pluck(app()->getLocale() == 'ar' ? 'name_arabic' : 'name', 'id'))
        ->options([null => __('admin-trip.select_feature')])
        ->id('feature_id')
        ->class('form-control js-example-basic-multiple') !!}
    
    {!! $errors->first('feature_id', '<p class="text-danger">:message</p>') !!}
</div>

@else
<div class="form-group {{ $errors->has('feature_id') ? 'has-error' : '' }}">
    {!! html()->label(__('admin-trip.feature'), 'feature_id')->class('control-label') !!}

    {!! html()->select('feature_id')
        ->class('form-control js-example-basic-multiple')
        ->id('feature_id')
        ->options(
            $features->pluck(
                app()->getLocale() == 'ar' ? 'name_arabic' : 'name', 'id'
            )->prepend(__('admin-trip.select_feature'), '')
        ) !!}

    {!! $errors->first('feature_id', '<p class="text-danger">:message</p>') !!}
</div>

@endif


<div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
    {!! html()->label(__('admin-trip.description'), 'description')->class('control-label') !!}

    {!! html()->text('description')
        ->class('form-control')
        ->required() !!}

    {!! $errors->first('description', '<p class="text-danger">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('description_arabic') ? 'has-error' : '' }}">
    {!! html()->label(__('admin-trip.description_arabic'), 'description_arabic')->class('control-label') !!}

    {!! html()->text('description_arabic')
        ->class('form-control')
        ->required() !!}

    {!! $errors->first('description_arabic', '<p class="text-danger">:message</p>') !!}
</div>


<div class="form-group {{ $errors->has('start_point') ? 'has-error' : '' }}">
    {!! html()->label(__('admin-trip.start_point'), 'start_point')->class('control-label') !!}

    {!! html()->text('start_point')
        ->class('form-control')
        ->id('searchStartPoint')
        ->required() !!}

    {!! $errors->first('start_point', '<p class="text-danger">:message</p>') !!}
</div>


<div class="form-group {{ $errors->has('end_point') ? 'has-error' : '' }}">
    {!! html()->label(__('admin-trip.end_point'), 'end_point')->class('control-label') !!}

    {!! html()->text('end_point')
        ->class('form-control')
        ->id('searchEndPoint')
        ->required() !!}

    {!! $errors->first('end_point', '<p class="text-danger">:message</p>') !!}
</div>



<div class="form-group datepicker-form-group {{ $errors->has('date') ? 'has-error' : '' }}">
    {!! html()->label(__('admin-trip.pickup_time'), 'date')->class('control-label') !!}

    {!! html()->text('date')
        ->class('form-control hijri-date-input ' . ($errors->has('date') ? '' : 'datepickerinput'))
        ->id('hijri-date-input-pickup')
        ->required($errors->has('date')) !!}

    {!! $errors->first('date', '<p class="text-danger">:message</p>') !!}
</div>

<div class="form-group datepicker-form-group {{ $errors->has('drop_off_time') ? 'has-error' : '' }}">
    {!! html()->label(__('admin-trip.drop_off_time'), 'drop_off_time')->class('control-label') !!}

    {!! html()->text('drop_off_time')
        ->class('form-control hijri-date-input datepickerinput')
        ->id('hijri-date-input')
        ->required($errors->has('drop_off_time')) !!}

    {!! $errors->first('drop_off_time', '<p class="text-danger">:message</p>') !!}
</div>







<div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
    {!! html()->label(__('admin-trip.type'), 'type')->class('control-label') !!}
    <br/>

    <div class="custom-control custom-checkbox custom-control-inline">
        {!! html()->checkbox('type', $formMode == 'edit' ? $trip->type == 1 : true, 1)->class('custom-control-input')->id('ride') !!}
        <label class="custom-control-label" for="ride">{{ __('admin-trip.ride') }}</label>
    </div>
</div>



<div class="form-group {{ $errors->has('product_type_id') ? 'has-error' : '' }}" id="product_type">
    {!! html()->label('Product Type', 'product_type_id')->class('control-label') !!}
    
    @if($formMode == 'edit')
        {!! html()->select('product_type_id[]', $producttypes, $trip->tripProductTypes->pluck('id')->toArray())
            ->class('form-control js-example-basic-multiple')
            ->id('product_type_id')
            ->multiple() !!}
    @else
        {!! html()->select('product_type_id[]', $producttypes, null)
            ->class('form-control js-example-basic-multiple')
            ->id('product_type_id')
            ->multiple()
            ->placeholder('Select Product Type')
            ->disabled() !!}
    @endif
</div>


<div class="form-group {{ $errors->has('number_of_person') ? 'has-error' : ''}}" id="">
    {!! html()->label(__('admin-trip.number_of_person'), 'number_of_person')->class('control-label') !!}
    {!! html()->number('number_of_person', null)
        ->class('form-control')
        ->id('input_number_of_person')
        ->required() !!}
    {!! $errors->first('number_of_person', '<p class="text-danger">:message</p>') !!}
</div>



<div class="form-group {{ $errors->has('price_per_person') ? 'has-error' : ''}}" id="price_per_person">
    {!! html()->label(__('admin-trip.price_per_person'), 'price_per_person')->class('control-label') !!}
    {!! html()->text('price_per_person', null)
        ->class('form-control')
        ->id('input_price_per_person')
        ->required() !!}
    {!! $errors->first('price_per_person', '<p class="text-danger">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('number_of_bag') ? 'has-error' : ''}}" id="number_of_bag">
    {!! html()->label('Number Of Bag', 'number_of_bag')->class('control-label') !!}
    {!! html()->number('number_of_bag', null)
        ->class('form-control')
        ->id('input_number_of_bag')
        !!}
    {!! $errors->first('number_of_bag', '<p class="text-danger">:message</p>') !!}
</div>


<div class="form-group {{ $errors->has('price_per_bag') ? 'has-error' : ''}}" id="price_per_bag">
    {!! html()->label('Price Per Bag', 'price_per_bag')->class('control-label') !!}
    {!! html()->text('price_per_bag', null)
        ->class('form-control')
        ->id('input_price_per_bag')
         !!}
    {!! $errors->first('price_per_bag', '<p class="text-danger">:message</p>') !!}
</div>


{!! html()->hidden('capacity_of_person')->id('capacity_person') !!}
{!! html()->hidden('capacity_of_bag')->id('capacity_bag') !!}

{{-- <div class="form-group">
    {
    {!! html()->submit($formMode === 'edit' ? 'تعديل رحلة' : 'إضافة رحلة')->class('btn btn-primary') !!}
    
</div> --}}
