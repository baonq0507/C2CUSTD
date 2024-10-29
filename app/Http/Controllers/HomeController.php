<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\BuyUstd;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use App\Models\DepositUstd;
use App\Models\Setting;
use App\Models\SellUstd;
use App\Models\Gifbox;
use App\Models\UserGifbox;
class HomeController extends Controller
{
    public function index()
    {
        $gifbox = null;
        // $gifbox = get last gifbox
        if(auth()->user()) {
            $gifbox = Gifbox::orderBy('created_at', 'desc')->first();

            $userGifboxes = UserGifbox::where(['user_id' => auth()->user()->id, 'gifbox_id' => $gifbox->id])->get();
            if(count($userGifboxes) > 0) {
                $gifbox = null;
            }
        }

        return view('home', compact('gifbox'));
    }

    public function noviciate()
    {
        return view('noviciate');
    }

    public function invite()
    {
        return view('invite');
    }

    public function team()
    {
        return view('team');
    }

    public function system()
    {
        return view('system');
    }

    public function user()
    {
        return view('user');
    }

    public function asset()
    {
        return view('asset');
    }

    public function bank()
    {
        return view('bank');
    }

    public function detail(Request $request)
    {
        $tab = $request->tab;
        $transactions = Transaction::where('user_id', auth()->user()->id)
        ->when($tab == 'deposit', function($query) {
            return $query->where('type', 'deposit_ustd');
        })
        ->when($tab == 'withdraw', function($query) {
            return $query->where('type', 'withdraw');
        })
        ->when($tab == 'usdt', function($query) {
            return $query->where('type', 'buy_usdt')->orWhere('type', 'sell_usdt');
        })
        ->orderBy('created_at', 'desc')->get();
        return view('detail', compact('tab', 'transactions'));
    }

    public function intro()
    {
        return view('intro');
    }

    public function information()
    {
        return view('information');
    }

