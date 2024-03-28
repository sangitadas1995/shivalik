@extends('layouts.app')
@section('title','Orders Management')
@push('extra_css')

@endpush
@section('content')
<div class="page-name">
    <div class="row justify-content-between align-items-center">
        <div class="col-md-6">
            <h2 class="mb-0"><i class="ri-arrow-left-line"></i> Order Details (ID: 1234 Client: Shivalik
                Industry)
            </h2>
        </div>

    </div>
</div>
<div class="card add-new-location mt-2">
    <div class="card-body order-details">
        <p class="title1">
            Order Stage
        </p>

        <div class="progressDiv">
            <div class="status">
                <div class="circle complete">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_332_991)">
                            <path
                                d="M20.5408 2.2442L10.0021 16.1385L3.77148 9.91237L0.896484 12.7874L10.4783 22.3692L23.8965 5.1192L20.5408 2.2442Z"
                                fill="white" />
                        </g>
                        <defs>
                            <clipPath id="clip0_332_991">
                                <rect width="23" height="23" fill="white"
                                    transform="translate(0.896484 0.896545)" />
                            </clipPath>
                        </defs>
                    </svg>

                </div>
                <p>
                    Order Received
                </p>
            </div>
            <div class="status">
                <div class="circle ">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_332_991)">
                            <path
                                d="M20.5408 2.2442L10.0021 16.1385L3.77148 9.91237L0.896484 12.7874L10.4783 22.3692L23.8965 5.1192L20.5408 2.2442Z"
                                fill="white" />
                        </g>
                        <defs>
                            <clipPath id="clip0_332_991">
                                <rect width="23" height="23" fill="white"
                                    transform="translate(0.896484 0.896545)" />
                            </clipPath>
                        </defs>
                    </svg>

                </div>
                <p>
                    Order Completeds
                </p>
            </div>
        </div>
        <div class="orderDetailsBox">

            <div class=" detailsBox  bg-heading-lightYellow ">
                <div class="col-auto">
                    <div class="heading">
                        Customer
                    </div>
                    <div class="content">
                        A4
                    </div>

                </div>
                <div class="col-auto">
                    <div class="heading">
                        Product
                    </div>
                    <div class="content">
                        A4
                    </div>

                </div>
                <div class="col-auto">
                    <div class="heading">
                        Title
                    </div>
                    <div class="content">
                        A4
                    </div>

                </div>
                <div class="col-auto">
                    <div class="heading">
                        No. of Pages
                    </div>
                    <div class="content">
                        A4
                    </div>

                </div>
                <div class="col-auto">
                    <div class="heading">
                        No. of Copy
                    </div>
                    <div class="content">
                        A4
                    </div>

                </div>
                <div class="col-auto">
                    <div class="heading">
                        Printing Cost
                    </div>
                    <div class="content">
                        A4
                    </div>

                </div>
                <div class="col-auto">
                    <div class="heading">
                        Cover Type
                    </div>
                    <div class="content">
                        A4
                    </div>

                </div>
                <div class="col-auto">
                    <div class="heading">
                        Cover Size
                    </div>
                    <div class="content">
                        A4
                    </div>

                </div>
                <div class="col-auto">
                    <div class="heading">
                        Paper Type
                    </div>
                    <div class="content">
                        A4
                    </div>

                </div>
                <div class="col-auto">
                    <div class="heading">
                        Paper Size
                    </div>
                    <div class="content">
                        A4
                    </div>

                </div>
                <div class="col-auto">
                    <div class="heading">
                        Color Type
                    </div>
                    <div class="content">
                        A4
                    </div>

                </div>
                <div class="col-auto">
                    <div class="heading">
                        Binding Type
                    </div>
                    <div class="content">
                        A4
                    </div>

                </div>
                <div class="text-end col-auto">
                    <button type="submit" class="btn grey-primary editBtn">Edit</button>
                    <!-- <button type="submit" class="btn black-btn">Save & Continue</button> -->
                </div>
            </div>
        </div>












    </div>
