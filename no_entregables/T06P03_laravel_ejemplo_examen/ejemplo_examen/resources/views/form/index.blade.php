@extends('adminlte.layout')

@section('title', 'Form')

@section('content')
    <div class="content-wrapper">
        <div class="content-header d-flex flex-row align-items-baseline">
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('posts-form.Posts') }}
            </h1>

            <p class="text-md text-gray-600 pl-2">
                {{ __("posts-form.Your publications") }}
            </p>
        </div>
        
        <a href="{{ route('posts.create') }}" >
            <button class="btn btn-primary">{{ __('Create publication') }}</button>
        </a>

        @include('form.partials.show-posts')
    </div>
@endsection
