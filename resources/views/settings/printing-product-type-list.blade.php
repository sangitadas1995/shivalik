@extends('layouts.app')
@section('title','Printing Product Type')
@push('extra_css')
    
@endpush
@section('content')
<div class="page-name">
    <div class="row justify-content-between align-items-center">
        <div class="col-md-4">
            <h2><i class="ri-arrow-left-line"></i> Paper Type</h2>
        </div>
        <div class="col-md-6">
            <div class="text-end mb-4">
                <a href="{{ route('settings.create-printing-product-type') }}" class="btn primary-btn"><svg width="24" height="24" viewBox="0 0 30 30"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M0 15C0 6.7155 6.7155 0 15 0C23.2845 0 30 6.7155 30 15C30 23.2845 23.2845 30 15 30C6.7155 30 0 23.2845 0 15ZM15 3C11.8174 3 8.76515 4.26428 6.51472 6.51472C4.26428 8.76515 3 11.8174 3 15C3 18.1826 4.26428 21.2348 6.51472 23.4853C8.76515 25.7357 11.8174 27 15 27C18.1826 27 21.2348 25.7357 23.4853 23.4853C25.7357 21.2348 27 18.1826 27 15C27 11.8174 25.7357 8.76515 23.4853 6.51472C21.2348 4.26428 18.1826 3 15 3Z"
                            fill="currentColor" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M16.5 7.5C16.5 7.10218 16.342 6.72064 16.0607 6.43934C15.7794 6.15804 15.3978 6 15 6C14.6022 6 14.2206 6.15804 13.9393 6.43934C13.658 6.72064 13.5 7.10218 13.5 7.5V13.5H7.5C7.10218 13.5 6.72064 13.658 6.43934 13.9393C6.15804 14.2206 6 14.6022 6 15C6 15.3978 6.15804 15.7794 6.43934 16.0607C6.72064 16.342 7.10218 16.5 7.5 16.5H13.5V22.5C13.5 22.8978 13.658 23.2794 13.9393 23.5607C14.2206 23.842 14.6022 24 15 24C15.3978 24 15.7794 23.842 16.0607 23.5607C16.342 23.2794 16.5 22.8978 16.5 22.5V16.5H22.5C22.8978 16.5 23.2794 16.342 23.5607 16.0607C23.842 15.7794 24 15.3978 24 15C24 14.6022 23.842 14.2206 23.5607 13.9393C23.2794 13.658 22.8978 13.5 22.5 13.5H16.5V7.5Z"
                            fill="currentColor" />
                    </svg>
                    Add
                </a>

            </div>
        </div>
    </div>
