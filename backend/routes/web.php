<?php


use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;


// Route::post('/login' , [AuthController::class , 'login'])->name("login");
// Route::post('/signup', [AuthController::class, 'signup'])->name('signup');

// Route::get('/sanctum/csrf-cookie', function () {
//     return response()->json(['message' => 'CSRF cookie set']);
// })->middleware('web');


Route::get('/test', function() {
    return response()->json(['message' => 'Test successful']);
    echo "hello";
});

Route::get('/', function () {
    return view('welcome');
});
Route::get('/db-test', function () {
    try {
        DB::connection()->getPdo();
        return 'Database connection is working!';
    } catch (\Exception $e) {
        return 'Could not connect to the database. Please check your configuration.';
    }
});

Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');
