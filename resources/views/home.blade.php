@extends('layouts.default')

@section('title', 'Головна')

@section('content')
    <section class="text-center mb-10">
        <h1 class="text-3xl font-bold mb-2">Словник жестової мови</h1>
    </section>

    <section>
        <h2 class="text-xl font-semibold mb-4">Останні додані жести:</h2>

        <div class="grid gap-6 md:grid-cols-3">
            <p class="text-gray-500">Нема :(</p>
        </div>
    </section>
@endsection
