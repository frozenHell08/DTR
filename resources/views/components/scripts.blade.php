@secure
<script src="{{ secure_asset('res/particles.js-master/particles.js') }}"></script>
@else
<script src="{{ asset('res/particles.js-master/particles.js') }}"></script>
@endsecure

{{ $slot }}

<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>