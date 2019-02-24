<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-static-top">
    <div class="container">
        <!-- Branding Image -->
        <a href="{{ url('/') }}" class="navbar-brand">
            Laravel Shop
        </a>
        <button class="navbar-toggler" type="buton" data-toggler="collapse" data-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
            
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav navbar-right">
                <!-- 登录注册链接开始 -->
                @guest
                <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">登录</a></li>
                <li class="nav-item"><a href="{{ route('register') }}" class="nav-link">注册</a></li>
                @else
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="https://iocaffcdn.phphub.org/uploads/images/201709/20/1/PtDKbASVcz.png?imageView2/1/w/60/h/60" class="img-responsive img-circle" width="30px" heigh="30px" alt="">
                        {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a href="{{ route('user_addresses.index') }}" class="dropdown-item">收货地址</a>
                        <a href="{{ route('products.favorites') }}" class="dropdown-item">我的收藏</a>
                        <a href="#" class="dropdown-item" id="logout"
                        onclick="event.preventDefault();document.getElementById('logout-form').submit()" >退出登录</a>
                        <form action="{{ route('logout') }}" id="logout-form" method="POST" style="display:none;">
                            {{ csrf_field() }}                        
                        </form>
                    </div>
                </li>
                @endguest
                <!-- 登录注册链接结束 -->
            </ul>
        </div>
    </div>
</nav>