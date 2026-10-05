@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' =>
        'w-full border-gray-300 focus:border-[#0da3d8] focus:ring-[#0da3d8] rounded-lg shadow-sm transition duration-150 ease-in-out',
]) !!}>
