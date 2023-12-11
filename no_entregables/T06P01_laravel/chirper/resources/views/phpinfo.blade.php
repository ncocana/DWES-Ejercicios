@if(env('EMAIL_ADMIN') === auth()->user()->email)
    {{phpinfo()}}
@else
    {{"Acceso prohibido."}}
@endif
