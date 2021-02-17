@component('mail::message')
# Hai {{$data->requester->name}}

Your Document <strong>{{$data->requester->filename}}</strong> has been signed by <strong>{{$data->name}}</strong>
<br>
Signed document attached within this email

Thank you,<br>
{{ config('app.name') }}
@endcomponent
