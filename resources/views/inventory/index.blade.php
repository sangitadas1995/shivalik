@extends('layouts.app')
@section('title','Inventory Management')
@push('extra_css')

@endpush
@section('content')
<div class="page-name">
    <div class="row justify-content-end">
        <div class="col-md-6">
            <div class="text-end mb-4">
                <a href="#" class="btn primary-btn">
                    <svg width="24" height="22" viewBox="0 0 24 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M21.333 6.74167V19.1667H18.9997V9.83333H4.99967V19.1667H2.66634V6.74167L11.9997 3.00833L21.333 6.74167ZM23.6663 21.5V5.16667L11.9997 0.5L0.333008 5.16667V21.5H7.33301V12.1667H16.6663V21.5H23.6663ZM10.833 19.1667H8.49967V21.5H10.833V19.1667ZM13.1663 15.6667H10.833V18H13.1663V15.6667ZM15.4997 19.1667H13.1663V21.5H15.4997V19.1667Z"
                            fill="white" />
                    </svg>

                    Add Warehouse</a>
                <a href="#" class="btn primary-btn">
                    <svg width="27" height="27" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M11.8125 20.2632V12.3398L3.375 8.12109V19.7227L10.5469 23.3218L10.1382 24.9961L1.6875 20.7773V6.22266L12.6562 0.751465L23.625 6.22266V9.78223C23.0098 9.87891 22.4473 10.0767 21.9375 10.3755V8.12109L13.5 12.3398V18.5757L11.8125 20.2632ZM9.94043 3.98145L17.6396 8.38477L20.896 6.75L12.6562 2.62354L9.94043 3.98145ZM12.6562 10.8765L15.8203 9.29443L8.12109 4.89111L4.4165 6.75L12.6562 10.8765ZM24.3633 11.8125C24.7324 11.8125 25.0752 11.8784 25.3916 12.0103C25.708 12.1421 25.9893 12.3223 26.2354 12.5508C26.4814 12.7793 26.666 13.0562 26.7891 13.3813C26.9121 13.7065 26.9824 14.0537 27 14.4229C27 14.7656 26.9341 15.0996 26.8022 15.4248C26.6704 15.75 26.4814 16.0356 26.2354 16.2817L16.7827 25.7344L11.8125 26.9736L13.0518 22.0034L22.5044 12.564C22.7593 12.3091 23.0449 12.1201 23.3613 11.9971C23.6777 11.874 24.0117 11.8125 24.3633 11.8125ZM25.0356 15.0952C25.2202 14.9106 25.3125 14.6865 25.3125 14.4229C25.3125 14.1504 25.2246 13.9307 25.0488 13.7637C24.873 13.5967 24.6445 13.5088 24.3633 13.5C24.2402 13.5 24.1216 13.5176 24.0073 13.5527C23.8931 13.5879 23.792 13.6538 23.7041 13.7505L14.5811 22.8735L14.1328 24.6533L15.9126 24.2051L25.0356 15.0952Z"
                            fill="white" />
                    </svg>


                    Add Product Stock
                </a>
            </div>
        </div>
    </div>
    <div class="row justify-content-between align-items-center mb-3">
        <div class="col-md-4">
            <h2><i class="ri-arrow-left-line"></i> Inventory Management</h2>
        </div>
        <div class="col-md-6">
            <div class="d-flex justify-content-end">
                <div class="searchBox">
                    <span>
                        Search Product
                    </span>

                    <div class="search">
                        <input type="text">
                        <span class="me-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_316_1858)">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M10.5003 2C9.14485 2.00012 7.80912 2.32436 6.60451 2.94569C5.3999 3.56702 4.36135 4.46742 3.57549 5.57175C2.78963 6.67609 2.27926 7.95235 2.08696 9.29404C1.89466 10.6357 2.026 12.004 2.47003 13.2846C2.91406 14.5652 3.6579 15.7211 4.63949 16.6557C5.62108 17.5904 6.81196 18.2768 8.11277 18.6576C9.41358 19.0384 10.7866 19.1026 12.1173 18.8449C13.448 18.5872 14.6977 18.015 15.7623 17.176L19.4143 20.828C19.6029 21.0102 19.8555 21.111 20.1177 21.1087C20.3799 21.1064 20.6307 21.0012 20.8161 20.8158C21.0015 20.6304 21.1066 20.3796 21.1089 20.1174C21.1112 19.8552 21.0104 19.6026 20.8283 19.414L17.1763 15.762C18.1642 14.5086 18.7794 13.0024 18.9514 11.4157C19.1233 9.82905 18.8451 8.22602 18.1485 6.79009C17.4519 5.35417 16.3651 4.14336 15.0126 3.29623C13.66 2.44911 12.0962 1.99989 10.5003 2ZM4.00025 10.5C4.00025 8.77609 4.68507 7.12279 5.90406 5.90381C7.12305 4.68482 8.77635 4 10.5003 4C12.2242 4 13.8775 4.68482 15.0964 5.90381C16.3154 7.12279 17.0003 8.77609 17.0003 10.5C17.0003 12.2239 16.3154 13.8772 15.0964 15.0962C13.8775 16.3152 12.2242 17 10.5003 17C8.77635 17 7.12305 16.3152 5.90406 15.0962C4.68507 13.8772 4.00025 12.2239 4.00025 10.5Z"
                                        fill="#BFBFBF" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_316_1858">
                                        <rect width="24" height="24" fill="white" />
                                    </clipPath>
                                </defs>
                            </svg>

                        </span>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="">
    <div class="d-flex gap-2 table-title align-items-center">

        <h4 class="mb-0">
            Warehouse: ABC Printing Company, Mayur vihar, Delhi
        </h4>
        <span>
            <img src="{{ asset('images/oui_tag.png') }}" />
        </span>
    </div>
    <div class="table-responsive p-0 table-sec mb-4">
        <table class="table table-normal mb-0">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Last Updated</th>
                    <th>Opening Stock</th>
                    <th>Current Stock</th>
                    <th>Low Stock Level</th>
                    <th style="text-align: center">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>80GSM</td>
                    <td>29-Feb-24</td>
                    <td>200</td>
                    <td class="text-green">55</td>
                    <td>50</td>
                    <td style="text-align: center">
                        <a href="#"><img src="{{ asset('images/inventoryIcon-1.png') }}" /></a>
                        <a href="#"><img src="{{ asset('images/inventoryIcon-2.png') }}" /></a>
                        <a href="#"><img src="{{ asset('images/inventoryIcon-3.png') }}" /></a>
                    </td>
                </tr>
                <tr>
                    <td>70GSM</td>
                    <td>25-Feb-24</td>
                    <td>400</td>
                    <td class="text-red">50</td>
                    <td class="">40</td>
                    <td style="text-align: center">
                        <a href="#"><img src="{{ asset('images/inventoryIcon-1.png') }}" /></a>
                        <a href="#"><img src="{{ asset('images/inventoryIcon-2.png') }}" /></a>
                        <a href="#"><img src="{{ asset('images/inventoryIcon-3.png') }}" /></a>
                    </td>
                </tr>
                <tr>
                    <td>100GSM</td>
                    <td>29-March-24</td>
                    <td>400</td>
                    <td>200</td>
                    <td>100</td>
                    <td style="text-align: center">
                        <a href="#"><img src="{{ asset('images/inventoryIcon-1.png') }}" /></a>
                        <a href="#"><img src="{{ asset('images/inventoryIcon-2.png') }}" /></a>
                        <a href="#"><img src="{{ asset('images/inventoryIcon-3.png') }}" /></a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')

@endsection