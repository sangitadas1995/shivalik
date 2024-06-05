<?php

namespace App\Traits;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\Customer;
use App\Models\PaperTypes;
use App\Models\ServiceType;
use App\Models\User;

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


    public function getAllUsers()
    {
        $users = User::where([
            'status' => 'A',
        ])->orderBy('name', 'ASC')->get();

        return $users;
    }

    public function convertData($body_content) {
       $body_content = trim($body_content);
       $body_content = stripslashes($body_content);
       $body_content = htmlspecialchars($body_content);
       return $body_content;
    }



    public function numberToWords(float $number)
    {
        $number_after_decimal = round($number - ($num = floor($number)), 2) * 100;

        // Check if there is any number after decimal
        $amt_hundred = null;
        $count_length = strlen($num);
        $x = 0;
        $string = array();
        $change_words = array(
            0 => 'Zero', 1 => 'One', 2 => 'Two',
            3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
            7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
            10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
            13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
            16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
            19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
            40 => 'Fourty', 50 => 'Fifty', 60 => 'Sixty',
            70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
        );
        $here_digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
        while ($x < $count_length) {
            $get_divider = ($x == 2) ? 10 : 100;
            $number = floor($num % $get_divider);
            $num = floor($num / $get_divider);
            $x += $get_divider == 10 ? 1 : 2;
            if ($number) {
                $add_plural = (($counter = count($string)) && $number > 9) ? 's' : null;
                $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
                $string[] = ($number < 21) ? $change_words[$number] . ' ' . $here_digits[$counter] . $add_plural . '
           ' . $amt_hundred : $change_words[floor($number / 10) * 10] . ' ' . $change_words[$number % 10] . '
           ' . $here_digits[$counter] . $add_plural . ' ' . $amt_hundred;
            } else $string[] = null;
        }
        $implode_to_Words = implode('', array_reverse($string));
        $get_word_after_point = ($number_after_decimal > 0) ? "Point " . ($change_words[$number_after_decimal / 10] . "
            " . $change_words[$number_after_decimal % 10]) : '';
        return ($implode_to_Words ? $implode_to_Words . " Only" : ' ');
    }

}
