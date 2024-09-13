<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GiftCard;
use App\Models\User;
use App\Models\Cryptocurrency;
use App\Models\CryptoWalletAddress;
use App\Models\Order;

class InvoiceController extends Controller
{

    public function orderTable()
    {
        $title = "Orders";
        $userId = auth()->id();

        $orders = Order::with(['buyer', 'seller'])
                        ->where('buyer', $userId)
                        ->orWhere('seller', $userId)
                        ->orderByRaw("FIELD(status, 'pending', 'completed', 'cancelled')")
                        ->get();
        return view('user.orders', compact('title', 'orders'));
    }

    public function showInvoice($id)
    {
        $giftCard = GiftCard::with(['seller', 'image'])->findOrFail($id);
        $buyer = auth()->user();
        return view('user.invoice', compact('giftCard', 'buyer'));
    }

    public function cryptoInvoice(Order $order)
    {
        $title = "Invoice";
        // $order = Order::with(['buyer', 'seller', 'crypto'])->findOrFail($order->id)->first();
        $order = Order::findOrFail($order->id);
        $seller = User::find($order->seller);
        $buyer = User::find($order->buyer);
        $crypto = Cryptocurrency::find($order->crypto_id);
        $sellerAccountDetails = [
            'bank_name' =>$seller->bank_name,
            'account_number' => $seller->account_number,
            'account_name'=> $seller->account_name,
        ];

        return view('user.crypto_invoice', [
            'order' => $order,
            'buyer' =>$buyer,
            'seller' => $seller,
            'cryptoName' => $crypto ? $crypto->name : 'N/A',
            'sellerAccountDetails' => $sellerAccountDetails,
            'title' => $title,
        ]);
    }

    public function getOrderDetails($id)
    {
        $order = Order::findOrFail($id);

        return response()->json(['order' => $order]);
    }

    public function updateOrder(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $order->status = $request->status;

        try{
            $order->save();
            return redirect()->back()->with('success', 'Order Status Changed successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to Change order status!');
        }


    }

    public function deleteOrder($id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->delete();

            return redirect()->back()->with('success','Order Deleted Successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete order!');
        }
    }
}
