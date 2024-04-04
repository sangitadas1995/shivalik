@extends('layouts.app')
@section('title','User Management')
@push('extra_css')

@endpush
@section('content')

                <div class="page-name">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <h2>
                              <a href="{{ route('users.index') }}"><i class="ri-arrow-left-line"></i></a> Manage Permission
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="card add-new-location mt-2">
                  <form action="{{ route('users.update_permission', encrypt($user->id)) }}" method="POST" id="user-add-form">
                  @csrf
                  <div class="col-md-12">
                  @include('utils.alert')
                  
                  <span class="text-danger error_name"></span>

                  </div>  
                    <?php
                    for ($i=0;$i<count($menu_permissions);$i++){
                    ?>
                    <div class="permission">
                        <h4><?php echo $menu_permissions[$i]['menu_name'];?></h4>
                        <ul>
                          <?php 
                          for ($k=0;$k<count($menu_permissions[$i]['sub_menu']);$k++){
                          ?>
                            <li>
                              <input type="checkbox" name="sub_menu[]" id="che<?php echo $menu_permissions[$i]['sub_menu'][$k]['id'];?>" value="<?php echo $menu_permissions[$i]['sub_menu'][$k]['reserve_keyword'];?>" class="d-none" <?php if($menu_permissions[$i]['sub_menu'][$k]['user_menu_status'] == "exist"){ echo "checked";} ?>>
                                <label for="che<?php echo $menu_permissions[$i]['sub_menu'][$k]['id'];?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </label>
                                <!-- <input type="text" name="reserve_keyword[]" id="che<?php echo $menu_permissions[$i]['sub_menu'][$k]['reserve_keyword'];?>" value="<?php echo $menu_permissions[$i]['sub_menu'][$k]['reserve_keyword'];?>"> -->
                                <?php echo $menu_permissions[$i]['sub_menu'][$k]['display_name'];?>
                            </li>
                          <?php } ?>
                        </ul>
                    </div>
                    <input type="hidden" name="menu_ids[]" id="menu_ids<?php echo $menu_permissions[$i]['id'];?>" value="<?php echo $menu_permissions[$i]['id'];?>">
                  <?php } ?>

                  <div class="text-end">
                    <a href="{{ route('users.index') }}">
                    <button type="button" class="btn grey-primary">Cancel</button>
                    </a>
                    <button type="submit" class="btn black-btn">Save &amp; Continue</button>
                  </div>
                  </form>
                </div>

            </main>
            <div class="overlay"></div>
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
  var token = "{{ csrf_token() }}";

  $(document).ready(function () {
    $(document).on('submit', '#user-add-form', function (e) {
      e.preventDefault();
      var __e = $(this);
      //var chk_arr =  document.getElementsByName("sub_menu[]").checked;
      //var chklength = chk_arr.length;
      //alert(chklength);

      var checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
      //var checkboxes = document.getElementsByClassName('permissionChkBox').checked;
      //alert(checkboxes.length);

      if (checkboxes.length==0) 
      {
        return $('.error_name').html('Please select atleast one menu');
      } 
      else 
      {
        $('.error_name').html('');
      }


      __e[0].submit();
    });
  });

</script>
@endsection