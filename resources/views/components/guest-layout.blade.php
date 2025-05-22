{{-- resources/views/components/guest-layout.blade.php --}}
@props(['title' => null])

{{-- Gunakan layout guest.blade.php --}}
<x-layouts.guest>
    {{ $slot }}
</x-layouts.guest>
