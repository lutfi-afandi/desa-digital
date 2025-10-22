<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\FamilyMemberController;
use App\Http\Controllers\HeadOfFamilyController;
use App\Http\Controllers\SocialAssistanceController;
use App\Http\Controllers\SocialAssistanceRecipientController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::get('/user/all/paginated', [UserController::class, 'getAllPaginated']);
Route::apiResource('user', UserController::class);

Route::get('/head-of-family/all/paginated', [HeadOfFamilyController::class, 'getAllPaginated']);
Route::apiResource('head-of-family', HeadOfFamilyController::class);

Route::get('/family-member/all/paginated', [FamilyMemberController::class, 'getAllPaginated']);
Route::apiResource('family-member', FamilyMemberController::class);

Route::get('/social-assistance/all/paginated', [SocialAssistanceController::class, 'getAllPaginated']);
Route::apiResource('social-assistance', SocialAssistanceController::class);

Route::get('/social-assistance-recipient/all/paginated', [SocialAssistanceRecipientController::class, 'getAllPaginated']);
Route::apiResource('social-assistance-recipient', SocialAssistanceRecipientController::class);

Route::get('/event/all/paginated', [EventController::class, 'getAllPaginated']);
Route::apiResource('event', EventController::class);
