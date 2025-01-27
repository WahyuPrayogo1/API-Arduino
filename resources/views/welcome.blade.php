
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cute+Font&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <style>
        .buttonfont {
            font-family: "Poppins", sans-serif;
            font-weight: 400;
            font-style: normal;
        }

        .poppins-medium {
            font-family: "Poppins", sans-serif;
            font-weight: 400;
            font-style: normal;
        }

        .poppins-semibold {
            font-family: "Poppins", sans-serif;
            font-weight: 600;
            font-style: normal;
        }

        .poppins-bold {
            font-family: "Poppins", sans-serif;
            font-weight: 700;
            font-style: normal;
        }

        .poppins-extrabold {
            font-family: "Poppins", sans-serif;
            font-weight: 800;
            font-style: normal;
        }
    </style>
</head>

<body>

    <div class="jumbotron jumbotron-fluid position-relative"
        style="background-image: url('{{ asset('bg-website.jpg') }}');
        background-size: cover;
        background-position: center;
        height: 100vh; /* Mengatur tinggi jumbotron sesuai dengan tinggi layar */
        width: 100%; /* Mengatur lebar jumbotron agar mengisi seluruh lebar layar */">
        <!-- Overlay dengan efek redup -->
        <div class="position-absolute top-0 start-0 w-100 h-100"
            style="background-color: rgba(0, 0, 0, 0.5); /* Warna hitam dengan opacity 0.5 */"></div>

        <!-- Teks di tengah -->
        <div class="position-absolute top-50 start-50 translate-middle text-center text-white">
            <div class="container">
                <h1 class="display-3 fw-bold poppins-extrabold">Sistem Gudang</h1>
                <p class="poppins-medium">Aplikasi untuk mencatat barang dan mengelola kehadiran berbasis integrasi dengan Arduino, dan website</p>


                <!-- Bagian login/register sesuai dengan kondisi -->
                @if (Route::has('login'))
                    <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                        @auth
                            <a class="btn btn-outline-light btn-lg rounded-0 px-5 buttonfont" href="{{ url('/dashboard') }}"
                                role="button">Dashboard</a>
                        @else
                            <a class="btn btn-outline-light btn-lg rounded-0 px-5 buttonfont" href="{{ route('login') }}"
                                role="button">LOGIN</a>
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </div>






    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
