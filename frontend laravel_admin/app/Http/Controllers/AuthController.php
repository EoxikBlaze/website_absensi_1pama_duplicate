<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'nrp' => 'required',
            'password' => 'required'
        ]);

        $apiUrl = env('NODE_API_URL', 'http://localhost:3000');

        try {
            $response = Http::post("{$apiUrl}/api/auth/login", [
                'nrp' => $request->nrp,
                'password' => $request->password,
            ]);

            if ($response->successful()) {
                $data = $response->json();

                // Store token and user data in session
                Session::put('api_token', $data['token'] ?? null);
                Session::put('user', $data['data'] ?? null);

                return redirect()->intended('/')->with('success', 'Berhasil login!');
            }

            return back()->withErrors([
                'nrp' => 'NRP atau Password salah. Peringatan SERVER: ' . ($response->json('message') ?? 'Unauthorized'),
            ]);

        } catch (\Exception $e) {
            return back()->withErrors([
                'nrp' => 'Gagal terhubung ke API Node.js: ' . $e->getMessage(),
            ]);
        }
    }

    public function logout()
    {
        Session::forget('api_token');
        Session::forget('user');
        return redirect('/login');
    }
}
