<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Device Status</title>

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
    {{-- <nav class="navbar main-navbar fixed-top">
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
    </nav> --}}

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
                    <h4>Device Status</h4>
                </div>
                <div style="display: flex; justify-content: center;">
                    <button class="btn btn-outline-primary btn-sm" id="get-status">Get status</button>
                </div>
            </div>
        </div>

    </section>
    <!-- Heading Section Ends -->



    <!-- Main Section -->

    <main class="main" style="margin-top:8rem;">
        <section class="main-section">
            <div class="container-fluid device-status">
                <h1 class="text-light mb-4">Status</h1>
                {{-- <div class="row">
                    <div class="col-7 p-0 text-light"> <h6><b> Battery Status</b></h6></div>
                    <div class="col-5 p-0 text-light d-flex justify-content-end"> <h6 class="info-weight"><span class=" charging-class">Not </span>&nbsp; Charging</h6></div>
                </div> --}}
                <div class="row">
                    @if($status !== 0)
                    <div class="col-7 p-0 text-light"> <h6><b> Battery Level</b></h6></div>
                    <div class="col-4 p-0 text-light d-flex justify-content-end"> <h6><span class="info-weight battery-parcent">{{$status->battery}} %</span></h6></div>

                    <div class="col-7 p-0 text-light"> <h6><b> Brand</b></h6></div>
                    <div class="col-4 p-0 text-light d-flex justify-content-end"> <h6><span class="info-weight battery-parcent">{{$status->brand}}</span></h6></div>
                    
                    <div class="col-7 p-0 text-light"> <h6><b> Model</b></h6></div>
                    <div class="col-4 p-0 text-light d-flex justify-content-end"> <h6><span class="info-weight battery-parcent">{{$status->model}}</span></h6></div>
                    
                    <div class="col-7 p-0 text-light"> <h6><b> Android version</b></h6></div>
                    <div class="col-4 p-0 text-light d-flex justify-content-end"> <h6><span class="info-weight battery-parcent">{{$status->android_version}}</span></h6></div>
                    


                    <div style="margin-top: 20px; margin-left: 20px; height: 90%; overflow-x: auto;" id="cont" >
                        <div class="row" >
                            <div style="width:80%;">
                                
            @if( $status->updated_at)
            @php
                $updatedTime = \Carbon\Carbon::parse($status->updated_at);
                $currentTime = \Carbon\Carbon::now();
                $timeDifference = $updatedTime->diff($currentTime);
        
                $formattedTime = '';
                if ($timeDifference->y > 0) {
                    $formattedTime = $timeDifference->y . ' years ago';
                } elseif ($timeDifference->m > 0) {
                    $formattedTime = $timeDifference->m . ' months ago';
                } elseif ($timeDifference->d > 0) {
                    $formattedTime = $timeDifference->d . ' days ago';
                } elseif ($timeDifference->h > 0) {
                    $formattedTime = $timeDifference->h . ' hours ago';
                } elseif ($timeDifference->i > 0) {
                    $formattedTime = $timeDifference->i . ' minutes ago';
                } else {
                    $formattedTime = 'just now';
                }
                @endphp
        
                <div class="alert alert-success" style="width: 60%;">
                Last updated: {{ $formattedTime }}
                </div>
                <br>
                @endif                      
                            </div>
                        </div>
                    </div>


                    @endif
                </div>
               
            </div>
            {{-- <div class="container-fluid device-status">
                <h6 class="info-weight text-light">
                    BASIC INFO
                </h6>
                <div class="row">
                    <div class="col-7 p-0 text-light"> <h6><b> Phone number (sim slot 1)</b></h6></div>
                    <div class="col-7 p-0 text-light"> <p>+919999999999</p></div>
                </div>
                <div class="row">
                    <div class="col-7 p-0 text-light"> <h6><b> Phone number (sim slot 2)</b></h6></div>
                    <div class="col-7 p-0 text-light"> <p>+919999999999</p></div>
                </div>
            </div> --}}
            {{-- <div class="container-fluid device-status">
                <h6 class="info-weight text-light">
                    DEVICE INFO
                </h6>
                <div class="row">
                    <div class="col-7 p-0 text-light"> <h6><b> Sim Status(sim slot 1)</b></h6></div>
                    <div class="col-7 p-0 text-light"> <p>JIO 5g -Jio</p></div>
                </div>
                <div class="row">
                    <div class="col-7 p-0 text-light"> <h6><b> Sim Status (sim slot 2)</b></h6></div>
                    <div class="col-7 p-0 text-light"> <p>Airtel</p></div>
                </div>
                <div class="row">
                    <div class="col-7 p-0 text-light"> <h6><b> Model</b></h6></div>
                    <div class="col-7 p-0 text-light"> <p>iPhone 14 Pro </p></div>
                </div>
                <div class="row">
                    <div class="col-7 p-0 text-light"> <h6><b> IMEI (sim slot 1)</b></h6></div>
                    <div class="col-7 p-0 text-light"> <p>999999999999999</p></div>
                </div>
                <div class="row">
                    <div class="col-7 p-0 text-light"> <h6><b> IMEI (sim slot 2)</b></h6></div>
                    <div class="col-7 p-0 text-light"> <p>999999999999999</p></div>
                </div>
            </div> --}}
            {{-- <div class="container-fluid device-status">
                <h6 class="info-weight text-light">
                    DEVICE IDENTIFIERS
                </h6>
                <div class="row">
                    <div class="col-7 p-0 text-light"> <h6><b> IP Address</b></h6></div>
                    <div class="col-7 p-0 text-light"> <p>192.168.61.169 <br>fe11::5491:44ff:fe94:912f</p></div>
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
    $(document).ready(function () {
        $(document).on('click','#get-status', function(){
            $.ajax({
                type: "get",
                url: "/device-status/get-status",
                dataType: "json",
                success: function (response) {
                    console.log(response.message);
                    location.reload();
                }
            });
        });
    });
</script>
</body>

</html>
