@props([
    'id',
    'name',
    'checked' => false,
    'label' => null,
])

<div {{ $attributes->merge(['class' => 'flex items-center gap-2']) }}>
    <input
        id="{{ $id }}"
        name="{{ $name }}"
        type="checkbox"
        value="1"
        @checked($checked)
        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
    >
    @if($label)
        <x-input-label for="{{ $id }}" :value="$label" class="!text-sm text-gray-700" />
    @endif
</div>
