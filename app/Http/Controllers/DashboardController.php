<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\GiftCard;
use App\Models\Order;
use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{

    public function dashboard()
    {
        $title = "Dashboard";
        return view('user.dashboard', compact('title'));
    }

    public function sellstore(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required|string|max:255',
        //     'code' => 'required|string|unique:giftcards',
        //     'pin' => 'required|string|max:255',
        //     'brand' => 'required|string|max:255',
        //     'value' => 'required|numeric',
        //     'currency' => 'required|string|max:255',
        //     'exchange_rate' =>  'nullable|numeric',
        //     'exchange_currency' => 'nullable|string|max:255',
        //     'expiration_date' => 'nullable|date',
        //     'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        // ]);

        // dd($validator);
    }

    public function orderTable()
    {
        $title = "Orders";
        $orders = Order::with('seller', 'giftcard', 'cryptocurrency')->firstOr(function () {
            return new Order();
        });
        // dd($orders);
        return view('user.orders', compact('title', 'orders'));
    }

    public function openTicket(Request $request)
    {
        $user = Auth::user();

        if (!$user || !$user->email || !$user->firstname)
        {
            return redirect()->back()->with('error', 'Please complete your profile for verification before opening ticket!');
        }

        $request->validate([
            'subject'=> 'required|string',
            'message' => 'required|string'
        ]);

        $ticket = SupportTicket::create([
            'user_id' => $user->id,
            'name'=> $user->firstname. ' ' . $user->lastname,
            'email'=>$user->email,
            'phone' => $user->phone ?? 'N/A',
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
            'status' => 'pending'
        ]);

        $ticketData = [
            'name' => $ticket->name,
            'email' => $ticket->email,
            'phone' => $ticket->phone,
            'subject' => $ticket->subject,
            'message' => $ticket->message,
            'status' => $ticket->status,
        ];

        $admin = User::where('role', 'admin')->first();
            if ($admin) {
                $admin->notify(new \App\Notifications\NewTicketNoticication($ticketData));
            }
        $user->email->notify(new \App\Notifications\UserTicketNotification($ticketData));

        return redirect()->back()->with('success', 'Support ticket opened successfully!');
    }

    public function catShow()
    {
        $title = 'Gift Card Categories';
        $categories = Category::all();
        return view ('admin.add_category', compact('title', 'categories'));
    }

    public function catStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:categories|max:255',
            'cat_photo' => 'required|file|mimes:jpeg, png, jpg, gif, svg|max:2048',
        ]);

        if($request->hasFile('cat_photo')) {
            $imagePath = $request->file('cat_photo')->store('category_images', 'public');
        } else {
            return back()->with('error', 'Image upload failed');
        }


        $category =  new Category();
        $category->name = $request['name'];
        $category->logo = $imagePath;

        try {
        $category->save();
        return back()->with('success', 'Category added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add Category!');
        }

    }

    public function catEdit($id)
    {
        $category = Category::findOrFail($id);
        return response()->json(['category' => $category]);
    }
    

    public function catUpdate(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        if($request->hasFile('cat_photo')) {
            $imagePath = $request->file('cat_photo')->store('category_images', 'public');
            $category->logo = $imagePath;
            } else {
            $imagePath = $category->logo;
        }

        $category->name = $request->name;

        try{
            $category->save();
            return redirect()->back()->with('success', 'Category updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update Category!');
        } 
}

    public function catDel($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();

            if($category){
                $category->delete();
            }

            return redirect()->back()->with('success','Category Deleted Successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete Category!');
        }
    }



    
}
