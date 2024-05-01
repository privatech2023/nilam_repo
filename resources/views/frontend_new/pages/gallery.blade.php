<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>

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
                            <div class="tab_btn active">Photos</div>
                            <div class="tab_btn">Albums</div>
                            <div class="line"></div>
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
                    <div class="container-fluid content active">
                        <div class="row">
                            @if($plan_expired == true)
                            @foreach($gallery_items as $image)
                            <div class="col-3 p-0 img-col">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#expire_modal">
                                    <img class="img-class" src="{{ $image->s3Url() }}" alt="img" style="filter: blur(5px);">
                                </a>
                            </div>
                            @endforeach
                            @else
                            @foreach($gallery_items as $image)
                            <div class="col-3 p-0 img-col">
                                <a href="{{ $image->s3Url() }}"><img class="img-class" src="{{ $image->s3Url() }}" alt="img" ></a>
                            </div>
                            @endforeach 
                            @endif
                        </div>
                    </div>
                    <div class="content container-fluid">
                        <div class="row">
                            <!-- Gallery Album -->
                            {{-- <div class="col-4">
                                <a href="album.html">
                                    <div class="album-box d-flex justify-content-center"></div>
                                    <div class="album-name text-light">
                                        <p>Album Name</p>
                                    </div>
                                </a>
                            </div>
                            <!-- Gallery Album -->
                            <div class="col-4">
                                <a href="album.html">
                                    <div class="album-box d-flex justify-content-center"></div>
                                    <div class="album-name text-light">
                                        <p>Album Name</p>
                                    </div>
                                </a>
                            </div>
                            <!-- Gallery Album -->
                            <div class="col-4">
                                <a href="album.html">
                                    <div class="album-box d-flex justify-content-center"></div>
                                    <div class="album-name text-light">
                                        <p>Album Name</p>
                                    </div>
                                </a>
                            </div> --}}
                        </div>
                        <hr>
                        
                        <div class="row">
                            <p class="text-light">Coming soon</p>
                            <!-- Gallery Album -->
                            {{-- <div class="col-4">
                                <a href="album.html">
                                    <div class="album-box d-flex justify-content-center"></div>
                                    <div class="album-name text-light">
                                        <p>Album Name</p>
                                    </div>
                                </a>
                            </div> --}}
                            {{-- <!-- Gallery Album -->
                            <div class="col-4">
                                <a href="album.html">
                                    <div class="album-box d-flex justify-content-center"></div>
                                    <div class="album-name text-light">
                                        <p>Album Name</p>
                                    </div>
                                </a>
                            </div>
                            <!-- Gallery Album -->
                            <div class="col-4">
                                <a href="album.html">
                                    <div class="album-box d-flex justify-content-center"></div>
                                    <div class="album-name text-light">
                                        <p>Album Name</p>
                                    </div>
                                </a>
                            </div> --}}
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </main>

    {{-- store modal --}}
    <div class="modal fade" id="store_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="true">
        <div class="modal-dialog modal-frame modal-notify modal-success modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row d-flex justify-content-center align-items-center">
                        <p class="pt-3 mx-4">Storage full. Please buy a storage plan to enjoy our gallery service
                            <strong></strong>.
                        </p>
                        <a href="{{ url('/storage-plan')}}" class="btn btn-success">Get it
                            <i class="fas fa-book ml-1 white-text"></i>
                        </a>
                        <a type="button" class="btn btn-outline-success waves-effect close1" data-dismiss="modal">No, thanks</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- expire modal --}}
    <div class="modal fade" id="expire_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="true">
        <div class="modal-dialog modal-frame modal-notify modal-success modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row d-flex justify-content-center align-items-center">
                        <p class="pt-3 mx-4">Plan expired. Please buy new storage plan.
                            <strong></strong>.
                        </p>
                        <a href="{{ url('/storage-plan')}}" class="btn btn-success">Get it
                            <i class="fas fa-book ml-1 white-text"></i>
                        </a>
                        <a type="button" class="btn btn-outline-success waves-effect close2" data-dismiss="modal">No, thanks</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- image modal --}}
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="imageModalLabel">Image View</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <img id="modalImage" src="" class="img-fluid" alt="Image">
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
    <!-- Latest compiled and minified Bootstrap JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/js/bootstrap.min.js" integrity="sha512-a6ctI6w1kg3J4dSjknHj3aWLEbjitAXAjLDRUxo2wyYmDFRcz2RJuQr5M3Kt8O/TtUSp8n2rAyaXYy1sjoKmrQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    

    @php
    $store_more = $store_more;
    $plan_expired = $plan_expired;
    @endphp

    <script>
        function openModal(){
            $('#expire').modal('show');
        }
    </script>
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
            // gallery
            const storeMoreValue = {!! json_encode($store_more) !!};
            const plan = {!! json_encode($plan_expired) !!};
            if(storeMoreValue == false){
            $('#store_modal').modal('show');
            }
            if(storeMoreValue == true){
            $('#expire').modal('show');
            }       
            $(document).on('click', '.close1', function(){
                $('#store_modal').modal('hide');
            });
            $(document).on('click', '.close2', function(){
                $('#expire_modal').modal('hide');
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

{{-- <script>
    document.addEventListener('livewire:load', function () {
        console.log('hey')
        const storeMoreValue = {!! json_encode($store_more) !!};
        const plan = {!! json_encode($plan_expired) !!};
        if(storeMoreValue == false){
            $('#store_modal').modal('show');
        }
        if(storeMoreValue == true){
            $('#expire').modal('show');
        }       
        $(document).on('click','.delete', function () {
            var id = this.getAttribute('data-id');
            document.getElementById('deleteItemId').value = id;
            $('#deleteModal').modal('show');
        });
        Livewire.on('loadmore', function () {
            if(storeMoreValue == false){
            $('#store_modal').modal('show');
            }
            if(storeMoreValue == true){
            $('#expire').modal('show');
            } 
        });

        $('.view-button').click(function() {
            var imageUrl = $(this).data('src');
            $('#modalImage').attr('src', imageUrl);
        });
    });

</script> --}}

</body>

</html>