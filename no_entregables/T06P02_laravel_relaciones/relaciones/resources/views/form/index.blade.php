@extends('adminlte.layout')

@section('title', 'Form')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Form') }}
            </h2>
            @include('components.language-switch')
        </div>

        <section class="content">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="max-w-xl">
                            @include('form.partials.update-profile-information-form')
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
