@forelse ($products as $product)
    <li class="shop_products-list_item col-sm-6 col-md-4 col-lg-6 col-xl-4" data-order="1">
        <div class="wrapper d-flex flex-column">
            <div class="media">
                <picture>
                    <source data-srcset="{{ asset('img/products/un-background/' . $product->thumbnail) }}"
                        srcset="{{ asset('img/products/un-background/' . $product->thumbnail) }}" type="image/webp" />
                    <img class="lazy" data-src="{{ asset('img/products/un-background/' . $product->thumbnail) }}"
                        src="{{ asset('img/products/un-background/' . $product->thumbnail) }}" alt="media" />
                </picture>
            </div>
            <div class="main d-flex flex-column align-items-center justify-content-between">

                <a class="" href="#" rel="noopener norefferer">{{ $product->prd_name }}</a>
                <div class="main_price">
                    <span class="price">{{ number_format($product->price, 0, ',', '.') }} VNĐ</span>
                </div>

                </br>
                <a class="btn btn--green" href="#">Add to Cart</a>
            </div>
        </div>
    </li>
@empty
    <p>No products available.</p>
@endforelse
