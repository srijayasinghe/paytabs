<?php

include_once(__DIR__."/Route.php");


Route::add("/home","HomeController@indexAction");
// Order Routs
Route::add("/myorder","OrderController@myorderAction");
Route::add("/orderdetails","OrderController@orderDetailsAction");
Route::add("/createorder","OrderController@createOrderAction");
Route::add("/paymentsuccess","OrderController@paymentSuccessAction");
Route::add("/ajaxdetails","OrderController@ajaxDetailsAction");
Route::add("/ajaxorderinfo","OrderController@ajaxOrderDetailsAction");
Route::add("/ajaxproductinfo","OrderController@ajaxProductInfoAction");
Route::add("/ajaxcreateorder","OrderController@ajaxCreateOrderAction");



Route::add("/ajaxcartinfo","CartController@ajaxCartInfoAction");
Route::add("/ajaxaddtocart","CartController@ajaxAddItemsToCartAction");
Route::add("/checkout","CartController@checkoutAction");



Route::add("/cart","CartController@indexAction");
$route = Route::run();
