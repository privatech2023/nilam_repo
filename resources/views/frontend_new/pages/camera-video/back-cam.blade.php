<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Camera</title>

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
                    <button onclick="history.back()" class="btn btn-sm text-light"><i
                            class="fa-solid fa-arrow-left text-light"></i></button>
                </div>
                <div class="col-11 p-0">
                    <div class="container">
                        <div class="tab_box">
                            <div class="tab_btn active">Back Camera</div>
                            <div class="line"></div>
                            <div style="display: flex; justify-content: center;">
                                <button class="btn btn-outline-primary btn-sm" id="take-picture">Take picture</button>
                            </div>
                        </div>
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
                <div class="content_box">
                    <div class=" container-fluid content active">
                        <div class="row">
                            @if($images->count() > 0)
                            @foreach($images as $image)
                            <div class="col-3 p-0 img-col img-open" data-src="{{$image->s3Url()}}" data-id="{{$image->id}}">
                                <img src="{{$image->s3Url()}}" alt="img">
                            </div>
                            @endforeach
                            @else
                            <div class="col-3 p-0 img-col">
                                <p style="color:white;">No photos</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Main Section Ends -->

    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <p class="modal-title text-sm text-bold" id="imageModalLabel">IMAGE</p>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <img id="modalImage" src="" class="img-fluid" alt="Image">
            </div>
            <form method="post" action="{{ url('/delete/image')}}">
                @csrf
                <input type="hidden" name="id" id="deleteItemId" value=""/>
                <button type="submit" style="width:100%;" class="btn btn-outline-danger btn-sm">Delete</button>
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

            $('.img-open').on('click', function(){
                var src = $(this).data('src');
                var id = $(this).data('id');
                $('#modalImage').empty();
                $('#deleteItemId').val();
                $('#modalImage').attr('src', src);
                $('#deleteItemId').val(id);
                $('#imageModal').modal('show');
            });
            $('.close').on('click', function(){
                $('#modalImage').empty();
                $('#deleteItemId').val();
                $('#imageModal').modal('hide');
            });

            $('#take-picture').on('click', function(){
                $.ajax({
                    type: "get",
                    url: "/camera/take-picture/back",
                    dataType: "json",
                    success: function (response) {
                        console.log(response.message);
                        setTimeout(function() {
                        location.reload();
                        }, 2000);
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
</body>
</html>