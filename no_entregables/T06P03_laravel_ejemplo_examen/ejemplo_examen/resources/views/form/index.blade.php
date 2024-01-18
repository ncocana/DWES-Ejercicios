@extends('adminlte.layout')

@section('title', 'Form')

@section('content')
    <div class="content-wrapper">
        <div class="content-header d-flex flex-row align-items-baseline">
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('posts-form.Posts') }}
            </h1>

            <p class="text-md text-gray-600 pl-2">
                {{ __("posts-form.Create publication") }}
            </p>
        </div>

        <section class="content pb-4">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="max-w-xl">
                            @include('form.partials.create-post-form')
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
            @foreach ($posts as $post)
                <div class="p-6 flex space-x-2">
                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-gray-800">{{ $post->user->name }}</span>
                                <small class="ml-2 text-sm text-gray-600">{{ $post->created_at->format('j M Y, g:i a') }}</small>
                            </div>
                        </div>
                        <p class="mt-4 text-lg text-gray-900">{{ $post->title }}</p>
                        <p class="mt-4 text-lg text-gray-900">{{ $post->extract }}</p>
                        <p class="mt-4 text-lg text-gray-900">{!! nl2br(e($post->content)) !!}</p>
                        <p class="mt-4 text-lg text-gray-900">{{ $post->expirable ? 'Expirable' : 'Not Expirable' }}</p>
                        <p class="mt-4 text-lg text-gray-900">{{ $post->commentable ? 'Commentable' : 'Not Commentable' }}</p>
                        <p class="mt-4 text-lg text-gray-900">{{ $post->access }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
