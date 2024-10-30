@extends('layouts.master')

@section('title', 'Sản phẩm')
@section('sub', 'Sản phẩm chất lượng đến từ Lalihui')


@section('header')
    @include('layouts._header')

    <link rel="stylesheet" href="{{ asset('assets/css/shop2.min.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.7.0/nouislider.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.7.0/nouislider.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const priceSlider = document.getElementById('price-slider');
            const priceMinInput = document.getElementById('priceMin');
            const priceMaxInput = document.getElementById('priceMax');
            const maxPrice = {{ $maxProductPrice }}; // Giá cao nhất từ backend
            const minPrice = {{ $minProductPrice}};

            noUiSlider.create(priceSlider, {
                start: [0, maxPrice],
                connect: true,
                step: 10000, // Bước nhảy 10,000
                range: {
                    'min': minPrice,
                    'max': maxPrice
                },
                tooltips: [false, false],
                format: {
                    to: (value) => Math.round(value).toLocaleString('vi-VN'),
                    from: (value) => Number(value.replace(/\D/g, '')) // Xóa ký tự không phải số
                }
            });

            priceSlider.noUiSlider.on('update', function(values, handle) {
                if (handle === 0) {
                    priceMinInput.value = values[0];
                } else {
                    priceMaxInput.value = values[1];
                }
            });
        });

        function applyPriceFilter() {
            const minPrice = document.getElementById('priceMin').value.replace(/\D/g, '');
            const maxPrice = document.getElementById('priceMax').value.replace(/\D/g, '');

            const url = new URL(window.location.href);
            url.searchParams.set('min_price', minPrice);
            url.searchParams.set('max_price', maxPrice);

            window.location.href = url.toString();
        }
    </script>

@endsection

@section('data-page', 'shop2')

@section('page-header')
    @include('layouts.page_header')
@endsection

