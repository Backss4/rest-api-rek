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
        <form id="add-tag-form" method="POST" name="add-tag-form" action="{{ route('pet.add.tag', ['id' => $pet->id]) }}">
            @csrf
            <div>
                <label class="block text-sm/6 font-medium text-gray-900" for="name">Name <span class="text-red-700 ">*</span></label>
                <div class="mt-2">
                    <input class="field" id="name" name="name" type="text" required>
                </div>
            </div>
            <div class="flex justify-between mt-2">
                <a href="{{ route('pet.show', ['id' => $pet->id]) }}" class="btn flex-">Go to pet</a>
                <button type="submit" class="btn">Add tag</button>
            </div>
        </form>
    </div>
@endsection

