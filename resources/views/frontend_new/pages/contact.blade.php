<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacts</title>

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

            </div>
        </div>

    </section>
    <!-- Heading Section Ends -->



    <!-- Main Section -->

    <main class="main">
        <section class="main-section">
            <div class="container-fluid">
                <div class="row">
                    <!-- Contacts -->
                    <div class="col-lg-4 col-md-6 col-12 message-col">
                        <div class="call-div">
                            <div class="container-fluid contacts-populate">
                            </div>
                        </div>
                    </div>
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
                        <div class="col-6 p-0 d-flex justify-content-center">
                            <a href="call-log.html" class="footer-btn">
                                <i class="fa-regular fa-clock"></i> <br> Recent
                            </a>
                        </div>
                        <div class="col-6 p-0 d-flex justify-content-center active">
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
            $(document).on('click','.tap',function () {
                var act = $(this).closest(".call-container").hasClass("call-bg");
                console.log(act);
                if (act == 0) {

                    $(".show").slideUp();
                    $(".call-container").removeClass("call-bg");
                }
                $(this).next(".show").slideToggle("slow");
                $(this).closest(".call-container").toggleClass("call-bg");
            });
            var user_id = {!! json_encode($user_id) !!};
            $.ajax({
                type: "get",
                url: "/get-contacts/"+user_id,
                dataType: "json",
                success: function (response) {
                    var url = "{{ asset('assets_2/img/icons/user.png')}}"
                    console.log(response.contacts)
                    response.contacts.forEach(function(contact) {
                    var div = $('<div class="row">' +
                        '<div class="col-2 p-1 d-flex align-items-center">' +
                            '<a href="#">' +
                                '<img class="w-100" src="'+url+'" alt="img">' +
                            '</a>' +
                        '</div>' +
                        '<div class="col-9 p-1 " >' +
                            '<h6 class="m-0">' + contact.name + '</h6>' +
                            '<p class="m-0 text-lg" style="font-size: 15px;">'+contact.number+'</p>' +
                        '</div>' +
                        '<hr>' +
                    '</div>');
                $('.contacts-populate').append(div);
            });
                }
            });
        });
    </script>
</body>

</html>