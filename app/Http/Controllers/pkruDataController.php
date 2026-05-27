<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class pkruDataController extends Controller
{
    public function studentprofile()
    {
         $studentcode = session('selected_studentcode');

       // exit();

        $response = Http::post('https://student.pkru.ac.th/api/getprofile', [
            'STUDENTCODE' => $studentcode,
        ]);

        $data    = $response->successful() ? ($response->json('data') ?? []) : [];
        $profile = $data[0] ?? [];

        return view('students.profile', compact('profile'));


       // return redirect()->route('students.enrollments');
    }
    public function studentenrollments()
    {
        $studentcode    = session('selected_studentcode');
        $studentProfile = session('selected_student_profile', []);

        $response = Http::post('https://student.pkru.ac.th/api/getenroll', [
            'studentcode' => $studentcode,
        ]);

        $enroll = $response->successful() ? ($response->json('data') ?? []) : [];

        $enrollBySemester = collect($enroll)
            ->groupBy('fullacadyear')
            ->sortKeysDesc();

        return view('students.enrollments', compact('studentProfile', 'enrollBySemester'));
    }

    public function studentvouchers()
    {
        $studentcode    = session('selected_studentcode');
        $studentProfile = session('selected_student_profile', []);

        $studentid = $studentProfile['studentid'] ?? null;

       // $studentid = '1236608';

        $response = Http::post('https://student.pkru.ac.th/api/getvoucher', [

            'studentid' => $studentid,
        ]);

        $vouchers = $response->successful() ? ($response->json('data') ?? []) : [];

        $vouchersBySemester = collect($vouchers)->sortByDesc('fullacadyear');

        return view('students.vouchers', compact('studentProfile', 'vouchersBySemester'));
    }
}
