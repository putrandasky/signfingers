@component('mail::message')
# Hai {{$data->name}}

You make a request for signing with data as below.

@component('mail::panel')
Document Name : {{$data->filename}} <br>
Signer : {{$data->signers[0]->name}} <br>
Message : {{$data->message}}
@endcomponent

Soon your signer will received your signing request and you will get an email soon after your document already signed.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
