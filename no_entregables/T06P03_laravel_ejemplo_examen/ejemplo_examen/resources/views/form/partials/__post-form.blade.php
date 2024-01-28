<div class="form-group">
    <label for="title">{{ __('Title of the publication') }}</label>
    <input id="title" name="title" type="text" class="form-control" value="{{ old('title', $post->title ?? '') }}" placeholder="{{ __('Write here the title of the publication') }}" required autofocus autocomplete="title" >
    <x-input-error class="mt-2 alert alert-danger" :messages="$errors->get('title')" />
</div>

<div class="form-group">
    <label for="extract">{{ __('Extract publication') }}</label>
    <input id="extract" name="extract" type="text" class="form-control" value="{{ old('extract', $post->extract ?? '') }}" placeholder="{{ __('Write here a extract of the publication') }}" autofocus autocomplete="extract" >
    <x-input-error class="mt-2" :messages="$errors->get('extract')" />
</div>

<div class="form-group">
    <label for="content">{{ __('Content publication') }}</label>
    <textarea id="content" name="content" class="form-control" rows="10" placeholder="{{ __('Write here the full content of the publication') }}" required autofocus autocomplete="content" >{{ old('content', $post->content ?? '') }}</textarea>
    <x-input-error class="mt-2" :messages="$errors->get('content')" />
</div>

<div class="form-check">
    <input type="hidden" name="expirable" value="0">
    <input class="form-check-input" type="checkbox" value="1" id="expirable" name="expirable" {{ old('expirable', $post->expirable ?? '') ? 'checked' : '' }}>
    <label class="form-check-label" for="expirable">
        {{ __('Expirable') }}
    </label>
    <x-input-error class="mt-2" :messages="$errors->get('expirable')" />
</div>

<div class="form-check">
    <input type="hidden" name="commentable" value="0">
    <input class="form-check-input" type="checkbox" value="1" id="commentable" name="commentable" {{ old('commentable', $post->commentable ?? '') ? 'checked' : '' }}>
    <label class="form-check-label" for="commentable">
        {{ __('Commentable') }}
    </label>
    <x-input-error class="mt-2" :messages="$errors->get('commentable')" />
</div>

<div class="form-group">
    <label for="access">{{ __('Access')}}</label>
    <select class="form-control" id="access" name="access">
        <option value="public" @if (old('access', $post->access ?? '') === 'public') selected @endif>{{ __('Public') }}</option>
        <option value="private" @if (old('access', $post->access ?? '') === 'private') selected @endif>{{ __('Private') }}</option>
    </select>
    <x-input-error class="mt-2" :messages="$errors->get('access')" />
</div>