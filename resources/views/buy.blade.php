@extends('layout.app')

@section('content')
<div class="container mt-2">
    <div class="header mb-5">
        <div class="row align-items-center">
            <div class="col-3">
                <a href="{{ url()->previous() }}" class="text-white f-20">
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>
            <div class="col-6 text-center">
                <p class="text-white f-14 mb-0">Mua USDT</p>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body text-center">
            <img src="{{ asset('images/icons/dolla.png') }}" alt="logo" class="logo" width="20" height="20">
            <span class="text-white f-14">Số dư (VND): {{ number_format(auth()->user()->balance, 0, ',', '.') }}</span>
        </div>
    </div>
    <div class="card mb-3">
        @if(session('error'))
        <div class="alert alert-danger mt-2 mx-2">
            {{ session('error') }}
        </div>
        @endif
        @if(session('success'))
        <div class="alert alert-success mt-2 mx-2">
            {{ session('success') }}
        </div>
        @endif
        <form action="{{ route('buy') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row align-items-center w-100 mb-3">
                    <div class="col-6">
                        <label for="price_buy" class="text-white f-14">Giá mua vào:</label>
                    </div>
                    <div class="col-6">
                        <input type="number" name="price_buy" class="form-control" id="price_buy" placeholder="Nhập giá mua" value="{{ old('price_buy') }}">
                        <p class="text-white f-12 mb-0">Giá USDT hiện tại: <span class="text-warning" id="price_usdt"></span></p>
                    </div>
                    @error('price_buy')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="row align-items-center w-100 mb-3">
                    <div class="col-6">
                        <label for="price_min" class="text-white f-14">Tổng khối lượng mua:</label>
                    </div>
                    <div class="col-6">
                        <input type="number" name="total_amount" class="form-control" id="total_amount" placeholder="Nhập tổng khối lượng mua" value="{{ old('total_amount') }}">

                    </div>
                    @error('total_amount')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="row align-items-center w-100 mb-3">
                    <div class="col-6">
                        <label for="limit" class="text-white f-14">Giới hạn nhỏ nhất mỗi lần mua:</label>
                    </div>
                    <div class="col-6">
                        <input type="number" name="min_limit_buy" class="form-control" id="min_limit_buy" placeholder="Nhập giới hạn nhỏ nhất mỗi lần mua" value="{{ old('min_limit_buy') }}">

                    </div>
                    @error('min_limit_buy')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="row align-items-center w-100 mb-3">
                    <div class="col-6">
                        <label for="max_limit_buy" class="text-white f-14">Giới hạn lớn nhất mỗi lần mua:</label>
                    </div>
                    <div class="col-6">
                        <input type="number" name="max_limit_buy" class="form-control" id="max_limit_buy" placeholder="Nhập giới hạn lớn nhất mỗi lần mua" value="{{ old('max_limit_buy') }}">

                    </div>
                    @error('max_limit_buy')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-warning w-100" id="buy">Mua ngay</button>
            </div>
        </form>
    </div>
</div>
@include('includes.footer')
@endsection

@section('js')
<script>
    $(document).ready(async function() {
        $('#all').on('click', function() {
            $('#amount').val('{{ auth()->user()->usdt_balance }}');
        });
        let load = false;
        $('#sell').on('click', function() {
            if (load) return;
            load = true;
            if ($('#amount').val() == '' || $('#amount').val() == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Vui lòng nhập số lượng bán',
                });
                load = false;
                return;
            }

            if (parseInt($('#amount').val()) > parseInt('{{ auth()->user()->usdt_balance }}')) {
                Swal.fire({
                    icon: 'error',
                    title: 'Số lượng bán không được lớn hơn số dư',
                });
                load = false;
                return;
            }
            $('#sell').html('<i class="fas fa-spinner fa-spin"></i> Đang bán...');
            $('#sell').prop('disabled', true);
            $.ajax({
                url: "{{ route('sell') }}",
                type: 'POST',
                data: {
                    amount: $('#amount').val(),
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#sell').html('Bán ngay');
                    $('#sell').prop('disabled', false);
                    Swal.fire({
                        icon: 'success',
                        title: 'Bán thành công',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#amount').val('');
                    load = false;
                },
                error: function(response) {
                    $('#sell').html('Bán ngay');
                    $('#sell').prop('disabled', false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Bán thất bại',
                        text: response.responseJSON.message,
                    });
                    load = false;
                }
            });
        });

        async function getPriceUsdt() {
            const url = `https://api.binance.com/api/v3/klines?symbol=BTCUSDT&interval=1m&limit=1`;
            const response = await fetch(url);
            const data = await response.json();
            return data[0][4];
        }
        const price_usdt = await getPriceUsdt();
        // $('#price_buy').val(parseFloat(price_usdt));
        $('#price_usdt').html(parseFloat(price_usdt).toFixed(0));
    });
</script>
@endsection
