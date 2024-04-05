@extends('layouts.app')
@section('title','Paper Setting')
@push('extra_css')
    
@endpush
@section('content')
<div class="page-name">
    <div class="row justify-content-between align-items-center">
      <div class="col-md-4">
        <h2><i class="ri-arrow-left-line"></i> Paper Color</h2>
      </div>
      <div class="col-md-6">
        <div class="text-end mb-4">
          <a href="{{ route('papersettings.add_paper_color') }}" class="btn primary-btn"
            ><img src="{{ asset('images/add-accoun-1t.png') }}" /> Add Paper Color</a
          >
        </div>
      </div>
    </div>
</div>
<div class="row">
  <div class="col-md-12">
    @include('utils.alert')
  </div>
</div>
<div class="row">
    <div class="table-responsive table-sec mb-4">
        <table class="table table-striped" id="papercolor_list_table">
        <thead>
            <tr>
            <th>Row ID</th>
            <th style="text-align: center">ID</th>
            <th style="text-align: center">Name</th>
            <th style="text-align: center">Status</th>
            <th style="text-align: center">Action</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
    <script>
      $(document).ready(function () {
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        let users_list_table = $('#papercolor_list_table').DataTable({
          stateSave: true,
          processing: true,
          serverSide: true,
          pageLength: 10,
          ajax: {
            url: "{{ route('papersettings.colorlistdata') }}",
            type: 'POST',
            'data': function(data) {
              return data;
            }
          },
          columnDefs: [{
              target: 0,
              searchable: false,
              sortable: false,
              visible: false,
            },
            {
              target: [1,4],
              searchable: false,
              sortable: false,
            },
            {"className": "dt-center", "targets": "_all"}
          ]
        });

        $(document).on('click','.doInactive',function(e){
          e.preventDefault();
          var __e = $(this);
          var rowid = __e.data('id');
          if (rowid) {
            $.ajax({
              type: "post",
              url: "{{ route('papersettings.doinactivecolor') }}",
              data: {rowid},
              dataType: "json",
              success: function (response) {
                if(response.status == "success")
                {
                  return Swal.fire({
                  icon: "success",
                  text: response.message,
                  showDenyButton: false,
                  showCancelButton: false,
                  confirmButtonText: "Ok",
                }).then((result) => {
                  if (result.isConfirmed) {
                    location.reload();
                  }
                });
              }
              },
              error: function(xhr, status, error) {
                return Swal.fire('Error!', 'Something went wrong, please try again.', 'error');
              }
            });
          }
        });

        $(document).on('click','.doActive',function(e){
          e.preventDefault();
          var __e = $(this);
          var rowid = __e.data('id');
          if (rowid) {
            $.ajax({
              type: "post",
              url: "{{ route('papersettings.doactivecolor') }}",
              data: {rowid},
              dataType: "json",
              success: function (response) {
                if(response.status == "success")
                {
                  return Swal.fire({
                  icon: "success",
                  text: response.message,
                  showDenyButton: false,
                  showCancelButton: false,
                  confirmButtonText: "Ok",
                }).then((result) => {
                  if (result.isConfirmed) {
                    location.reload();
                  }
                });
              }
              },
              error: function(xhr, status, error) {
                return Swal.fire('Error!', 'Something went wrong, please try again.', 'error');
              }
            });
          }
        });

      });
      
    </script>
@endsection