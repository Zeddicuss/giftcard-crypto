<?php

namespace App\Http\Controllers;

use App\Models\AddCrypto;
use App\Models\Cryptocurrency;
use App\Models\CryptoTransaction;
use App\Models\CryptoWalletAddress;
use App\Models\CurrencyRate;
use App\Models\GiftCard;
use App\Models\Order;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Validation\ValidationException;

class CryptocurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Pending Crypto Transactions";
        $cryptos = Cryptocurrency::with('buyer', 'seller')
                                ->select('id', 'name', 'crypto_price', 'v_status', 'photo', 'listed_by', 'exchange_rate')
                                ->whereIn('v_status', ['pending', 'approved', 'rejected'])
                                ->get();
        return view ('user.crypto_index', compact(['cryptos','title']));
    }

    public function showCoin($id)
    {
        $crypto = Cryptocurrency::findOrFail($id);
        return response()->json([
            'v_status' => $crypto->v_status,
            'photo' => $crypto->photo,
        ]);
    }

    public function updateCoin(Request $request, $id)
    {
        $request->validate([
            'v_status' => 'nullable|string',
        ]);
        

        $crypto = Cryptocurrency::findOrFail($id);
        $crypto->v_status = $request->v_status;
        $crypto->save();
        $seller = User::where('id', $crypto->listed_by)->first(); // Assuming there's a user_id column in the cryptocurrencies table

    // Send notification to the seller
    if ($seller) {
        if($crypto->v_status === 'approved') {
            $seller->notify(new \App\Notifications\CryptoApproved($crypto));
        }else {
            $seller->notify(new \App\Notifications\CryptoRejected($crypto));
        }
       
    }

        return redirect()->back()->with('success', 'Crypto status updated successfully!');
    }

    public function deleteCoin($id)
    {
        try {
            $crypto = Cryptocurrency::findOrFail($id);
            $crypto->delete();

            return redirect()->back()->with('success','Crypto Deleted Successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete Crypto!');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function sellForm()
    {
        $title = "Sell Cryptocurrency";
        $cryptos = AddCrypto::all();
        $currencies = CurrencyRate::all();
        $settings = Setting::pluck('value', 'key');
        return view('user.sell_crypto', compact('title', 'cryptos', 'currencies', 'settings'));
    }

    public function buyForm()
    {
        $title = "Buy Crypto";
        // $cryptos = AddCrypto::all();
        $cryptos  = Cryptocurrency::whereHas('user', function ($query) {
            $query->where('role', 'admin');
        })->get();
        return view('user.buy_crypto', compact('title', 'cryptos'));
        
    }

    public function buy(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'crypto_price' => 'required|numeric',
            'exchange_rate' => 'required|numeric',
            'wallet_address' => 'required|string',
            'network' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        
        if ($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        $crypto = Cryptocurrency::first();
        

        $seller = User::find($crypto->listed_by);
        

        $amountInNGN = $request->crypto_price * $crypto->exchange_rate;

        $order = new Order();
        $order->order_number = 'ORD-' . strtoupper(uniqid());
        $order->buyer = $user->id;
        $order->buyer_name = $user->firstname . ' ' . $user->lastname;
        $order->seller = $seller->id;  
        $order->seller_name = $seller->firstname . ' ' . $seller->lastname;
        $order->crypto_id = $crypto->id;
        $order->wallet_address = $request->wallet_address;
        $order->network = $request->network;
        $order->amount_in_usd = $request->crypto_price;
        $order->exchange_rate = $request->exchange_rate;
        $order->amount_in_naira = $amountInNGN;
        $order->order_type = 'crypto';
        $order->status = 'pending';
        

        if ($request->hasFile('photo')) {
            // $image = $request->file('photo');
            // $imageName = time().'.'.$image->getClientOriginalExtension();
            // $image->move(public_path('order_images'), $imageName);
            $imageName = $request->photo->store('order_images', 'public');
            $order->photo = $imageName;
        }
        $order->save();
        $buyer = $user;

        $buyer->email->notify(new \App\Notifications\OrderPlaced($order));
        $seller->email->notify(new \App\Notifications\SellerOrder($order));
        $sellerAccountDetails = [
            'bank_name' =>$seller->bank_name,
            'account_number' => $seller->account_number,
            'account_name'=> $seller->account_name,
        ];

        $invoiceUrl = route('invoice.crypto', ['order' => $order->id]);

        return redirect($invoiceUrl)->with([
            'success' => 'Order placed successfully!',
            'order' => $order,
            'buyer' => $buyer,
            'seller' => $seller,
            'sellerAccountDetails' => $sellerAccountDetails,
            'cryptoName' => $crypto->name,
            'photo' => $order->photo,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!Auth::check()) {
            return redirect()->route('login.form')->with('error', 'You must be logged in to sell a gift card!');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'crypto_price' => 'required|numeric',
            'exchange_rate' =>  'nullable|numeric',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        if ($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

            $cryptoName = Cryptocurrency::where('id', $request->name)->value('name');

        if (!$cryptoName) {
            return back()->with('error', 'Invalid cryptocurrency selected.')->withInput();
        }
    
        

            $crypto = new Cryptocurrency;
            $crypto->name = $cryptoName;
            $crypto->crypto_price = $request->crypto_price;
            $crypto->currency = "USD";
            $crypto->exchange_rate = $request->exchange_rate;
            $crypto->listed_by = $user->id;
            $crypto->v_status = "pending";
            

        if ($request->hasFile('photo')) {
            $fileName = $request->photo->store('photos', 'public');
            $crypto->photo = $fileName;

        }

        try {
            $crypto->save();
            $admin = User::where('role', 'admin')->first();
            if ($admin) {
                $admin->notify(new \App\Notifications\NewCryptoPending($crypto));
            }

            return redirect()->back()->with('success', 'Crypto uploaded and is now Pending Admin Approval!');

            // Alert::success('Success', 'Crypto uploaded successfully!');
            // return redirect()->route('dashboard');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to save data!');
            // Return error message using SweetAlert
            // Alert::error('Error', 'Failed to save data');
            // return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function getCryptoRate(Request $request)
    {
        $crypto_price = $request->crypto_price;
        $rate = AddCrypto::where('exchange_rate', $crypto_price)->first();

        if($rate){
            return response()->json(['rate' => $rate->exchange_rate]);
        }

        return response()->json(['rate' => 'Rate not found'], 404);
    }

    // public function cryptoTransactions()
    // {
    //     $title = "Cryptocurrency Transactions";
    //     $cryptotransactions = CryptoTransaction::with('user', 'cryptocurrency')->where('status', 'completed')->get();
    //     return view('admin.crypto_transactions', compact('title', 'cryptotransactions'));
    // }

    public function getBankAccountNumber($cryptoId)
{
    // ... your logic to fetch the cryptocurrency
    $cryptocurrency = Cryptocurrency::findOrFail($cryptoId);

    // Assuming a user relationship on the Cryptocurrency model
    $listingUser = $cryptocurrency->user;

    return response()->json(['account_number' => $listingUser ? $listingUser->account_number : 'No Account Number for this crypto!',
                                'account_name' => $listingUser ? $listingUser->account_name: 'No Account Name for this crypto!',
                                'bank_name' => $listingUser ? $listingUser->bank_name : 'No Bank for this crypto!']);
}

    public function showWallet($cryptoId)
    {
        $user = Auth::user();
        $crypto = AddCrypto::find($cryptoId);

        if(!$crypto) {
            return response()->json(['error' => 'Crypto not found'], 404);
        }

        if($user->isAdmin()) {
            $walletAddress = CryptoWalletAddress::where('crypto_name', $crypto->name)->first();
        } else {
            $admin = User::where('role', 'admin')->first();
            if(!$admin) {
                return response()->json(['error' => 'Admin user not found'], 404);
            }

            $walletAddress = CryptoWalletAddress::where('crypto_name', $crypto->name)
                                                ->where('user_id', $admin->id)
                                                ->first();
        }

        return response()->json([
            'wallet_address' => $walletAddress ? $walletAddress->wallet_address : 'No Wallet Address Found for this crypto!',
            'crypto_name' => $walletAddress ? $walletAddress->crypto_name : 'No Wallet Name Found for this crypto!',
            'wallet_provider' => $walletAddress ? $walletAddress->wallet_provider : 'No Wallet Provider Found for this crypto!',
        ]);
    }

    public function getCurrencyRate(Request $request, $cryptoId)
    {
       $crypto_price = $request->input('crypto_price'); 


    $currencyRate = Cryptocurrency::find($cryptoId);

    if (!$currencyRate) {
        return response()->json([
            'success' => false,
            'message' => 'Exchange rate not found for ID' . $cryptoId,
        ], 404); // Not Found
    }

    
    $calculatedPrice = $crypto_price * $currencyRate->exchange_rate;

    return response()->json([
        'success' => true,
        'exchange_rate' => $currencyRate->exchange_rate,
        'calculated_price' => $calculatedPrice,
    ]);
}
    
}
