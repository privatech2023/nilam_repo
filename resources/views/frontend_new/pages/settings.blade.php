<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Settings</title>

    <!-- Favicons -->
    <link href="{{ asset('assets/frontend/images/favicon-32x32.png')}}" rel="icon">
    <link href="{{ asset('assets_2/img/apple-touch-icon.png" rel="apple-touch-icon')}}" rel="apple-touch-icon">

    <!-- bootstrap CDN -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Fontawesome CDN -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Poppins CDN -->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Custom CSS -->

    <link rel="stylesheet" href="{{ asset('assets_2/css/style.css')}}">


</head>

<body class="page-body">

    <!--  Header Section -->
    <nav class="navbar main-navbar fixed-top">
        <div class="container">
            <div class="left-div text-light">
                <b>11:11 AM </b>
            </div>
            <div class="right-div text-light">
                <i class="fa-solid fa-signal"></i>
                <i class="fa-solid fa-signal"></i>
                <i class="fa-solid nav-icons fa-wifi"></i>
                <i class="fa-solid nav-icons fa-battery-full"></i>
                <b>99%</b>
            </div>
        </div>
    </nav>

    <!--  Header Section Ends -->

    <!-- heading Section -->
    <section class="heading fixed-top mt-4">

        <div class="container-fluid p-0">
            <div class="row m-2 heading-row">

                <div class="col-1 p-0 d-flex align-items-center justify-content-center">
                    <button onclick="history.back()" class="btn btn-sm text-light"><i
                            class="fa-solid fa-arrow-left text-light"></i></button>
                </div>
                <div class="col-10 d-flex align-items-center justify-content-center text-light">
                    <h4>Settings</h4>
                </div>
            </div>
        </div>

    </section>
    <!-- Heading Section Ends -->



    <!-- Main Section -->

    <main class="main">
        <section class="main-section">
            <div class="container-fluid device-status">
                <h1 class="text-light mb-2">Device</h1>
                {{-- <a class="text-light p-0 m-2 text-decoration-none" href="sim-details.html">
                    <div class="row">
                        <div class="col-10">
                            <h6><b>Sim Settings</b></h6>
                        </div>
                        <div class="col-2 d-flex justify-content-end">
                            <i class="fa-solid fa-angle-right"></i>

                        </div>
                    </div>
                </a> --}}
                <a class="text-light p-0 m-2 text-decoration-none" href="{{ url('/device-status')}}">
                    <div class="row">
                        <div class="col-10">
                            <h6><b>Device Status</b></h6>
                        </div>
                        <div class="col-2 d-flex justify-content-end">
                            <i class="fa-solid fa-angle-right"></i>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Other Settings -->
            <div class="container-fluid device-status">
                <h1 class="text-light mb-2">Other Settings</h1>
                <a class="text-light p-0 m-2 text-decoration-none" href="#" data-bs-toggle="modal"
                    data-bs-target="#deviceModal">
                    <div class="row">
                        <div class="col-10">
                            <h6><b>Change Device</b></h6>
                        </div>
                        <div class="col-2 d-flex justify-content-end">
                            <i class="fa-solid fa-angle-right"></i>

                        </div>
                    </div>
                </a>
                <a class="text-light p-0 m-2 text-decoration-none" href="#" data-bs-toggle="modal"
                    data-bs-target="#bgModal">
                    <div class="row">
                        <div class="col-10">
                            <h6><b>Change Background Image</b></h6>
                        </div>
                        <div class="col-2 d-flex justify-content-end">
                            <i class="fa-solid fa-angle-right"></i>

                        </div>
                    </div>
                </a>



                <a class="text-light p-0 m-2 text-decoration-none" href="device-status.html">
                    <div class="row">
                        <a href="{{ url('client/logout')}}" style="text-decoration: none;">
                            <div class="col-10">
                                <h6><b>Log Out</b></h6>
                            </div>
                        </a>
                    </div>
                </a>
            </div>
        </section>
    </main>

    <!-- Main Section Ends -->


    <!-- modal Section -->

    <div class="modal fade" id="deviceModal" tabindex="-1" aria-labelledby="deviceModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-light">
                <div class="modal-header">
                    <h5 class="modal-title" id="deviceModalLabel">Control Another Device</h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            @foreach($devices as $d)
                            @if($client->device_id == $d['device_id'])
                            <a href="{{ url('/default-device'.'/'.$d->device_id) }}" style="text-decoration: none; color:white;"><div class="col-12 device-div active" onclick="toggleActive(this)">{{$d['device_name']}}</div></a>
                            @else
                            <a href="{{ url('/default-device'.'/'.$d->device_id) }}" style="text-decoration: none; color:white;"><div class="col-12 device-div" onclick="toggleActive(this)">{{$d['device_name']}}</div></a>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="bgModal" tabindex="-1" aria-labelledby="deviceModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-light">
                <div class="modal-header">
                    <h5 class="modal-title" id="bgModalLabel">Change Background</h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row d-flex justify-content-center">
                            <div class="col-5 p-1 choose-bg-div">
                                <img src="{{ asset('assets_2/img/main-wallpaper.jpg')}}" alt="" class="bg-image" data-src="{{ asset('assets_2/img/main-wallpaper.jpg')}}">
                            </div>
                            <div class="col-5 p-1 choose-bg-div">
                                <img src="{{ asset('assets_2/img/billy-huynh-W8KTS-mhFUE-unsplash.jpg')}}" alt="" class="bg-image" data-src="{{ asset('assets_2/img/billy-huynh-W8KTS-mhFUE-unsplash.jpg')}}">
                            </div>
                        </div>
                    </div>
                </div>
                <a href="{{ url('/change-background-gallery')}}" ><button class="btn btn-outline-primary btn-sm" style="width: 100%; color:white;">Select from gallery</button></a>
            </div>
        </div>
    </div>

    <!-- modal Section Ends -->

    <!-- Footer Section -->



    <!-- Footer Section Ends -->

    <!-- Bootstrap Script -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

    <!-- Fontawesome Script -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"
        integrity="sha512-GWzVrcGlo0TxTRvz9ttioyYJ+Wwk9Ck0G81D+eO63BaqHaJ3YZX9wuqjwgfcV/MrB2PhaVX9DkYVhbFpStnqpQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- JQuery Script -->

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script>
        function toggleActive(clickedDiv) {
            // Remove 'active' class from all divs
            $('.device-div').removeClass('active');

            // Add 'active' class to the clicked div
            $(clickedDiv).addClass('active');
        }
    </script>
    <script>
        $(document).ready(function () {
            var bgImages = document.querySelectorAll('.bg-image');
            $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
    bgImages.forEach(function(img) {
        img.addEventListener('click', function() {
            var selectedImgUrl = this.getAttribute('data-src');
            $.ajax({
                type: "post",
                url: "/settings/set-background",
                data: {
                imageUrl: selectedImgUrl 
                },
                dataType: "json",
                success: function (response) {
                    console.log(response)
                    $('#bgModal').modal('hide');
                }
            });
        });
    });
    });
    </script>
</body>

</html>