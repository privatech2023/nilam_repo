<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sim Details</title>

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
                    <h4>Sim Details</h4>
                </div>
            </div>
        </div>

    </section>
    <!-- Heading Section Ends -->



    <!-- Main Section -->

    <main class="main">
        <section class="main-section">

            <div class="container-fluid device-status">
                @if(count($data) != 0)
                @foreach($data as $d)
                
                <div class="row">
                    <div class="col-7 p-0 text-light">
                        <h6><b>Sim slot 1</b></h6>
                    </div>
                    <div class="col-7 p-0 text-light">
                        <p>{{$d['operator']}}&nbsp;/&nbsp;{{$d['area'] == 'in' ? 'India' : $d['area']}} </p>
                    </div>
                </div>
                @endforeach
                @else
                <div class="col-7 p-0 text-light">
                    <h6><b>Device not synced</b></h6>
                </div>
                @endif
            </div>
            {{-- <div class="container-fluid device-status">

                <div class="row">
                    <h6 class="info-weight text-light p-0">
                        Data Sim
                    </h6>
                    <div class="data-sim mb-3">
                        <div class="container-fluid p-0">
                            <div class="row">
                                <div class="col-6 p-0">
                                    <div class="clickable-div active sim-toggle text-light"
                                        onclick="toggleActive(this)">Sim 1</div>
                                </div>
                                <div class="col-6 p-0">
                                    <div class="clickable-div sim-toggle text-light" onclick="toggleActive(this)">Sim 2
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h6 class="info-weight text-light p-0">
                        Settings
                    </h6>
                    <div class="row p-0">
                        <div class="col-10 p-0">
                            <div class="container-fluid p-0">
                                <div class="row">
                                    <div class="col-12 p-0 text-light">
                                        <h6><b> Mobile Data</b></h6>
                                    </div>
                                    <div class="col-12 p-0 text-light">
                                        <p>Allow this device to use Mobile Data</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 d-flex align-items-center">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                    id="flexSwitchCheckChecked" checked>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </section>
    </main>

    <!-- Main Section Ends -->


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
            $('.clickable-div').removeClass('active');

            // Add 'active' class to the clicked div
            $(clickedDiv).addClass('active');
        }
    </script>

</body>

</html>
