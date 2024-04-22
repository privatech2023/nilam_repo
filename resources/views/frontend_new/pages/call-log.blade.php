<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Call Log</title>

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
                <div class="col-10 p-0">
                    <div class="box">
                        <input type="text" name="search-call" placeholder="Search Contacts...">
                        <button type="submit" class="btn btn-sm text-light"><i class="fa fa-search"
                                style="color: black;" aria-hidden="true"></i></button>
                    </div>
                </div>
                <!-- <div class="col-1 p-0 d-flex align-items-center">
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
                </div> -->

            </div>
        </div>

    </section>
    <!-- Heading Section Ends -->



    <!-- Main Section -->

    <main class="main">
        <section class="main-section">
            <div class="container-fluid">
                <div class="row">
                    <!-- Incoming -->
                    <div class="col-lg-4 col-md-6 col-12 message-col">
                        <div class="call-div">
                            {{-- <div class="container-fluid call-container">
                                <div class="row tap">
                                    <div class="col-2 p-1 d-flex align-items-center">
                                        <a href="#">
                                            <img class="w-100" src="{{ asset('assets_2/img/icons/user.png')}}" alt="img">
                                        </a>
                                    </div>
                                    <div class="col-9 p-1">
                                        <h6 class="m-0">Elon Musk</h6>
                                        <p class="m-0">+919876543210</p>
                                        <p class="m-0">Mobile &nbsp;&nbsp;Incoming &nbsp; &nbsp; 11:11 AM</p>
                                    </div>
                                    <div class="col-1 p-1 d-flex align-items-center text-light">
                                        <a href="#" style="text-decoration: none;">
                                            <i class="fa-solid fa-phone text-light"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="row show">
                                    <hr>
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-3 text-center">
                                                <a href="#" style="text-decoration: none;">
                                                    <i class="fa-solid fa-phone text-light"></i>
                                                    <p class="text-light">Call</p>
                                                </a>
                                            </div>
                                            <div class="col-3 text-center">
                                                <a href="messageinside.html" style="text-decoration: none;">
                                                    <i class="fa-solid fa-message text-light"></i>
                                                    <p class="text-light">Message</p>
                                                </a>
                                            </div>
                                            <div class="col-3 text-center">
                                                <a href="call-history.html" style="text-decoration: none;">
                                                    <i class="fa-solid fa-clock-rotate-left text-light"></i>
                                                    <p class="text-light">History</p>
                                                </a>
                                            </div>
                                            <div class="col-3 text-center">
                                                <a href="#" style="text-decoration: none;">
                                                    <i class="fa-solid fa-trash text-light"></i>
                                                    <p class="text-light">Delete</p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>

                    <!-- Outgoing -->
                    {{-- <div class="col-lg-4 col-md-6 col-12 message-col">
                        <div class="call-div">
                            <div class="container-fluid call-container">
                                <div class="row tap">
                                    <div class="col-2 p-1 d-flex align-items-center">
                                        <a href="#">
                                            <img class="w-100" src="{{ asset('assets_2/img/icons/user.png')}}" alt="img">
                                        </a>
                                    </div>
                                    <div class="col-9 p-1">
                                        <h6 class="m-0">Elon Musk</h6>
                                        <p class="m-0">+919876543210</p>
                                        <p class="m-0">Mobile &nbsp;&nbsp;Outgoing &nbsp; &nbsp; 11:11 AM</p>
                                    </div>
                                    <div class="col-1 p-1 d-flex align-items-center text-light">
                                        <a href="#" style="text-decoration: none;">
                                            <i class="fa-solid fa-phone text-light"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="row show">
                                    <hr>
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-3 text-center">
                                                <a href="#" style="text-decoration: none;">
                                                    <i class="fa-solid fa-phone text-light"></i>
                                                    <p class="text-light">Call</p>
                                                </a>
                                            </div>
                                            <div class="col-3 text-center">
                                                <a href="messageinside.html" style="text-decoration: none;">
                                                    <i class="fa-solid fa-message text-light"></i>
                                                    <p class="text-light">Message</p>
                                                </a>
                                            </div>
                                            <div class="col-3 text-center">
                                                <a href="call-history.html" style="text-decoration: none;">
                                                    <i class="fa-solid fa-clock-rotate-left text-light"></i>
                                                    <p class="text-light">History</p>
                                                </a>
                                            </div>
                                            <div class="col-3 text-center">
                                                <a href="#" style="text-decoration: none;">
                                                    <i class="fa-solid fa-trash text-light"></i>
                                                    <p class="text-light">Delete</p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div> --}}

                    <!-- Missed Call -->
                    {{-- <div class="col-lg-4 col-md-6 col-12 message-col">
                        <div class="call-div">
                            <div class="container-fluid call-container">
                                <div class="row tap">
                                    <div class="col-2 p-1 d-flex align-items-center">
                                        <a href="#">
                                            <img class="w-100" src="{{ asset('assets_2/img/icons/user.png')}}" alt="img">
                                        </a>
                                    </div>
                                    <div class="col-9 p-1">
                                        <h6 class="m-0">Elon Musk</h6>
                                        <p class="m-0">+919876543210</p>
                                        <p class="m-0">Mobile &nbsp;&nbsp;Missed Call &nbsp; &nbsp; 11:11 AM</p>
                                    </div>
                                    <div class="col-1 p-1 d-flex align-items-center text-light">
                                        <a href="#" style="text-decoration: none;">
                                            <i class="fa-solid fa-phone text-light"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="row show">
                                    <hr>
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-3 text-center">
                                                <a href="#" style="text-decoration: none;">
                                                    <i class="fa-solid fa-phone text-light"></i>
                                                    <p class="text-light">Call</p>
                                                </a>
                                            </div>
                                            <div class="col-3 text-center">
                                                <a href="messageinside.html" style="text-decoration: none;">
                                                    <i class="fa-solid fa-message text-light"></i>
                                                    <p class="text-light">Message</p>
                                                </a>
                                            </div>
                                            <div class="col-3 text-center">
                                                <a href="call-history.html" style="text-decoration: none;">
                                                    <i class="fa-solid fa-clock-rotate-left text-light"></i>
                                                    <p class="text-light">History</p>
                                                </a>
                                            </div>
                                            <div class="col-3 text-center">
                                                <a href="#" style="text-decoration: none;">
                                                    <i class="fa-solid fa-trash text-light"></i>
                                                    <p class="text-light">Delete</p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </section>
    </main>

    <!-- Main Section Ends -->


    <!-- Footer Section -->

    <footer class="bg-body-tertiary fixed-bottom text-center text-lg-start m-2 contact-bg">
        <div class="container-fluid send-message-div p-0">
            <div class="row p-0">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6 p-0 d-flex justify-content-center active">
                            <a href="call-log.html" class="footer-btn">
                                <i class="fa-regular fa-clock"></i> <br> Recent
                            </a>
                        </div>
                        <div class="col-6 p-0 d-flex justify-content-center">
                            <a href="{{ url('/contacts')}}" class="footer-btn">
                                <i class="fa-regular fa-address-book"></i> <br> Contacts
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

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

    @php
    $user_id = session('user_id');
    @endphp
    <script>
        $(document).ready(function () {
            var user_id = {!! json_encode($user_id) !!};
            fetch_messages();

            $(document).on('click','.tap', function () {
                var act = $(this).closest(".call-container").hasClass("call-bg");
                if (act == 0) {
                    console.log(act)
                    $(".show").slideUp();
                    $(".call-container").removeClass("call-bg");
                }
                $(this).next(".show").slideToggle("slow");
                $(this).closest(".call-container").toggleClass("call-bg");
            });

            function fetch_messages(){
                $.ajax({
                    type: "get",
                    url: "/get-call-logs/"+user_id,
                    dataType: "json",
                    success: function (response) {
                        console.log(response.calls)
                        var url = "{{ asset('assets_2/img/icons/user.png')}}";
                        $.each(response.calls, function(index, call) {
                            var datetimeString = call.date;
                var dateTime = new Date(datetimeString);

                // Extracting date
                    var year = dateTime.getFullYear();
                    var month = ("0" + (dateTime.getMonth() + 1)).slice(-2);
                    var day = ("0" + dateTime.getDate()).slice(-2);
                    var formattedDate = year + "-" + month + "-" + day;


                    var hours = dateTime.getHours() % 12 || 12;
                    var minutes = ("0" + dateTime.getMinutes()).slice(-2);
                    var period = dateTime.getHours() >= 12 ? "PM" : "AM"; 
                    var formattedTime = hours + ":" + minutes + " " + period;


                var callContent = '<div class="container-fluid call-container">' +
                                '<div class="row tap">' +
                                    '<div class="col-2 p-1 d-flex align-items-center">' +
                                        '<a href="#">' +
                                            '<img class="w-100" src="'+url+'" alt="img">' +
                                        '</a>' +
                                    '</div>' +
                                    '<div class="col-9 p-1">' +
                                        '<h6 class="m-0">' + call.name + '</h6>' +
                                        '<p class="m-0">' + call.number + '</p>' +
                                        '<p class="m-0">&nbsp;&nbsp;' + call.duration + '&nbsp;&nbsp;' + formattedTime + ' &nbsp;&nbsp;'+formattedDate+'</p>' +
                                    '</div>' +
                                    '<div class="col-1 p-1 d-flex align-items-center text-light">' +
                                        '<a href="#" style="text-decoration: none;">' +
                                            '<i class="fa-solid fa-phone text-light"></i>' +
                                        '</a>' +
                                    '</div>' +
                                '</div>' +
                                '<div class="row show">' +
                                    '<hr>' +
                                    '<div class="container-fluid">' +
                                        '<div class="row">' +
                                            '<div class="col-3 text-center">' +
                                                '<a href="#" style="text-decoration: none;">' +
                                                    '<i class="fa-solid fa-phone text-light"></i>' +
                                                    '<p class="text-light">Call</p>' +
                                                '</a>' +
                                            '</div>' +
                                            '<div class="col-3 text-center">' +
                                                '<a href="messageinside.html" style="text-decoration: none;">' +
                                                    '<i class="fa-solid fa-message text-light"></i>' +
                                                    '<p class="text-light">Message</p>' +
                                                '</a>' +
                                            '</div>' +
                                            '<div class="col-3 text-center">' +
                                                '<a href="call-history.html" style="text-decoration: none;">' +
                                                    '<i class="fa-solid fa-clock-rotate-left text-light"></i>' +
                                                    '<p class="text-light">History</p>' +
                                                '</a>' +
                                            '</div>' +
                                            '<div class="col-3 text-center">' +
                                                '<a href="#" style="text-decoration: none;">' +
                                                    '<i class="fa-solid fa-trash text-light"></i>' +
                                                    '<p class="text-light">Delete</p>' +
                                                '</a>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>' +
                                '</div>' +
                            '</div>';
                $('.call-div').append(callContent);
            });
                }
            });
            }
        });
    </script>

</body>

</html>