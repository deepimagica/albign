<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function getLoginPage()
    {
        return view('user.auth.login');
    }

    public function postLoginPage(Request $request)
    {
        try {
            $credentials = $request->validate([
                'employee_code' => 'required|string',
                'password' => 'required',
            ]);
            
            $user = User::where('employee_code', $credentials['employee_code'])->first();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Employee code not found.',
                ], 401);
            }
            if ($user->password === md5($request->password)) {
                Auth::guard('user')->login($user);

                return response()->json([
                    'success' => true,
                    'redirect_url' => route('dashboard'),
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => 'Mismatched! Employee code or password do not match.',
            ], 401);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors(),], 422);
        } catch (\Exception $e) {
            dd($e);
            return response()->json(['success' => false, 'message' => 'Something went wrong.', 'error' => $e->getMessage(),], 500);
        }
    }

    public function getForgotPasswordPage()
    {
        return view('user.auth.forgot_pass');
    }
}
