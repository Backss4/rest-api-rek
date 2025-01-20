@extends('petstore.pet.layout')

@section('content')
@if(session('message'))
    <div class="flex flex-col p-2 gap-2 border border-indigo-500 mt-12">
        <h2 class="text-lg">{{ session('message') }}</h2>
    </div>
@endif
<div class="grid grid-cols-7 gap-4 p-2 justify-stretch justify-items-stretch border border-indigo-500 mt-12">
    <div class="md:col-span-5">
        <form id="search-form" name="search-form" method="POST" action="{{ route('pet.search') }}">
            @csrf
            <div>
                <label class="block text-sm/6 font-medium text-gray-900" for="search-id">ID</label>
                <div class="mt-2">
                    <input class="field" id="search-id" name="id" type="number" required>
                </div>
            </div>
            <div class="mt-2">
                <input type="submit" class="btn" value="Search">
            </div>
        </form>
    </div>
    <div class="flex justify-center justify-items-center items-center">
        <a href="{{ route('pet.create.pet') }}" class="btn">Create new pet</a>
    </div>
</div>
@endsection

@section('scripts')
    <script type="module">
        $(document).ready(function(){
            $("#search-id").on("keypress",function(event){
                if(event.which <= 48 || event.which >=57){
                    event.preventDefault();
                }
            });

            $('#search-id').on('paste', function (event) {
                if (event.originalEvent.clipboardData.getData('Text').match(/[^\d]/)) {
                    event.preventDefault();
                }
            });
        });
    </script>
@endsection
