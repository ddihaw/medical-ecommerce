<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        return view('authentication.login');
    }

    public function register_index()
    {
        return view('authentication.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
            'store_name' => "required_if:role,'seller'|nullable|unique:stores|string|max:255",
        ]);

        if ($validator->fails()) {
            $failedRules = $validator->failed();

            if (isset($failedRules['email']) && isset($failedRules['email']['Unique'])) {
                return redirect(route('auth.signUp'))->with(['message' => ['secondary', 'Email sudah terdaftar.']]);
            }

            if (isset($failedRules['store_name']) && isset($failedRules['store_name']['Unique'])) {
                return redirect(route('auth.signUp'))->with(['message' => ['secondary', 'Nama toko sudah terdaftar.']]);
            }

            return redirect(route('auth.signUp'))->with(['message' => ['secondary', 'Periksa kembali data yang Anda masukkan.']]);
        }

        if ($request->role === 'buyer') {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'buyer',
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return redirect(route('auth.signIn'))->with(['message' => ['success', 'Pendaftaran akun berhasil. Silakan login.']]);
        } elseif ($request->role === 'seller') {
            if (! isset($request->store_name)) {
                return redirect(route('auth.signUp'))->with(['message' => ['secondary', 'Nama toko wajib diisi untuk pendaftaran sebagai penjual.']]);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'seller',
            ]);

            Store::create([
                'user_id' => $user->id,
                'store_name' => $request->store_name,
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return redirect(route('auth.signIn'))->with(['message' => ['success', 'Pendaftaran akun berhasil. Silakan login.']]);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect(route('auth.signIn'))->with(['message' => ['warning', $validator->errors()]]);
        }

        if (! Auth::attempt($request->only('email', 'password'))) {
            return redirect(route('auth.signIn'))->with(['message' => ['danger', 'Email atau password salah']]);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return redirect(route('dashboard.index'));
    }

    public function me(Request $request)
    {
        $user = $request->user();

        if ($user->isSeller()) {
            $user->load('store');
        }

        return response()->json($user);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('auth.signIn')->with(['message' => ['success', 'Logout berhasil']]);
    }
}