</div>

<div class="row deleveryDetails ">
    <div class="col-md-8">
        <div>

            <div class="expectedDelivery">
                <p>
                    Expected Delivery Date: <span>
                        10-03-2024
                    </span>
                </p>
            </div>
            <div class="instruction">
                <p class="font-weight-bold">
                    Delivery Instruction:
                </p>
                <p class="instructionPara">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Cupiditate, nulla
                    doloremque velit esse blanditiis architecto a reprehenderit nobis excepturi
                    asperiores.
                </p>
            </div>
            <div class="download">

                Download

                <span>
                    <svg width="18" height="22" viewBox="0 0 18 22" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M0.25 22H17.75V19.5H0.25V22ZM17.75 8.25H12.75V0.75H5.25V8.25H0.25L9 17L17.75 8.25Z"
                            fill="#232F40" />
                    </svg>

                </span>
                <div class="links">
                    <a href="#">Purchase Order</a>
                    <span class="divider">
                        |
                    </span>
                    <a href="#">Challan Doc</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="customerDetails">
            <div class="top">
                <p class="title">
                    Customer’s Details
                </p>
                <p>
                    Saikat Mitra
                </p>
                <p>
                    Mobile No: +91 9933725604
                </p>
                <p>
                    Address: Kolkata, West Bengal, India
                </p>
            </div>
            <div class="row links">
                <div class="col-4 px-0">
                    <div class="link">

                        <a href="#">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M22.4503 17.3503C22.2056 17.0896 21.3417 16.319 19.7536 15.2995C18.1537 14.271 16.9739 13.6298 16.6354 13.4803C16.6056 13.467 16.5727 13.4622 16.5404 13.4662C16.508 13.4703 16.4773 13.4831 16.4517 13.5032C15.9065 13.9284 14.9887 14.7093 14.9395 14.7515C14.6217 15.0238 14.6217 15.0238 14.3615 14.939C13.904 14.789 12.4828 14.0343 11.2443 12.7931C10.0059 11.5518 9.21231 10.0954 9.06231 9.63838C8.97653 9.37775 8.97653 9.37775 9.24981 9.05994C9.292 9.01072 10.0734 8.09291 10.4986 7.54822C10.5187 7.52257 10.5315 7.49191 10.5356 7.45954C10.5396 7.42716 10.5348 7.3943 10.5215 7.36447C10.372 7.02557 9.73075 5.84619 8.70231 4.24635C7.68137 2.65869 6.91168 1.79479 6.65106 1.5501C6.62714 1.52753 6.59758 1.51183 6.56549 1.50465C6.5334 1.49747 6.49997 1.49909 6.46871 1.50932C5.55769 1.82239 4.67869 2.22186 3.84371 2.70229C3.03766 3.17086 2.27455 3.70967 1.56325 4.31244C1.53842 4.33355 1.5198 4.36102 1.5094 4.3919C1.49899 4.42279 1.49719 4.45592 1.50418 4.48775C1.60215 4.94432 2.07043 6.85025 3.52356 9.49025C5.00621 12.1846 6.03371 13.5651 8.21106 15.7349C10.3884 17.9048 11.8125 18.9942 14.5097 20.4768C17.1497 21.9299 19.0565 22.3987 19.5122 22.4957C19.5441 22.5027 19.5772 22.5008 19.6082 22.4904C19.6391 22.48 19.6667 22.4614 19.6879 22.4367C20.2906 21.7254 20.8293 20.9623 21.2976 20.1562C21.778 19.3212 22.1774 18.4422 22.4906 17.5312C22.5006 17.5002 22.5022 17.467 22.4951 17.4352C22.488 17.4034 22.4725 17.3741 22.4503 17.3503Z"
                                    fill="#232F40" />
                            </svg>

                        </a>
                    </div>
                </div>
                <div class="col-4 px-0">
                    <div class="link">

                        <a href="#">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_339_2598)">
                                    <path
                                        d="M0.512578 11.8564C0.512016 13.8729 1.04302 15.8418 2.0527 17.5773L0.416016 23.5067L6.53152 21.9157C8.22298 22.8294 10.1181 23.3081 12.044 23.3082H12.0491C18.4067 23.3082 23.582 18.1749 23.5847 11.8654C23.586 8.80804 22.3871 5.93307 20.2089 3.77009C18.0311 1.6073 15.1347 0.41558 12.0486 0.414185C5.6902 0.414185 0.515297 5.54721 0.512672 11.8564"
                                        fill="url(#paint0_linear_339_2598)" />
                                    <path
                                        d="M0.100313 11.8527C0.0996563 13.9417 0.649687 15.981 1.69537 17.7786L0 23.9207L6.33478 22.2726C8.08022 23.2168 10.0454 23.7147 12.0451 23.7154H12.0502C18.636 23.7154 23.9972 18.3975 24 11.8621C24.0011 8.69488 22.7591 5.71656 20.5031 3.47609C18.2468 1.23591 15.2468 0.00130233 12.0502 0C5.46337 0 0.102938 5.31721 0.100313 11.8527ZM3.87291 17.469L3.63637 17.0965C2.64206 15.5277 2.11725 13.7149 2.118 11.8534C2.12006 6.4213 6.57544 2.00186 12.054 2.00186C14.7071 2.00298 17.2005 3.02921 19.0759 4.89116C20.9512 6.7533 21.9831 9.22865 21.9824 11.8614C21.98 17.2935 17.5245 21.7135 12.0502 21.7135H12.0463C10.2638 21.7126 8.51569 21.2376 6.99113 20.34L6.62831 20.1265L2.86912 21.1045L3.87291 17.469Z"
                                        fill="url(#paint1_linear_339_2598)" />
                                    <path
                                        d="M9.06383 6.89746C8.84014 6.40416 8.60473 6.39421 8.39202 6.38556C8.21783 6.37811 8.0187 6.37867 7.81977 6.37867C7.62064 6.37867 7.29711 6.453 7.02364 6.74928C6.74989 7.04583 5.97852 7.76249 5.97852 9.22007C5.97852 10.6777 7.04848 12.0864 7.19764 12.2843C7.34698 12.4817 9.26323 15.5686 12.2981 16.7562C14.8204 17.743 15.3336 17.5468 15.881 17.4973C16.4285 17.448 17.6477 16.7808 17.8964 16.089C18.1453 15.3973 18.1453 14.8043 18.0707 14.6804C17.996 14.557 17.7969 14.4829 17.4983 14.3348C17.1996 14.1866 15.7317 13.4698 15.458 13.371C15.1843 13.2722 14.9853 13.2229 14.7861 13.5195C14.587 13.8157 14.0152 14.4829 13.841 14.6804C13.6669 14.8785 13.4926 14.9031 13.1941 14.755C12.8953 14.6063 11.9337 14.2938 10.7929 13.2846C9.90523 12.4993 9.30598 11.5296 9.1318 11.2329C8.95761 10.9367 9.11314 10.7762 9.26286 10.6285C9.39702 10.4958 9.56155 10.2826 9.71098 10.1096C9.85986 9.93663 9.90955 9.81318 10.0091 9.6156C10.1088 9.41783 10.0589 9.24481 9.98436 9.09663C9.90955 8.94844 9.32933 7.48323 9.06383 6.89746Z"
                                        fill="white" />
                                </g>
                                <defs>
                                    <linearGradient id="paint0_linear_339_2598" x1="1158.85"
                                        y1="2309.67" x2="1158.85" y2="0.414185"
                                        gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#1FAF38" />
                                        <stop offset="1" stop-color="#60D669" />
                                    </linearGradient>
                                    <linearGradient id="paint1_linear_339_2598" x1="1200" y1="2392.07"
                                        x2="1200" y2="0" gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#F9F9F9" />
                                        <stop offset="1" stop-color="white" />
                                    </linearGradient>
                                    <clipPath id="clip0_339_2598">
                                        <rect width="24" height="24" fill="white" />
                                    </clipPath>
                                </defs>
                            </svg>


                        </a>
                    </div>
                </div>
                <div class="col-4 px-0">
                    <div class="link">

                        <a href="#">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M21.6004 8.84765V17.4C21.6004 18.1957 21.2843 18.9588 20.7217 19.5214C20.1591 20.084 19.396 20.4 18.6004 20.4H5.40039C4.60474 20.4 3.84168 20.084 3.27907 19.5214C2.71646 18.9588 2.40039 18.1957 2.40039 17.4V8.84765L11.6956 14.3172C11.7879 14.3717 11.8932 14.4004 12.0004 14.4004C12.1076 14.4004 12.2128 14.3717 12.3052 14.3172L21.6004 8.84765ZM18.6004 4.80005C19.3386 4.79993 20.0509 5.07198 20.601 5.56414C21.1512 6.0563 21.5006 6.73402 21.5824 7.46765L12.0004 13.104L2.41839 7.46765C2.50018 6.73402 2.84958 6.0563 3.39974 5.56414C3.94991 5.07198 4.66221 4.79993 5.40039 4.80005H18.6004Z"
                                    fill="#232F40" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="orderDetailsBox">
    <p class="title">
        Print Vendor for Cover Page
    </p>
    <div class=" detailsBox bg-heading-blue ">
        <div class="col-auto">
            <div class="heading">
                Vendor
            </div>
            <div class="content">
                A4
            </div>

        </div>
        <div class="col-auto">
            <div class="heading">
                No. of Pages
            </div>
            <div class="content">
                A4
            </div>

        </div>
        <div class="col-auto">
            <div class="heading">
                No. of Copy
            </div>
            <div class="content">
                A4
            </div>

        </div>
        <div class="col-auto">
            <div class="heading">
                Paper Type
            </div>
            <div class="content">
                A4
            </div>

        </div>
        <div class="col-auto">
            <div class="heading">
                Net Paper Required
            </div>
            <div class="content">
                A4
            </div>

        </div>
        <div class="col-auto">
            <div class="heading">
                Wastage
            </div>
            <div class="content">
                A4
            </div>

        </div>
        <div class="col-auto">
            <div class="heading">
                Total paper required
            </div>
            <div class="content">
                A4
            </div>

        </div>
        <div class="col-auto">
            <div class="heading">
                Book Size
            </div>
            <div class="content">
                A4
            </div>

        </div>
        <div class="col-auto">
            <div class="heading">
                Paper In Stock
            </div>
            <div class="content">
                A4
            </div>

        </div>
        <div class="text-end col-auto">
            <button type="submit" class="btn grey-primary editBtn">Edit</button>
            <button type="submit" class="btn black-btn">Genarate PO</button>
        </div>
    </div>
