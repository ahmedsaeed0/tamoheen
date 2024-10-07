<div class="form-group {{ $errors->has('code') ? 'has-error' : '' }}">
    <label for="code" class="control-label">{{ __('admin-promo-code.code') }}</label>
    <input type="text" name="code" id="code" value="{{ old('code', $code) }}" class="form-control" readonly required>
    {!! $errors->first('code', '<p class="text-danger">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
    <label for="type" class="control-label">{{ __('admin-promo-code.type') }}</label>
    <select name="type" id="promo_code_select" class="form-control js-example-basic-multiple" required>
        <option value="percent">Percentage</option>
        <option value="amount">Amount</option>
    </select>
    {!! $errors->first('type', '<p class="text-danger">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('percent') ? 'has-error' : '' }}" id="percentage">
    <label for="percent" class="control-label">{{ __('admin-promo-code.percent') }}</label>
    <input type="text" name="percent" id="percent" value="{{ old('percent') }}" class="form-control" required>
    {!! $errors->first('percent', '<p class="text-danger">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('amount') ? 'has-error' : '' }}" id="amount">
    <label for="amount" class="control-label">{{ __('admin-promo-code.amount') }}</label>
    <input type="text" name="amount" id="amount" value="{{ old('amount') }}" class="form-control" required>
    {!! $errors->first('amount', '<p class="text-danger">:message</p>') !!}
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ $formMode === 'edit' ? __('admin-promo-code.update') : __('admin-promo-code.create') }}</button>
</div>
