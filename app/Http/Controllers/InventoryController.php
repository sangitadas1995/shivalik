<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\City;
use App\Models\State;
use App\Models\Country;
use App\Traits\Validate;
use App\Traits\Helper;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
	use Validate, Helper;
    public function index()
    {
        return view('inventory.index');
    }

    public function create()
    {
    	$countries = Country::where([
            'status' => 'A'
        ])
            ->orderBy('country_name', 'asc')
            ->get();

        $states = $this->getAllStates(101);

        return view('inventory.warehouse.create', [
            'countries' => $countries,
            'states' => $states
        ]);
    }
}
