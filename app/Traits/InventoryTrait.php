<?php

namespace App\Traits;

use App\Models\PaperTypes;
use App\Models\Warehouses;
use App\Models\Inventory;

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

    public function fetchUniquePaperTypes($warehouse_id)
    {
        $inventories = Inventory::where('warehouse_id',$warehouse_id)->get();
            foreach ($inventories as $inv) {
                $data[] = $inv->papertype_id;
        }

        $papertypes = PaperTypes::where('status','A')
        ->whereNotIn('id', $data)
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

    public function fetchUnits($paper_id)
    {
        $mesurementUnitId = PaperTypes::with('unit_type')->where('id',$paper_id)
        ->first();
        return $mesurementUnitId;
    }
}
