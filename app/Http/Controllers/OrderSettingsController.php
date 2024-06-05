<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OrderSettingsController extends Controller
{
    public function index()
    {
        return view('ordersettings.product.index');
    }
}
