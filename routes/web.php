<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthorController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
    // return DB::table('sach')->get();
})->name('home');


Route::group(['prefix' => 'sach'], function () {
    Route::get('', [HomeController::class, 'index']);
    Route::post('themmoi', [HomeController::class, 'store'])->name('routeThemSach');
    Route::get('xoasach', [HomeController::class, 'destroy']);
    Route::get('laysach', [HomeController::class, 'show']);
    Route::post('suasach', [HomeController::class, 'edit']);
});
Route::get('tacgia/{id}',[AuthorController::class,'showAuthor']); 
// use qlsach;
// CREATE TABLE THELOAI(
// 	Id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
//     TenTheLoai VARCHAR(30)
// );

// CREATE TABLE TACGIA(
// 	Id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
//     TenTacGia VARCHAR(30),
//     NamSinh VARCHAR(30)
// );

// CREATE TABLE SACH(
// 	Id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
//   	TenSach VARCHAR(30),
//     NamXb VARCHAR(30),
//     MoTa VARCHAR(30),
//     Anh VARCHAR(30),
//     SoLuong INT,
//     IdTacGia INT NOT NULL,
//     IdTheLoai INT NOT NULL,
//     FOREIGN KEY (IdTacGia) REFERENCES TACGIA(Id),
//     FOREIGN KEY (IdTheLoai) REFERENCES THELOAI(Id)
// );