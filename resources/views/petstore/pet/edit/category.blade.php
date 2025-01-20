@extends('petstore.pet.layout')

@section('content')
    @if ($errors->any() || session('message'))
        <div class="flex flex-col p-2 gap-2 border border-indigo-500 mt-12">
            <h2 class="text-lg">{{ session('message') }}</h2>
            <ul class="list-disc list-inside pl-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="flex flex-col p-2 border border-indigo-500 mt-12">
        <form id="edit-pet-form" method="POST" name="edit-pet-form" action="{{ route('pet.edit.category', ['id' => $pet->id]) }}">
            @csrf
            <div>
                <label class="block text-sm/6 font-medium text-gray-900" for="id">ID <span class="text-red-700 ">*</span></label>
                <div class="mt-2">
                    <input class="field" id="id" name="id" type="number" value="{{ $pet->category?->id ?? '' }}" required>
                </div>
            </div>
            <div>
                <label class="block text-sm/6 font-medium text-gray-900" for="name">Name <span class="text-red-700 ">*</span></label>
                <div class="mt-2">
                    <input class="field" id="name" name="name" type="text" value="{{ $pet->category?->name ?? '' }}" required>
                </div>
            </div>
            <div class="flex justify-between mt-2">
                <a href="{{ route('pet.show', ['id' => $pet->id]) }}" class="btn">Go back to pet</a>
                <button type="submit" class="btn">Submit</button>
            </div>
        </form>
    </div>
@endsection

