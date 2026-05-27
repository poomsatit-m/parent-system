<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class ThaiDController extends Controller
{
    // 1. ส่งผู้ใช้ไปยังหน้า Login ของ ThaiD
    public function redirect()
    {
        $state = Str::random(40);
        session(['thaid_state' => $state]); // เก็บ state ลง session เพื่อตรวจสอบภายหลัง

        $query = http_build_query([
            'response_type' => 'code',
            'client_id'     => config('services.thaid.client_id'),
            'redirect_uri'  => config('services.thaid.redirect_uri'),
            'scope'         => 'pid name',
            'state'         => $state,
        ]);

        return redirect(config('services.thaid.base_url') . '/auth/?' . $query);
    }

    /**
     * 2. รับ Callback และแลกเปลี่ยน Token
     */
    public function callback(Request $request)
    {
        // ตรวจสอบ State เพื่อความปลอดภัย
       /* $state = $request->get('state');
        if (!$state || $state !== session('thaid_state')) {
            return redirect()->route('login---')->with('error', 'Invalid state parameter.');
        }

        $code = $request->get('code');
        if (!$code) {
            return redirect()->route('login')->with('error', 'Authorization code not found.');
        }*/


        try {
              $code = $request->get('code');
            $clientId = config('services.thaid.client_id');
            $clientSecret = config('services.thaid.client_secret');

            // ขั้นตอนการแลก Token
            $response = Http::asForm()
                ->withBasicAuth($clientId, $clientSecret) // แนะนำใช้ Method นี้แทนการจัด Header เอง
                ->post(config('services.thaid.base_url') . '/token/', [
                    'grant_type'   => 'authorization_code',
                    'code'         => $code,
                    'redirect_uri' => config('services.thaid.redirect_uri'),
                    'scope'        => 'pid name',
                ]);



            if ($response->failed()) {
                Log::error('ThaiD Token Error: ' . $response->body());
                return redirect('/')->with('error', 'ไม่สามารถเชื่อมต่อกับ ThaiD ได้');
            }

            $tokenData = $response->json();


            $userData = $tokenData;
            $password = Str::random(16); // สร้างรหัสผ่านแบบสุ่มสำหรับผู้ใช้ที่สร้างใหม่

            $user = User::updateOrCreate(
                ['citizenid' => $userData['pid']],
                [
                    'name' => $userData['name'] ?? 'ผู้ใช้ ThaiD',
                    'password' => bcrypt($password),
                  //  'email' => $username . '@pkru.ac.th',

                ]
            );

            Auth::login($user);

            session()->forget('thaid_state');

            return redirect('/select-student')->with('success', 'ยืนยันตัวตนสำเร็จ');
       } catch (\Exception $e) {
            Log::error('ThaiD Callback Exception: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'เกิดข้อผิดพลาดภายในระบบ');
        }

    }
}
