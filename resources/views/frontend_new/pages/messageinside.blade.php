<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message / View</title>

    <!-- Favicons -->
    <link href="{{ asset('assets/frontend/images/favicon-32x32.png')}}" rel="icon">
    <link href="{{ asset('assets_2/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

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
                    <button onclick="history.back()" class="btn btn-sm text-light"><i class="fa-solid fa-arrow-left text-light"></i></button>
                </div>

                <div class="col-2 p-0 d-flex align-items-center">
                    <img class="text-center" src="{{ asset('assets_2/img/icons/user.png')}}" alt="img">
                </div>

                <div class="col-8 p-0 d-flex align-items-center align-items-center">
                    <h4 class="text-light m-0">{{ $number}}</h4>
                </div>

                <div class="col-1 p-0 d-flex align-items-center align-items-center">
                    <div class="dropstart">
                        <a class="btn btn-sm dropdown-toggle text-light w-100" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </a>

                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Delete Chat</a></li>
                            <li><a class="dropdown-item" href="#">Add to Blocklist</a></li>
                            <li><a class="dropdown-item" href="#">Block and Report</a></li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>

    </section>
    <!-- Heading Section Ends -->

    <main class="main">

        <section class="main-section">
            <div class="conversation-day">
                
                <!-- Conversation Day-->
                <p class="text-center text-light">Today</p>

                <div class="container-fluid message-box">
                    @if($data->isEmpty())
                    <div class="col-12 p-0">
                        <p>No messages found</p>
                    </div>
                    @else
                    @foreach($data as $d)
                        @if($d['is_inbox'] ==  0)
                        <!-- Received Message -->
                            <div class="row">
                            <div class="col-10 message-receive-col">
                            <div class="message-receive-div">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-12 p-0">
                                            <p>{{$d['body']}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                            </div>
                        @else
                            <!-- Sent Message -->
                            <div class="row">
                            <div class="col-2">
                            </div>
                            <div class="col-10 message-sent-col">
                            <div class="message-sent-div">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-12 p-0">
                                            <p>{{$d['body']}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                    @endif
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->

    <footer class="bg-body-tertiary fixed-bottom text-center text-lg-start">
        <div class="container-fluid send-message-div p-0">
            <div class="row m-1 mb-0">
                <div class="col-9 p-0">
                    <input type="text" class="form-control" id="inputMessage" aria-describedby="Message"
                        placeholder="Type Here...">
                </div>
                <div class="col-3 p-0">
                    <button type="submit" class="btn btn-dark text-light w-100">Send</button>
                </div>

            </div>
        </div>
    </footer>




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
</body>

</html>