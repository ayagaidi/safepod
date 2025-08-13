@extends('layouts.app')

@section('title', $category->name)

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold">{{ $category->name }}</h1>
    <p class="mt-4">{{ $category->description }}</p>
</div>
@endsection
