@extends('layout')

@section('title', 'story')  

@auth
{{ csrf_field() }}


        <head>
            <meta charset="UTF-8">
            {{-- <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" /> --}}
            <link rel="stylesheet" href="assets/css/story-style2.css">
            <link rel="stylesheet" href="assets/css/story-style.css">

            {{-- <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
            <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
            <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script> --}}
            <script src="assets/js/story/ionicons.esm.js"></script>
            <script src="assets/js/story/ionicons.js"></script>
            <script src="assets/js/story/swiper-bundle.min.js"></script>

        </head>

        <body style="overflow: hidden;">
        <section id="tranding">
            <div>
        
                <div style="color: rgb(102, 102, 102);" class="swiper-button-prev">
                    <ion-icon name="back-outline"></ion-icon>
                </div>

                <div style="max-width: 100%; margin: 13px" class="swiper tranding-slider">
                    <div class="swiper-wrapper">

                        @foreach ($all_story as $story)

                            <div class="swiper-slide tranding-slide">
                                <div class="tranding-slide-img">
                                <img src="{{$story['story_picture']}}" alt="Tranding">
                                </div>
                                <div class="tranding-slide-content">

                                    <div style="padding: 15px" class="d-flex align-items-center position-relative">
                                        <!-- Avatar -->
                                        <div class="avatar me-3">
                                          <img class="avatar-img rounded-circle" src="{{$story['user_profile_pic']}}" alt="avatar">
                                        </div>
                                        <div>
                                          <a class="h6 stretched-link" href="/user/{{$story['user_name']}}">{{$story['user_name']}}</a>
                                          <p class="small m-0">{{$story['first_name']}} {{$story['last_name']}}</p>
                                        </div>
                                    </div>

                                    <div style="width: 70%" class="tranding-slide-content-bottom">
                                        <h5 class="food-rating">
                                            <span> {{$story['description']}} </span>
                                        </h5>
                                        <br>
                                        <div class="d-flex align-items-end">
                                            <input style="background: rgba(4, 4, 4, 0.44); border-radius: 15px" class="form-control py-2" type="search" placeholder="Comment" aria-label="Search">
                                        </div>
                                        
                                    </div>

                                    @livewire('story.like-story', ['story' => $story])
                                    
                                </div>
                                
                            </div>

                        @endforeach

                    </div>
                </div>

                <div style="color: rgb(102, 102, 102);" class="swiper-button-next">
                    <ion-icon name="forward-outline"></ion-icon>
                </div>

            </div>
        </section>

        <script>
        var TrandingSlider = new Swiper('.tranding-slider', {
            effect: 'coverflow',
            grabCursor: true,
            centeredSlides: true,
            loop: false,
            slidesPerView: 'auto',
            coverflowEffect: {
                rotate: 0,
                stretch: 0,
                depth: 100,
                modifier: 2.5,
                slideShadows: true,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            initialSlide: {{$show_story_number}},
        });
        </script>
        </body>   


@endauth
