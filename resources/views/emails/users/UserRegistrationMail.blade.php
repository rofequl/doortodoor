@component('mail::message')
# New Merchant registration email

Message from {{basic_information()->company_name}} <br>

Hello sir, <br>
One new merchant has been registered right now. Here are the details <br> <br>

Merchant Name: {{$user->first_name}} {{$user->last_name}}<br>
Merchant Phone No: {{$user->phone}}<br>
Merchant Email address: {{$user->email}}<br><br>



Thanks,<br>
{{ config('app.name') }}
@endcomponent