    public function informationUpdate(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'nullable|string|min:8',
        ], [
            'password.min' => 'Mật khẩu có ít nhất 8 ký tự',
        ]);
        $user = auth()->user();
        $user->username = $request->username;
        if($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return back()->with('success', 'Cập nhật thành công');
    }

    public function hail()
    {
        $buy_usdt = BuyUstd::where('status', 'pending')
        ->with('user')
        ->where('remaining_buy', '>', 0)
        ->where('status', 'pending')
        ->orderBy('created_at', 'desc')
        ->get();
        $sell_usdt = BuyUstd::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();
        return view('hail', compact('buy_usdt', 'sell_usdt'));
    }

    public function sell()
    {
        return view('sell');
    }

    public function postSell(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'id_card' => 'required|numeric|exists:buy_ustds,id',
        ], [
            'id_card.exists' => 'Không tìm thấy đơn hàng',
            'amount.required' => 'Số lượng bán không được để trống',
            'amount.numeric' => 'Số lượng bán phải là số',
            'amount.min' => 'Số lượng bán không được nhỏ hơn 1',
            'id_card.required' => 'Đơn hàng không được để trống',
            'id_card.numeric' => 'Đơn hàng phải là số',
        ]);
        $buy_usdt = BuyUstd::find($request->id_card);
        if($buy_usdt->remaining_buy < $request->amount) {
            return response()->json(['message' => 'Số lượng bán không được lớn hơn khả dụng'], 422);
        }
        $amount = $request->amount;
        $user = auth()->user();
        $user->usdt_balance -= $amount;
        // get price usdt
        $price_usdt = $buy_usdt->price_buy;
        $total_vnd = $amount * $price_usdt;
        $user->balance += $total_vnd;
        $user->save();

        $buy_usdt->transaction_count += 1;
        $buy_usdt->remaining_buy -= $amount;
        $buy_usdt->save();

        // inset transaction
        Transaction::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'type' => 'buy_usdt',
            'status' => 'approved',
        ]);
        return response()->json(['message' => 'Bán thành công']);
    }

    // sell now
    public function sellNow(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);
        $amount = $request->amount;
        $user = auth()->user();
        if($user->usdt_balance < $amount) {
            return response()->json(['message' => 'Số lượng bán không được lớn hơn số dư'], 422);
        }

        $price_usdt = $this->getPriceUsdt();
        $total_vnd = $amount * $price_usdt;
        $user->balance += $total_vnd;
        $user->usdt_balance -= $amount;
        $user->save();

        Transaction::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'type' => 'sell_usdt',
            'status' => 'approved',
        ]);

        SellUstd::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'status' => 'approved',
        ]);
        return response()->json(['message' => 'Bán thành công']);
    }

    public function sellUpdate(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric|exists:buy_ustds,id',
            'status' => 'required|string',
        ]);
        $buy_usdt = BuyUstd::find($request->id);
        $buy_usdt->status = $request->status;
        $buy_usdt->save();
        return response()->json(['message' => 'Cập nhật thành công']);
    }

    public function deleteSell(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric|exists:buy_ustds,id',
        ]);

        $buy_usdt = BuyUstd::find($request->id);
        $buy_usdt->delete();
        return response()->json(['message' => 'Xóa thành công']);
    }

    public function buy(Request $request)
    {
        return view('buy');
    }

    public function postBuy(Request $request)
    {
        $request->validate([
            'price_buy' => 'required|numeric|min:1',
            'total_amount' => 'required|numeric|min:1',
            'min_limit_buy' => 'required|numeric|min:1|lte:max_limit_buy',
            'max_limit_buy' => 'required|numeric|min:1|gte:min_limit_buy|lte:total_amount',
        ], [
            'price_buy.required' => 'Giá mua không được để trống',
            'price_buy.numeric' => 'Giá mua phải là số',
            'total_amount.required' => 'Tổng khối lượng mua không được để trống',
            'total_amount.numeric' => 'Tổng khối lượng mua phải là số',
            'min_limit_buy.required' => 'Giới hạn nhỏ nhất mỗi lần mua không được để trống',
            'min_limit_buy.numeric' => 'Giới hạn nhỏ nhất mỗi lần mua phải là số',
            'max_limit_buy.required' => 'Giới hạn lớn nhất mỗi lần mua không được để trống',
            'max_limit_buy.numeric' => 'Giới hạn lớn nhất mỗi lần mua phải là số',
            'max_limit_buy.gt' => 'Giới hạn lớn nhất mỗi lần mua phải lớn hơn giới hạn nhỏ nhất mỗi lần mua',
            'min_limit_buy.lte' => 'Giới hạn nhỏ nhất mỗi lần mua phải nhỏ hơn giới hạn lớn nhất mỗi lần mua',
        ]);
        $user = auth()->user();

        $total_vnd = $request->total_amount * $request->price_buy;
        if($user->balance < $total_vnd) {
            return back()->with('error', 'Số tiền VNĐ không đủ');
        }

        BuyUstd::create([
            'user_id' => $user->id,
            'price_buy' => $request->price_buy,
            'total_buy' => $request->total_amount,
            'min_limit_buy' => $request->min_limit_buy,
            'max_limit_buy' => $request->max_limit_buy,
            'remaining_buy' => $request->total_amount,
            'transaction_count' => 0,
            'status' => 'pending',
        ]);

        Transaction::create([
            'user_id' => $user->id,
            'amount' => $request->total_amount,
            'type' => 'buy_usdt',
            'status' => 'approved',
        ]);

        return back()->with('success', 'Mua thành công');
    }

    public function cskh()
    {
        $livechat_id = Setting::where('key', 'livechat_id')->first()->value;
        return view('cskh', compact('livechat_id'));
    }

    public function getPriceUsdt()
    {
        $url = 'https://api.binance.com/api/v3/klines?symbol=BTCUSDT&interval=1m&limit=1';
        $response = Http::get($url);
        return $response->json()[0][4];
    }

    public function deposit()
    {
        $deposit_ustd = DepositUstd::where('status', 'active')->get();
        return view('deposit', compact('deposit_ustd'));
    }

    public function postDeposit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'proof' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'id_deposit' => 'required|numeric|exists:deposit_ustds,id',
        ]);
        $proof_name = null;
        if($request->hasFile('proof')) {
            $proof = $request->file('proof');
            $result = $proof->store('/', 'public');
            $proof_name = $proof->hashName();

            if (!$result) {
                // Xử lý lỗi khi upload không thành công
                \Log::error('Failed to upload proof image: ' . $proof_name);
                return response()->json(['error' => 'Không thể tải lên hình ảnh. Vui lòng thử lại.'], 500);
            }
        } else {
            // Xử lý trường hợp không có file được gửi lên
            \Log::warning('No proof image file was uploaded');
            return response()->json(['error' => 'Vui lòng chọn hình ảnh để tải lên.'], 400);
        }
        $user = auth()->user();

        Transaction::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'type' => 'deposit_ustd',
            'status' => 'pending',
            'image' => $proof_name,
            'deposit_ustd_id' => $request->id_deposit,
        ]);

        return response()->json(['message' => 'Nạp tiền thành công']);
    }

    public function postBank(Request $request)
    {
        $request->validate([
            'bank_name' => 'required|string',
            'bank_owner' => 'required|string',
            'bank_account' => 'required|string',
            'phone' => 'required|string',
            'cccd_before' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'cccd_after' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'cccd_before.required' => 'Ảnh CMND/CCCD trước không được để trống',
            'cccd_after.required' => 'Ảnh CMND/CCCD sau không được để trống',
            'cccd_before.image' => 'Ảnh CMND/CCCD trước phải là ảnh',
            'cccd_after.image' => 'Ảnh CMND/CCCD sau phải là ảnh',
            'cccd_before.max' => 'Ảnh CMND/CCCD trước không được lớn hơn 2MB',
            'cccd_after.max' => 'Ảnh CMND/CCCD sau không được lớn hơn 2MB',
            'phone.required' => 'Số điện thoại không được để trống',
            'phone.string' => 'Số điện thoại phải là số',
            'bank_name.required' => 'Tên ngân hàng không được để trống',
            'bank_name.string' => 'Tên ngân hàng phải là số',
            'bank_owner.required' => 'Tên chủ tài khoản không được để trống',
            'bank_owner.string' => 'Tên chủ tài khoản phải là số',
            'bank_account.required' => 'Số tài khoản không được để trống',
            'bank_account.string' => 'Số tài khoản phải là số',
        ]);
        $user = auth()->user();
        if($request->hasFile('cccd_before') && $request->hasFile('cccd_after')) {
            $cccd_before = $request->file('cccd_before');
            $cccd_after = $request->file('cccd_after');


            $cccd_before->store('/', 'public');
            $cccd_after->store('/', 'public');
            $cccd_before_name = $cccd_before->hashName();
            $cccd_after_name = $cccd_after->hashName();

            $user->cccd_before = $cccd_before_name;
            $user->cccd_after = $cccd_after_name;
        }
        $user->bank_name = $request->bank_name;
        $user->bank_owner = $request->bank_owner;
        $user->bank_account = $request->bank_account;
        $user->phone = $request->phone;
        $user->save();

        return response()->json(['message' => 'Gửi yêu cầu thành công']);
    }

    public function withdraw()
    {
        return view('withdraw');
    }

    public function postWithdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ], [
            'amount.required' => 'Số tiền không được để trống',
            'amount.numeric' => 'Số tiền phải là số',
            'amount.min' => 'Số tiền phải lớn hơn 0',
        ]);

        $user = auth()->user();
        if($user->balance < $request->amount) {
            return back()->with('error', 'Số tiền VNĐ không đủ');
        }
        if($user->min_withdraw > $request->amount) {
            return back()->with('error', 'Số tiền rút tối thiểu là ' . number_format($user->min_withdraw, 0, ',', '.'));
        }
        $user->balance -= $request->amount;
        $user->save();
        Transaction::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'type' => 'withdraw',
            'status' => 'pending',
        ]);

        return back()->with('success', 'Gửi yêu cầu thành công');
    }

    public function buyGifbox(Request $request)
    {
        $user = auth()->user();
        $gifbox = Gifbox::find($request->id);
        UserGifbox::create([
            'user_id' => $user->id,
            'gifbox_id' => $gifbox->id,
        ]);
        // ví dụ $gifbox->amount là 10 thì sẽ được nhân thêm 10% vào số dư hiện tại
        $user->balance += $user->balance * $gifbox->amount / 100;
        $user->save();
        return response()->json(['message' => 'Nhận hộp quà thành công. Phần quà là ' . $gifbox->name]);
    }
}
