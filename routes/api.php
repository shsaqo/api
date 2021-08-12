<?php

use App\Http\Controllers\DescriptionOneController;
use App\Http\Controllers\SpecialOfferController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\CodeController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:api']], function () {
    //admin
    Route::put('change-user', [AuthController::class, 'changeUser']);
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    //domain
    Route::apiResource('domain', DomainController::class);

    //product
    Route::apiResource('product', ProductController::class);

    //order by slider
    Route::post('slider-order', [SliderController::class, 'orderBy']);

    //product status
    Route::put('product-status/{id}', [ProductController::class, 'status']);

    //slider delete
    Route::post('slider-delete', [SliderController::class, 'destroy']);

    //slider add
    Route::post('slider-add/{id}', [SliderController::class, 'store']);

    //product description one
    Route::apiResource('product-description-one', DescriptionOneController::class);

    //description one add
    Route::post('description-one-add', [DescriptionOneController::class, 'descriptionOneAdd']);

    //get Select Domain Url
    Route::get('select-domain-url', [IndexController::class, 'getSelectDomainUrl']);

    //Special Offer
    Route::apiResource('special-offer', SpecialOfferController::class);

    //User info
    Route::get('user-info', [AuthController::class, 'userInfo']);
    Route::get('all-user', [AuthController::class, 'getAllUser']);

    Route::group(['middleware' => 'isAdmin'], function () {
        //Invitation
        Route::post('invitation', [AuthController::class, 'invitation']);

        //Change permissions
        Route::put('change-permission', [AuthController::class, 'changePermission']);

        //Delete user
        Route::delete('delete-user/{id}', [AuthController::class, 'deleteUser']);

        //Code Script
        Route::apiResource('code', CodeController::class);

        //Color
        Route::post('color', [ColorController::class, 'store']);
        Route::delete('color/{color}', [ColorController::class, 'delete']);
        Route::get('color', [ColorController::class, 'index']);
    });
});

// Login
Route::post('login', [AuthController::class, 'login'])->name('login');

//Register admin
Route::post('register-admin-invitation', [AuthController::class, 'registerAdminInvitation']);

//Url register template
Route::get('register-invitation', [AuthController::class, 'registerInvitation']);

//Special offer
Route::get('get-special-offer', [IndexController::class, 'GetSpecialOffer']);

//images
Route::get('images/{file}', [IndexController::class, 'getImage']);

//Get code for front
Route::get('code-front', [CodeController::class, 'frontIndex']);

//Get product for url
Route::get('/{url}', [IndexController::class, 'indexUrl']);







//If not route 404 response
Route::fallback(function(){
    return \App\Http\Traits\ResponseJson::response([], 404, 'not found');
});
