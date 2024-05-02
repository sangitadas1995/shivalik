<?php

namespace App\Traits;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\Customer;
use App\Models\PaperTypes;
use App\Models\ServiceType;

trait Helper
{
    public function getAllCountries($id = null)
    {
        if (!empty($id)) {
            $states = Country::where([
                'id' => $id,
                'status' => 'A',
            ])->orderBy('country_name', 'ASC')->get();
        } else {
            $states = Country::where([
                'status' => 'A',
            ])->orderBy('country_name', 'ASC')->get();
        }
        return $states;
    }

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

    public function getAllCitiesByState($id = null)
    {
        if (!empty($id)) {
            $states = City::where([
                'state_id' => $id,
                'status' => 'A',
            ])->orderBy('city_name', 'ASC')->get();
        } else {
            $states = City::where([
                'status' => 'A',
            ])->orderBy('city_name', 'ASC')->get();
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

    public function getAllPaperTypes($vendorTypeid = null)
    {
        if (!empty($vendorTypeid)) {
            $service_types = PaperTypes::where([
                'id' => $vendorTypeid,
                'status' => 'A',
            ])->orderBy('paper_name', 'ASC')->get();
        } else {
            $service_types = PaperTypes::where([
                'status' => 'A',
            ])->orderBy('paper_name', 'ASC')->get();
        }
        return $service_types;
    }

    public function getAllPaperTypesExceptGivenIds($vendorTypeid = null, $ids = null)
    {
        if (!empty($vendorTypeid)) {
            $service_types = PaperTypes::where([
                'id' => $vendorTypeid,
                'status' => 'A',
            ])
                ->whereNotIn('id', $ids)
                ->orderBy('paper_name', 'ASC')->get();
        } else {
            $service_types = PaperTypes::where([
                'status' => 'A',
            ])
                ->whereNotIn('id', $ids)
                ->orderBy('paper_name', 'ASC')->get();
        }
        return $service_types;
    }
}
