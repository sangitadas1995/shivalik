<?php

namespace App\Traits;
use App\Models\PaperunitMeasument;

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

    

  
}
