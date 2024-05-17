<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\Auth\LoginController;
use App\Http\Controllers\User\Auth\RegisterController;
use App\Http\Controllers\User\BudgetController;
use App\Http\Controllers\User\BudgetPlanController;
use App\Http\Controllers\User\CategoryController;
use App\Http\Controllers\User\ExpenseController;
use App\Http\Controllers\User\HomeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [RegisterController::class, 'store']);
Route::post('/login', [LoginController::class, 'store']);

Route::middleware(['auth:sanctum', 'role:user'])->group(function(){
    Route::get('/loaduser', function(){
        $user = Auth::user();

        return response([
            'user' => $user
        ], 200);
    });
    Route::get('/logout', function(Request $request){
        $request->user()->tokens()->delete();

        return response([
            'message' => 'Logout Success'
        ]);
    });

    Route::get('/home', [HomeController::class, 'index']);



    Route::resource('budgets', BudgetController::class)->except(['create', 'edit']);
    Route::resource('expenses', ExpenseController::class)->except(['create', 'edit']);
    Route::resource('categories', CategoryController::class)->except(['create', 'edit']);
    Route::resource('budget-plan', BudgetPlanController::class)->except(['create', 'edit']);
});