</div>
<div class="card  mt-2">
    <div class="card-body">
        <form action="" class="add-paper-type-form">
            <div class="row">
                <div>
                    <div class="mb-3">
                        <label class="form-label">Paper Type :</label>
                        <input type="text" class="form-control" />
                    </div>

                </div>
                <div class="">
                    <div class="text-end">
                        <button type="submit" class="btn black-btn">Save </button>
                        <button type="submit" class="btn grey-primary">Cancle</button>

                    </div>
                </div>
            </div>
        </form>


        <div class="setting-paper-type-table">


            <div class="row head">
                <div class="col-4 colum-border">
                    <div class="d-flex align-items-center justify-content-center colum">

                        Paper Type
                    </div>
                </div>
                <div class="col-4 colum-border">
                    <div class="d-flex align-items-center justify-content-center colum">
                        Status
                    </div>
                </div>
                <div class="col-4 colum-border">
                    <div class="d-flex align-items-center justify-content-center colum">
                        Action
                    </div>
                </div>
            </div>
            <div class="row paper-type-row">
                <div class="col-4 colum-border">
                    <div class=" colum">

                        <p>Newspaper</p>
                    </div>
                </div>
                <div class="col-4 colum-border content-center">
                    <div class="colum middle-colum">
                        <span>
                            OFF
                        </span>
                        <label class="toggle">
                            <input type="checkbox">
                            <span class="white-slider"></span>
                        </label>
                        <span>

                            ON
                        </span>
                    </div>
                </div>
                <div class="col-4 colum-border content-center">
                    <div class="colum">
                        <a href="#" title="Edit">
                            <svg width="29" height="29" viewBox="0 0 29 29" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M19.9066 6.5347L22.4647 9.09274M21.5512 4.28116L14.6311 11.2013C14.2735 11.5583 14.0296 12.0133 13.9302 12.5087L13.291 15.7084L16.4907 15.068C16.9861 14.9689 17.4404 14.726 17.7981 14.3683L24.7182 7.4482C24.9262 7.24025 25.0911 6.99338 25.2037 6.72168C25.3162 6.44997 25.3741 6.15877 25.3741 5.86468C25.3741 5.57059 25.3162 5.27939 25.2037 5.00769C25.0911 4.73598 24.9262 4.48911 24.7182 4.28116C24.5103 4.07321 24.2634 3.90825 23.9917 3.79571C23.72 3.68317 23.4288 3.62524 23.1347 3.62524C22.8406 3.62524 22.5494 3.68317 22.2777 3.79571C22.006 3.90825 21.7591 4.07321 21.5512 4.28116Z"
                                    stroke="#4A88DA" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M22.958 18.1251V21.7501C22.958 22.391 22.7034 23.0057 22.2502 23.4589C21.797 23.9121 21.1823 24.1667 20.5413 24.1667H7.24967C6.60873 24.1667 5.99405 23.9121 5.54083 23.4589C5.08762 23.0057 4.83301 22.391 4.83301 21.7501V8.45841C4.83301 7.81747 5.08762 7.20279 5.54083 6.74957C5.99405 6.29636 6.60873 6.04175 7.24967 6.04175H10.8747"
                                    stroke="#4A88DA" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>

                        </a>
                        <a href="#" title="Delete">
                            <svg width="29" height="29" viewBox="0 0 29 29" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12.2344 5.89062V6.34375H16.7656V5.89062C16.7656 5.28974 16.5269 4.71347 16.102 4.28859C15.6772 3.8637 15.1009 3.625 14.5 3.625C13.8991 3.625 13.3228 3.8637 12.898 4.28859C12.4731 4.71347 12.2344 5.28974 12.2344 5.89062ZM10.4219 6.34375V5.89062C10.4219 4.80904 10.8515 3.77175 11.6163 3.00696C12.3811 2.24216 13.4184 1.8125 14.5 1.8125C15.5816 1.8125 16.6189 2.24216 17.3837 3.00696C18.1485 3.77175 18.5781 4.80904 18.5781 5.89062V6.34375H25.375C25.6154 6.34375 25.8459 6.43923 26.0158 6.60918C26.1858 6.77914 26.2812 7.00965 26.2812 7.25C26.2812 7.49035 26.1858 7.72086 26.0158 7.89082C25.8459 8.06077 25.6154 8.15625 25.375 8.15625H24.0084L22.2938 23.171C22.1673 24.2768 21.6383 25.2974 20.8076 26.0381C19.9769 26.7789 18.9027 27.188 17.7897 27.1875H11.2103C10.0973 27.188 9.02305 26.7789 8.19237 26.0381C7.36168 25.2974 6.83269 24.2768 6.70625 23.171L4.99162 8.15625H3.625C3.38465 8.15625 3.15414 8.06077 2.98418 7.89082C2.81423 7.72086 2.71875 7.49035 2.71875 7.25C2.71875 7.00965 2.81423 6.77914 2.98418 6.60918C3.15414 6.43923 3.38465 6.34375 3.625 6.34375H10.4219ZM8.50787 22.9644C8.58354 23.6277 8.9006 24.2399 9.39865 24.6845C9.89669 25.1291 10.5409 25.3749 11.2085 25.375H17.7906C18.4582 25.3749 19.1024 25.1291 19.6004 24.6845C20.0985 24.2399 20.4156 23.6277 20.4912 22.9644L22.185 8.15625H6.81591L8.50787 22.9644ZM11.7812 11.3281C12.0216 11.3281 12.2521 11.4236 12.4221 11.5936C12.592 11.7635 12.6875 11.994 12.6875 12.2344V21.2969C12.6875 21.5372 12.592 21.7677 12.4221 21.9377C12.2521 22.1076 12.0216 22.2031 11.7812 22.2031C11.5409 22.2031 11.3104 22.1076 11.1404 21.9377C10.9705 21.7677 10.875 21.5372 10.875 21.2969V12.2344C10.875 11.994 10.9705 11.7635 11.1404 11.5936C11.3104 11.4236 11.5409 11.3281 11.7812 11.3281ZM18.125 12.2344C18.125 11.994 18.0295 11.7635 17.8596 11.5936C17.6896 11.4236 17.4591 11.3281 17.2188 11.3281C16.9784 11.3281 16.7479 11.4236 16.5779 11.5936C16.408 11.7635 16.3125 11.994 16.3125 12.2344V21.2969C16.3125 21.5372 16.408 21.7677 16.5779 21.9377C16.7479 22.1076 16.9784 22.2031 17.2188 22.2031C17.4591 22.2031 17.6896 22.1076 17.8596 21.9377C18.0295 21.7677 18.125 21.5372 18.125 21.2969V12.2344Z"
                                    fill="#ED1C24" />
                            </svg>

                        </a>
                    </div>
                </div>
            </div>
            <div class="row paper-type-row">
                <div class="col-4 colum-border">
                    <div class=" colum">

                        <p>Newspaper</p>
                    </div>
                </div>
                <div class="col-4 colum-border content-center">
                    <div class="colum middle-colum">
                        <span>
                            OFF
                        </span>
                        <label class="toggle">
                            <input type="checkbox">
                            <span class="white-slider"></span>
                        </label>
                        <span>

                            ON
                        </span>
                    </div>
                </div>
                <div class="col-4 colum-border content-center">
                    <div class="colum">
                        Action
                    </div>
                </div>
            </div>
            <div class="row paper-type-row">
                <div class="col-4 colum-border">
                    <div class=" colum">

                        <p>Newspaper</p>
                    </div>
                </div>
                <div class="col-4 colum-border content-center">
                    <div class="colum middle-colum">
                        <span>
                            OFF
                        </span>
                        <label class="toggle">
                            <input type="checkbox">
                            <span class="white-slider"></span>
                        </label>
                        <span>

                            ON
                        </span>
                    </div>
                </div>
                <div class="col-4 colum-border content-center">
                    <div class="colum">
                        Action
                    </div>
                </div>
            </div>
            <div class="row paper-type-row">
                <div class="col-4 colum-border">
                    <div class=" colum">

                        <p>Newspaper</p>
                    </div>
                </div>
                <div class="col-4 colum-border content-center">
                    <div class="colum middle-colum">
                        <span>
                            OFF
                        </span>
                        <label class="toggle">
                            <input type="checkbox">
                            <span class="white-slider"></span>
                        </label>
                        <span>

                            ON
                        </span>
                    </div>
                </div>
                <div class="col-4 colum-border content-center">
                    <div class="colum">
                        Action
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade rejection-popup" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-body">
            <h5 class="modal-title" id="exampleModalLabel">
                Reason for Rejection
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <hr />
            <form>
                <div class="mb-3">
                    <label for="message-text" class="col-form-label">Message:</label>
                    <textarea class="form-control" id="message-text"></textarea>
                </div>
                <button type="button" class="btn btn-primary">
                    Send message
                </button>
            </form>
        </div>
        <!-- <div class="modal-footer">
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
<button type="button" class="btn btn-primary">Send message</button>
</div> -->
    </div>
</div>
</div>
@endsection

@section('scripts')
    
<script>
    $("#mobile_code-1").intlTelInput({
        initialCountry: "in",
        separateDialCode: true,
        // utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.4/js/utils.js"
    });
    $("#mobile_code-2").intlTelInput({
        initialCountry: "in",
        separateDialCode: true,
        // utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.4/js/utils.js"
    });
    $("#mobile_code-3").intlTelInput({
        initialCountry: "in",
        separateDialCode: true,
        // utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.4/js/utils.js"
    });
    $("#mobile_code-4").intlTelInput({
        initialCountry: "in",
        separateDialCode: true,
        // utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.4/js/utils.js"
    });
</script>
@endsection