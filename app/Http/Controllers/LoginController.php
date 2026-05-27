<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    //

    public function login(Request $request)
    {

        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            /*  'g-recaptcha-response' => 'required|captcha',
                                ], [
                                    'g-recaptcha-response.required' => 'กรุณายืนยันว่า คุณไม่ใช่บอท',
                                    'g-recaptcha-response.captcha' => 'การตรวจสอบ reCAPTCHA ล้มเหลว กรุณาลองใหม่อีกครั้ง',
                                    */
        ]);


        $username = $request->input('username');
        $password = $request->input('password');


        //echo "Username: $username, Password: $password";

        //exit();


        $AuthCode = '4AJD-BF86-AJGF-YD67-AKGF-6ABF-VEV2';
        $RequestInfo = 'true';

        $response = Http::asForm()->post('https://data-service.pkru.ac.th/api/staff/auth/CallPassport', [
            'user' => $username,
            'password' => $password,
            'authcode' => $AuthCode,
            'RequestInfo' => $RequestInfo,
        ]);

        // เช็กว่า response สำเร็จหรือไม่
        $json = $response->json();

        //dd($json);

        // ✅ ตรวจสอบว่า login ผ่านและมีข้อมูล
        if (
            !isset($json['status']) || $json['status'] != 200 ||
            !isset($json['data'][0]) || $json['data'][0] !== true
        ) {
            return back()->withErrors(['username' => 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง']);
        }

        $staff = $json['data'];

        // dd($staff);

        // รวมชื่อ-นามสกุลจาก array
        // $staff[2] = คำนำหน้า, $staff[3] = ชื่อ, $staff[4] = นามสกุล
        $fullName = ($staff[2] ?? '') . ($staff[3] ?? '') . ' ' . ($staff[4] ?? '');

        $citizenid = '3830300065687';
        $user = User::updateOrCreate(
            ['citizenid' => $citizenid],
            [
                'name' => trim($fullName) ?: $username,
               // 'email' => $username . '@pkru.ac.th',
                'password' => bcrypt($password),
                'citizenid' => $citizenid,
            ]

        );

        Auth::login($user);
       // echo "Login successful for user: authenticated with " . auth()->user()->name;

      //  exit();

        // return redirect()->intended('/dashboard');

        //return redirect('/aaaa')->with('success', 'เข้าสู่ระบบสำเร็จ');

        return redirect()->intended('/select-student');
    }
}
