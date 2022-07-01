@component('mail::message')
# Merchant registration verification code

Welcome to {{basic_information()->company_name}}.<br>
Your account verification code is: <b>{{$code}}</b> <br><br>
Please click the link below and access your account at <b>{{basic_information()->company_name}}</b><br><br>
<a href="/{{basic_information()->website_link}}/verify">Click here to activate your link</a> <br><br><br>
Thanks,<br>
{{basic_information()->company_name}}
@endcomponent

<script>
	window.history.back();
</script>