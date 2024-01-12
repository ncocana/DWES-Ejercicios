<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 pb-3">
            {{ __('Create a publication') }}
        </h2>
    </header>

    <form method="post" action="" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="form-group">
            <label for="title">{{ __('Title of the publication') }}</label>
            <input id="title" name="title" type="text" class="form-control" placeholder="{{ __('Write here the title of the publication') }}" required autofocus autocomplete="title" >
            <x-input-error class="mt-2" :messages="$errors->get('title')" />
        </div>

        <div class="form-group">
            <label for="extract">{{ __('Extract publication') }}</label>
            <input id="extract" name="extract" type="text" class="form-control" placeholder="{{ __('Write here a extract of the publication') }}" required autofocus autocomplete="extract" >
            <x-input-error class="mt-2" :messages="$errors->get('extract')" />
        </div>

        <div class="form-group">
            <label for="content">{{ __('Content publication') }}</label>
            <textarea id="content" name="content" class="form-control" rows="10" placeholder="{{ __('Write here the full content of the publication') }}" required autofocus autocomplete="content" ></textarea>
            <x-input-error class="mt-2" :messages="$errors->get('content')" />
        </div>
        
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="true" id="expirable" name="expirable">
            <label class="form-check-label" for="status1">
                {{ __('Expirable') }}
            </label>
            <br>
            <input class="form-check-input" type="checkbox" value="true" id="commentable" name="commentable">
            <label class="form-check-label" for="status2">
                {{ __('Commentable') }}
            </label>
        </div>

        <div class="form-group">
            <label for="access">{{ __('Access')}}</label>
            <select class="form-control" id="access">
                <option value="public">{{ __('Public') }}</option>
                <option value="private">{{ __('Private') }}</option>
            </select>
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
