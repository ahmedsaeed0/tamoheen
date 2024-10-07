<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
    {!! html()->label(__('admin-users.title'), 'title')->class('control-label') !!}
    
    {!! html()->select('title', [
        '' => 'Select Title', 
        '1' => 'Mr', 
        '2' => 'Mrs'
    ], null)
        ->class('form-control js-example-basic-multiple' . ($errors->has('title') ? ' is-invalid' : ''))
        ->required($errors->has('title') ? 'required' : null) !!}
    
    @if ($errors->has('title'))
        <p class="help-block text-danger">{{ $errors->first('title') }}</p>
    @endif
</div>


<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    {!! html()->label(__('admin-users.name'), 'name')->class('control-label') !!}
    
    {!! html()->text('name')
        ->class('form-control' . ($errors->has('name') ? ' is-invalid' : ''))
        ->required($errors->has('name')) !!}
    
    @if ($errors->has('name'))
        <p class="help-block text-danger">{{ $errors->first('name') }}</p>
    @endif
</div>

<div class="form-group {{ $errors->has('mobile') ? 'has-error' : '' }}">
    {!! html()->label(__('admin-users.mobile'), 'mobile')->class('control-label') !!}
    
    {!! html()->text('mobile')
        ->class('form-control' . ($errors->has('mobile') ? ' is-invalid' : ''))
        ->required($errors->has('mobile')) !!}
    
    @if ($errors->has('mobile'))
        <p class="help-block text-danger">{{ $errors->first('mobile') }}</p>
    @endif
</div>


<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
    {!! html()->label(__('admin-users.email'), 'email')->class('control-label') !!}
    
    {!! html()->email('email')
        ->class('form-control' . ($errors->has('email') ? ' is-invalid' : ''))
        ->required($errors->has('email')) !!}
    
    @if ($errors->has('email'))
        <p class="help-block text-danger">{{ $errors->first('email') }}</p>
    @endif
</div>

@if($formMode == 'create')
    <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
        {!! html()->label(__('admin-users.password'), 'password')->class('control-label') !!}
        
        {!! html()->password('password')
            ->class('form-control' . ($errors->has('password') ? ' is-invalid' : ''))
            ->required($errors->has('password')) !!}
        
        @if ($errors->has('password'))
            <p class="help-block text-danger">{{ $errors->first('password') }}</p>
        @endif
    </div>

    <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
        {!! html()->label('password_confirmation', 'Confirm password')->class('control-label') !!}
        
        {!! html()->password('password_confirmation')
            ->class('form-control' . ($errors->has('password_confirmation') ? ' is-invalid' : ''))
            ->required($errors->has('password_confirmation')) !!}
        
        @if ($errors->has('password_confirmation'))
            <p class="help-block text-danger">{{ $errors->first('password_confirmation') }}</p>
        @endif
    </div>
@endif

<div class="form-group {{ $errors->has('user_image') ? 'has-error' : '' }}">
    {!! html()->label(__('admin-users.user_image'), 'user_image')->class('control-label') !!}
    
    {!! html()->file('user_image')
        ->class('form-control' . ($errors->has('user_image') ? ' is-invalid' : ''))
        ->required($errors->has('user_image'))
        ->id('user_image') !!}
    
    @if ($errors->has('user_image'))
        <p class="help-block text-danger">{{ $errors->first('user_image') }}</p>
    @endif
</div>

<div class="form-group">
    {!! html()->submit($formMode === 'edit' ? __('admin-users.update') : __('admin-users.create'), ['class' => 'btn btn-primary']) !!}
</div>

