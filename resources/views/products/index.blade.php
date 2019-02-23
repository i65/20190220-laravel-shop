@extends('layouts.app')
@section('title', '商品列表')
@section('content')
    <div class="row">
        <div class="col-lg-10 offset-lg-1">
            <div class="card">
                <div class="card-body">
                    <!-- 筛选组件开始 -->
                        <form action="{{ route('products.index') }}" class="search-form">
                            <div class="form-row">
                                <div class="col-md-9">
                                    <div class="form-row">
                                        <div class="col-auto">
                                            <input type="text" class="form-control form-control-sm" name="search" placeholder="搜索">
                                        </div>
                                        <div class="col-auto">
                                            <button class="btn btn-primary btn-sm">搜索</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <select name="order" id="" class="form-control form-control-sm float-right">
                                        <option value="">排序方式</option>
                                        <option value="price_asc">价格从低到高</option>
                                        <option value="price_desc">价格从高到低</option>
                                        <option value="sold_count_desc">销量从高到低</option>
                                        <option value="sold_count_asc">销量从低到高</option>
                                        <option value="rating_desc">评价从高到低</option>
                                        <option value="rating_asc">评价从低到高</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    <!-- 筛选组件结束 -->
                    <div class="row products-list">
                        @foreach($products as $product)
                            <div class="col-3 product-item">
                                <div class="product-content">
                                    <div class="top">
                                    <!-- Laravel 的模型访问器会自动把下划线改为驼峰，所以 image_url 对应的就是 getImageUrlAttribute -->
                                        <div class="img"><img src="{{ $product->image_url }}" alt=""></div>
                                        <div class="price"><b>￥</b>{{ $product->price }}</div>
                                        <div class="title">{{ $product->title }}</div>
                                    </div>
                                    <div class="bottom">
                                        <div class="sold_count">销量 <span>{{ $product->sold_count }}笔</span></div>
                                        <div class="review_count">评价 <span>{{ $product->review_count }}</span></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- 只需要添加这一行 -->
                    <div class="float-right">{{ $products->appends($filters)->render() }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scriptsAfterJs')
    <script>
        // 把控制器传过来的 $filters 变量变成一个 JSON 字符串，赋值给 JS 的 filters 变量。
        var filters = {!! json_encode($filters) !!};
        $(document).ready(function() {
            $('.search-form input[name=search]').val(filters.search);
            $('.search-form select[name=order]').val(filters.order);
        })

        // 监听下拉菜单
        $('.search-form select[name=order').on('change', function() {
            $('.search-form').submit();
        })
    </script>
@endsection