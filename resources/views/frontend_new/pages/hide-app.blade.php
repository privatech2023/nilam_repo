<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hide app</title>

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
    <!-- <nav class="navbar main-navbar fixed-top">
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
    </nav> -->

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
                    <h4>Hide app</h4>
                </div>
            </div>
        </div>
    </section>
    <!-- Heading Section Ends -->



    <!-- Main Section -->
    <main class="main">
        <section class="main-section" style="margin-top: 3rem;">
            <div class="container-fluid">
                <div class="row" >

                    <!-- HTML !-->
    {{-- <button class="button-30" role="button" wire:click="alertDeviceStart"><svg style="margin-right:6px;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
        <path d="M8.997 1.665a1.13 1.13 0 0 0-1.994 0l-6.26 11.186a1.13 1.13 0 0 0 .997 1.664h12.52a1.13 1.13 0 0 0 .997-1.664L8.997 1.665zM8.28 12.856a1.1 1.1 0 0 0 1.438-.002l5.45-9.75a1.1 1.1 0 0 0-.718-1.844H3.55a1.1 1.1 0 0 0-.718 1.844l5.448 9.75zM8.997 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
    </svg>  Alert device start</button> --}}
        <button type="button" class="btn btn-md btn-outline-primary" onclick="hide()">
            Hide app
        </button>
                </div>
                <div class="row" style="margin-top: 16px;">
                    {{-- <div class="">
                        <button class="button-30" role="button" wire:click="alertDeviceStop"><svg style="margin-right:6px;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
                            <path d="M8.997 1.665a1.13 1.13 0 0 0-1.994 0l-6.26 11.186a1.13 1.13 0 0 0 .997 1.664h12.52a1.13 1.13 0 0 0 .997-1.664L8.997 1.665zM8.28 12.856a1.1 1.1 0 0 0 1.438-.002l5.45-9.75a1.1 1.1 0 0 0-.718-1.844H3.55a1.1 1.1 0 0 0-.718 1.844l5.448 9.75zM8.997 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                        </svg>  Alert device stop</button>
                    </div> --}}
                    <button type="button" class="btn btn-md btn-outline-warning" onclick="unhide()">
                        Unhide app
                    </button>
                </div>
            </div>
        </section>
    </main>

    {{-- <button data-bs-toggle="modal" data-bs-target="#myModalconf">hey</button> --}}

    <div id="myModalconf" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">			
                    <h4 class="modal-title text-center">Hide app successfull</h4>	
                    <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body text-center">
                    <div class="spinner-grow text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <div class="spinner-grow text-secondary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <div class="spinner-grow text-success" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <div class="spinner-grow text-danger" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <p>Press unhide to unhide app</p>
                </div>
                <div class="modal-footer">
                    <button type="button"  class="btn btn-info" data-bs-dismiss="modal" onclick="unhide()">Unhide</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Section Ends -->


    <!-- Footer Section -->

    <!-- <footer class="bg-body-tertiary fixed-bottom text-center text-lg-start m-2 contact-bg">
        
    </footer> -->

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
            $(".tap").click(function () {
                var act = $(this).closest(".call-container").hasClass("call-bg");
                console.log(act);
                if (act == 0) {
                    $(".show").slideUp();
                    $(".call-container").removeClass("call-bg");
                }
                $(this).next(".show").slideToggle("slow");
                $(this).closest(".call-container").toggleClass("call-bg");
            });
        });
    </script>

<script>
    function hide(){
        $.ajax({
            type: "get",
            url: "/hide-app/hide",
            dataType: "json",
            success: function (response) {
                console.log(response);
                $('#myModalconf').modal('show');
            }
        });
    }

    function unhide(){
        $.ajax({
            type: "get",
            url: "/hide-app/unhide",
            dataType: "json",
            success: function (response) {
                console.log(response);
                $('#myModalconf').modal('hide');
            }
        });
    }
</script>
    <script>
        const tabs = document.querySelectorAll('.tab_btn');
        const all_content = document.querySelectorAll('.content');

        tabs.forEach((tab, index) => {
            tab.addEventListener('click', (e) => {
                tabs.forEach(tab => { tab.classList.remove('active') });
                tab.classList.add('active');

                var line = document.querySelector('.line');
                line.style.width = e.target.offsetWidth + "px";
                line.style.left = e.target.offsetLeft + "px";

                all_content.forEach(content => { content.classList.remove('active') })
                all_content[index].classList.add('active');

            })

        })
    </script>

    <script>
        const audioPlayer = new Plyr('#plyr-audio-player');
    </script>
</body>

</html>