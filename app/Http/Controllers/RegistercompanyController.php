<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\RegistercompanyRequest;
use App\Mail\EmailVerify;
use App\Models\EmailVerification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegistercompanyController extends Controller
{

    public function register(RegistercompanyRequest $request)
    {
        $userData = $request->validated();
        $username = Company::generateUsername($userData['name']);
        $userData['username'] = $username;
        $emailExist = Company::where('email', $userData['email'])->exists();

        if ($emailExist) {
            return response()->json([
                'success' => false,
                'message' => 'Email sudah dipakai',
            ]);
        }

        $telephoneExist = Company::where('telephone', $userData['telephone'])->exists();

        if ($telephoneExist) {
            return response()->json([
                'success' => false,
                'message' => 'Telepon sudah dipakai',
            ]);
        }

        $otp = random_int(100000, 999999);
        $emailverify = new EmailVerification();
        $emailverify->email = $request->email;
        $emailverify->token = Hash::make($otp);
        $emailverify->created_at = now();
        $emailverify->save();

        Mail::to($request->email)->send(new EmailVerify($otp));

        session()->put('registration_data', $userData);

        return response()->json([
            'success' => true,
            'message' => 'OTP has been sent to your email!'
        ]);
    }
    public function otp(Request $request)
    {
        $request->validate([
            'otp' => 'required',
            'email' => 'required|email'
        ]);

        $otp = EmailVerification::where('email', $request->email)
            ->where('created_at', '>', Carbon::now()->subMinutes(2))
            ->latest()
            ->first();

        if (!$otp || !Hash::check($request->otp, $otp->token)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP'
            ]);
        }

        $userData = session()->get('registration_data');
        $company = Company::create($userData);
        Auth::login($company);
        return response()->json([
            'success' => true,
            'csrf_token' => csrf_token(),
        ]);
    }
}
