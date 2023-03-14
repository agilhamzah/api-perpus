<?php

use Illuminate\Http\Request;
use App\Http\Controllers\BukuC;
use App\Http\Controllers\UsersC;
use App\Http\Controllers\PeminjamanC;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;

route::get('/about', function(){
    return 'kasih dan agil !';
});

Route::apiResource('/peminjaman', PeminjamanC::class);
Route::apiResource('/buku', BukuC::class);
Route::apiResource('/users', UsersC::class);