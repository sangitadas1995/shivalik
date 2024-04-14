<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label"><span class="text-danger">*</span>Length :</label>
            <input type="text" class="form-control" name="paper_length" id="paper_length" value="{{ $size_details->width }}" {{ $size_details->name != 'Custom' ? 'readonly' : null }} />
            <small class="text-danger error_paper_size_name"></small>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label"><span class="text-danger">*</span>Height :</label>
            <input type="text" class="form-control" name="paper_height" id="paper_height" value="{{ $size_details->height }}" {{ $size_details->name != 'Custom' ? 'readonly' : null }} />
            <small class="text-danger error_paper_size_name"></small>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-12">
        <label class="form-label"><span class="text-danger">*</span>Paper Unit:</label>
        <select class="form-select" aria-label="Default select example" id="paper_unit_id" name="paper_unit_id">
            <option value="">Select Paper Unit</option>
            @if (!empty($size_details->paperunit))
                <option value="{{ $size_details->paperunit?->id }}" selected>{{ $size_details->paperunit->name }}</option>
            @else
                @if (!empty($paperUnits) && $paperUnits->isNotEmpty())
                    @foreach ($paperUnits as $pu)
                        <option value="{{ $pu->id }}" {{ $pu->id == $size_details->paperunit?->id ? 'selected' : null }}>{{ $pu->name }}</option>
                    @endforeach
                @endif
            @endif
        </select>
    </div>
</div>