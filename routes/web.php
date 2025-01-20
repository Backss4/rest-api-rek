<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Petstore\Pet;

Route::name('pet.')->group(function() {
    Route::get('/', [Pet::class, 'index'])->name('index');
    Route::post('/', [Pet::class, 'search'])->name('search');
    Route::get('/{id}', [Pet::class, 'show'])->name('show')->whereNumber('id');

    Route::name('create.')->group(function() {
        Route::get('/create', [Pet::class, 'create'])->name('pet');
        Route::post('/create', [Pet::class, 'store']);
    });


    Route::name('edit.')->prefix('/edit/{id}')->group(function() {
        Route::get('/', [Pet::class, 'edit'])->name('pet');
        Route::post('/', [Pet::class, 'update']);

        Route::get('/category', [Pet::class, 'editCategory'])->name('category');
        Route::post('/category', [Pet::class, 'updateCategory']);
    })->whereNumber('id');

    Route::name('remove.')->prefix('/remove/{id}')->group(function() {
        Route::get('/tag', [Pet::class, 'removeTag'])->name('tag')->whereNumber('id');
        Route::post('/tag', [Pet::class, 'destroyTag'])->whereNumber('id');

        Route::get('/photo', [Pet::class, 'removePhoto'])->name('photo')->whereNumber('id');
        Route::post('/photo', [Pet::class, 'destroyPhoto'])->whereNumber('id');
    })->whereNumber('id');

    Route::name('add.')->prefix('/add/{id}')->group(function() {
        Route::get('/tag', [Pet::class, 'addTag'])->name('tag')->whereNumber('id');
        Route::post('/tag', [Pet::class, 'storeTag'])->whereNumber('id');

        Route::get('/photo', [Pet::class, 'addPhoto'])->name('photo')->whereNumber('id');
        Route::post('/photo', [Pet::class, 'storePhoto'])->whereNumber('id');
    })->whereNumber('id');

    Route::post('/delete/{id}', [Pet::class, 'destroy'])->name('delete')->whereNumber('id');
});

