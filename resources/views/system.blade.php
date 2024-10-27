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
                <p class="text-white f-14 mb-0">Tin nhắn hệ thống</p>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
    <div class="content text-center">
        <img src="{{ asset('images/icons/nodata.png') }}" alt="system" class="w-50 mx-auto">
    </div>
</div>
@endsection

@section('js')

@endsection
