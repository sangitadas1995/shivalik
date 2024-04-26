<?php

namespace App\Traits;
use App\Models\PaperunitMeasument;
use App\Models\PaperQuantityCalculation;

trait QuantityCalculationTrait
{
    public function fetchUnitMeasure()
    {
        $units_measure = PaperunitMeasument::where([
            'status' => 'A'
        ])
            ->orderBy('measurement_unuit', 'asc')
            ->get();
        return $units_measure;

    }

    public function fetchPackagingTitle()
    {
        $title = PaperQuantityCalculation::where([
            'status' => 'A'
        ])
            ->orderBy('id', 'desc')
            ->get();
        return $title;
    }

    

  
}
