
<div class="customer-details-popup">
    <div class="popup-content ">
        <button class="close-popup-btn" data-bs-dismiss="modal" aria-label="Close">
            <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M8.01562 0.984375L0.984375 8.01562M0.984375 0.984375L8.01562 8.01562" stroke="#18202B"
                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </button>
        <div class="container">
            <div class="parent-table">
                <div class="child-table">
                    <div class="container">
    
                        <div class="row border-gray">
                            <div class="col-12 child-table-row">
                                <div>
                                    <p class="title">
                                        Lot Calculation Details
                                    </p>
                                </div>
                            </div>
    
                            <!-- table row -->
<!--                             <div class="col-5 child-table-row">
                                <div>
                                    Packaging Title
                                </div>
                            </div>
                            <div class="col-7 child-table-row">
                                <div>
                                    {{ $unitMeasure->packaging_title }}
    
                                </div>
                            </div> -->
                            <!-- table row end -->
                            <!-- table row -->
                            <div class="col-5 child-table-row">
                                <div>
                                    Unit Type
                                </div>
                            </div>
                            <div class="col-7 child-table-row">
                                <div>
                                    {{ $unitMeasure->unit_type?->measurement_unuit ?? null }}
                                </div>
                            </div>
                            <!-- table row end -->
                            <!-- table row -->
                            <div class="col-5 child-table-row">
                                <div>
                                    No of Sheet
                                </div>
                            </div>
                            <div class="col-7 child-table-row">
                                <div>
                                    {{ $unitMeasure->no_of_sheet }}
    
                                </div>
                            </div>
                            <!-- table row end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>