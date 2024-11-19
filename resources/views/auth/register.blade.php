<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <!--favicon-->
    <link href="https://st4.depositphotos.com/3265223/24936/v/450/depositphotos_249366040-stock-illustration-fitness-gym-logo-with-strong.jpg" rel="icon" type="image/png" />
    <!--plugins-->
    <link href="{{ asset('admin') }}/assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href="{{ asset('admin') }}/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <link href="{{ asset('admin') }}/assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <!-- loader-->
    <link href="{{ asset('admin') }}/assets/css/pace.min.css" rel="stylesheet" />
    <script src="{{ asset('admin') }}/assets/js/pace.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('admin') }}/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('admin') }}/assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="{{ asset('admin') }}/assets/css/app.css" rel="stylesheet">
    <link href="{{ asset('admin') }}/assets/css/icons.css" rel="stylesheet">
    <title>Register - No Limit GYM</title>
</head>

<body class="bg-login">
    <!--wrapper-->
    <div class="wrapper">
        <div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
            <div class="container-fluid">
                <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
                    <div class="col mx-auto">
                        <div class="mb-4 text-center mt-3">
                            <img alt="" src="https://st4.depositphotos.com/3265223/24936/v/450/depositphotos_249366040-stock-illustration-fitness-gym-logo-with-strong.jpg"
                                width="180" />
                        </div>
                        <!--breadcrumb-->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="card">
                            <div class="card-body">
                                <div class="border p-4 rounded">
                                    <div class="text-center">
                                        <h3 class="">No Limit GYM</h3>

                                    </div>

                                    <div class="login-separater text-center mb-4"> <span>MASUK MENGGUNAKAN USERNAME DAN
                                            PASSWORD</span>
                                        <hr />
                                    </div>
                                    <div class="form-body">
                                        <form action="{{ route('register') }}" class="row g-3" method="POST">
                                            @csrf
                                            <div class="col-12">
                                                <label class="form-label" for="nama">Nama Lengkap</label>
                                                <input class="form-control" id="nama" name="nama"
                                                    value="{{ old('nama') }}" placeholder="Nama" required type="text">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label" for="username">Username</label>
                                                <input class="form-control" id="username" name="username"
                                                    placeholder="Username" required type="text">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label" for="no_hp">No HP</label>
                                                <input class="form-control" id="no_hp" name="no_hp"
                                                    placeholder="No HP" required type="text">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label" for="email">Email</label>
                                                <input class="form-control" id="email" name="email"
                                                    placeholder="Email" required type="email">
                                            </div>
                                            
                                            <div class="col-12">
                                                <label class="form-label" for="alamat">Alamat</label>
                                                <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat" required></textarea>
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label" for="password">Enter Password</label>
                                                <div class="input-group" id="show_hide_password">
                                                    <input class="form-control border-end-0" id="password"
                                                        name="password" placeholder="Enter Password" required
                                                        type="password">
                                                    <a class="input-group-text bg-transparent" href="javascript:;"><i
                                                            class='bx bx-hide'></i></a>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                                                <div class="input-group" id="show_hide_password">
                                                    <input class="form-control border-end-0" id="password_confirmation"
                                                        name="password_confirmation" placeholder="Enter Password Confirmation" required
                                                        type="password">
                                                    <a class="input-group-text bg-transparent" href="javascript:;"><i
                                                            class='bx bx-hide'></i></a>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-switch">
                                                    <input checked class="form-check-input" id="flexSwitchCheckChecked"
                                                        type="checkbox">
                                                    <label class="form-check-label"
                                                        for="flexSwitchCheckChecked">Remember Me</label>
                                                </div>
                                            </div>
                                         
                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <button class="btn btn-primary" type="submit"><i
                                                            class="bx bxs-lock-open"></i>Sign in</button>
                                                </div>
                                            </div>
                                         
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end row-->
            </div>
        </div>
    </div>
    <!--end wrapper-->
    <!-- Bootstrap JS -->
    @include('sweetalert::alert')

    <script src="{{ asset('admin') }}/assets/js/bootstrap.bundle.min.js"></script>
    <!--plugins-->
    <script src="{{ asset('admin') }}/assets/js/jquery.min.js"></script>
    <script src="{{ asset('admin') }}/assets/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="{{ asset('admin') }}/assets/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="{{ asset('admin') }}/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
    <!--Password show & hide js -->
    <script>
        $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("bx-hide");
                    $('#show_hide_password i').removeClass("bx-show");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("bx-hide");
                    $('#show_hide_password i').addClass("bx-show");
                }
            });
        });
    </script>
    <!--app JS-->
    <script src="{{ asset('admin') }}/assets/js/app.js"></script>
</body>

</html>
