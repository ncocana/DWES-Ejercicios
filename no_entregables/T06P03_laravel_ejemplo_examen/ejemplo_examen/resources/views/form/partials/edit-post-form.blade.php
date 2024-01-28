<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 pb-3">
            {{ __('Edit a publication') }}
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

    <form method="post" action="{{ route('posts.update', $post) }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        @include('form.partials.__post-form')

        <div class="flex items-center gap-4">
            <x-primary-button class="btn btn-primary">{{ __('Update') }}</x-primary-button>

            @if (session('status') === 'post-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Updated') }}</p>
            @endif
        </div>
    </form>
</section>
