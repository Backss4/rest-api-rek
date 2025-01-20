@extends('petstore.pet.layout')

@section('content')
    <div class="flex flex-col p-4 gap-2 border border-indigo-500 mt-12">
        <h1 class="text-2xl">Error occurred</h1>
        <h2 class="text-lg">{{ $message }}</h2>
        <div class="flex">
            <a href="{{ route('pet.index') }}" class="btn grow">Go home</a>
        </div>
    </div>
@endsection
