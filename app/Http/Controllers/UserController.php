<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;


class UserController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->verification_token !== null) {
                $verificationToken = rand(100000, 999999);

                Session::put('verification_token', $verificationToken);

                $user->notify(new \App\Notifications\VerifyEmail($verificationToken));

            return view('notify.email_verification')->with('success', 'A verification code has been sent to your email');

            }

            Session::flash('success', 'You have successfully logged in.');
            if ($user->role === 'admin') {
                Session::flash('success', 'Welcome' .' '.$user->firstname. '!');
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'superadmin') {
                Session::flash('success', 'You have successfully logged in!');
                return redirect()->route('admin.dashboard');
            } else {
                Session::flash('success', 'Welcome' .' '.$user->firstname. '!');
                return redirect()->route('dashboard');
            }
            } else {
                Session::flash('error', 'Invalid email or password.');
                return redirect()->route('login.form');
            }
        }
    

    public function signup()
    {
        return view ('user.register');
    }
    public function register(Request $request)
    {
        // Log the incoming request data for debugging
        Log::info('Registration Request:', $request->all());

        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Log validation errors if any
        if ($validator->fails()) {
            Log::error('Validation Errors:', $validator->errors()->toArray());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        else {

            $verificationToken = rand(100000, 999999);

            $user = User::create([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'verification_token' => $verificationToken,
            ]);

            $user->notify(new \App\Notifications\VerifyEmail($verificationToken));

            return view('notify.email_verification')->with('success', 'Please verify your email');

        }
    }

    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required'
        ]);

       
        
        $user = Auth::user();
        if(!Hash::check($request->password, $user->password)){
            return redirect()->back()->with('error', 'Old Password is incorrect!');
        }

        if($request->new_password !== $request->confirm_password){
            return redirect()->back()->with('error', 'The passwords do not match!');
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->back()->with('success', 'Password Changed successfully!');

    }

    public function invoice(Order $order)
{
    return view('user.invoice', ['order' => $order]);
}
   
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.form');
    }

    public function passwordReset()
    {
        return view('user.change-password');
    }

    public function showProfile()
    {
        $title = "Profile Details";
        return view ('user.profile', compact(['title']));
    }

    public function editProfile($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function giftForm()
    {
        return view ('user.sellgift');
    }
    
    public function updateProfile(request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'nullable|string|max:255',
            'lastname' => 'nullable|string|max:255',
            'address.street' => 'nullable|string|max:255',
            'address.state' => 'nullable|string|max:255',
            'address.country' => 'nullable|string|in:US,UK,NGA,GH,SA,SL,KE',
            'gender' => 'nullable|string|in:male,female',
            'date_of_birth' => 'nullable|date',
            'email' => 'nullable|email|max:255|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:15',
            'photo' => 'nullable|mimes:jpeg,png,jpg|max:2048'
        ]);
        
        $user = Auth::user();
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->address = $request->input('address');
        $user->gender = $request->input('gender');
        $user->date_of_birth = $request->input('date_of_birth');

        if($request->filled('email')){
            $user->email = $request->input('email');
        }
        $user->phone = $request->input('phone');

        if($request->hasFile('photo')){
            $user->photo = $request->file('photo')->store('profile_pictures', 'public');
        }

        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
        
    }

    public function faStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            '2fa_enabled' => 'required|in:1,0',
            
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $user = Auth::user();
        $user->update(['2fa_enabled' => $request->input('2fa_enabled')]);

        $user->save();    
        return redirect()->back()->with('success', '2FA status updated successfully!');
    }

    public function passChange(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required'
        ]);

       
        
        $user = Auth::user();
        if(!Hash::check($request->password, $user->password)){
            return redirect()->back()->with('error', 'Old Password is incorrect!');
        }

        if($request->new_password !== $request->confirm_password){
            return redirect()->back()->with('error', 'The passwords do not match!');
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->back()->with('success', 'Password Changed successfully!');
        
    }

    // public function updateProfile(Request $request)
    // {
    //     dd($request);
    //     $user = User::findOrFail(auth()->id());

    //     $validatedData = $request->validate([
    //         'firstname' => 'required|string|max:255',
    //         'lastname' => 'required|string|max:255',
    //         'address.street' => 'required|string|max:255',
    //         'address.state_province' => 'required|string|max:255',
    //         'address.country' => 'required|string|max:255',
    //         'gender' => 'required|string|in:male,female',
    //         'email' => [
    //             'required',
    //             'string',
    //             'email',
    //             Rule::unique('users', 'email')->ignore($user->id), // Unique excluding current user
    //         ],
    //         'phone' => 'required|string', // Additional validation for phone number might be needed
    //     ]);
        

    //     // Extract address data
    //     $addressData = [
    //         'street' => $validatedData['address']['street'],
    //         'state_province' => $validatedData['address']['state_province'],
    //         'country' => $validatedData['address']['country'],
    //     ];

    //     $user->firstname = $validatedData['firstname'];
    //     $user->lastname = $validatedData['lastname'];
    //     $user->address = json_encode($addressData); // Store address as JSON
    //     $user->gender = $validatedData['gender'];
    //     $user->email = $validatedData['email'];
    //     $user->phone = $validatedData['phone'];

    //     // Handle profile picture upload (if applicable)
    //     if ($request->hasFile('photo')) {
    //         $photo = $request->file('photo');
    //         $fileName = time() . '.' . $photo->getClientOriginalExtension();
    //         $photo->storeAs('public/profile_pictures', $fileName);
    //         $user->photo = $fileName; // Update profile picture path
    //     }

    //     $user->save();

    //     return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    // }

}
