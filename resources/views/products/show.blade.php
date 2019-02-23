@extends('layouts.app')
@section('title', $product->title)

@section('content')
    <div class="row">
        <div class="col-lg-10 offset-lg-1">
            <div class="card">
                <div class="card-body product-info">
                    <div class="row">
                        <div class="col-5">
                            <img src="{{ $product->image_url }}" alt="" class="cover">
                        </div>
                        <div class="col-7">
                            <div class="title">{{ $product->title }}</div>
                            <div class="price">
                                <label for="">价格</label>
                                <em>￥{{ $product->price }}</em>
                            </div>
                            <div class="sales_and_reviews">
                                <div class="sold_count">累计销量 <span class="count">{{ $product->sold_count }}</span></div>
                                <div class="review_count">累计评价 <span class="count">{{ $product->review_count }}</span></div>
                                <div class="rating" title="评分 {{ $product->rating }}">评分 <span class="count">{{ str_repeat('★', floor($product->rating)) }}{{ str_repeat('☆', 5 - floor($product->rating)) }}</span></div>
        
                            </div>
                            <div class="skus">
                                <label for="">选择</label>
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    @foreach($product->skus as $sku)
                                        <label 
                                        class="btn sku-btn" 
                                        data-price="{{ $sku->price }}"
                                        data-stock="{{ $sku->stock }}"
                                        data-toggle="tooltip"
                                        title="{{ $sku->description }}"
                                        data-placement="bottom">
                                            <input type="radio" name="skus" id="" autocomplete="off" value="{{ $sku->id }}">{{ $sku->description }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="cart_amount">
                                <label for="">数量</label><input type="number" class="form-control form-control-sm" min="1" value="1"><span>件</span><span class="stock"></span>
                            </div>
                            <div class="buttons">
                                <button class="btn btn-success btn-favor">❤ 收藏</button>
                                <button class="btn btn-primary btn-add-to-cart">加入购物车</button>
                            </div>
                        </div>
                    </div>
                    <div class="product-detail">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a href="#product-detail-tab" class="nav-link active" aria-controls="product-detail-tab" role="tab" data-toggle="tab" aria-selected="true">
                                    商品详情
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#product-reviews-tab" class="nav-link" aria-controls="product-rviews-tab" role="tab" data-toggle="tab" aria-selected="false">
                                    用户评价
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="product-detail-tab">
                                {!! $product->description !!}
                            </div>
                            <div role="tabpanel" class="tab-pane" id="product-reviews-tab"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
@endsection
@section('scriptsAfterJs')
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip({trigger: 'hover'});
            $('.sku-btn').click(function () {
                $('.product-info .price span').text($(this).data('price'));
                $('.product-info .stock').text('库存：' + $(this).data('stock') + '件');
            })
        });
    </script>
@endsection
