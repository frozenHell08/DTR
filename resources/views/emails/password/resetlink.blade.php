<x-mail::message>
Hello {{ $user->firstName }},

You forgot. Here's the otp. 

<!-- <x-mail::button :url="''">
Reset Password
</x-mail::button> -->

{{ $otp }}

If you did not lose or forgot your password, feel free to ignore this email.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
