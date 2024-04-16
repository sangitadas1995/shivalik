@if ($vendor_type_id == 2)
<label class="form-label">Deals in services<span class="text-danger">*</span>:</label>
<div class="form-select p-0 position-relative">
    <span class="multiselectSvgSpan">

        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
            <path fill-rule="evenodd"
                d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                clip-rule="evenodd" />
        </svg>
    </span>
    <select class="form-select service_types" aria-label="Default select example" id="service_type_id"
        name="service_type_id[]" multiple="multiple">
        <option value="">-- Select deals in services ---</option>
        @if (!empty($service_types) && $service_types->isNotEmpty())
        @foreach ($service_types as $type)
        <option value="{{ $type->id }}">{{ $type->name }}</option>
        @endforeach
        @endif
    </select>
</div>

@else
<label class="form-label">Supplier of paper types<span class="text-danger">*</span>:</label>
<div class="form-select p-0 position-relative">
    <span class="multiselectSvgSpan">

        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
            <path fill-rule="evenodd"
                d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                clip-rule="evenodd" />
        </svg>
    </span>


    <select class="form-select service_types" aria-label="Default select example" id="service_type_id"
        name="service_type_id[]" multiple="multiple">
        <option value="">-- Select supplier of paper types ---</option>
        @if (!empty($service_types) && $service_types->isNotEmpty())
        @foreach ($service_types as $type)
        <option value="{{ $type->id }}">{{ $type->paper_name }}</option>
        @endforeach
        @endif
    </select>
</div>

@endif