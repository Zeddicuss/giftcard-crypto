<?php

namespace App\Http\Controllers;

use App\Models\AddGiftcard;
use App\Models\Category;
use App\Models\CurrencyRate;
use GuzzleHttp\Psr7\UploadedFile;
use Illuminate\Http\Request;
// use App\Http\Requests\StoreGiftCardRequest;
use Illuminate\Support\Facades\Validator;
use App\Models\GiftCard;
use App\Models\GiftcardImage;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class GiftCardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function giftIndex()
    {
        $title = "Available Gift Cards";
        $giftcards = GiftCard::with('category', 'seller')
                                ->select('id', 'name', 'v_status', 'status', 'type', 'pin', 'amount','photo', 'listed_by', 'exchange_rate', 'category_id')
                                ->whereIn('v_status', ['pending', 'approved', 'rejected'])
                                ->whereIn('status', ['sold', 'available'])
                                ->get();
        return view('giftcard_index', compact('title', 'giftcards'));
    }

    public function showGiftcard($id)
    {
        $giftcard = giftCard::findOrFail($id);
        return response()->json([
            'status' => $giftcard->status,
            'v_status' => $giftcard->v_status,
            'photo' => $giftcard->photo,
        ]);
    }

    public function updateCard(Request $request, $id)
    {
        $request->validate([
            'status' => 'nullable|string',
            'v_status' => 'nullable|string',
        ]);
        

        $giftcard = GiftCard::findOrFail($id);
        $giftcard->status = $request->status;
        $giftcard->v_status = $request->v_status;
        $giftcard->save();
        $seller = User::where('id', $giftcard->listed_by)->first(); // Assuming there's a user_id column in the cryptocurrencies table

        // Send notification to the seller
        if ($seller) {
            if($giftcard->v_status === 'approved') {
                $seller->notify(new \App\Notifications\GiftcardApproved($giftcard));
            }else {
                $seller->notify(new \App\Notifications\GiftcardRejected($giftcard));
            }
       
    }

        return redirect()->back()->with('success', 'Gift Card status updated successfully!');
    }

    public function deleteCard($id)
    {
        try {
            $giftcard = GiftCard::findOrFail($id);
            $giftcard->delete();

            return redirect()->back()->with('success','Giftcard Deleted Successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete Giftcard!');
        }
    }

    public function makeOrder(Request $request, $id)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'proof_of_payment' => 'required|image|max:2048',
        ]);

        if ($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        $giftcard = GiftCard::findOrFail($id);

        $seller = User::find($giftcard->listed_by);

        $amountInNGN = $giftcard->amount * $giftcard->exchange_rate;

        if($request->hasFile('proof_of_payment')) {
            $file = $request->file('proof_of_payment');
            $filename = time() .'_' .$file->getClientOriginalName();
            $path = $file->storeAs('proof_of_payments', $filename, 'public');

            $order = new Order();
            $order->order_number = 'ORD-' . strtoupper(uniqid());
            $order->buyer = $user->id;
            $order->buyer_name = $user->firstname . ' ' . $user->lastname;
            $order->giftcard_id = $giftcard->id;
            $order->photo = $path;
            $order->amount_in_usd = $giftcard->amount;
            $order->exchange_rate = $giftcard->exchange_rate;
            $order->amount_in_naira = $amountInNGN;
            $order->order_type = 'giftcard';
            $order->status = 'pending';
            $order->seller = $seller->id;
            $order->seller_name = $seller->firstname . ' ' . $seller->lastname;
            $order->save();
        }

        return redirect()->route('order.view', $order->id)->with('success', 'Order placed successfully');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function sellForm()
    {
        $title = "Sell Gift Card";
        // $physicalCategories = Category::whereHas('giftcards', function ($query) {
        //     $query->where('type', 'physical');
        // })->get();
        
        // $eCodeCategories = Category::whereHas('giftcards', function ($query) {
        //     $query->where('type', 'e-code');
        // })->get();
        $giftcards = AddGiftcard::all();
        $categories = Category::with('giftcards')->get();
        return view ('user.sell_giftcard', compact('title', 'giftcards','categories'));
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
            'category' => 'required|exists:categories,id',
            'gift_card_id' => 'required|exists:gift_cards,id',
            'exchange_rate' => 'required|numeric',
            'amount' => 'required|numeric|min:0',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'pin' => 'nullable|string|max:16',
        ]);

        // if ($validator->fails()){
        //     return back()->withErrors($validator)->withInput();
        // }

        
        // Handle file upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('giftcard_images', 'public');
        }

        // Calculate total amount
        $totalAmount = $request->amount * $request->exchange_rate;
        $giftCard = AddGiftcard::find($request->gift_card_id);

        $amount = $request->amount;
            if ($amount < $giftCard->min_amount) {
                return back()->with('error', 'The amount entered is less than the minimum amount allowed.');
            }

            if ($amount > $giftCard->max_amount) {
                return back()->with('error', 'The amount entered exceeds the maximum amount allowed.');
            }
        

        $giftcard = new GiftCard;
        $giftcard->category_id = $request->category;
        $giftcard->name = $giftCard->name;
        $giftcard->exchange_rate = $request->exchange_rate;
        $giftcard->amount = $request->amount;
        $giftcard->type = $request->type;
        $giftcard->amount_in_naira = $totalAmount;
        $giftcard->pin = $request->pin;
        $giftcard->photo = $photoPath;
        $giftcard->listed_by = $user->id;
        $giftcard->status = 'available';
        $giftcard->v_status = 'pending';
        try{
            $giftcard->save();

            $admin = User::where('role', 'admin')->first();
            if($admin) {
                $admin->notify(new \App\Notifications\GiftcardAvailableNotification($giftcard));
            }
            
            return redirect()->back()->with('success', 'Giftcard uploaded and is now Pending Admin Approval!');
        } catch (\Exception $e) {
            Log::error('Error saving giftcard: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()->with('error', 'Failed to save data!');
            // Alert::error('Error', 'Failed to save data');
            // return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }



    public function getExchangeRate(Request $request)
    {
        $currencySymbol = $request->get('currency');
        if (!$currencySymbol) {
            return response()->json([
                'success' => false,
                'message' => 'Missing currency code.',
            ], 400); // Bad Request
        }
        $currencyRate = CurrencyRate::where('symbol', $currencySymbol)->first();

        if ($currencyRate) {
            return response()->json([
                'success' => false,
                'message' => 'Exchange rate not found for ' . $currencySymbol,
            ], 404); // Not Found
        }
        return response()->json([
            'success' => true,
            'rate' => $currencyRate->exchange_rate,
        ]);

    }

    public function getCurrencyRate(Request $request)
    {
        
    }

    public function Transactions()
    {
        $title = "Transactions";
        $userId = auth()->id();

        $transactions = Order::with(['buyer', 'seller'])
                        ->where('buyer', $userId)
                        ->orWhere('seller', $userId)
                        ->orderByRaw("FIELD(status, 'completed')")
                        ->get();
        // return view('user.orders', compact('title', 'orders'));
        // $transactions = Transaction::with('user', 'giftcard')->where('status', 'completed')->get();
        // // dd($transactions);
        return view('admin.transactions', compact('title', 'transactions'));
    }
}
