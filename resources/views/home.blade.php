@extends('layout.app')

@section('content')
<div class="container mt-3">
    <img src="{{ asset('images/logo.jpg') }}" alt="logo" class="logo" width="30" height="30">
    <marquee behavior="scroll" direction="left" scrollamount="3">
        <h6 class="text-white">Chào mừng Quý khách đến với nền tảng UT SPEED ngày !</h6>
    </marquee>

    <div class="card mb-3">
        <div class="card-body">
            <img src="{{ asset('images/icons/banner.png') }}" alt="logo" class="w-100">
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-6 text-center">
                    <a href="{{ route('noviciate') }}" class="text-white f-14 mb-1 text-decoration-none">
                        <img src="{{ asset('images/icons/1.png') }}" alt="logo" class="logo" width="40" height="40">
                        <p class="text-white f-12">Hướng dẫn người mới</p>
                    </a>
                </div>
                <div class="col-6 text-center">
                    <a href="{{ route('invite') }}" class="text-white f-14 mb-1 text-decoration-none">
                        <img src="{{ asset('images/icons/2.png') }}" alt="logo" class="logo" width="40" height="40">
                        <p class="text-white f-12">Lời mời đăng ký</p>
                    </a>
                </div>
                <div class="col-6 text-center">
                    <a href="{{ route('team') }}" class="text-white f-14 mb-1 text-decoration-none">
                        <img src="{{ asset('images/icons/3.png') }}" alt="logo" class="logo" width="40" height="40">
                        <p class="text-white f-12">Danh sách đội</p>
                    </a>
                </div>
                <div class="col-6 text-center">
                    <a href="{{ route('system') }}" class="text-white f-14 mb-1 text-decoration-none">
                        <img src="{{ asset('images/icons/4.png') }}" alt="logo" class="logo" width="40" height="40">
                        <p class="text-white f-12">Tin nhắn hệ thống</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="card mb-3">
                <div class="card-body">
                    <p class="text-gray f-14 mb-1">Giao dịch nhanh</p>
                    <p class="text-gray-light f-12 mb-1" style="height: 40px;">Mua USDT chỉ bằng một cú nhấp chuột</p>
                    <div class="row">
                        <div class="col-6">
                            <img src="{{ asset('images/icons/2_1.png') }}" alt="logo" class="logo" width="40" height="40">
                        </div>
                        <div class="col-6 d-flex justify-content-end">
                            <div class="d-flex justify-content-end p-1" style="width: 20px; height: 20px; border-radius: 100%; background-color: rgb(240, 185, 11);">
                                <img src="{{ asset('images/icons/arrow-right.png') }}" class="w-100" alt="logo" class="logo">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card mb-3">
                <div class="card-body">
                    <p class="text-gray f-14 mb-1">Giao dịch C2C</p>
                    <p class="text-gray-light f-12 mb-1" style="height: 40px;">Mua và bán USDT</p>
                    <div class="row">
                        <div class="col-6">
                            <img src="{{ asset('images/icons/2-2.png') }}" alt="logo" class="logo" width="40" height="40">
                        </div>
                        <div class="col-6 d-flex justify-content-end">
                            <div class="d-flex justify-content-end p-1" style="width: 20px; height: 20px; border-radius: 100%; background-color: rgb(240, 185, 11);">
                                <img src="{{ asset('images/icons/arrow-right.png') }}" class="w-100" alt="logo" class="logo">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <p class="text-gray f-14 mb-1" style="height: 40px;">Người dùng trực tuyến</p>
                        <div class="row align-items-center">
                            <div class="col-7">
                                <p class="text-warning f-14 mb-1" style="height: 40px;">{{ rand(500000, 1000000) }}</p>
                            </div>
                            <div class="col-5">
                                <img src="{{ asset('images/icons/3-1.png') }}" alt="logo" class="logo" width="40" height="40">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <p class="text-gray f-14 mb-1" style="height: 40px;">Tổng số giao dịch trong giờ(USDT)</p>
                        <div class="row align-items-center">
                            <div class="col-7">
                                <p class="text-warning f-14 mb-1" style="height: 40px;">{{ rand(100000, 1000000) }}</p>
                            </div>
                            <div class="col-5">
                                <img src="{{ asset('images/icons/3-2.png') }}" alt="logo" class="logo" width="40" height="40">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="row text-center">
                <div class="col-4">
                    <h6 class="text-white f-14 mb-1">BTC/</h6>
                    <h6 class="text-warning f-14 mb-1" id="btc-price">100,000</h6>
                    <h6 class="text-red f-14 mb-1" id="btc-profit">-1.2%</h6>
                </div>
                <div class="col-4">
                    <h6 class="text-white f-14 mb-1">ETH/</h6>
                    <h6 class="text-warning f-14 mb-1" id="eth-price">100,000</h6>
                    <h6 class="text-red f-14 mb-1" id="eth-profit">-1.2%</h6>
                </div>
                <div class="col-4">
                    <h6 class="text-white f-14 mb-1">USDT/</h6>
                    <h6 class="text-warning f-14 mb-1" id="usdt-price">100,000</h6>
                    <h6 class="text-red f-14 mb-1" id="usdt-profit">-1.2%</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-1 symbol" data-symbol="BTCUSDT">
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <span><i class="fas fa-star text-warning"></i></span>
                    <img src="{{ asset('images/icons/btc.png') }}" alt="logo" class="logo" width="30" height="30">
                    <span class="text-white f-14 mb-1">BTC</span>
                </div>
                <div class="col-4">
                    <span class="text-white f-14 mb-1 price">$66498,86</span>
                </div>
                <div class="col-4">
                    <span class="text-white f-14 mb-1 profit">0,36%</span>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-1 symbol" data-symbol="ETHUSDT">
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <span><i class="fas fa-star text-warning"></i></span>
                    <img src="{{ asset('images/icons/eth.png') }}" alt="logo" class="logo" width="30" height="30">
                    <span class="text-white f-14 mb-1">ETH</span>
                </div>
                <div class="col-4">
                    <span class="text-white f-14 mb-1 price">$1000,00</span>
                </div>
                <div class="col-4">
                    <span class="text-white f-14 mb-1 profit">0,00%</span>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="card mb-1 symbol" data-symbol="USDTBUSD">
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <span><i class="fas fa-star text-warning"></i></span>
                    <img src="{{ asset('images/icons/usdt.png') }}" alt="logo" class="logo" width="30" height="30">
                    <span class="text-white f-14 mb-1">USDT</span>
                </div>
                <div class="col-4">
                    <span class="text-white f-14 mb-1 price">$1000,00</span>
                </div>
                <div class="col-4">
                    <span class="text-white f-14 mb-1 profit">0,36%</span>
                </div>
            </div>
        </div>
    </div> -->
    <div class="card mb-1 symbol" data-symbol="TRXUSDT">
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <span><i class="fas fa-star text-warning"></i></span>
                    <img src="{{ asset('images/icons/trx.png') }}" alt="logo" class="logo" width="30" height="30">
                    <span class="text-white f-14 mb-1">TRX</span>
                </div>
                <div class="col-4">
                    <span class="text-white f-14 mb-1 price">$1000,00</span>
                </div>
                <div class="col-4">
                    <span class="text-white f-14 mb-1 profit">0,36%</span>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-1 symbol" data-symbol="BCHUSDT">
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <span><i class="fas fa-star text-warning"></i></span>
                    <img src="{{ asset('images/icons/bch.png') }}" alt="logo" class="logo" width="30" height="30">
                    <span class="text-white f-14 mb-1">BCH</span>
                </div>
                <div class="col-4">
                    <span class="text-white f-14 mb-1 price">$1000,00</span>
                </div>
                <div class="col-4">
                    <span class="text-white f-14 mb-1 profit">0,36%</span>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-1 symbol" data-symbol="EOSUSDT">
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <span><i class="fas fa-star text-warning"></i></span>
                    <img src="{{ asset('images/icons/eos.png') }}" alt="logo" class="logo" width="30" height="30">
                    <span class="text-white f-14 mb-1">EOS</span>
                </div>
                <div class="col-4">
                    <span class="text-white f-14 mb-1 price">$1000,00</span>
                </div>
                <div class="col-4">
                    <span class="text-white f-14 mb-1 profit">0,36%</span>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-1 symbol" data-symbol="LTCUSDT">
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <span><i class="fas fa-star text-warning"></i></span>
                    <img src="{{ asset('images/icons/ltc.png') }}" alt="logo" class="logo" width="30" height="30">
                    <span class="text-white f-14 mb-1">LTC</span>
                </div>
                <div class="col-4">
                    <span class="text-white f-14 mb-1 price">$1000,00</span>
                </div>
                <div class="col-4">
                    <span class="text-white f-14 mb-1 profit">0,36%</span>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-1 symbol" data-symbol="ADAUSDT">
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <span><i class="fas fa-star text-warning"></i></span>
                    <img src="{{ asset('images/icons/ada.png') }}" alt="logo" class="logo" width="30" height="30">
                    <span class="text-white f-14 mb-1">ADA</span>
                </div>
                <div class="col-4">
                    <span class="text-white f-14 mb-1 price">$1000,00</span>
                </div>
                <div class="col-4">
                    <span class="text-white f-14 mb-1 profit">0,36%</span>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-1 symbol" data-symbol="DAIUSDT">
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <span><i class="fas fa-star text-warning"></i></span>
                    <img src="{{ asset('images/icons/dai.png') }}" alt="logo" class="logo" width="30" height="30">
                    <span class="text-white f-14 mb-1">DAI</span>
                </div>
                <div class="col-4">
                    <span class="text-white f-14 mb-1 price">$1000,00</span>
                </div>
                <div class="col-4">
                    <span class="text-white f-14 mb-1 profit">0,36%</span>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-1 symbol" data-symbol="XRPUSDT">
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <span><i class="fas fa-star text-warning"></i></span>
                    <img src="{{ asset('images/icons/xrp.png') }}" alt="logo" class="logo" width="30" height="30">
                    <span class="text-white f-14 mb-1">XRP</span>
                </div>
                <div class="col-4">
                    <span class="text-white f-14 mb-1 price">$1000,00</span>
                </div>
                <div class="col-4">
                    <span class="text-white f-14 mb-1 profit">0,36%</span>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-5 symbol" style="margin-bottom: 70px !important;" data-symbol="ETCUSDT">
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <span><i class="fas fa-star text-warning"></i></span>
                    <img src="{{ asset('images/icons/etc.png') }}" alt="logo" class="logo" width="30" height="30">
                    <span class="text-white f-14 mb-1">ETC</span>
                </div>
                <div class="col-4">
                    <span class="text-white f-14 mb-1 price">$1000,00</span>
                </div>
                <div class="col-4">
                    <span class="text-white f-14 mb-1 profit">0,36%</span>
                </div>
            </div>
        </div>
    </div>
    <div id="cskh">
        <a href="{{ route('cskh') }}" class="text-white f-14 mb-1 text-decoration-none">
            <img src="{{ asset('images/icons/customer.png') }}" alt="logo" class="logo" width="60" height="60">
        </a>
    </div>
    @include('includes.footer')

