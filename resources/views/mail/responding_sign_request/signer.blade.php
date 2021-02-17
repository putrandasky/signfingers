@component('mail::message')
# Hai {{$data->name}}

You already signed a document <strong>{{$data->requester->filename}}</strong> requested by <strong>{{$data->requester->name}}</strong>
<br>
Signed document attached within this email

Thank you,<br>
{{ config('app.name') }}
@endcomponent
