@extends('layout.app')
@section('js')
<script>
    window.__lc = window.__lc || {};
    window.__lc.license = "{{ $livechat_id }}";
    (function(n, t, c) {
        function i(n) {
            return e._h ? e._h.apply(null, n) : e._q.push(n)
        }
        var e = {
            _q: [],
            _h: null,
            _v: "2.0",
            on: function() {
                i(["on", c.call(arguments)])
            },
            once: function() {
                i(["once", c.call(arguments)])
            },
            off: function() {
                i(["off", c.call(arguments)])
            },
            get: function() {
                if (!e._h) throw new Error("[LiveChatWidget] You can't use getters before load.");
                return i(["get", c.call(arguments)])
            },
            call: function() {
                i(["call", c.call(arguments)])
            },
            init: function() {
                var n = t.createElement("script");
                n.async = !0, n.type = "text/javascript", n.src = "https://cdn.livechatinc.com/tracking.js", t.head.appendChild(n)
            }
        };
        !n.__lc.asyncInit && e.init(), n.LiveChatWidget = n.LiveChatWidget || e
    }(window, document, [].slice))
</script>
<script>
    LiveChatWidget.call("hide");

    LiveChatWidget.on('visibility_changed', onVisibilityChanged)
    const openLiveChat = () => {
        LiveChatWidget.call('maximize')
    }

    function onVisibilityChanged(data) {
        switch (data.visibility) {
            case "maximized":
                break;
            case "minimized":
                LiveChatWidget.call('hide')
                break;
            case "hidden":
                break;
        }
    }
</script>

@endsection
@section('content')
<div class="container mt-2">
    <div class="header mb-5">
        <div class="row align-items-center">
            <div class="col-3">
                <a href="{{ url()->previous() }}" class="text-white f-20">
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>
            <div class="col-8">
                <p class="text-white f-14 mb-0">Liên hệ chăm sóc khách hàng</p>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
    <div class="content">
        <div class="card mb-3">
            <div class="card-body" onclick="openLiveChat()">
                <p class="text-white f-14 mb-0">
                    <img src="{{ asset('images/icons/cskh.png') }}" alt="logo" class="logo" width="30" height="30">
                    Dịch vụ hỗ trợ trực tuyến
                </p>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body" onclick="openLiveChat()">
                <p class="text-white f-14 mb-0">
                    <img src="{{ asset('images/icons/line.png') }}" alt="logo" class="logo" width="30" height="30">
                    Line dịch vụ khách hàng
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
