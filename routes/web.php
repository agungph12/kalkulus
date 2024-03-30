<?php

use App\Http\Controllers\Calculator\CalculatorController;
use Illuminate\Support\Facades\Route;

Route::resource('/', CalculatorController::class);
