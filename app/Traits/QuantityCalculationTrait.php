<?php

namespace App\Traits;

use App\Models\PaperQuantityCalculation;
use App\Models\PaperSize;

trait QuantityCalculationTrait
{
    public function getSettingValueByField($field)
    {
        $quantitySetting = PaperQuantityCalculation::where([
            'field' => $field
        ])
            ->first();

        return $quantitySetting;
    }

    public function storeSetting($field, $from_unit, $quantity_description, $value, $conversion_unit)
    {
        $quantityCalculation = new PaperQuantityCalculation();
        $quantityCalculation->field = $field;
        $quantityCalculation->quantity = 1;
        $quantityCalculation->from_unit = $from_unit;
        $quantityCalculation->quantity_description = $quantity_description;
        $quantityCalculation->conversion_ratio = $value;
        $quantityCalculation->conversion_unit = $conversion_unit;
        $save = $quantityCalculation->save();

        if ($save) {
            return $quantityCalculation->id;
        }

        return null;
    }

    public function updateSetting($field, $value)
    {
        $setting = $this->getSettingValueByField($field);

        $setting->conversion_ratio = $value;
        $update = $setting->update();

        if ($update) {
            return true;
        }

        return false;
    }

    public function getQuantityUnits()
    {
        $quantity_unit = PaperQuantityCalculation::where([
            'status' => 'A',
        ])->get();

        return $quantity_unit;
    }
}
