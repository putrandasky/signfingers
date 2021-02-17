@component('mail::message')
# Hai {{$data->signers[0]->name}},

You have a request for signing the document with data as below

@component('mail::panel')
Document Name : {{$data->filename}} <br>
Requester : {{$data->name}} <br>
Message : {{$data->message}}
@endcomponent

Please sign the document with click the button below.

@component('mail::button', ['url' => config('app.url').'/sign-request/sign-file/'.$data->signers[0]->token])
Sign Here
@endcomponent

Thank You,<br>
{{ config('app.name') }}
@endcomponent
