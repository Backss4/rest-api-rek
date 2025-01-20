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
        <form id="edit-pet-form" method="POST" name="edit-pet-form" action="{{ route('pet.edit.pet', ['id' => $pet->id]) }}">
            @csrf
            <div>
                <label class="block text-sm/6 font-medium text-gray-900" for="name">Name <span class="text-red-700 ">*</span></label>
                <div class="mt-2">
                    <input class="field" id="name" name="name" type="text" value="{{ $pet->name }}" required>
                </div>
            </div>
            <div>
                <label class="block text-sm/6 font-medium text-gray-900" for="status">Status <span class="text-red-700 ">*</span></label>
                <div class="mt-2">
                    <select class="field" id="status" name="status">
                        @foreach($statuses as $status)
                            @if($pet->status === $status)
                                <option value="{{ $status->value }}" selected>{{ $status->value }}</option>
                            @else
                                <option value="{{ $status->value }}">{{ $status->value }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="flex justify-between mt-2">
                <a href="{{ route('pet.show', ['id' => $pet->id]) }}" class="btn">Go back to pet</a>
                <button type="submit" class="btn">Submit</button>
            </div>
        </form>
    </div>
@endsection

