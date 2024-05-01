<div class="mb-3">
    <label class="form-label"><span class="text-danger">*</span>No of Sheet :</label>
    <input type="text" class="form-control" name="no_of_sheet" id="no_of_sheet"
        value="{{ $packaging_details?->no_of_sheet ?? null }}"
        {{ $packaging_details?->no_of_sheet != 'Custom' ? 'readonly' : null }} />
    <small class="text-danger error_no_of_sheet"></small>
</div>