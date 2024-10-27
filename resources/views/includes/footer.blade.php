<footer class="text-center p-2">
    <div class="row">
        <div class="col-3">
            <a href="{{ route('home') }}" class="text-white f-14 mb-1 text-decoration-none">
                <img src="{{ request()->is('/') ? asset('images/icons/home_select.png') : asset('images/icons/home.png') }}" alt="logo" class="logo" width="20" height="20">
                <p class="f-12 mb-1 {{ request()->is('/') ? 'text-warning' : 'text-gray-light' }}">Trang chủ</p>
            </a>
        </div>
        <div class="col-3">
            <a href="{{ route('hail') }}" class="text-white f-14 mb-1 text-decoration-none">
                <img src="{{ request()->is('hail') ? asset('images/icons/vip_select.png') : asset('images/icons/vip.png') }}" alt="logo" class="logo" width="20" height="20">
                <p class="f-12 mb-1 {{ request()->is('hail') ? 'text-warning' : 'text-gray-light' }}">Hail</p>
            </a>
        </div>
        <div class="col-3">
            <a href="#" class="text-white f-14 mb-1 text-decoration-none">
                <img src="{{ request()->is('order') ? asset('images/icons/order_select.png') : asset('images/icons/order.png') }}" alt="logo" class="logo" width="20" height="20">
                <p class="f-12 mb-1 {{ request()->is('order') ? 'text-warning' : 'text-gray-light' }}">Đơn hàng</p>
            </a>
        </div>
        <div class="col-3">
            <a href="{{ route('user') }}" class="text-white f-14 mb-1 text-decoration-none">
                <img src="{{ request()->is('user') ? asset('images/icons/user_select.png') : asset('images/icons/user.png') }}" alt="logo" class="logo" width="20" height="20">
                <p class="f-12 mb-1 {{ request()->is('user') ? 'text-warning' : 'text-gray-light' }}">Tôi</p>
            </a>
        </div>
    </div>
</footer>
