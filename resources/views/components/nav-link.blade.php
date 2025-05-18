@props(['href', 'active' => false])

<a href="{{ $href }}" {{ $attributes->class([
    'text-white px-4 py-2 rounded-md block hover:bg-blue-700 transition',
    'bg-blue-900' => $active
]) }}>
    {{ $slot }}
</a>