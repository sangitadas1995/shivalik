<?php

namespace App\Traits;

use App\Models\PaperSize;
use App\Models\PaperTypes;
use App\Models\PaperQuantityCalculation;

trait PaperTypeTrait
{
    public function getTypeDetailsById($id)
    {
        $type_details = PaperTypes::with('papercategory', 'papergsm', 'paperquality', 'papercolor', 'paperunit', 'papersize', 'paper_qty.unit_type')
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
        $packaging_details = PaperQuantityCalculation::with('unit_type')->where([
            'status' => 'A',
            'id' => $id
        ])
            ->first();

        return $packaging_details;
    }

    public function getNoOfSheetDetailsByUnitId($unitid)
    {
        $packaging_details = PaperQuantityCalculation::with('unit_type')->where([
            'status' => 'A',
            'measurement_type_unit' => $unitid
        ])
            ->first();
        return $packaging_details;
    }

    public function getAllPaperType()
    {
        $paper = PaperTypes::where([
            'status' => 'A'
        ])
            ->orderBy('id', 'desc')
            ->get();

        return $paper;
    }

    public function getPaperType_name($ids)
    {
        $paper_name = PaperTypes::with('unit_type')->whereIn('id', $ids)
            ->where(['status' => 'A'])
            ->orderBy('id', 'desc')
            ->get();

        return $paper_name;
    }

    public function getPaperNameById($id)
    {
        $paper_name = PaperTypes::with('unit_type')->where([
            'id' => $id
        ])
        ->first();

        return $paper_name;
    }

    public function getPaperStatusCheck($id)
    {
        $cnt = PaperTypes::where([
            'id' => $id,
            'status' => 'A'
        ])->count();
        return $cnt;
    }
}
