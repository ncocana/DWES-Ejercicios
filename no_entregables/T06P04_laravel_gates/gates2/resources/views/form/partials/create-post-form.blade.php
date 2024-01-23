<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 pb-3">
            {{ __('Create a publication') }}
        </h2>
    </header>

    <!-- Display validation errors at the beginning of the form -->
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="post" action="{{ route('posts.store') }}" class="mt-6 space-y-6">
        @csrf

        <div class="form-group">
            <label for="title">{{ __('Title of the publication') }}</label>
            <input id="title" name="title" type="text" class="form-control" :value="old('title', $post->title)" placeholder="{{ __('Write here the title of the publication') }}" required autofocus autocomplete="title" >
            <x-input-error class="mt-2 alert alert-danger" :messages="$errors->get('title')" />
        </div>

        <div class="form-group">
            <label for="extract">{{ __('Extract publication') }}</label>
            <input id="extract" name="extract" type="text" class="form-control" :value="old('extract', $post->extract)" placeholder="{{ __('Write here a extract of the publication') }}" autofocus autocomplete="extract" >
            <x-input-error class="mt-2" :messages="$errors->get('extract')" />
        </div>

        <div class="form-group">
            <label for="content">{{ __('Content publication') }}</label>
            <textarea id="content" name="content" class="form-control" rows="10" :value="old('content', $post->content)" placeholder="{{ __('Write here the full content of the publication') }}" required autofocus autocomplete="content" ></textarea>
            <x-input-error class="mt-2" :messages="$errors->get('content')" />
        </div>
        
        <div class="form-check">
            <input type="hidden" name="expirable" value="0">
            <input class="form-check-input" type="checkbox" value="1" id="expirable" name="expirable" {{ old('expirable') ? 'checked' : '' }}>
            <label class="form-check-label" for="expirable">
                {{ __('Expirable') }}
            </label>
            <x-input-error class="mt-2" :messages="$errors->get('expirable')" />
        </div>

        <div class="form-check">
            <input type="hidden" name="commentable" value="0">
            <input class="form-check-input" type="checkbox" value="1" id="commentable" name="commentable" {{ old('commentable') ? 'checked' : '' }}>
            <label class="form-check-label" for="commentable">
                {{ __('Commentable') }}
            </label>
            <x-input-error class="mt-2" :messages="$errors->get('commentable')" />
        </div>

        <div class="form-group">
            <label for="access">{{ __('Access')}}</label>
            <select class="form-control" id="access" name="access">
                <option value="public" @if (old('access') === 'public') selected @endif>{{ __('Public') }}</option>
                <option value="private" @if (old('access') === 'private') selected @endif>{{ __('Private') }}</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('access')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="btn btn-primary">{{ __('Publish') }}</x-primary-button>

            @if (session('status') === 'post-created')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Published') }}</p>
            @endif
        </div>
    </form>
</section>
