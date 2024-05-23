<?php

namespace App\Traits;

use App\Models\PaperTypes;
use App\Models\Warehouses;
use App\Models\Inventory;
use App\Models\InventoryDetails;

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
        $data = array();
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

    public function fetchInventortDetails($id)
    {
        $invDetails = InventoryDetails::where('inventory_id',$id)
        ->OrderBy('id','desc')
        ->offset(0)
        ->limit(1)
        ->first();
        return $invDetails;
    }

    public function fetchInventoriesById($id)
    {
        $inventories = Inventory::with('paper_type')->where([
            'id' => $id
        ])
        ->first();
        return $inventories;
    }

    public function fetchInventoryCalculation($warehouseId,$paperId,$noofdays)
    {
        $inventories = Inventory::with('inventory_details','vendor')->where([
            'warehouse_id' => $warehouseId,
            'papertype_id' => $paperId,
            'inventory_type' => 'manual'
        ])->where('created_at', '>=', now()->subDays($noofdays))
        ->orderBy('id', 'desc')
        ->get();
        return $inventories;
    }
}
