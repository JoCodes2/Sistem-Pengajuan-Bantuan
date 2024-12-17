<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('assets/assets/logopemprov.png')}}" type="image/png" />
    <title>Sistem Pengaduan Bantuan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="{{ asset('assets/assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/assets/css/uiweb.css') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    @include('Layouts.NavUiWeb');
    <!-- content -->
    <main class="content container y">
        @yield('content')
    </main>
    <!-- footer -->
    <!-- footer -->
    <section id="footer" >
        <div class="container pt-3">
            <div class=" col-12 footer-content mx-auto">
                <div class="row d-flex justify-content-center text-center text-light">
                    <div class="col-md-4 justify-content-center ">
                        <div>
                            <h5 class="font-popins fw-bold">Sistem Inforamsi Pengajuan Bantuan</h5>
                            <p class="font-kanit">Terima kasih sudah menggunakan layanan kami.</p>
                        </div>
                    </div>
                    <div class="col-md-4 justify-content-center">
                        <h6 class="font-popins fw-bold">Navigation</h6>
                        <div>
                            <ul class="list-unstyled font-kanit text-light">
                                <li><a href="#" class="nav-footer">Home</a></li>
                                <li><a href="#" class="nav-footer">Data</a></li>
                                <li><a href="#" class="nav-footer">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4 justify-content-center">
                        <h6 class="font-popins fw-bold ">Contact</h6>
                        <div>
                            <ul class=" list-unstyled justify-content-center text-center ">
                                <li><i class="fa-solid fa-envelope"></i>jocodes@gmail.com</a>
                                </li>
                                <li>
                                    <i class="fas fa-map-marker-alt"></i>Jln.Soekarno-Hatta
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <footer class="mt-3 ">
        <div class="col-md-12 justify-content-center text-center font-kanit sky">
            <p>&copy; 2025 Jocodes</p>
        </div>
    </footer>
    <!-- footer -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-element-bundle.min.js"></script>

    <!--   Core JS Files   -->
    <script src="{{ asset('assets/js/core/jquery.3.2.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2.full.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    @include('Layouts.Scripts')
    @yield('script')
</body>

</html>
