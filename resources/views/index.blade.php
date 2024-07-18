<x-header />
<!-- Product Section Begin -->
<section class="product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <ul class="filter__controls">
                    <li class="active" data-filter="*">Best Sellers</li>
                    <li data-filter=".new-arrivals">New Arrivals</li>
                    <li data-filter=".sale">Hot Sales</li>

                </ul>
            </div>
        </div>
        <div class="row product__filter">
            {{-- <p>n Laravel, asset() is a helper function that is used to generate URLs for assets like images,
                stylesheets, JavaScript files, and other resources stored in the public directory of
                your Laravel application</p> --}}
            @foreach ($allProducts as $item)
                <div class="col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 mix {{ $item->type }}">
                    <div class="product__item">
                        <div class="product__item__pic set-bg"
                            data-setbg="{{ URL::asset('uploads/products/' . $item->picture) }}">
                            <span class="label">New</span>
                            <ul class="product__hover">
                                <li><a href="#"><img src="img/icon/heart.png" alt=""></a></li>
                                <li><a href="#"><img src="img/icon/compare.png" alt="">
                                        <span>Compare</span></a></li>
                                <li><a href="{{ URL::to('single/' . $item->id) }}"><img src="img/icon/search.png"
                                            alt=""></a></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6>{{ $item->title }}</h6>
                            <a href="{{ URL::to('single/' . $item->id) }}" class="add-cart">+ Add To Cart</a>
                            <div class="rating">
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star-o"></i>
                            </div>
                            <h5>${{ $item->price }}</h5>
                            <div class="product__color__select">
                                <label for="pc-1">
                                    <input type="radio" id="pc-1">
                                </label>
                                <label class="active black" for="pc-2">
                                    <input type="radio" id="pc-2">
                                </label>
                                <label class="grey" for="pc-3">
                                    <input type="radio" id="pc-3">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<x-footer />
