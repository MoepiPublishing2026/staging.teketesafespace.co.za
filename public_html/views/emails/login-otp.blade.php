@component('mail::message')
# Your One-Time Password

Your one-time password for login is: **{{ $otp }}**

This code is valid for 5 minutes. Do not share it with anyone.

Thanks,
{{ config('app.name') }}
@endcomponent
