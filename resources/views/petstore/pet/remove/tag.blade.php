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
        @if($pet->tags->isEmpty())
            <div>
                <h2 class="text-lg">No tags found.</h2>
                <div class="flex">
                    <a href="{{ route('pet.show', ['id' => $pet->id]) }}" class="btn grow">Go back to pet</a>
                </div>
            </div>
        @else
        <form id="remove-tag-form" name="remove-tag-form" method="POST" action="{{ route('pet.remove.tag', ['id' => $pet->id]) }}">
            @csrf
            <div>
                <label class="block text-sm/6 font-medium text-gray-900" for="tag_id">Tag <span class="text-red-700 ">*</span></label>
                <div class="mt-2">
                    <select class="field" id="tag_id" name="tag_id">
                        @foreach($pet->tags as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->name ?? 'undefined tag name' }}</option>
                        @endforeach
                    </select>

                </div>
            </div>
            <div class="flex justify-between mt-2">
                <a href="{{ route('pet.show', ['id' => $pet->id]) }}" class="btn">Go back to pet</a>
                <button type="submit" class="btn">Remove</button>
            </div>
        </form>
        @endif
    </div>
@endsection

