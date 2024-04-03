
<div class="customer-details-popup">
   
    <div class="popup-content ">
        <h4>
            User Name: {{ $user->name }} (ID: {{ $user->id }})
        </h4>
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
                                    Manager
                                </div>
                            </div>
                            <div class="col-7 child-table-row">
                                <div>
                                    {{ $user->usermanager?->name ?? null }}
                                </div>
                            </div>
                            <!-- table row end -->
                            <!-- table row -->
                            <div class="col-5 child-table-row">
                                <div>
                                    Designation
                                </div>
                            </div>
                            <div class="col-7 child-table-row">
                                <div>
                                    {{ $user->designation?->name ?? null }}
                                </div>
                            </div>
                            <!-- table row end -->
                            <!-- table row -->
                            <div class="col-5 child-table-row">
                                <div>
                                    Functional Area
                                </div>
                            </div>
                            <div class="col-7 child-table-row">
                                <div>
                                    {{ $user->functionalareas?->name ?? null }}
                                </div>
                            </div>
                            <!-- table row end -->
                            <!-- table row -->
                            <div class="col-5 child-table-row">
                                <div>
                                    Email
                                </div>
                            </div>
                            <div class="col-7 child-table-row">
                                <div>
                                    {{ $user->email }}
                                </div>
                            </div>
                            <!-- table row end -->
    
                            <!-- table row -->
                            <div class="col-5 child-table-row">
                                <div>
                                    Mobile
                                </div>
                            </div>
                            <div class="col-7 child-table-row">
                                <div>
                                   +91 {{ $user->mobile }}
                                </div>
                            </div>
                            <!-- table row end -->
                            <!-- table row -->
                            <div class="col-5 child-table-row">
                                <div>
                                    Address
                                </div>
                            </div>
                            <div class="col-7 child-table-row">
                                <div>
                                    {{ $user->address }}
                                </div>
                            </div>
                            <!-- table row end -->
                            <!-- table row -->
                            <div class="col-5 child-table-row">
                                <div>
                                    Country
                                </div>
                            </div>
                            <div class="col-7 child-table-row">
                                <div>
                                    {{ $user->country?->country_name ?? null }}
    
                                </div>
                            </div>
                            <!-- table row end -->
                            <!-- table row -->
                            <div class="col-5 child-table-row">
                                <div>
                                    State
                                </div>
                            </div>
                            <div class="col-7 child-table-row">
                                <div>
                                    {{ $user->state?->state_name ?? null }}
                                </div>
                            </div>
                            <!-- table row end -->
                            <!-- table row -->
                            <div class="col-5 child-table-row">
                                <div>
                                    City
                                </div>
                            </div>
                            <div class="col-7 child-table-row">
                                <div>
                                    {{ $user->city?->city_name ?? null }}
                                </div>
                            </div>
                            <!-- table row end -->
                            <!-- table row -->
                            <div class="col-5 child-table-row">
                                <div>
                                    Pincode
                                </div>
                            </div>
                            <div class="col-7 child-table-row">
                                <div>
                                    {{ $user->pincode }}
                                </div>
                            </div>
                            <!-- table row end -->
                        </div>
                    </div>
                </div>
            {{--             <div class="child-table">
            </div>

                <div class="container">

                    <div class="row border-gray">
                        <div class="col-12 child-table-row">
                            <div>
                                <p class="title">
                                    Order Details
                                </p>
                            </div>
                        </div>

                        <!-- table row -->
                        <div class="col-5 child-table-row">
                            <div>
                                No. of Orders
                            </div>
                        </div>
                        <div class="col-7 child-table-row">
                            <div>
                                24

                            </div>
                        </div>
                        <!-- table row end -->
                        <!-- table row -->
                        <div class="col-5 child-table-row">
                            <div>
                                Print Margin
                            </div>
                        </div>
                        <div class="col-7 child-table-row">
                            <div>
                                2%
                            </div>
                        </div>
                        <!-- table row end -->

                    </div>
                </div>
            </div> --}}
        </div>
    </div>
  </div>