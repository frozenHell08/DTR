<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>{{ config('app.name') }}</title>

<link rel="icon" href="{{ asset('res/P.png') }}">
<link rel="stylesheet" href="/src/base.css">

{{ $slot }}

@secure
<link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
@else
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
@endsecure


<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js"></script>
</head>