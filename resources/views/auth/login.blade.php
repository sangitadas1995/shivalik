<!DOCTYPE html>
<html lang="">

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>
    <base href="{{ \URL::to('/') }}">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/remixicon.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}" />
  </head>

  <body>
    <section class="login-page">
      <div class="container">
        <div class="logo-sec">
          <img src="{{ asset('images/logo1.png') }}" />
        </div>
        <div class="login-white-bg rounded-4">
          <div class="row align-items-center h-100 w-100">
            <div class="col-md-6 h-100 d-flex align-items-center login-border-right">
              <div class="login-img w-100">
                <img src="{{ asset('images/login-img.png') }}" class="w-100" />
              </div>
            </div>
            <div class="col-md-6 ps-4">
              <div class="login-hd">
                <h2 class="mb-5">Login</h2>
              </div>
              @include('utils.alert')
              <form class="login-form" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">User Id (ID or Email)</label>
                  <input name="userid" type="text" class="form-control" id="exampleInputEmail1"
                    aria-describedby="emailHelp" value="{{ old('userid') }}" />
                  <div id="emailHelp" class="form-text">
                    We'll never share your email with anyone else.
                  </div>
                </div>
                <div class="mb-3">
                  <label for="exampleInputPassword1" class="form-label">Password</label>
                  <input name="password" type="password" class="form-control" id="exampleInputPassword1" />
                </div>
                <div class="btn-sec login-btn-sec text-end">
                  <button type="button" class="btn grey-primary login-reset">Cancel</button>
                  <button type="submit" class="btn black-primary">Login</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>

    <script src="{{ asset('js/jquery-3.6.3.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
  </body>

</html>
<script>
  $(document).ready(function () {
    $('.login-reset').click(function () {
      $('.login-form')[0].reset();
    });
  });
</script>