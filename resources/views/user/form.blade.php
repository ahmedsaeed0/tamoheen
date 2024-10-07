<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
    <label for="title" class="control-label">Title</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', isset($post) ? $post->title : '') }}" {{ $errors->has('title') ? 'required' : '' }}>
    {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('body') ? 'has-error' : '' }}">
    <label for="body" class="control-label">Body</label>
    <textarea name="body" class="form-control" {{ $errors->has('body') ? 'required' : '' }}>{{ old('body', isset($post) ? $post->body : '') }}</textarea>
    {!! $errors->first('body', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ $formMode === 'edit' ? 'Update' : 'Create' }}</button>
</div>
