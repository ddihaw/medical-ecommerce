<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <title>
        403 - Akses Ditolak
    </title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-svg.css" rel="stylesheet" />
    <link id="stylesheet" href="{{ asset('assets/css/all.min.css') }}" rel="stylesheet" />
    <link id="pagestyle" href="{{ asset('assets/css/argon-dashboard.css') }}" rel="stylesheet" />
</head>

<body class="bg-gray-100">

    <main class="main-content position-relative border-radius-lg max-height-vh-100 h-100 min-vh-100 d-flex flex-column">

        <div class="container-fluid py-4 my-auto">
            <div class="row mt-5 pt-5">
                <div class="col-lg-8 col-md-10 mx-auto">

                    <div class="card shadow-lg border-0">
                        <div class="card-body p-5 text-center">

                            <div
                                class="icon icon-shape icon-lg bg-gradient-danger shadow text-center border-radius-lg mb-4 mx-auto">
                                <i class="ni ni-button-pause opacity-10"></i>
                            </div>

                            <h1 class="display-3 text-danger">403</h1>
                            <h2 class="mb-3">Akses Ditolak (Forbidden)</h2>

                            <p class="lead mb-4">
                                @if (isset($exception) && $exception->getMessage())
                                    <strong>{{ $exception->getMessage() }}</strong>
                                @else
                                    Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.
                                @endif
                            </p>

                            <a href="javascript:history.back()" class="btn btn-outline-secondary">
                                <i class="ni ni-bold-left me-1"></i>
                                Kembali
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer pt-3 mx-4 mb-3">
            <div class="container-fluid my-auto">
                <div class="row align-items-center justify-content-lg-between">
                    <div class="col-12">
                        <div class="copyright text-center text-sm text-muted">
                            ©
                            <script>
                                document.write(new Date().getFullYear())
                            </script>
                            ,
                            dibuat oleh Tim Anda.
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </main>

    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/argon-dashboard.min.js') }}"></script>

</body>

</html>