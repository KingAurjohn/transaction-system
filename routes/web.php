<?php

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});
Route::get('/home',function(){
    return view('home');
})->name('home');

Route::middleware('adminauth')->post('/login',function(){
    return redirect()->route('enter_admin');
})->name('login'); 

Route::get('/admin/home',function(Request $request){
    return view('adminHome');
})->name('enter_admin');

Route::controller(AdminController::class)->group(function(){

    Route::get('/admin/fetch/pulledOut','fetch_pulledOut')->name('fetch_pulledOut');
    Route::get('/admin/fetch/data','fetch_transactions')->name('fetch_transactions');
    Route::get('/admin/add/transaction', 'add_transaction')->name('add_transaction');
    Route::post('/admin/pullout','pullout')->name('pullout');
    Route::post('/admin/delete1','delete1')->name('delete1');
    Route::post('/admin/delete2','delete2')->name('delete2');
});