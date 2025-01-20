@extends('petstore.pet.layout')

@section('content')
    @if(session('message'))
        <div class="flex flex-col p-2 gap-2 border border-indigo-500 mt-12">
            <h2 class="text-lg">{{ session('message') }}</h2>
        </div>
    @endif
    <div class="flex flex-col p-2 gap-2 border border-indigo-500 mt-12">
        <div>
            <span>ID:</span>
            <span>{{ $pet->id }}</span>
        </div>
        <div>
            <span>Name:</span>
            <span>{{ $pet->name ?? 'not specified' }}</span>
        </div>
        <div>
            <span>Category:</span>
            @if(!is_null($pet->category))
                <ul class="list-disc list-inside pl-2">
                    <li>ID: {{ $pet->category->id }}</li>
                    <li>Name: {{ $pet->category->name ?? 'undefined category name' }}</li>
                </ul>
            @else
                <span>not defined</span>
            @endif
        </div>
        <div>
            <span>Photos:</span>
            @forelse ($pet->photoUrls as $photoUrl)
                <img src="{{$photoUrl}}">
                <p>{{$photoUrl}}</p>
            @empty
                <span>No images</span>
            @endforelse
        </div>
        <div>
            <span>Tags:</span>
            @if ($pet->tags->isEmpty())
                <span>No tags</span>
            @else
                <ul class="list-disc list-inside pl-2">
                    @foreach($pet->tags as $tag)
                        <li>ID: {{$tag->id}} | Name: {{ $tag->name ?? 'undefined tag name' }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
        <div>
            <span>Status:</span>
            <span>{{ $pet->status ?? 'unknown' }}</span>
        </div>
        <div class="flex justify-between mt-2">
            <a href="{{ route('pet.index') }}" class="btn flex-">Go home</a>
            <div>
                <a href="{{ route('pet.edit.pet', ['id' => $pet->id]) }}" class="btn flex-">Edit</a>
                <a href="{{ route('pet.edit.category', ['id' => $pet->id]) }}" class="btn flex-">Edit category</a>
                <form class="inline" action="{{ route('pet.delete', ['id' => $pet->id]) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn">Delete</button>
                </form>
                <a href="{{ route('pet.add.tag', ['id' => $pet->id]) }}" class="btn flex-">Add tag</a>
                <a href="{{ route('pet.remove.tag', ['id' => $pet->id]) }}" class="btn flex-">Remove tag</a>
                <a href="{{ route('pet.add.photo', ['id' => $pet->id]) }}" class="btn flex-">Add photo</a>
                <a href="{{ route('pet.remove.photo', ['id' => $pet->id]) }}" class="btn flex-">Remove photo</a>
            </div>
        </div>
    </div>
@endsection

