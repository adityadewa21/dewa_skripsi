@extends('layouts.index')

@section('title', 'Dewa Shop')

@section('content')
    <section id="billboard" class="bg-light py-5">
        <div class="container">
        <div class="row justify-content-center">
            <h1 class="section-title text-center mt-4" data-aos="fade-up">Our Collections</h1>
            <div class="col-md-6 text-center" data-aos="fade-up" data-aos-delay="300">
            <p>Temukan koleksi terbaru kami dengan desain modern dan kualitas terbaik. Setiap produk dirancang untuk memberikan kenyamanan, gaya, dan kepercayaan diri di setiap kesempatan!</p>
            </div>
        </div>
        <div class="row">
            <div class="swiper main-swiper py-4" data-aos="fade-up" data-aos-delay="600">
            <div class="swiper-wrapper d-flex border-animation-left">
                @foreach ($categories as $category)
                    <div class="swiper-slide">
                        <div class="banner-item image-zoom-effect">
                            <div class="image-holder">
                                <a href="{{ route('category.show', $category->slug) }}">
                                    <img src="{{ asset('storage/'.$category->picture) }}" alt="product" class="img-fluid">
                                </a>
                            </div>
                            <div class="banner-content py-4">
                                <h5 class="element-title text-uppercase">
                                    <a href="index.html" class="item-anchor">{{ $category->name }}</a>
                                </h5>
                                {{-- <p>Scelerisque duis aliquam qui lorem ipsum dolor amet, consectetur adipiscing elit.</p> --}}
                                <div class="btn-left">
                                    <a href="{{ route('category.show', $category->slug) }}" class="btn-link fs-6 text-uppercase">
                                        Lihat Produk
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
            </div>
            <div class="icon-arrow icon-arrow-left"><svg width="50" height="50" viewBox="0 0 24 24">
                <use xlink:href="#arrow-left"></use>
            </svg></div>
            <div class="icon-arrow icon-arrow-right"><svg width="50" height="50" viewBox="0 0 24 24">
                <use xlink:href="#arrow-right"></use>
            </svg></div>
        </div>
        </div>
    </section>
    <section class="features py-5">
        <div class="container">
        <div class="row">
            <div class="col-md-3 text-center" data-aos="fade-in" data-aos-delay="0">
            <div class="py-5">
                <svg width="38" height="38" viewBox="0 0 24 24">
                <use xlink:href="#calendar"></use>
                </svg>
                <h4 class="element-title text-capitalize my-3">24 / 7 Akses Website</h4>
                <p>Website bebas akses kapanpun dan dimanapun.</p>
            </div>
            </div>
            <div class="col-md-3 text-center" data-aos="fade-in" data-aos-delay="300">
            <div class="py-5">
                <svg width="38" height="38" viewBox="0 0 24 24">
                <use xlink:href="#shopping-bag"></use>
                </svg>
                <h4 class="element-title text-capitalize my-3">Proses Pemesanan Simpel</h4>
                <p>Fitur Pemesanan anti bingung dan anti ribet.</p>
            </div>
            </div>
            <div class="col-md-3 text-center" data-aos="fade-in" data-aos-delay="600">
            <div class="py-5">
                <svg width="38" height="38" viewBox="0 0 24 24">
                <use xlink:href="#gift"></use>
                </svg>
                <h4 class="element-title text-capitalize my-3">Kemasan Extra Eksklusif</h4>
                <p>Setiap pembelian dikemas rapi dan elegan, cocok untuk hadiah spesial.</p>
            </div>
            </div>
            <div class="col-md-3 text-center" data-aos="fade-in" data-aos-delay="900">
            <div class="py-5">
                <svg width="38" height="38" viewBox="0 0 24 24">
                <use xlink:href="#arrow-cycle"></use>
                </svg>
                <h4 class="element-title text-capitalize my-3">Garansi Uang Kembali</h4>
                <p>Garansi uang kembali apabila barang tidak sesuai dengan kualitas.</p>
            </div>
            </div>
        </div>
        </div>
    </section>
    <section class="py-5 bg-light">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="section-title">New Arrivals</h2>
                <a href="{{ route('products') }}" class="btn btn-outline-dark btn-sm">
                    View All
                </a>
            </div>

            <div class="row g-4">
                @foreach($newArrivals as $product)
                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="product-item">
                            <a href="{{ route('product.show', $product->slug) }}">
                                <img
                                    src="{{ $product->primaryImage
                                        ? asset('storage/' . $product->primaryImage->image_path)
                                        : asset('template/images/placeholder.jpg') }}"
                                    class="img-fluid rounded mb-2"
                                    alt="{{ $product->name }}">
                            </a>
                            <h6 class="mt-2 mb-1">{{ $product->name }}</h6>

                            <span class="text-muted">
                                Rp {{ number_format($product->base_price, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="collection bg-light position-relative py-5">
        <div class="container">
            <div class="row">
                <div class="title-xlarge text-uppercase txt-fx domino">Collection</div>

                @if($topProduct)
                <div class="collection-item d-flex flex-wrap my-5">

                    <div class="col-md-6 column-container">
                        <div class="image-holder">
                            <img
                                src="{{ $topProduct->primaryImage
                                    ? asset('storage/'.$topProduct->primaryImage->image_path)
                                    : asset('template/images/placeholder.jpg') }}"
                                alt="{{ $topProduct->name }}"
                                class="product-image img-fluid">
                        </div>
                    </div>

                    <div class="col-md-6 column-container bg-white">
                        <div class="collection-content p-5 m-0 m-md-5">
                            <h3 class="element-title text-uppercase">
                                {{ $topProduct->name }}
                            </h3>

                            <p>
                                {{ Str::limit($topProduct->description, 300) }}
                            </p>

                            <strong class="d-block mb-3">
                                Rp {{ number_format($topProduct->base_price, 0, ',', '.') }}
                            </strong>

                            <a href="{{ route('product.show', $topProduct->slug) }}"
                            class="btn btn-dark text-uppercase mt-3">
                                Lihat Product
                            </a>
                        </div>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </section>
    <section class="py-5">
        <div class="container">
            <h2 class="section-title mb-4">Best Sellers</h2>

            <div class="row g-4">
                @foreach($bestSellers as $product)
                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="product-item">

                            <a href="{{ route('product.show', $product->slug) }}">
                                <img
                                    src="{{ $product->primaryImage
                                        ? asset('storage/' . $product->primaryImage->image_path)
                                        : asset('template/images/placeholder.jpg') }}"
                                    class="img-fluid rounded mb-2"
                                    alt="{{ $product->name }}">
                            </a>
                            <h6 class="mt-2">{{ $product->name }}</h6>
                            <strong>
                                Rp {{ number_format($product->base_price, 0, ',', '.') }}
                            </strong>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="py-5 bg-dark text-white">
        <div class="container">
            <div class="row g-4">

                @foreach($categories->take(3) as $category)
                    <div class="col-md-4">
                        <a href="{{ route('category.show', $category->slug) }}"
                        class="text-white text-decoration-none">

                            <div class="position-relative">
                                <img src="{{ asset('storage/'.$category->picture ?? 'template/images/category-banner.jpg') }}"
                                    class="img-fluid rounded">
                                <div class="position-absolute bottom-0 start-0 p-3">
                                    <h4 class="fw-bold">{{ $category->name }}</h4>
                                    <span>Shop Now →</span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
    <section class="testimonials py-5 bg-light">
        <div class="section-header text-center mt-5">
        <h3 class="section-title">Pujian Dari Costumers</h3>
        </div>
        <div class="swiper testimonial-swiper overflow-hidden my-5">
        <div class="swiper-wrapper d-flex">
            <div class="swiper-slide">
            <div class="testimonial-item text-center">
                <blockquote>
                <p>“Kualitas barang yang dijual sangat bagus dan memiliki tekstur yang lembut dan nyaman untuk dipakai.”</p>
                <div class="review-title text-uppercase">Sweater</div>
                </blockquote>
            </div>
            </div>
            <div class="swiper-slide">
            <div class="testimonial-item text-center">
                <blockquote>
                <p>“Fitur yang disediakan sangat mudah digunakan dan lebih praktis</p>
                <div class="review-title text-uppercase">Fitur</div>
                </blockquote>
            </div>
            </div>
            <div class="swiper-slide">
            <div class="testimonial-item text-center">
                <blockquote>
                <p>“Semua produk baju yang disediakan adalah produk trendy dan masa kini.”</p>
                <div class="review-title text-uppercase">Produk</div>
                </blockquote>
            </div>
            </div>
            <div class="swiper-slide">
            <div class="testimonial-item text-center">
                <blockquote>
                <p>“Pengiriman produk sangat aman dan cepat”</p>
                <div class="review-title text-uppercase">Pengiriman</div>
                </blockquote>
            </div>
            </div>
        </div>
        </div>
        <div class="testimonial-swiper-pagination d-flex justify-content-center mb-5"></div>
    </section>
    <section class="py-5">
        <div class="container">
            <h2 class="section-title mb-4">You May Also Like</h2>

            <div class="row g-4">
                @foreach($recommended as $product)
                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="product-item">

                            <a href="{{ route('product.show', $product->slug) }}">
                                <img src="{{ asset('storage/'.$product->primaryImage?->image_path ?? 'template/images/placeholder.jpg') }}"
                                    class="img-fluid rounded mb-2">
                            </a>

                            <h6 class="mt-2">{{ $product->name }}</h6>
                            <span>
                                Rp {{ number_format($product->base_price, 0, ',', '.') }}
                            </span>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="instagram position-relative">
        <div class="d-flex justify-content-center w-100 position-absolute bottom-0 z-1">
        <a href="https://www.instagram.com/templatesjungle/" class="btn btn-dark px-5">Follow us on Instagram</a>
        </div>
        <div class="row g-0">
        <div class="col-6 col-sm-4 col-md-2">
            <div class="insta-item">
            <a href="https://www.instagram.com/templatesjungle/" target="_blank">
                <img src="{{ asset('template/images/insta-item1.jpg') }}" alt="instagram" class="insta-image img-fluid">
            </a>
            </div>
        </div>
        <div class="col-6 col-sm-4 col-md-2">
            <div class="insta-item">
            <a href="https://www.instagram.com/templatesjungle/" target="_blank">
                <img src="{{ asset('template/images/insta-item2.jpg') }}" alt="instagram" class="insta-image img-fluid">
            </a>
            </div>
        </div>
        <div class="col-6 col-sm-4 col-md-2">
            <div class="insta-item">
            <a href="https://www.instagram.com/templatesjungle/" target="_blank">
                <img src="{{ asset('template/images/insta-item3.jpg') }}" alt="instagram" class="insta-image img-fluid">
            </a>
            </div>
        </div>
        <div class="col-6 col-sm-4 col-md-2">
            <div class="insta-item">
            <a href="https://www.instagram.com/templatesjungle/" target="_blank">
                <img src="{{ asset('template/images/insta-item4.jpg') }}" alt="instagram" class="insta-image img-fluid">
            </a>
            </div>
        </div>
        <div class="col-6 col-sm-4 col-md-2">
            <div class="insta-item">
            <a href="https://www.instagram.com/templatesjungle/" target="_blank">
                <img src="{{ asset('template/images/insta-item5.jpg') }}" alt="instagram" class="insta-image img-fluid">
            </a>
            </div>
        </div>
        <div class="col-6 col-sm-4 col-md-2">
            <div class="insta-item">
            <a href="https://www.instagram.com/templatesjungle/" target="_blank">
                <img src="{{ asset('template/images/insta-item6.jpg') }}" alt="instagram" class="insta-image img-fluid">
            </a>
            </div>
        </div>
        </div>
    </section>
@endsection
