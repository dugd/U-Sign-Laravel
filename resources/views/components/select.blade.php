@props([
    'id',
    'name',
    'label' => null,
    'value' => null,
    'options' => [],
    'placeholder' => null,
    'error' => null,
])

<div>
    @if($label)
        <x-input-label :for="$id" :value="$label" />
    @endif

    <select
        id="{{ $id }}"
        name="{{ $name }}"
        {{ $attributes->merge(['class' => 'mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500']) }}
    >
        @if($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif

        @foreach($options as $optValue => $optLabel)
            <option value="{{ $optValue }}" @selected($value == $optValue)>
                {{ $optLabel }}
            </option>
        @endforeach
    </select>

    @if($error)
        <x-input-error :messages="$error" class="mt-2" />
    @endif
</div>
