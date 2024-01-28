@extends('adminlte.layout')

@section('title', 'Form')

@section('content')
    <div class="content-wrapper">
        <div class="content-header d-flex flex-row align-items-baseline">
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('posts-form.Posts') }}
            </h1>

            <p class="text-md text-gray-600 pl-2">
                {{ __("posts-form.Edit publication") }}
            </p>
        </div>

        <section class="content">
            <div class="py-6">
                <div class="max-w-auto mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="max-w-auto">
                            @include('form.partials.edit-post-form')
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
