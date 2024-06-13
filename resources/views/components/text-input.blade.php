@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' =>
        'border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-lime-600 focus:ring-lime-400 rounded-md shadow-sm',
]) !!}>
