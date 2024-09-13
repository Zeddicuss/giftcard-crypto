<?php

namespace App\Http\Controllers;

use App\Models\AddCrypto;
use App\Models\AddGiftcard;
use App\Models\Category;
use App\Models\Cryptocurrency;
use App\Models\CryptoRate;
use App\Models\CryptoWalletAddress;
use App\Models\CurrencyRate;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserCryptoPending;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function adminDashboard()
    {
        $title = "Dashboard";
        return view('admin.dashboard', compact('title'));
    }

    public function adminBuyForm()
    {
        $title = "Buy Crypto";
        $admincryptos  = Cryptocurrency::whereHas('user', function ($query) {
            $query->where('role', 'user');
        })->get();
        $admincurrencies = CurrencyRate::all();
        return view('admin.buy_crypto', compact('title', 'admincurrencies', 'admincryptos'));
        
    }

    public function AdminSellForm()
    {
        $title = "Sell Cryptocurrency";
        $cryptos = AddCrypto::all();
        $currencies = CurrencyRate::all();
        return view('admin.sell_crypto', compact('title', 'cryptos', 'currencies'));
    }

    public function storecrypto(Request $request)
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
    
           
    
                $crypto = new Cryptocurrency;
                $crypto->name = $request->name;
                $crypto->crypto_price = $request->crypto_price;
                $crypto->exchange_rate = $request->exchange_rate;
                $crypto->listed_by = $user->id;
    
            if ($request->hasFile('photo')) {
                $fileName = $request->photo->store('photos', 'public');
                $crypto->photo = $fileName;
    
            }
    
            try {
                $crypto->save();
                $user = User::where('role', 'user')->first();
                if ($user) {
                    $user->notify(new UserCryptoPending($crypto));
                }
    
                return redirect()->back()->with('success', 'Crypto uploaded successfully!');
    
                // Alert::success('Success', 'Crypto uploaded successfully!');
                // return redirect()->route('dashboard');
    
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Failed to save data!');
                // Return error message using SweetAlert
                // Alert::error('Error', 'Failed to save data');
                // return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            }

    }

    public function adminOrder(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'wallet_address' => 'nullable|string',
            'network' =>'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'crypto_id' => 'required|integer',
        ]);

        
        if ($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        $crypto = Cryptocurrency::find($request->crypto_id);

        if(!$crypto) {
            return back()->with('error', 'The selected crypto was not found.')->withInput();
        }

        $seller = User::find($crypto->listed_by);
        

        $amountInNGN = $crypto->crypto_price * $crypto->exchange_rate;

        $order = new Order();
        $order->order_number = 'ORD-' . strtoupper(uniqid());
        $order->buyer = $user->id;
        $order->buyer_name = $user->firstname . ' ' . $user->lastname;
        $order->seller = $seller->id;  
        $order->seller_name = $seller->firstname . ' ' . $seller->lastname;
        $order->crypto_id = $crypto->id;
        $order->amount_in_usd = $crypto->crypto_price;
        $order->exchange_rate = $crypto->exchange_rate;
        $order->amount_in_naira = $amountInNGN;
        $order->wallet_address = $request->wallet_address;
        $order->network = $request->network;
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
        $buyerWalletAddress = CryptoWalletAddress::where('user_id', $buyer->id)->first();
        $sellerAccountDetails = [
            'bank_name' =>$seller->bank_name,
            'account_number' => $seller->account_number,
            'account_name'=> $seller->account_name,
        ];

        $invoiceUrl = route('admin.invoice', ['order' => $order->id]);

        return redirect($invoiceUrl)->with([
            'success' => 'Order placed successfully!',
            'order' => $order,
            'buyer' => $buyer,
            'seller' => $seller,
            'buyerWalletAddress' => $buyerWalletAddress, 
            'sellerAccountDetails' => $sellerAccountDetails,
            'cryptoName' => $crypto->name,
        ]);
    }

    public function adminInvoice(Order $order)
    {
        $title = "Invoice";
        $order = Order::findOrFail($order->id);
        $buyer = User::find($order->buyer);
        $seller = User::find($order->seller);
        $crypto = Cryptocurrency::find($order->crypto_id);
        $buyerWalletAddress = CryptoWalletAddress::where('user_id', $buyer->id)->first();

    $sellerAccountDetails = [
        'bank_name' => $seller->bank_name,
        'account_number' => $seller->account_number,
        'account_name' => $seller->account_name
    ];

    return view('admin.crypto_invoice', [
        'order' => $order,
        'buyer' => $buyer,
        'seller' => $seller,
        'buyerWalletAddress' => $buyerWalletAddress,
        'sellerAccountDetails' => $sellerAccountDetails,
        'cryptoName' => $crypto->name,
        'title' =>$title,
    ]);
    }

    public function users()
    {
        $title = "Users";
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.users', compact('title', 'users'));
    }

    public function addUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role' => 'required|string|in:user,admin',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        

        $user = new User();
        $user->role = $request->input('role');
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));

        $user->save();

        return redirect()->back()->with('success', 'User created successfully!');
    }

    public function getUserDetails($id)
    {
        $user = User::findOrFail($id);

        return response()->json(['user' => $user]);
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->phone = $request->phone;
        $user->role = $request->role;
        $user->verification_status = $request->verification_status;
        $user->email = $request->email;

        if($request->filled('password')){
            $user->password = bcrypt($request->password);
        }

        try{
            $user->save();
            return redirect()->back()->with('success', 'User Details updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update user details!');
        }
    }

    public function deleteUser($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->back()->with('success','User Deleted Successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete user!');
        }
    }

    public function activeCrypto()
    {
        $title = "Active cryptos";
        $active_cryptos = AddCrypto::all();
        return view('admin.active_crypto', compact('title', 'active_cryptos'));

    }

    public function addCrypto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'symbol' => 'required|string|max:10',
            'exchange_rate' => 'required|string|max:10',
            'currency' => 'required|string|max:10',
            'crypto_photo' => 'required|file|mimes:jpeg, png,jpg,gif,svg|max:2048'
        ]);

        if($request->hasFile('crypto_photo')) {
            $imagePath = $request->file('crypto_photo')->store('crypto_images', 'public');
           }else {
            return back()->with('error', 'Image upload failed');
           }

        $addcrypto = new AddCrypto();
        $addcrypto->name = $request->name;
        $addcrypto->symbol = $request->symbol;
        $addcrypto->exchange_rate = $request->exchange_rate;
        $addcrypto->currency = $request->currency;
        $addcrypto->photo = $imagePath;
        $addcrypto->status = 'active';
        try{
            $addcrypto->save();
        
            $crypto = new Cryptocurrency();
            $crypto->name = $request->name;
            $crypto->exchange_rate = $request->exchange_rate;
            $crypto->currency = $request->currency;
            $crypto->v_status = 'approved';
            $crypto->listed_by = auth()->id();
            $crypto->save();

        $users = User::where('role', 'user')->get();
        Notification::send($users, new UserCryptoPending($crypto));

            return back()->with('success', 'Crypto added successfully!');
        } catch (QueryException $e) {
            if($e->getCode() == 23000) {
                return redirect()->back()->with('error', 'Crypto name already exists!');
            }
            
            return redirect()->back()->with('error', 'Failed to add crypto');

        }catch (\Exception $e) {

            return redirect()->back()->with('error', 'An unexpected error occured!');
        }
    }

    public function editCrypto($id)
    {
        $crypto = AddCrypto::findOrFail($id);
        return response()->json(['crypto' => $crypto]);
    }
    

    public function updateCrypto(Request $request, $id)
    {
        $addcrypto = AddCrypto::findOrFail($id);

        $originalName = $addcrypto->name;

        if($request->hasFile('crypto_photo')) {
            $imagePath = $request->file('crypto_photo')->store('crypto_images', 'public');
            $addcrypto->photo = $imagePath;
            } else {
            $imagePath = $addcrypto->photo;
        }

        $addcrypto->name = $request->name;
        $addcrypto->symbol = $request->symbol;
        $addcrypto->exchange_rate = $request->exchange_rate;
        $addcrypto->currency = $request->currency;
        $addcrypto->status = 'active';
        $addcrypto->save();

        $crypto = Cryptocurrency::where('name', $originalName)
                                    ->where('listed_by', auth()->id())
                                    ->first();
        if($crypto) {
            $crypto->name = $request->name;
            $crypto->exchange_rate = $request->exchange_rate;
            $crypto->currency = $request->currency;
            $crypto->photo = $imagePath;
            $crypto->v_status = 'approved';
            $crypto->listed_by = auth()->id();

        try{
            $crypto->save();
            return redirect()->back()->with('success', 'Crypto updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update Crypto!');
        } 
    } else {
        return redirect()->back()->with('error', 'No matching cryptocurrency found to update.');
    }
}

    public function deleteCrypto($id)
    {
        try {
            $addcrypto = AddCrypto::findOrFail($id);
            $originalName = $addcrypto->name;

            $crypto = Cryptocurrency::where('name', $originalName)
                                        ->where('listed_by', auth()->id())
                                        ->first();
            $addcrypto->delete();

            if($crypto){
                $crypto->delete();
            }

            return redirect()->back()->with('success','Crypto Deleted Successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete Crypto!');
        }
    }


    public function activeGiftcard()
    {
        $title = "Active Giftcard";
        $categories = Category::with('addgiftcards')->get();
        return view('admin.active_giftcard', compact('title', 'categories'));

    }

    public function addGiftcard(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'gift_type' => 'required|string',
            'gift_cat' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'min_amount' => 'required|numeric|min:0',
            'max_amount' => 'required|numeric|gte:min_amount',
            'exchange_rate' => 'required|numeric|min:0',
            'currency' => 'required|string|max:10',
            'gift_photo' => 'required|image|mimes:jpeg, png,jpg,gif,svg|max:2048',
       ], [

            'max_amount.gte' => 'The maximum amount must be greater than or equal to the minimum amount,',
       ]);

       if($request->hasFile('gift_photo')) {
        $imagePath = $request->file('gift_photo')->store('giftcard_images', 'public');
       }else {
        return back()->with('error', 'Image upload failed');
       }
            $addgiftcard = new AddGiftcard();
            $addgiftcard->type = $request['gift_type'];
            $addgiftcard->category_id = $request['gift_cat'];
            $addgiftcard->name = $request['name'];
            $addgiftcard->min_amount = $request['min_amount'];
            $addgiftcard->max_amount = $request['max_amount'];
            $addgiftcard->exchange_rate = $request['exchange_rate'];
            $addgiftcard->currency = $request['currency'];
            $addgiftcard->photo = $imagePath;
            $addgiftcard->status = 'active';

        try{
            $addgiftcard->save();
            // $validatedData['status'] = 'active';
            // AddGiftcard::create($validatedData);
            return redirect()->back()->with('success', 'Giftcard added successfully!');
        } catch (QueryException $e) {
            if($e->getCode() == 23000) {
                return redirect()->back()->with('error', 'Giftcard name already exists!');
            }
            
            return redirect()->back()->with('error', 'Failed to add Giftcard');

        }catch (\Exception $e) {

            return redirect()->back()->with('error', 'An unexpected error occured!');
        }
    }

    public function editGiftCard($id)
    {
        $addgiftcard = AddGiftcard::with('category')->find($id);
    
        // Return the gift card details in a JSON response for AJAX requests.
        return response()->json(['addgiftcard' => $addgiftcard]);
    }
    

    public function updateGiftCard(Request $request, $id)
    {
        $addgiftcard = AddGiftcard::findOrFail($id);

        if($request->hasFile('gift_photo')) {
            $imagePath = $request->file('gift_photo')->store('giftcard_images', 'public');
            $addgiftcard->photo = $imagePath; // Update the photo path
           }

        $addgiftcard->type = $request->gift_type;
        $addgiftcard->category_id = $request->gift_cat;
        $addgiftcard->name = $request->name;
        $addgiftcard->min_amount = $request->min_amount;
        $addgiftcard->max_amount = $request->max_amount;
        $addgiftcard->exchange_rate = $request->exchange_rate;
        $addgiftcard->currency = $request->currency;
        $addgiftcard->status = 'active';

        try{
            $addgiftcard->save();
            return redirect()->back()->with('success', 'Giftcard Details updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update Giftcard details!');
        }
    }

    public function deleteGiftcard($id)
    {
        try {
            $addgiftcard = AddGiftCard::findOrFail($id);
            $addgiftcard->delete();

            return redirect()->back()->with('success','Giftcard Deleted Successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete Giftcard!');
        }
    }



    public function cryptoExchange()
    {
        $title = "Crypto Exchange";
        $crypto_rates = CryptoRate::all();
        return view('admin.crypto_exchange_rate', compact('title', 'crypto_rates'));
    }

    public function cryptoSet(Request $request)
    {
        $request->validate([
            'crypto' => 'required|string|max:255',
            'symbol' => 'required|string|max:255',
            'exchange_rate' => 'required|numeric|min:0',
            'exchange_crypto' => 'required|string|max:255',
            'exchange_symbol' => 'required|string|max:10',
           ]);
    
                $setcrypto = new CryptoRate();
                $setcrypto->crypto = $request->crypto;
                $setcrypto->symbol = $request->symbol;
                $setcrypto->exchange_rate = $request->exchange_rate;
                $setcrypto->exchange_crypto = $request->exchange_crypto;
                $setcrypto->exchange_symbol = $request->exchange_symbol;
    
            try{
                $setcrypto->save();
                // $validatedData['status'] = 'active';
                // AddGiftcard::create($validatedData);
                return redirect()->back()->with('success', 'Crypto Exchange rate is set successfully!');
            } catch (QueryException $e) {
                if($e->getCode() == 23000) {
                    return redirect()->back()->with('error', 'This Crypto Rate already exists!');
                }
                
                return redirect()->back()->with('error', 'Operation Failed!');
    
            }catch (\Exception $e) {
    
                return redirect()->back()->with('error', 'An unexpected error occured!');
            }
    }

    public function exchangeRate()
    {
        $title = "Exchange Rates";
        $exchange_rates = CurrencyRate::all();
        return view('admin.currency_rates', compact('title', 'exchange_rates'));
    }

    public function currencySet(Request $request)
    {
        $request->validate([
            'currency' => 'required|string|max:255',
            'symbol' => 'required|string|max:255',
            'exchange_rate' => 'required|numeric|min:0',
            'exchange_currency' => 'required|string|max:255',
            'exchange_symbol' => 'required|string|max:10',
           ]);
    
                $setexchange = new CurrencyRate();
                $setexchange->currency = $request->currency;
                $setexchange->symbol = $request->symbol;
                $setexchange->exchange_rate = $request->exchange_rate;
                $setexchange->exchange_currency = $request->exchange_currency;
                $setexchange->exchange_symbol = $request->exchange_symbol;
    
            try{
                $setexchange->save();
                // $validatedData['status'] = 'active';
                // AddGiftcard::create($validatedData);
                return redirect()->back()->with('success', 'Currency Exchange rate is set successfully!');
            } catch (QueryException $e) {
                if($e->getCode() == 23000) {
                    return redirect()->back()->with('error', 'This Currrency Rate already exists!');
                }
                
                return redirect()->back()->with('error', 'Operation Failed!');
    
            }catch (\Exception $e) {
    
                return redirect()->back()->with('error', 'An unexpected error occured!');
            }
    }

    public function setting()
    {
        $title = "Website Setting";
        $settings = Setting::pluck('value', 'key');
        return view('admin.settings', compact('title', 'settings'));

    }

    

    public function saveSetting(Request $request)
{
    $validator = Validator::make($request->all(), [
        'site_name' => 'nullable|string',
        'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,svg,gif|max:2048',
        'site_email' => 'nullable|email',
        'site_phone' => 'nullable|string'
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $settings = [
        'site_name' => $request->input('site_name'),
        'site_email' => $request->input('site_email'),
        'site_phone' => $request->input('site_phone'),
        'wallet_address' => $request->input('wallet_address'),
        'wallet_name' => $request->input('wallet_name'),
    ];

    if ($request->hasFile('site_logo')) {
        $logoPath = $request->file('site_logo')->store('logos', 'public');
        $settings['site_logo'] = $logoPath;
    }

    foreach ($settings as $key => $value) {
        Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $value ?? '']
        );
    }

    return redirect()->back()->with('success', 'Settings updated successfully!');
}

    /**
     * Show the form for creating a new resource.
     */
    /**
     * Display the specified resource.
     */
}
