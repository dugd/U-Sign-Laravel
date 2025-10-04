@extends('layouts.default')

@section('title', 'Головна')

@section('content')
    <h1 class="font-bold text-black">Welcome to USign!</h1>
    <p class="my-1">{{$welcome ?? "bimbim."}}</p>
@endsection
