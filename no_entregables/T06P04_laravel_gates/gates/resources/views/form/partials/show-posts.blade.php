@foreach ($posts as $post)
<section class="content pb-4">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <div class="p-6 flex space-x-2">
                        <div class="flex-1">
                            <article>
                                <!-- Post header-->
                                <header class="mb-4">
                                    <!-- Post title-->
                                    <h1 class="fw-bolder mb-1">{{ $post->title }}</h1>
                                    <!-- Post meta content-->
                                    <div class="text-muted fst-italic mb-2">{{ __('Posted on')}} {{ $post->created_at->translatedFormat(__('posts-form.date_format')) }} {{ __('by') }} {{ $post->user->name }}</div>
                                    <!-- Post extract-->
                                    <p class="text-md text-muted font-weight-bold">{{ $post->extract }}</p>
                                </header>
                                <!-- Post content-->
                                <section>
                                    <p class="fs-5">{!! nl2br(e($post->content)) !!}</p>
                                </section>
                            </article>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endforeach