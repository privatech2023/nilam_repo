<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Screen Record</title>

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
<style>
    .delete-btn{
        margin-left: 50%;
        border-radius: 15px;
    }
                .video-container {
        position: relative; /* Set position to relative */
        width: 46%; 
        height: auto; 
        /* overflow: hidden;  */
    }
    
    .video-container p {
        /* position: absolute;  */
        bottom: 0;
        width: 100%;
        text-align: left;
        background-color: rgba(255, 255, 255, 0.7);
        margin: 0;
        padding: 5px 10px; 
        border-radius: 10px;
    }
    
    .video-container video {
        width: 100%; /* Set video width to 100% */
        border-radius: 5px;
        box-shadow: 0 4px 6px rgba(61, 34, 79, 0.5);
    }
    
    @media screen and (max-width: 1228px) {
        .video-container {
            width: 100%; 
        }
        .delete-btn{
        margin-left: 30%;
        border-radius: 15px;
    }
    }
    
            </style>
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
                    <h4>Screen record</h4>
                </div>
                <div style="display: flex; justify-content: center;">
                    <button class="btn btn-outline-primary btn-sm" id="record-screen">Record screen</button>
                </div>
            </div>
        </div>

    </section>
    <!-- Heading Section Ends -->



    <!-- Main Section -->
    <main class="main" style="margin-top: 9rem;">
        <div class="text-center loader" style="display:none;  background-color: rgba(0, 0, 0, 0.5); z-index: 9999;">
            <div class="spinner-border" role="status">
            <span class="sr-only" style="color:white;">Loading...</span>
            </div>
        </div>
        <section class="main-section">
            <div class="container-fluid">
                {{-- <div class="row">
                    <div class=" col-12">
                        <div class="container-fluid">
                            <div class="row">
                                
                                @if($screenRecordings->count() > 0)
                                @foreach($screenRecordings as $video)
                                <video controls class="w-full h-full">
                                    <source src="{{$video->s3Url()}}" type="video/mp4">
                                    Your browser does not support the video element.
                                </video>
                                @endforeach
                                @else  
                                <p style="color: white;">No screen recordings</p>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>  --}}
                <div class="border-2 p-1 rounded-md" style="display: flex; flex-wrap: wrap; gap: 10px; overflow-y: auto; height:83%;" >
                    @foreach($screenRecordings as $video)
            <div class="video-container" >
                <video controls class="w-full h-full">
                    <source src="{{$video->s3Url()}}" type="video/mp4">
                    Your browser does not support the video element.
                </video>
                <p >
                    {{ $video->created_at->format('M d, Y h:i A') }}
                    <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="{{$video->id}}">Delete</button>
                </p>  
            </div>
            @endforeach
                </div>
            </div>
        </section>
    </main>
    <!-- Main Section Ends -->


    <div class="modal" id="deleteModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h6 class="modal-title text-md">Are you sure you want to delete this item ?</h6>
              <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{ url('/delete/screen-record')}}" method="post">
                @csrf
            <div class="modal-footer">
                <input type="hidden" name="id" id="deleteItemId" value=""/>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
              <button type="submit" class="btn btn-primary">Yes</button>
            </div>
        </form>
          </div>
        </div>
    </div>
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

            $(document).on('click','.delete-btn', function () {
            var id = this.getAttribute('data-id');
                document.getElementById('deleteItemId').value = id;
                $('#deleteModal').modal('show');
                console.log('hey')
            });

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

            $('#record-screen').on('click', function () {
                $.ajax({
                    type: "get",
                    url: "/take-screen-record",
                    dataType: "json",
                    success: function (response) {
                        console.log(response.message);
                        $('.loader').show();
                        setTimeout(function() {
                        $('.loader').hide();
                        location.reload();
                        }, 10000);
                    }
                });
            });
        });
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