@section('content')

    <div class="shop-wrapper section">
        <div class="container d-flex d-lg-grid flex-column">
            <div class="shop_panel d-flex flex-wrap justify-content-between">
                <form action="{{ route('shop') }}" method="GET" class="wrapper d-flex justify-content-between">
                    <label class="label" for="sorting">Sorting:</label>
                    <select name="sorting" id="sorting" class="form-control" onchange="this.form.submit()">
                        <option value="default" {{ request('sorting') == 'default' ? 'selected' : '' }}>Default sorting
                        </option>
                        <option value="lowest" {{ request('sorting') == 'lowest' ? 'selected' : '' }}>Lowest price</option>
                        <option value="highest" {{ request('sorting') == 'highest' ? 'selected' : '' }}>Highest price
                        </option>
                        <option value="popular" {{ request('sorting') == 'popular' ? 'selected' : '' }}>Most popular
                        </option>
                    </select>
                </form>
            </div>
            <div class="shop_products">
                <ul class="shop_products-list d-sm-flex flex-wrap" id="product-list">
                    @include('partials.product_list', ['products' => $products])
                </ul>
            </div>
            <div class="shop_aside">
                <div class="shop_aside-wrapper collapse" id="shopFilters">
                    <div class="shop_aside-block shop_aside-block--search">
                        <h4 class="shop_aside-block_header d-flex align-items-center">
                            <span class="leaf">
                                <img src="./img/symbol-logo.png" width="24" height="24" />
                            </span>
                            Search by Products
                        </h4>
                        <form class="form form--search" data-type="searchProducts" action="#" method="get">
                            <input class="field required" type="text" placeholder="Search..." />
                            <button class="btn" type="submit">Search</button>
                        </form>
                    </div>
                    <div class="shop_aside-block shop_aside-block--categories">
                        <h4 class="shop_aside-block_header d-flex align-items-center">
                            <span class="leaf">
                                <img src="{{ asset('img/symbol-logo.png') }}" width="24" height="24" />
                            </span>
                            Product Categories
                        </h4>
                        <form action="{{ route('shop') }}" method="GET" id="category-filter-form">
                            <ul class="list">

                                <li class="list-item d-flex align-items-center">
                                    <input type="radio" id="all-products" name="category" value="" 
                                        onchange="submitForm()" {{ request('category') == '' ? 'checked' : '' }} />
                                    <label for="all-products">Tất cả sản phẩm</label>
                                </li>

                                @foreach ($categories as $category)
                                    <li class="list-item d-flex align-items-center">
                                        <input type="radio" id="{{ $category->category_name }}" name="category"
                                            value="{{ $category->category_name }}" onchange="submitForm()"
                                            {{ request('category') == $category->category_name ? 'checked' : '' }} />
                                        <label for="{{ $category->category_name }}">{{ $category->category_name }}</label>
                                    </li>
                                @endforeach
                            </ul>
                        </form>
                    </div>

                    <script>
                        function submitForm() {
                            document.getElementById('category-filter-form').submit();
                        }
                    </script>

                    {{-- <div class="shop_aside-block shop_aside-block--weight">
                        <h4 class="shop_aside-block_header d-flex align-items-center">
                            <span class="leaf">
                                <img src="./img/symbol-logo.png" width="24" height="24" />
                            </span>
                            Weight
                        </h4>
                        <ul class="list d-flex flex-wrap">
                            <li class="list-item">
                                <input type="radio" id="weight1" name="weight" />
                                <label for="weight1">1g</label>
                            </li>
                            <li class="list-item">
                                <input type="radio" id="weight2" name="weight" />
                                <label for="weight2">3.5g</label>
                            </li>
                            <li class="list-item">
                                <input type="radio" id="weight3" name="weight" />
                                <label for="weight3">5g</label>
                            </li>
                            <li class="list-item">
                                <input type="radio" id="weight4" name="weight" />
                                <label for="weight4">7g</label>
                            </li>
                            <li class="list-item">
                                <input type="radio" id="weight5" name="weight" checked />
                                <label for="weight5">10g</label>
                            </li>
                            <li class="list-item">
                                <input type="radio" id="weight6" name="weight" />
                                <label for="weight6">14g</label>
                            </li>
                            <li class="list-item">
                                <input type="radio" id="weight7" name="weight" />
                                <label for="weight7">28g</label>
                            </li>
                        </ul>
                    </div> --}}
                    {{-- <div class="shop_aside-block shop_aside-block--price">
                        <h4 class="shop_aside-block_header d-flex align-items-center">
                            <span class="leaf">
                                <img src="./img/symbol-logo.png" width="24" height="24" />
                            </span>
                            Filter by Price
                        </h4>
                        <div id="price-slider" class="range-slider"></div>

                        <div class="range-output d-flex align-items-center justify-content-between mt-2">
                            <input type="text" id="priceMin" readonly />
                            <input type="text" id="priceMax" readonly />
                        </div>

                        <button type="button" class="btn btn--green mt-2" onclick="applyPriceFilter()">Apply
                            Filter</button>
                    </div> --}}
                    {{-- <div class="shop_aside-block shop_aside-block--sale">
                        <div class="content">
                            <h4 class="shop_aside-block_header">Everything is 20% off for this special day!</h4>
                            <p class="shop_aside-block_text">Excluding items already on sale</p>
                            <div class="shop_aside-block_timer timer d-flex justify-content-start">
                                <div class="timer_block d-flex flex-column justify-content-center">
                                    <span class="timer_block-number" id="hours">22</span>
                                </div>
                                <div class="timer_separator d-flex flex-column justify-content-center align-items-center">
                                    <span class="dot"></span>
                                    <span class="dot"></span>
                                </div>
                                <div class="timer_block d-flex flex-column justify-content-center">
                                    <span class="timer_block-number" id="minutes">00</span>
                                </div>
                                <div class="timer_separator d-flex flex-column justify-content-center align-items-center">
                                    <span class="dot"></span>
                                    <span class="dot"></span>
                                </div>
                                <div class="timer_block d-flex flex-column justify-content-center">
                                    <span class="timer_block-number" id="seconds">59</span>
                                </div>
                            </div>
                            <a href="#" class="btn">Shop Now</a>
                        </div>
                        <picture>
                            <source data-srcset="https://dummyimage.com/310x217/d6d6d6/fff"
                                srcset="https://dummyimage.com/310x217/d6d6d6/fff" type="image/webp" />
                            <img class="lazy leaf" data-src="https://dummyimage.com/310x217/d6d6d6/fff"
                                src="https://dummyimage.com/310x217/d6d6d6/fff" alt="media" />
                        </picture>
                    </div>
                    <div class="shop_aside-block shop_aside-block--thc">
                        <h4 class="shop_aside-block_header d-flex align-items-center">
                            <span class="leaf">
                                <img src="./img/symbol-logo.png" width="24" height="24" />
                            </span>
                            THC
                        </h4>
                        <ul class="list">
                            <li class="list-item">
                                <input type="radio" id="010-thc" name="thc" checked />
                                <label for="010-thc">0% - 10%</label>
                            </li>
                            <li class="list-item">
                                <input type="radio" id="1020-thc" name="thc" />
                                <label for="1020-thc">10% - 20%</label>
                            </li>
                            <li class="list-item">
                                <input type="radio" id="3040-thc" name="thc" />
                                <label for="3040-thc">30% - 40%</label>
                            </li>
                            <li class="list-item">
                                <input type="radio" id="4050-thc" name="thc" />
                                <label for="4050-thc">40% - 50%</label>
                            </li>
                        </ul>
                    </div>
                    <div class="shop_aside-block shop_aside-block--cbd">
                        <h4 class="shop_aside-block_header d-flex align-items-center">
                            <span class="leaf">
                                <img src="./img/symbol-logo.png" width="24" height="24" />
                            </span>
                            CBD
                        </h4>
                        <ul class="list">
                            <li class="list-item">
                                <input type="radio" id="010-cbd" name="cbd" />
                                <label for="010-cbd">0% - 10%</label>
                            </li>
                            <li class="list-item">
                                <input type="radio" id="1020-cbd" name="cbd" checked />
                                <label for="1020-cbd">10% - 20%</label>
                            </li>
                            <li class="list-item">
                                <input type="radio" id="3040-cbd" name="cbd" />
                                <label for="3040-cbd">30% - 40%</label>
                            </li>
                            <li class="list-item">
                                <input type="radio" id="4050-cbd" name="cbd" />
                                <label for="4050-cbd">40% - 50%</label>
                            </li>
                        </ul>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer')
    @include('layouts._footer')
@endsection