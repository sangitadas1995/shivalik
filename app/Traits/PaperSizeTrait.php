<?php

namespace App\Traits;

use App\Models\PaperSize;

trait PaperSizeTrait
{
    public function getActiveSizes()
    {
        $paperSizes = PaperSize::where([
            'status' => 'A'
        ])
            ->orderBy('created_at', 'desc')
            ->get();

        return $paperSizes;
    }

    public function getSizeDetailsById($id)
    {
        $size_details = PaperSize::with('paperunit')->where([
            'status' => 'A',
            'id' => $id
        ])->first();

        return $size_details;
    }
}
