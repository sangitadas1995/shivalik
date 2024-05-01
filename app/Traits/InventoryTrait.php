<?php

namespace App\Traits;

use App\Models\PaperTypes;
use App\Models\Warehouses;

trait InventoryTrait
{
    public function fetchPaperTypes()
    {
        $papertypes = PaperTypes::where([
            'status' => 'A'
        ])
            ->orderBy('id', 'desc')
            ->get();
        return $papertypes;

    }

    public function fetchWarehouse()
    {
        $warehouses = Warehouses::where([
            'status' => 'A'
        ])
            ->orderBy('id', 'desc')
            ->get();
        return $warehouses;

    }

    public function fetchWarehouseById($id)
    {
        $one_warehouse = Warehouses::where([
            'status' => 'A',
            'id' => $id
        ])
        ->first();
        return $one_warehouse;

    }
}
