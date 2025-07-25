<!doctype html>
<html lang="en">

<head>
    {{-- <script>
        function isMobile() {
            return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
        }

        if (isMobile()) {
            // Option 1: Redirect to another page
            window.location.href = "/not-available-on-mobile";

            // Option 2: Show an alert and stop interaction
            // alert("This site is not supported on mobile devices.");
            // document.body.innerHTML = "<h2>Sorry, mobile access is not supported.</h2>";
        }
    </script> --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

    <link rel="stylesheet" href="{{ asset('login-template/assets/css/styles.min.css') }}">
</head>

<body>

    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div
            class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body">
                                {{-- <a href="./index.html" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <img src="../assets/images/logos/logo-light.svg" alt="">
                </a> --}}
                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                <p class="text-center">Welcome back</p>
                                <form action="login" method="post">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Username</label>
                                        <input type="email" class="form-control" value="{{ old('email') }}"
                                            name="email" aria-describedby="emailHelp">
                                    </div>
                                    <div class="mb-4">
                                        <label for="exampleInputPassword1" class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control"
                                            id="exampleInputPassword1">
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        {{-- <div class="form-check">
                                            <input class="form-check-input primary" type="checkbox" value=""
                                                id="flexCheckChecked" checked>
                                            <label class="form-check-label text-dark" for="flexCheckChecked">
                                                Remeber this Device
                                            </label>
                                        </div> --}}
                                        <a class="text-primary fw-bold" href="./index.html">Forgot Password ?</a>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <button type="submit" class="btn btn-primary w-100 py-8 fs-4 ">Sign
                                            In</button>
                                        <p class="mb-0 text-center" style="font-weight: bold; font-szie: 1rem ">Or</p>
                                        <a href="{{ route('auth.google') }}" class="btn btn-light mb-2">
                                            Login with Google
                                        </a>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-center">
                                        <p class="fs-4 mb-0 fw-bold">Don't have an account?</p>
                                        <a class="text-primary fw-bold ms-2" href="{{ route('signup') }}">Create an
                                            account</a>
                                    </div>
                                    @csrf
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <script src="D:/HOC/LUAN VAN/LUAN VAN/laravel-app/public/login-template/assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="D:/HOC/LUAN VAN/LUAN VAN/laravel-app/public/login-template/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script> --}}
</body>

</html>
