@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'p-3 rounded-lg bg-green-50 text-green-700 border border-green-200']) }}>
        {{ $status }}
    </div>
@endif
