<?php

namespace App\Http\Controllers;

use App\Models\AddCrypto;
use App\Models\AddGiftcard;
use App\Models\Category;
use App\Models\CryptoWalletAddress;
use App\Models\CurrencyRate;
use App\Models\GiftCard;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function paymentMethod()
    {
        $user = Auth::user();
        $cryptos = AddCrypto::all();
        $title = "Setting";

        if ($user) {
            $wallets = CryptoWalletAddress::with('addcrypto')->where('user_id', $user->id)->get();
        } else {
            return redirect()->back()->with('error', 'User not authenticated.');
        }
        return view ('user.payment_method', compact('title', 'wallets', 'user', 'cryptos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function walletStore(Request $request)
    {
        $user = Auth::user();
        if(!$user) {
            return redirect()->route('login.form')->withErrors(['error' => 'User not found']);
        }

        $validator = Validator::make($request->all(),[
            'crypto_name' => 'required|string|max:255',
            'wallet_address' => 'required|string|max:255',
            'wallet_provider' => 'nullable|string|max:255',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }


        $crypto = AddCrypto::where('name', $request->input('crypto_name'))->first();
        if(!$crypto) {
            return back()->with('error', 'Crypto name not found therefore wallet not added');
        }
        
    try{
        $cryptoWalletAddress = new CryptoWalletAddress;
        $cryptoWalletAddress->user_id = $user->id;
        $cryptoWalletAddress->crypto_id = $crypto->id;
        $cryptoWalletAddress->crypto_name = $crypto->name;
        $cryptoWalletAddress->wallet_address = $request->wallet_address;
        $cryptoWalletAddress->wallet_provider = $request->wallet_provider;

        // Log::info('Saving crypto wallet address', [
        //     'user_id' => $user->id,
        //     'crypto_id' => $crypto->id,
        //     'crypto_name' => $crypto->name,
        //     'wallet_address' => $request->input('wallet_address'),
        //     'wallet_provider' => $request->input('wallet_provider'),
        // ]);

        // dd($cryptoWalletAddress);
       
        $cryptoWalletAddress->save();

        // Log::info('Query Log:', DB::getQueryLog());


            return redirect()->back()->with('success', 'Payment Method is set successfully!');
        } catch (QueryException $e) {
            // Log::error('QueryException', ['error' => $e->getMessage()]);
            if($e->getCode() == 23000) {
                return redirect()->back()->with('error', 'This account details already exists!');
            }
            
            return redirect()->back()->with('error', 'Operation Failed!');

        }catch (\Exception $e) {

            return redirect()->back()->with('error', 'An unexpected error occured!');
        }
    
    }

    public function walletEdit($id)
    {
        try {
            $wallet = CryptoWalletAddress::findOrFail($id);
    
            return response()->json([
                'wallet' => $wallet, 
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Wallet not found'
            ], 404);
        }
    // $user = Auth::user(); // Fetch the user details
    // if (!$user) {
    //     return response()->json(['error' => 'User not found'], 404);
    // } 

    // $cryptoWalletAddress = CryptoWalletAddress::where('id', $id)->where('user_id', $user->id)->first();

    // if(!$cryptoWalletAddress) {
    //     return response()->json(['error'=> 'Wallet not found or Wallet does not belong to you'],404);
    // }

    // return response()->json([
    //     'wallet' => [
    //         'crypto_name'=> $cryptoWalletAddress->crypot_name,
    //         'wallet_address' => $cryptoWalletAddress->wallet_address,
    //         'wallet_provider' => $cryptoWalletAddress->wallet_provider
    //     ]
    //     ]);
    }
    

    public function walletUpdate(Request $request, $id)
    {
        $wallet = CryptoWalletAddress::findOrFail($id);

        $wallet->crypto_name = $request->crypto_name;
        $wallet->wallet_address = $request->wallet_address;
        $wallet->wallet_provider = $request->wallet_provider;

        try{
            $wallet->save();
            return redirect()->back()->with('success', 'Wallet updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update Wallet!');
        }
    }

    public function walletDelete($id)
    {
        try {
            $wallet = CryptoWalletAddress::findOrFail($id);
            $wallet->delete();

            return redirect()->back()->with('success','Wallet Deleted Successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete Wallet!');
        }
    }



    /**
     * Store a newly created resource in storage.
     */
    public function paymentStore(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('profile.edit')->withErrors(['error' => 'User not found.']);
        }

        $validator = Validator::make($request->all(), [
            'bank_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:12',
            'account_name' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user->bank_name = $request->input('bank_name');
        $user->account_number = $request->input('account_number');
        $user->account_name = $request->input('account_name');
       
        try{
            $user->save();
            return redirect()->back()->with('success', 'Payment Method is set successfully!');
        } catch (QueryException $e) {
            if($e->getCode() == 23000) {
                return redirect()->back()->with('error', 'This account details already exists!');
            }
            
            return redirect()->back()->with('error', 'Operation Failed!');

        }catch (\Exception $e) {

            return redirect()->back()->with('error', 'An unexpected error occured!');
        }

        
    }

    public function paymentEdit($id)
    {
    $user = User::find($id); // Fetch the user details
    if ($user) {
        return response()->json($user);
    } else {
        return response()->json(['error' => 'User not found'], 404);
    }
    }
    

    public function paymentUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->account_number = $request->account_number;
        $user->account_name = $request->account_name;
        $user->bank_name = $request->bank_name;

        try{
            $user->save();
            return redirect()->back()->with('success', 'Bank updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update Bank!');
        }
    }

    public function paymentDelete($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->account_name = null; 
            $user->account_number = null; 
            $user->bank_name = null;

            $user->save();

            return redirect()->back()->with('success','Bank Deleted Successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete Bank!');
        }
    }

    public function sellin()
    {
        $title = 'Sell Physical Gift Card';
        $giftcards = AddGiftcard::all();
        $categories = Category::with('giftcards')->get();
        $currencies = CurrencyRate::all();
        return view('user.sellshow', compact('giftcards', 'currencies','categories', 'title'));
    }

    public function getByCategory($categoryId)
    {
        // $giftCards = GiftCard::where('category_id', $categoryId)->get();
        $giftCards = AddGiftcard::where('category_id', $categoryId)->get(['id', 'name', 'min_amount', 'max_amount', 'category_id']);
         $giftCards->map(function($giftCard) {
            $category = Category::find($giftCard->category_id);
            $giftCard->category_logo = $category->logo;
            $giftCard->category_name = $category->name;
            return $giftCard;
        });
        return response()->json($giftCards);
    }

    public function getExchangeRate($giftCardId)
    {
        $giftCard = AddGiftCard::find($giftCardId);
        return response()->json(['exchange_rate' => $giftCard->exchange_rate]);
    }

    
}
