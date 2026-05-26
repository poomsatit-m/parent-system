<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class checkStudentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (session('selected_studentcode') === null || session('selected_student_profile') === null) {
            return redirect()->route('select-student')->with('error', 'กรุณาระบุนักศึกษา เพื่อเข้าถึงข้อมูลนักศึกษา');
        }
        return $next($request);
    }
}
