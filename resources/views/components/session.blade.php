@if (session()->has('success'))
<div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" class="session">
    <p>{{ session('success') }}</p>
</div>
@endif

@if (session()->has('status'))
<div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" class="session">
    <p>{{ session('status') }}</p>
</div>
@endif