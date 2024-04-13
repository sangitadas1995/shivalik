@if ($vendor_type_id == 2)    
    <label class="form-label">Deals in services<span class="text-danger">*</span>:</label>
    <select class="form-select service_types" aria-label="Default select example" id="service_type_id" name="service_type_id[]" multiple="multiple">
        <option value="">-- Select deals in services ---</option>
        @if (!empty($service_types) && $service_types->isNotEmpty())
            @foreach ($service_types as $type)
                <option value="{{ $type->id }}">{{ $type->name }}</option>
            @endforeach
        @endif
    </select>
@else
    <label class="form-label">Supplier of paper types<span class="text-danger">*</span>:</label>
    <select class="form-select service_types" aria-label="Default select example" id="service_type_id" name="service_type_id[]" multiple="multiple">
        <option value="">-- Select supplier of paper types ---</option>
        @if (!empty($service_types) && $service_types->isNotEmpty())
            @foreach ($service_types as $type)
                <option value="{{ $type->id }}">{{ $type->paper_name }}</option>
            @endforeach
        @endif
    </select>
@endif
