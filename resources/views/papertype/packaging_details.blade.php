<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label"><span class="text-danger">*</span>Masurement Type Unit :</label>
            <input type="text" class="form-control" name="measurement_type_unit" id="measurement_type_unit"
                value="{{ $packaging_details?->unit_type?->measurement_unuit ?? null }}" readonly />
            <small class="text-danger error_measurement_type_unit"></small>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label"><span class="text-danger">*</span>No of Sheet :</label>
            <input type="text" class="form-control" name="no_of_sheet" id="no_of_sheet"
                value="{{ $packaging_details?->no_of_sheet ?? null }}"
                {{ $packaging_details?->no_of_sheet != 'Custom' ? 'readonly' : null }} />
            <small class="text-danger error_no_of_sheet"></small>
        </div>
    </div>
</div>
