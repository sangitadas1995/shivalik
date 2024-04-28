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
                                        Details
                                    </p>
                                </div>
                            </div>

                            <!-- table row -->
                            <div class="col-5 child-table-row">
                                <div>
                                    Name
                                </div>
                            </div>
                            <div class="col-7 child-table-row">
                                <div>
                                    {{ $papertype->paper_name }}
                                </div>
                            </div>
                            <!-- table row end -->
                            <!-- table row -->
                            <div class="col-5 child-table-row">
                                <div>
                                    Category
                                </div>
                            </div>
                            <div class="col-7 child-table-row">
                                <div>
                                    {{ $papertype->papercategory?->name ?? null }}
                                </div>
                            </div>
                            @if (!empty($papertype->paper_qty))
                                <div class="col-5 child-table-row">
                                    <div>
                                        Packaging Details
                                    </div>
                                </div>
                                <div class="col-7 child-table-row">
                                    <div>
                                        {{ $papertype->paper_qty?->packaging_title ?? null }}
                                    </div>
                                </div>

                                @if (!empty($papertype->paper_qty?->unit_type))
                                    <div class="col-5 child-table-row">
                                        <div>
                                            Masurement Type Unit
                                        </div>
                                    </div>
                                    <div class="col-7 child-table-row">
                                        <div>
                                            {{ $papertype->paper_qty?->unit_type?->measurement_unuit ?? null }}
                                        </div>
                                    </div>
                                @endif

                                <div class="col-5 child-table-row">
                                    <div>
                                        No of Sheet
                                    </div>
                                </div>
                                <div class="col-7 child-table-row">
                                    <div>
                                        {{ $papertype->paper_qty?->no_of_sheet ?? null }}
                                    </div>
                                </div>
                            @endif
                            <!-- table row end -->
                            <!-- table row -->
                            <div class="col-5 child-table-row">
                                <div>
                                    Color
                                </div>
                            </div>
                            <div class="col-7 child-table-row">
                                <div>
                                    {{ $papertype->papercolor?->name ?? null }}
                                </div>
                            </div>
                            <!-- table row end -->
                            <!-- table row -->
                            <div class="col-5 child-table-row">
                                <div>
                                    Quality
                                </div>
                            </div>
                            <div class="col-7 child-table-row">
                                <div>
                                    {{ $papertype->paperquality?->name ?? null }}
                                </div>
                            </div>
                            <!-- table row end -->

                            <!-- table row -->
                            <div class="col-5 child-table-row">
                                <div>
                                    GSM
                                </div>
                            </div>
                            <div class="col-7 child-table-row">
                                <div>
                                    {{ $papertype->papergsm?->name ?? null }}
                                </div>
                            </div>
                            @if (!empty($papertype->papersize))
                                <!-- table row end -->
                                <!-- table row -->
                                <div class="col-5 child-table-row">
                                    <div>
                                        Size name
                                    </div>
                                </div>
                                <div class="col-7 child-table-row">
                                    <div>
                                        {{ $papertype->papersize?->name ?? null }}
                                    </div>
                                </div>
                                <!-- table row end -->
                                <!-- table row -->
                                <div class="col-5 child-table-row">
                                    <div>
                                        Unit
                                    </div>
                                </div>
                                <div class="col-7 child-table-row">
                                    <div>
                                        {{ $papertype->paperunit?->name ?? null }}
                                    </div>
                                </div>
                                <!-- table row end -->
                                <!-- table row -->
                                <div class="col-5 child-table-row">
                                    <div>
                                        Height
                                    </div>
                                </div>
                                <div class="col-7 child-table-row">
                                    <div>
                                        {{ $papertype->paper_height }}
                                    </div>
                                </div>
                                <!-- table row end -->
                                <!-- table row -->
                                <div class="col-5 child-table-row">
                                    <div>
                                        Width
                                    </div>
                                </div>
                                <div class="col-7 child-table-row">
                                    <div>
                                        {{ $papertype->paper_width }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
