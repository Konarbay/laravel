<?php
use App\Http\Controllers\FileUploadController;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/', function () {
    return view('upload');
});

Route::post('/upload', [FileUploadController::class, 'upload']);
Route::post('/upload', [FileUploadController::class, 'upload'])->name('file.upload');
