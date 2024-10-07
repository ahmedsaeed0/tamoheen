<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
    <label for="title" class="control-label">{{ __('admin-pages.title') }}</label>
    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $page->title ?? '') }}" required="{{ $errors->has('title') ? 'required' : '' }}">
    {!! $errors->first('title', '<p class="text-danger">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('title_arabic') ? 'has-error' : '' }}">
    <label for="title_arabic" class="control-label">{{ __('admin-pages.title_arabic') }}</label>
    <input type="text" name="title_arabic" id="title_arabic" class="form-control" value="{{ old('title_arabic', $page->title_arabic ?? '') }}" required="{{ $errors->has('title_arabic') ? 'required' : '' }}">
    {!! $errors->first('title_arabic', '<p class="text-danger">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
    <label for="content" class="control-label">{{ __('admin-pages.content') }}</label><br>
    <textarea name="content" id="content" class="form-control tinymce-editor" rows="5" required="{{ $errors->has('content') ? 'required' : '' }}">{{ old('content', $page->content ?? '') }}</textarea>
    {!! $errors->first('content', '<p class="text-danger">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('content_arabic') ? 'has-error' : '' }}">
    <label for="content_arabic" class="control-label">{{ __('admin-pages.content_arabic') }}</label><br>
    <textarea name="content_arabic" id="content_arabic" class="form-control tinymce-editor" rows="5" required="{{ $errors->has('content_arabic') ? 'required' : '' }}">{{ old('content_arabic', $page->content_arabic ?? '') }}</textarea>
    {!! $errors->first('content_arabic', '<p class="text-danger">:message</p>') !!}
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ $formMode === 'edit' ? __('admin-pages.update') : __('admin-pages.create') }}</button>
</div>
