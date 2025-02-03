<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

    <title>Login</title>

    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    @include('Layouts.Styles')
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/assets/vendor/css/pages/page-auth.css') }}">
    <style type="text/css">
        .layout-menu-fixed .layout-navbar-full .layout-menu,
        .layout-page {
        padding-top: 0px !important;
        }
        .content-wrapper {
        padding-bottom: 0px !important;
        }
        .social-icons a {
            margin: 0 10px;
            color: #333;
        }
        .img-logo{
            width: 50px;
            height: 50px;
        }
    </style>
  </head>

  <body>
    <!-- Content -->

    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Register -->
          <div class="card">
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center">
                <a href="index.html" class="app-brand-link gap-2">
                  <span class="app-brand-logo demo">
                    <img src="{{ asset('assets/assets/logopemprov.png')}}" width="50" height="50" alt="">
                  </span>
                </a>
              </div>
              <h4 class="mb-2">Welcome to SIPB! 👋</h4>
              <p class="mb-4">Please sign-in to your account and start the adventure</p>

              <form id="formAuthentication" class="mb-3" method="POST">
                @csrf
                <div class="mb-3">
                  <label for="email" class="form-label">Email </label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" autofocus="">
                  <small id="email-error" class="text-danger"></small>
                </div>
                <div class="mb-3 form-password-toggle">
                  <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">Password</label>
                  </div>
                  <div class="input-group input-group-merge">
                    <input type="password" id="password" class="form-control" name="password" placeholder="············" aria-describedby="password">
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
                <small id="password-error" class="text-danger"></small>
                </div>
                <div class="mb-3">
                  <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                </div>
              </form>
              <div class="social-icons text-center mt-4">
                  <a href="#"><img src="{{ asset('assets/assets/img/stmikadhigunaicon.svg') }}" alt="Logo" class="img-fluid img-logo rounded" ></a>
                  <a href="#"><img src="{{ asset('assets/assets/img/20241107_171817.jpg') }}" alt="Logo" class="img-fluid img-logo rounded" ></a>
              </div>
            </div>
          </div>
          <!-- /Register -->
        </div>
      </div>
    </div>

    <!-- / Content -->

    @include('Layouts.Scripts')
    <script>
        const apiUrl = 'auth/login';
        function successAlert(message) {
            Swal.fire({
                title: 'Berhasil!',
                text: message,
                icon: 'success',
                showConfirmButton: false,
                timer: 1000,
            });
        }

        function errorAlert(message) {
            Swal.fire({
                title: 'Error',
                text: message,
                icon: 'error',
                showConfirmButton: false,
                timer: 1500,
            });
        }

        function loadingAlert() {
            Swal.fire({
                title: 'Loading...',
                text: 'Please wait',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        }

        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let formInput = $('#formAuthentication');

            formInput.on('submit', function (e) {
                e.preventDefault();

                $('.text-danger').text('');

                let formData = new FormData(this);
                loadingAlert();

                $.ajax({
                    type: 'POST',
                    url: `{{ url('${apiUrl}') }}`,
                    data: formData,
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        console.log(response);

                        Swal.close();
                        if (response.code === 422) {
                            let errors = response.errors;
                            $.each(errors, function(key, value) {
                                $('#' + key + '-error').text(value[0]);
                            });
                        } else {
                            successAlert();
                            if (response.data.user && response.data.user.role) {
                                switch (response.data.user.role.toLowerCase()) {
                                    case 'super admin':
                                        window.location.href = '/dashboard';
                                        break;
                                    case 'admin':
                                        window.location.href = '/disposision';
                                        break;
                                    default:
                                        window.location.href = '/dashboard';
                                        break;
                                }
                            } else {
                                console.error('User role not found in response.');
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.close();
                        const response = xhr.responseJSON;
                        if (xhr.status === 401) {
                            errorAlert('Terjadi kesalahan!');
                        }else {
                            console.error(xhr.responseText);
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
