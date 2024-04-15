<?php

namespace App\Traits;

use App\Models\PaperSize;
use App\Models\PaperTypes;

trait PaperTypeTrait
{
    public function getTypeDetailsById($id)
    {
        $type_details = PaperTypes::with('papercategory', 'papergsm', 'paperquality', 'papercolor', 'paperunit', 'papersize')
            ->where(['id' => $id])
            ->first();

        return $type_details;
    }
}
