<form action="{{ route('language.switch') }}" method="POST" class="inline-block">
    @csrf
    <select name="language" onchange="this.form.submit()" class="rounded bg-gray-100 text-gray-800">
        <option value="en" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>{{ __('English') }}</option>
        <option value="es" {{ app()->getLocale() === 'es' ? 'selected' : '' }}>{{ __('Spanish') }}</option>
    </select>
</form>