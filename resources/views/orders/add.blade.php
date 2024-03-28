@extends('layouts.app')
@section('title','Add Order')
@push('extra_css')

@endpush
@section('content')
<!-- Add new order form 1 -->
<div id="add-new-orderForm-1">

    <div class="page-name">
        <div class="row justify-content-between align-items-center">
            <div class="col-md-4">
                <h2><i class="ri-arrow-left-line"></i> Add New Order</h2>
            </div>

        </div>
    </div>
    <div class="card add-new-location mt-2">
        <div class="card-body">

            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Select Customer :</label>
                        <input type="text" class="form-control" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Product :</label>
                        <input type="text" class="form-control" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Title:</label>
                        <input type="text" class="form-control" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">No. of Pages :</label>
                        <input type="text" class="form-control" />
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">No. of Copy :</label>
                        <input type="text" class="form-control" />
                    </div>
                </div>
                <div class="col-md-6">

                    <div class="mb-3">
                        <label class="form-label">Printing Cost to the Client (in Rs):</label>
                        <input type="email" class="form-control" />
                    </div>
                </div>
                <div class="col-md-6">

                    <div class="mb-3">
                        <label class="form-label">Order Date:</label>
                        <input type="date" class="form-control" />
                    </div>
                </div>
                <div class="col-md-6">

                    <div class="mb-3">
                        <label class="form-label">Delivery Date:</label>
                        <input type="date" class="form-control" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Job Assigned To :</label>
                        <select class="form-select" aria-label="Default select example">
                            <option selected>Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- scoend section form -->
            <div class="page-name">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-4">
                        <h2> Add New Order</h2>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Cover Type:</label>
                        <select class="form-select" aria-label="Default select example">
                            <option selected>Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Cover Size :</label>
                        <select class="form-select" aria-label="Default select example">
                            <option selected>Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Paper Type :</label>
                        <select class="form-select" aria-label="Default select example">
                            <option selected>Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Color Type :</label>
                        <select class="form-select" aria-label="Default select example">
                            <option selected>Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3 d-flex align-items-center">
                        <input type="checkbox" name="ch" id="ch1" class="checkbox me-2">
                        <label class="form-label mb-0">Paper GSM :</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Paper GSM :</label>
                        <input type="text" class="form-control" />
                    </div>
                </div>
            </div>
            <!-- Third section form -->
            <div class="page-name">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-4">
                        <h2> Inner Page Details</h2>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Paper Type:</label>
                        <select class="form-select" aria-label="Default select example">
                            <option selected>Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Paper Size :</label>
                        <select class="form-select" aria-label="Default select example">
                            <option selected>Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Color Type :</label>
                        <select class="form-select" aria-label="Default select example">
                            <option selected>Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                </div>
            </div>
            <!-- Forth section form -->
            <div class="page-name">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-4">
                        <h2> Book Binding Details</h2>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Binding Type:</label>
                        <select class="form-select" aria-label="Default select example">
                            <option selected>Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Upload Document Type:</label>
                        <select class="form-select" aria-label="Default select example">
                            <option selected>Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <div class="uploadDocInputBox">
                        <button class="cancleBtn">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.5312 6.46875L6.46875 11.5312M6.46875 6.46875L11.5312 11.5312"
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
        </div>
    </div>
</div>
<!-- Add new order form 2 -->
<div id="add-new-orderForm-2" style="display: none;">

    <div class="page-name">
        <div class="row justify-content-between align-items-center">
            <div class="col-md-6">
                <h2><i class="ri-arrow-left-line"></i> Select Printing Vendor for Cover Page</h2>
            </div>

        </div>
    </div>
    <div class="card add-new-location mt-2">
        <div class="card-body">

            <div class=" detailsBox ">
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
                        Net Paper Required
                    </div>
                    <div class="content">
                        A4
                    </div>

                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Select Vendor :</label>
                        <input type="text" class="form-control" />
                    </div>
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Paper In Stock :</label>
                        <input type="text" class="form-control" />
                    </div>
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Paper Required:</label>
                        <input type="text" class="form-control" />
                    </div>
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Paper Left In Stock :</label>
                        <input type="text" class="form-control" />
                    </div>
                </div>
                <div class="col-md-6"></div>




            </div>











        </div>
    </div>
</div>
<!-- Add new order form 3 -->
<div id="add-new-orderForm-3" style="display: none;">

    <div class="page-name">
        <div class="row justify-content-between align-items-center">
            <div class="col-md-6">
                <h2><i class="ri-arrow-left-line"></i> Select Vendor for Printing Plate</h2>
            </div>

        </div>
    </div>
    <div class="card add-new-location mt-2">
        <div class="card-body">



            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Select Vendor :</label>
                        <select class="form-select" aria-label="Default select example">
                            <option selected>Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Plate Type :</label>
                        <select class="form-select" aria-label="Default select example">
                            <option selected>Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">No. of Plates Required :</label>
                        <input type="text" class="form-control" />
                    </div>
                </div>




            </div>











        </div>
    </div>
</div>


<!-- Add new order form 4 -->
<div id="add-new-orderForm-4" style="display: none;">


    <div class="page-name">
        <div class="row justify-content-between align-items-center">
            <div class="col-md-6">
                <h2><i class="ri-arrow-left-line"></i>Select Printing Vendor for Book Binding </h2>
            </div>

        </div>
    </div>
    <div class="card add-new-location mt-2">
        <div class="card-body">



            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Select Vendor :</label>
                        <select class="form-select" aria-label="Default select example">
                            <option selected>Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Binding Type :</label>
                        <select class="form-select" aria-label="Default select example">
                            <option selected>Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                </div>





            </div>











        </div>
    </div>
</div>





<div class="text-end mt-auto">
    <button type="button" class="btn grey-primary">Cancel</button>
    <button type="button" class="btn black-btn" currentForm="1" onclick="addNewFormSaveAndContinue(event)">Save &
        Continue</button>
</div>

@endsection

@section('scripts')
<script>
    function addNewFormSaveAndContinue(event) {
        // document.getElementById('fasd').innerText="Save"
        let btn = event.target;
        let currentForm = Number(btn.getAttribute('currentForm'));
        if (currentForm !== 4) {

            document.getElementById(`add-new-orderForm-${currentForm}`).style.display = "none";
            document.getElementById(`add-new-orderForm-${(++currentForm)}`).style.display = "block";
            btn.setAttribute('currentForm', currentForm)

            if (currentForm == 4) {
                btn.innerText = "Save"
            }
        }
    }
</script>

@endsection