</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        function getPrice(element) {
            var symbol = $(element).data('symbol');
            console.log(symbol);
            var url = `https://api.binance.com/api/v3/klines?symbol=${symbol}&interval=1m&limit=100`;
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const profit = data.reduce((sum, item) => {
                        const startPrice = parseFloat(item[1]);
                        const endPrice = parseFloat(item[4]);
                        const percentChange = Math.abs((endPrice - startPrice) / startPrice * 100);
                        return sum + percentChange;
                    }, 0) / data.length;
                    const lastPrice = parseFloat(data[data.length - 1][4]);
                    $(element).find('.price').text(`${lastPrice}`);
                    $(element).find('.profit').text(`${profit.toFixed(2)}%`);
                    $(element).find('.profit').toggleClass('text-white', profit < 0);
                    $(element).find('.profit').toggleClass('text-green', profit > 0);
                    if (symbol.includes('BTC')) {
                        $('#btc-price').text(`${lastPrice}`);
                        $('#btc-profit').text(`${profit.toFixed(2)}%`);
                        $('#btc-profit').toggleClass('text-red', profit < 0);
                        $('#btc-profit').toggleClass('text-green', profit > 0);
                    }
                    if (symbol.includes('ETH')) {
                        $('#eth-price').text(`${lastPrice}`);
                        $('#eth-profit').text(`${profit.toFixed(2)}%`);
                        $('#eth-profit').toggleClass('text-red', profit < 0);
                        $('#eth-profit').toggleClass('text-green', profit > 0);
                    }
                    if (symbol.includes('USDT')) {
                        $('#usdt-price').text(`${lastPrice}`);
                        $('#usdt-profit').text(`${profit.toFixed(2)}%`);
                        $('#usdt-profit').toggleClass('text-red', profit < 0);
                        $('#usdt-profit').toggleClass('text-green', profit > 0);
                    }
                });

        }
        const symbols = $('.symbol');
        symbols.each(function() {
            getPrice($(this));
        });

        setInterval(function() {
            symbols.each(function() {
                getPrice($(this));
            });
        }, 3000);
    });
</script>
@endsection
