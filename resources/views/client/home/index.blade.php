@extends('client.master')

@php
    // Safe fallbacks (page break na ho agar controller se data na aaye)
    $categoriesFood = $categoriesFood ?? collect();
    $categoriesEssentials = $categoriesEssentials ?? collect();
    $featuredProducts = $featuredProducts ?? collect();
@endphp

@section('title')
    Animal Food Shop In India
@endsection

@php
    $cat_ids = null;
@endphp

@section('content')

    {{-- BARKBITES INTRO (with background image) --}}
    {{-- NOTE: Image must exist at: public/assets/images/intro-bg.jpg --}}
    <section class="py-5"
       style="background: url('{{ asset('client/img/intro-bg.jpg') }}') center/cover no-repeat;"
        <img src="{{ asset('client/img/intro-bg.jpg') }}" style="max-width:200px;border:2px solid red;">
		<div class="container">
            <div class="p-4 rounded" style="background: rgba(255,255,255,0.85);">
                <h2 class="fw-bold mb-2">BarkBites — International Pet Care & Nutrition</h2>

                <p class="text-muted mb-2">
                    BarkBites is a global pet care brand providing high-quality food, toys, accessories, and grooming
                    products for <strong>Cats, Dogs, Birds, Rabbits, and Horses</strong>.
                </p>

                <p class="text-muted mb-0">
                    Founded in <strong>Jajmau, Kanpur (India)</strong>, BarkBites is built with a vision to serve pet
                    parents worldwide by delivering authentic, safe, and reliable pet products directly to their
                    doorstep.
                </p>
            </div>
        </div>
    </section>

    <div class="slider">
        <div class="row">
            <div class="col-md-12">
                <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0"
                                class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                                aria-label="Slide 2"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ asset('client') }}/img/pet-food-online.jpg" class="d-block w-100"
                                 alt="img/pet-food-online.jpg">
                            <div class="carousel-caption d-none d-md-block">
                                <h2 class="text-uppercase text-black fw-bolder">
                                    Buy Cat Food From Online at Cheapest Price in Your Jajmau Kanpur Uttar Pradesh
                                </h2>
                                <p>
                                    <button class="btn bg-purple text-white">SHOP NOW</button>
                                </p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('client') }}/img/pet-food-online-BD.jpg" class="d-block w-100"
                                 alt="img/pet-food-online-BD.jpg">
                            <div class="carousel-caption d-none d-md-block">
                                <h2 class="text-uppercase text-black fw-bolder">
                                    Buy Dog Food From Online at Cheapest Price in Your Jajmau Kanpur Uttar Pradesh
                                </h2>
                                <p>
                                    <button class="btn bg-purple text-white">SHOP NOW</button>
                                </p>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                            data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                            data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container p-3">
        <div class="categories">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="text-uppercase fw-bold pb-3 pt-5">Categories</h4>
                </div>
            </div>

            <div class="row">
                @foreach ($categories as $category)
                    <div class="col-md-3 mb-4">
                        <a href="{{ route('products', ['id' => $category->id]) }}">
                            <div class="card">
                                <div class="card-body">
                                    <img 
                                        src="{{ asset($category->cat_image) }}"
                                        alt="{{ $category->name }}"
                                        style="width:100%; height:220px; object-fit:contain; background:#f5f5f5; padding:10px;">
                                    <div class="card-footer">
                                        <h5 class="card-title fw-bold text-uppercase text-center text-black">
                                            {{ $category->name }}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        <section class="food p-4 p-md-0">

            <!-- Cat Food Start -->
            <div class="row">
                <div class="col-md-12">
                    <h4 class="text-uppercase fw-bold pt-5 pb-2 border-bottom">Cat Food</h4>
                </div>
            </div>
            <div class="row">
                @php $cat_ids = null; @endphp
                @foreach ($catfoods as $catfood)
                    <div class="col-md-3 mb-4 ">
                        <div class="card">
                            <div class="card-body">
                                <a href="{{ route('product', ['cat_id' => $catfood->cat_id, 'id' => $catfood->id]) }}">
                                    <img src="{{ asset($catfood->image) }}" alt="" class="card-img">
                                </a>
                                <h6 class="card-text text-primary pt-3 fw-light">
                                    <a href="{{ route('product', ['cat_id' => $catfood->cat_id, 'id' => $catfood->id]) }}">
                                        {{ $catfood->name }}
                                    </a>
                                </h6>
                                <div class="card-price text-danger pb-2 ps-2">
                                    {{ config('app.currency_symbol') }} {{ $catfood->price }}.00

                                    <del class="text-black-50"> ₹ 70.00</del>
                                </div>
                                <div class="action-buttons pt-2">
                                    <a href="{{ route('product', ['cat_id' => $catfood->cat_id, 'id' => $catfood->id]) }}"
                                       class="btn btn-success"> Add to Cart</a>
                                    <a href="{{ route('product', ['cat_id' => $catfood->cat_id, 'id' => $catfood->id]) }}"
                                       class="btn text-white" style="background-color: purple;"> Buy Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php $cat_ids = $catfood->cat_id; @endphp
                @endforeach

                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center">
                            @if (!empty($cat_ids))
                                <a href="{{ route('products', ['id' => $cat_ids]) }}"
                                   class="btn text-uppercase btn-outline-secondary">View All</a>
                            @else
                                <a href="javascript:void(0)"
                                   class="btn text-uppercase btn-outline-secondary disabled" aria-disabled="true">View All</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- Cat Food End -->

            <!-- Dog Food Start -->
            <div class="row">
                <div class="col-md-12">
                    <h4 class="text-uppercase fw-bold pt-5 pb-2 border-bottom">Dog Food</h4>
                </div>
            </div>
            <div class="row">
                @php $cat_ids = null; @endphp
                @foreach ($dogfoods as $dogfood)
                    <div class="col-md-3 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <a href="{{ route('product', ['cat_id' => $dogfood->cat_id, 'id' => $dogfood->id]) }}">
                                    <img src="{{ asset($dogfood->image) }}" alt="" class="card-img">
                                </a>
                                <h6 class="card-text text-primary pt-3 fw-light">
                                    <a href="{{ route('product', ['cat_id' => $dogfood->cat_id, 'id' => $dogfood->id]) }}">
                                        {{ $dogfood->name }}
                                    </a>
                                </h6>
                                <div class="card-price text-danger pb-2 ps-2">
                                    ₹ {{ $dogfood->price }}.00
                                    <del class="text-black-50"> ₹ 70.00</del>
                                </div>
                                <div class="action-buttons pt-2">
                                    <a href="{{ route('product', ['cat_id' => $dogfood->cat_id, 'id' => $dogfood->id]) }}"
                                       class="btn btn-success"> Add to Cart</a>
                                    <a href="{{ route('product', ['cat_id' => $dogfood->cat_id, 'id' => $dogfood->id]) }}"
                                       class="btn text-white" style="background-color: purple;"> Buy Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php $cat_ids = $dogfood->cat_id; @endphp
                @endforeach

                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center">
                            @if (!empty($cat_ids))
                                <a href="{{ route('products', ['id' => $cat_ids]) }}"
                                   class="btn text-uppercase btn-outline-secondary">View All</a>
                            @else
                                <a href="javascript:void(0)"
                                   class="btn text-uppercase btn-outline-secondary disabled" aria-disabled="true">View All</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- Dog Food End -->

            <!-- Bird Food Start -->
            <div class="row">
                <div class="col-md-12">
                    <h4 class="text-uppercase fw-bold pt-5 pb-2 border-bottom">Bird Food</h4>
                </div>
            </div>
            <div class="row">
                @php $cat_ids = null; @endphp
                @foreach ($birdfoods as $birdfood)
                    <div class="col-md-3 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <a href="{{ route('product', ['cat_id' => $birdfood->cat_id, 'id' => $birdfood->id]) }}">
                                    <img src="{{ asset($birdfood->image) }}" alt="" class="card-img">
                                </a>
                                <h6 class="card-text text-primary pt-3 fw-light">
                                    <a href="{{ route('product', ['cat_id' => $birdfood->cat_id, 'id' => $birdfood->id]) }}">
                                        {{ $birdfood->name }}
                                    </a>
                                </h6>
                                <div class="card-price text-danger pb-2 ps-2">
                                    ₹ {{ $birdfood->price }}.00
                                    <del class="text-black-50"> ₹ 70.00</del>
                                </div>
                                <div class="action-buttons pt-2">
                                    <a href="{{ route('product', ['cat_id' => $birdfood->cat_id, 'id' => $birdfood->id]) }}"
                                       class="btn btn-success"> Add to Cart</a>
                                    <a href="{{ route('product', ['cat_id' => $birdfood->cat_id, 'id' => $birdfood->id]) }}"
                                       class="btn text-white" style="background-color: purple;"> Buy Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php $cat_ids = $birdfood->cat_id; @endphp
                @endforeach

                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center">
                            @if (!empty($cat_ids))
                                <a href="{{ route('products', ['id' => $cat_ids]) }}"
                                   class="btn text-uppercase btn-outline-secondary">View All</a>
                            @else
                                <a href="javascript:void(0)"
                                   class="btn text-uppercase btn-outline-secondary disabled" aria-disabled="true">View All</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- Bird Food End -->

            <!-- Rabbit Food Start -->
            <div class="row">
                <div class="col-md-12">
                    <h4 class="text-uppercase fw-bold pt-5 pb-2 border-bottom">Rabbit Food</h4>
                </div>
            </div>
            <div class="row">
                @php $cat_ids = null; @endphp
                @foreach ($rabbitfoods as $rabbitfood)
                    <div class="col-md-3 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <a href="{{ route('product', ['cat_id' => $rabbitfood->cat_id, 'id' => $rabbitfood->id]) }}">
                                    <img src="{{ asset($rabbitfood->image) }}" alt="" class="card-img">
                                </a>
                                <h6 class="card-text text-primary pt-3 fw-light">
                                    <a href="{{ route('product', ['cat_id' => $rabbitfood->cat_id, 'id' => $rabbitfood->id]) }}">
                                        {{ $rabbitfood->name }}
                                    </a>
                                </h6>
                                <div class="card-price text-danger pb-2 ps-2">
                                    ₹ {{ $rabbitfood->price }}.00
                                    <del class="text-black-50"> ₹ 70.00</del>
                                </div>
                                <div class="action-buttons pt-2">
                                    <a href="{{ route('product', ['cat_id' => $rabbitfood->cat_id, 'id' => $rabbitfood->id]) }}"
                                       class="btn btn-success"> Add to Cart</a>
                                    <a href="{{ route('product', ['cat_id' => $rabbitfood->cat_id, 'id' => $rabbitfood->id]) }}"
                                       class="btn text-white" style="background-color: purple;"> Buy Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php $cat_ids = $rabbitfood->cat_id; @endphp
                @endforeach

                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center">
                            @if (!empty($cat_ids))
                                <a href="{{ route('products', ['id' => $cat_ids]) }}"
                                   class="btn text-uppercase btn-outline-secondary">View All</a>
                            @else
                                <a href="javascript:void(0)"
                                   class="btn text-uppercase btn-outline-secondary disabled" aria-disabled="true">View All</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- Rabbit Food End -->

        </section>

        <section class="about">
            <div class="row">
                <div class="col-md-12">

                    <h1 class="text-uppercase fw-bold  pt-5">
                        <span class="text-success">PET FOOD.</span>
                        <span class="text-purple"> ONLINE PET FOOD DELIVERY</span>
                    </h1>

                    <div class="about-text pt-3 text-secondary">
                        <p>
                            Who doesn’t want a pet as a friend? Sometimes, people say that having a pet is better
                            than having a big family. A pet heals our depression and loneliness.
                        </p>
                        <p>
                            Like a human, a pet also needs care and love. Having a pet is like having a child. You
                            always have to be attentive about their needs, health, and other kinds of stuff.
                        </p>

                        <p>
                            The first thing that comes to mind is your pet food. There are many types of pet food.
                            Like cat food and dog food, their preferences may be different. May a cat additionally
                            need cat litter, but not a dog. Different pets have different tastes. An owner needs to
                            buy food according to their pet’s preferences. Sometimes sick pets need special food.
                            If you have a cat, you need to arrange for cat medicine; yes you have to do it carefully.
                        </p>

                        <p>
                            Pet food is an essential thing. Human food consumption is not suitable for an animal.
                            It’s cumbersome and out of their digestion capacity. At the same time, the food of
                            different species of pets cannot be the same. What Cat and Dog eat is very different
                            from what a bird eats, so it’s need bird food. To keep our pets healthy and happy, we
                            must need to give them their food.
                        </p>

                        <p>
                            Like the way we give baby food to babies, the pet should also get pet food.
                        </p>
                    </div>

                    <h1 class="text-uppercase fw-bold  pt-5">
                        <span class="text-purple">PET FOOD </span>
                        <span class="text-success"> IN KANPUR</span>
                    </h1>

                    <div class="about-text pt-3 text-secondary">
                        <p>
                            We can find pet food in Kanpur in various grocery stores or super shops. Some shops
                            sell only pet foods. However, due to the limited supply of these stores, we do not get
                            all kinds of pet food including rabbit food.
                        </p>
                        <p>
                            We can easily buy food from them. But the pandemic showed how tough it is to manage food
                            for our lovely pets when stores are closed and we cannot step outside.
                        </p>

                        <p>
                            Here comes <strong>BarkBites</strong> for you — a global pet care brand where you’ll find
                            authentic pet food and daily essentials online. We offer food for cats, dogs, birds,
                            rabbits, and horses — plus toys, accessories, and grooming products.
                        </p>

                        <p>
                            Without stepping out, get your desired pet products delivered to your doorstep.
                        </p>

                        <p>
                            We’re building BarkBites with international standards, safe packaging, and a long-term
                            mission to serve pet parents worldwide.
                        </p>
                    </div>

                    <h1 class="text-uppercase fw-bold  pt-5">
                        <span class="text-success">ONLINE PET PRODUCT DELIVERY</span>
                        <span class="text-purple"> IN All Over worldwide</span>
                    </h1>

                    <div class="about-text pt-3 text-secondary">
                        <p>
                            We aim to deliver fast anywhere in India:
                        </p>
                        <p>
                            The term ‘Online delivery’ has become very famous in our country. More than 60% of
                            people in our country do shopping online. Our hectic lifestyle is not much preferable
                            for shopping physically all the time. The best solution is to purchase online and get
                            them at your doorstep.
                        </p>

                        <p>
                            Now let’s talk about online delivery in India.<strong>BarkBites</strong> is committed
                            to delivering authentic and fresh products for your beloved pets without hassle.
                        </p>

                        <p>
                            We have various ranges for cats, dogs, rabbits, pigeons and birds — and we are expanding
                            with more essentials and international supply plans.
                        </p>

                        <p>
                            Over time, we aim to build a reliable delivery system that gives you the fastest and safest
                            experience.
                        </p>
                    </div>

                    <h1 class="text-uppercase fw-bold  pt-5">
                        <span class="text-purple">ONLINE PET CARE </span>
                        <span class="text-success"> COMPANIES IN BD</span>
                    </h1>

                    <div class="about-text pt-3 text-secondary">
                        <p>
                            Over the last 5 to 7 years, the online delivery system has gained significant popularity
                            all over India.
                        </p>
                        <p>
                            Most people are dependent on online delivery services. Our hectic lifestyle is not much preferable
                            for shopping physically all the time. The best solution is to purchase online and get
                            them at your doorstep.
                        </p>

                        <p>
                            <strong>BarkBites</strong> is here for pet parents who want trusted products and a smooth
                            shopping experience.
                        </p>

                        <p>
                            Customers can buy multiple pet products at a time and get safe and fast delivery.
                            We focus on authentic products and top-notch packaging.
                        </p>

                        <p>
                            BarkBites is always ready to serve you with food and essentials for your lovely pets.
                        </p>
                    </div>

                </div>
            </div>
        </section>
    </div>

    <section class="review mt-4">
        <div class="container p-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12 pt-4">
                            <h4 class="pt-4 pb-4 fw-bolder text-white">
                                What Client Say
                            </h4>
                        </div>
                    </div>
                    <div class="row pt-5">
                        <div class="col-md-6">
                            <div class="card p-3">
                                <div class="card-body">
                                    <img src="{{ asset('client') }}/img/birds-food-bd.png" alt="" class="card-img">
                                    <h5 class="card-title pt-5">
                                        Micky Mouse
                                    </h5>
                                    <p class="pt-3 text-secondary">
                                        I was looking for good dog food at a cheap
                                        rate for a long time. I own
                                        three
                                        dogs and it was getting tough to keep them well fed on a budget. Then a
                                        friend told me about BarkBites and I have been a regular customer ever
                                        since. Now I can serve my dogs their delicious treats without putting a
                                        strain on my budget.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card p-3">
                                <div class="card-body">
                                    <img src="{{ asset('client') }}/img/cat-food-bd.png" alt="" class="card-img">
                                    <h5 class="card-title pt-5">
                                        Tiwnkle Wan
                                    </h5>
                                    <p class="pt-3 text-secondary">
                                        My cat Minnie and I am a fan of BarkBites. Her favorite because she loves
                                        the tasty treats and mine because I can get that at an affordable price. It
                                        can be a bit costly to raise a Persian cat whose entire diet almost consists
                                        of cat food. Before buying from this shop, I was always anxious about the
                                        cost of cat food.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
