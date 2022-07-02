<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title; ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/assets/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/assets/templates/adminlte320/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <div class="login-logo">
                    <img class="brand mb-2 img-circle elevation-2" src="/assets/templates/adminlte320/img/AdminLTELogo.png" height="135" width="135"><br>
                </div>
                <a href="/admin" class="h3 "><b>Rewaste World</b></a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Silahkan login untuk masuk ke sistem</p>

                <form id="formLogin" method="post">
                    <div class="input-group mb-3">
                        <input type="username" id="username" name="username" class="form-control" placeholder="Username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <small id="username_error" class="form-text text-danger mb-3"></small>
                    <div class="input-group mb-3">
                        <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <small id="password_error" class="form-text text-danger mb-3"></small>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="tampil_password">
                                <label for="tampil_password">
                                    Tampilkan Password
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" id="btnLogin" class="btn btn-primary btn-block">Log In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                    <a href="/user/register" class="text-center">Belum punya akun? Register disini</a>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="/assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/assets/templates/adminlte320/js/adminlte.min.js"></script>

    <!-- Custome script -->
    <script>
        $(document).ready(function() {
            // tampilkan password
            $('#tampil_password').click(function() {
                // jika diceklis, maka ubah atribut "type=text" untuk menampilkan password
                if ($(this).is(':checked')) {
                    $('#password').attr('type', 'text');
                }
                // jika tidak diceklis, maka ubah atribut "type=password" untuk menyembunyikan password
                else {
                    $('#password').attr('type', 'password');
                }
            });
            // login masuk sistem
            $('#btnLogin').on('click', function(e) {
                e.preventDefault();
                const formLogin = $('#formLogin');

                $.ajax({
                    url: "/Login/cek_login_user",
                    method: "POST",
                    data: formLogin.serialize(),
                    dataType: "JSON",
                    success: function(data) {
                        //Login Error
                        if (data.error) {

                            if (data.login_error['username'] != '') $('#username_error').html(data.login_error['username']);
                            else $('#username_error').html('');

                            if (data.login_error['password'] != '') $('#password_error').html(data.login_error['password']);
                            else $('#password_error').html('');
                        }
                        //Login Succes
                        if (data.success) {
                            formLogin.trigger('reset');
                            $('#username_error').html('');
                            $('#password_error').html('');
                            window.location.replace(data.link);
                        }
                    }
                });
            });
            //-------------------------------------------------------------------
        });
    </script>
</body>

</html>