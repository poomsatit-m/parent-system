<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function selectStudent()
    {
        $citizenid = auth()->user()->citizenid;

        $response = Http::post('https://student.pkru.ac.th/api/getparent', [
            'citizenid' => $citizenid,
        ]);

        $students = $response->successful() ? ($response->json('data') ?? []) : [];

        session(['students_list' => $students]);

        if (count($students) === 1) {
            $studentCode = $students[0]['studentcode'] ?? null;
            if ($studentCode) {
                return redirect()->route('profile.student', ['studentId' => $studentCode]);
            }
        }



        return view('profile.select-student', compact('students'));
    }

    public function studentProfile($studentCode)
    {
        $studentsList = session('students_list', []);


        $profile = collect($studentsList)->firstWhere('studentcode', $studentCode);

        session([
            'selected_studentcode'     => $studentCode,
            'selected_student_profile' => $profile,
        ]);

        return redirect()->route('students.profile');
    }
}