</div>
<div class="orderDetailsBox">
    <p class="title">
        Print Vendor for Inner Page
    </p>
    <div class=" detailsBox bg-heading-lightGreen ">
        <div class="col-auto">
            <div class="heading">
                Vendor
            </div>
            <div class="content">
                A4
            </div>

        </div>
        <div class="col-auto">
            <div class="heading">
                No. of Pages
            </div>
            <div class="content">
                A4
            </div>

        </div>
        <div class="col-auto">
            <div class="heading">
                No. of Copy
            </div>
            <div class="content">
                A4
            </div>

        </div>
        <div class="col-auto">
            <div class="heading">
                Paper Type
            </div>
            <div class="content">
                A4
            </div>

        </div>
        <div class="col-auto">
            <div class="heading">
                Net Paper Required
            </div>
            <div class="content">
                A4
            </div>

        </div>
        <div class="col-auto">
            <div class="heading">
                Wastage
            </div>
            <div class="content">
                A4
            </div>

        </div>
        <div class="col-auto">
            <div class="heading">
                Total paper required
            </div>
            <div class="content">
                A4
            </div>

        </div>
        <div class="col-auto">
            <div class="heading">
                Book Size
            </div>
            <div class="content">
                A4
            </div>

        </div>
        <div class="col-auto">
            <div class="heading">
                Paper In Stock
            </div>
            <div class="content">
                A4
            </div>

        </div>
        <div class="text-end col-auto">
            <button type="submit" class="btn grey-primary editBtn">Edit</button>
            <button type="submit" class="btn black-btn">Genarate PO</button>
        </div>
    </div>
