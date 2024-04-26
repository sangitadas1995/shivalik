<?php

namespace App\Traits;

use App\Models\PaperSize;
use App\Models\PaperTypes;
use App\Models\PaperQuantityCalculation;

trait PaperTypeTrait
{
    public function getTypeDetailsById($id)
    {
        $type_details = PaperTypes::with('papercategory', 'papergsm', 'paperquality', 'papercolor', 'paperunit', 'papersize')
            ->where(['id' => $id])
            ->first();

        return $type_details;
    }

    // public function getPackagingDetailsById($id)
    // {
    //     $packaging_details = PaperQuantityCalculation::where([
    //         'status' => 'A',
    //         'id' => $id
    //     ])->first();

    //     return $packaging_details;
    // }


    public function getPackagingDetailsById($id)
    {
        $packaging_details = PaperQuantityCalculation::where([
            'status' => 'A',
            'id' => $id
        ])->first();

        return $packaging_details;
    }


}
