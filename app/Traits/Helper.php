<?php

namespace App\Traits;

use App\Models\State;
use App\Models\Customer;
use App\Models\ServiceType;

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

    public function getAllServiceTypes($vendorTypeid = null)
    {
        if (!empty($vendorTypeid)) {
            $service_types = ServiceType::where([
                'vendor_type_id' => $vendorTypeid,
                'status' => 'A',
            ])->orderBy('name', 'ASC')->get();
        } else {
            $service_types = ServiceType::where([
                'status' => 'A',
            ])->orderBy('name', 'ASC')->get();
        }
        return $service_types;
    }
}