</div>
<div class="orderDetailsBox">
    <p class="title">
        Vendor for Printing Plate
    </p>
    <div class=" detailsBox bg-heading-lightRed ">
        <div class="col-auto">
            <div class="heading">
                Vendor
            </div>
            <div class="content">
                A4
            </div>

        </div>
        <div class="col-auto">
            <div class="heading">
                Plate Type
            </div>
            <div class="content">
                A4
            </div>

        </div>
        <div class="col-auto">
            <div class="heading">
                No. of Plate Required
            </div>
            <div class="content">
                A4
            </div>

        </div>

        <div class="text-end col-auto">
            <button type="submit" class="btn grey-primary editBtn">Edit</button>
            <button type="submit" class="btn black-btn">Genarate PO</button>
        </div>
    </div>
</div>
<div class="orderDetailsBox">
    <p class="title">
        Vendor for Printing Plate
    </p>
    <div class=" detailsBox bg-heading-lightGreen2 ">
        <div class="col-auto">
            <div class="heading">
                Vendor
            </div>
            <div class="content">
                A4
            </div>

        </div>
        <div class="col-auto">
            <div class="heading">
                BInding Type
            </div>
            <div class="content">
                A4
            </div>

        </div>


        <div class="text-end col-auto">
            <button type="submit" class="btn grey-primary editBtn">Edit</button>
            <button type="submit" class="btn black-btn">Genarate PO</button>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div>
            <div class="orderHistory">
                <p class="font-weight-bold">
                    Order History
                </p>
                <div class="history">
                    <p>
                        Oder Id: <span>
                            1
                        </span>
                    </p>
                    <p>
                        Customer Name: <span> Saikat Mitra</span>
                    </p>
                    <p>
                        Product: <span> Book</span>
                    </p>
                    <br>
                    <p>
                        Order Date: <span> 29-Feb-24</span>
                    </p>
                    <p>
                        Delivery Date: <span> 10-Mar-24</span>
                    </p>
                    <p>
                        Status: <span> Delivered</span>
                    </p>
                </div>
            </div>
            <form action="">


                <div class="mb-3">
                    <label for="message-text" class="col-form-label font-weight-bold">Message:</label>
                    <textarea class="form-control" id="message-text"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Document Type:</label>
                    <select class="form-select" aria-label="Default select example">
                        <option selected>Open this select menu</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="uploadDocInputBox">
                            <button class="cancleBtn">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M11.5312 6.46875L6.46875 11.5312M6.46875 6.46875L11.5312 11.5312"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M9 16.0312C12.8833 16.0312 16.0312 12.8833 16.0312 9C16.0312 5.11675 12.8833 1.96875 9 1.96875C5.11675 1.96875 1.96875 5.11675 1.96875 9C1.96875 12.8833 5.11675 16.0312 9 16.0312Z"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>

                            </button>
                            <!-- <label for="file1"> -->
                            <p>Drag and Drop your files here</p>
                            <span>OR</span>
                            <label for="file1" type="submit" class="btn black-btn">Browse File</label>
                            <!-- <button for="file1" type="submit" class="btn black-btn">Browse File</button> -->
                            <!-- </label> -->

                            <input type="file" id="file1" multiple
                                class="position-absolute h-100 w-100 top-0 start-0 opacity-0 ">
                        </div>
                    </div>
                </div>
                <div class="text-end col-auto mt-3">

                    <button type="submit" class="btn black-btn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')

@endsection