<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function papertype(){
        return view('settings.paper-type');
    }

    public function printingProductType(){
        return view('settings.printing-product-type-list');
    }

    public function addPrintingProductType(){
        return view('settings.create-printing-product-type');
    }
}
