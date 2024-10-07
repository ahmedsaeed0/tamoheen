<div class="form-group {{ $errors->has('payment_method') ? 'has-error' : '' }}">
    <label for="payment_method" class="control-label">{{ __('admin-withdraw-request.payment_method') }}</label>
    
    <select name="payment_method" id="payment_method" class="form-control js-example-basic-multiple" required>
        <option value="">{{ __('admin-withdraw-request.select_payment_method') }}</option>
        @foreach($methods as $key => $value)
            <option value="{{ $key }}" {{ old('payment_method') == $key ? 'selected' : '' }}>{{ $value }}</option>
        @endforeach
    </select>

    @if ($errors->has('payment_method'))
        <p class="text-danger">{{ $errors->first('payment_method') }}</p>
    @endif
</div>

<div class="form-group {{ $errors->has('amount') ? 'has-error' : '' }}">
    <label for="amount" class="control-label">{{ __('admin-withdraw-request.amount') }}</label>
    
    <input type="text" name="amount" id="amount" class="form-control" required="{{ $errors->has('amount') ? 'required' : '' }}" value="{{ old('amount') }}">

    @if ($errors->has('amount'))
        <p class="text-danger">{{ $errors->first('amount') }}</p>
    @endif
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">
        {{ $formMode === 'edit' ? __('admin-withdraw-request.update') : __('admin-withdraw-request.create') }}
    </button>
</div>
