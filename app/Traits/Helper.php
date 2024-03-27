<?php

namespace App\Traits;

use App\Models\State;
use App\Models\Customer;

trait Helper
{
    public function getAllStates($id = null)
    {
        if (!empty($id)) {
            $states = State::where([
                'country_id' => $id,
                'status' => 'A',
            ])->orderBy('state_name', 'ASC')->get();
        } else {
            $states = State::where([
                'status' => 'A',
            ])->orderBy('state_name', 'ASC')->get();
        }
        return $states;
    }
}
