<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class pkruDataController extends Controller
{
    public function studentDashboard()
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

        return view('students.dashboard', compact('studentProfile', 'enrollBySemester'));
    }
}
