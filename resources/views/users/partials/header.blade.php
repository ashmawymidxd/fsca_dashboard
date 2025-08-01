<div class="header pb-6 pt-6 pt-lg-7 d-flex align-items-center" style="background-image: url(../argon/img/theme/profile-cover.jpg); background-size: cover; background-position: center center">
{{-- <div class="header pb-6 pt-5 pt-lg-6 d-flex align-items-center" style="background-image: url(https://picsum.photos/800/600); background-size: cover; background-position: center top;"> --}}
    <!-- Mask -->
    <span class="mask bg-gradient-default opacity-8"></span>
    <!-- Header container -->
    <div class="container-fluid d-flex align-items-center" data-aos="fade-right" data-aos-delay="100">
        <div class="row">
            <div class="col-md-12 {{ $class ?? '' }}">
                <h1 class="display-2 text-white">{{ $title }}</h1>
                @if (isset($description) && $description)
                    <p class="text-white mt-0 mb-5">{{ $description }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
