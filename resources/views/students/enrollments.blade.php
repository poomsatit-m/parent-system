@extends('layouts.front.main')

@section('page-title', 'การลงทะเบียน')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('select-student') }}">เลือกนักศึกษา</a></li>
    <li class="breadcrumb-item active" aria-current="page">การลงทะเบียน</li>
@endsection

@section('content')

{{-- ===== Student Profile Card ===== --}}
<div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #bbd3f3 0%, #67a1f8 50%);">
    <div class="card-body p-4 text-white">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center flex-shrink-0"
                 style="width:64px;height:64px;">
                <i class="fas fa-user-graduate fs-2 text-white"></i>
            </div>
            <div class="flex-grow-1">
                <h5 class="mb-1 fw-bold">
                    {{ ($studentProfile['prefixabb'] ?? '') . ($studentProfile['studentname'] ?? '') . ' ' . ($studentProfile['studentsurname'] ?? '') }}
                </h5>
                <div class="d-flex flex-wrap gap-2 mt-2">
                    <span class="badge bg-white bg-opacity-25 px-3 py-2">
                        <i class="fas fa-id-card me-1"></i>{{ $studentProfile['studentcode'] ?? '-' }}
                    </span>
                    <span class="badge bg-white bg-opacity-25 px-3 py-2">
                        <i class="fas fa-calendar-alt me-1"></i>ปีที่รับเข้า {{ $studentProfile['admitacadyear'] ?? '-' }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Finance status summary --}}
        @php
            $hasUnpaid = collect($enrollBySemester->first() ?? [])->where('financestatusbysem', 'Y')->isNotEmpty();
        @endphp
        @if ($hasUnpaid)
        <div class="mt-3 p-2 rounded bg-warning bg-opacity-25 d-flex align-items-center gap-2">
            <i class="fas fa-exclamation-triangle text-warning"></i>
            <span class="small">มีค่าลงทะเบียนค้างชำระในภาคเรียนล่าสุด</span>
        </div>
        @endif
    </div>
</div>

{{-- ===== Enrolled Courses by Semester ===== --}}
@forelse ($enrollBySemester as $semester => $courses)
    @php
        $financeOk = $courses->firstWhere('financestatusbysem', 'Y') !== null;
        $totalCredits = $courses->sum('creditattempt');
    @endphp

    <div class="card border-0 shadow-sm mb-3">
        <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <span class="fw-bold text-dark">
                    <i class="fas fa-book-open me-2 text-primary"></i>ภาคเรียน {{ $semester }}
                </span>
                <span class="text-muted small ms-2">{{ $courses->count() }} วิชา · {{ $totalCredits }} หน่วยกิต</span>
            </div>
            @if ($courses->first()['financestatusbysem'] === 'N')
                <span class="badge bg-success-subtle text-success px-3 py-2">
                    <i class="fas fa-check-circle me-1"></i>ชำระค่าลงทะเบียนแล้ว
                </span>
            @else
                <span class="badge bg-danger-subtle text-danger px-3 py-2">
                    <i class="fas fa-times-circle me-1"></i>มีค่าลงทะเบียนค้างชำระ
                </span>
            @endif
        </div>

        <div class="card-body p-0">
            @foreach ($courses as $course)
                @php
                    $grade = $course['grade'] ?? '';
                    $gradeClass = match(true) {
                        in_array($grade, ['A'])           => 'success',
                        in_array($grade, ['B+', 'B'])     => 'primary',
                        in_array($grade, ['C+', 'C'])     => 'warning',
                        in_array($grade, ['D+', 'D'])     => 'secondary',
                        in_array($grade, ['F'])           => 'danger',
                        default                           => 'light',
                    };
                @endphp
                <div class="d-flex align-items-center gap-3 px-4 py-3 border-bottom">
                    <div class="flex-grow-1">
                        <div class="fw-semibold text-dark small">{{ $course['coursename'] ?? '-' }}</div>
                        <div class="text-muted" style="font-size:0.78rem;">
                            {{ $course['coursecode'] ?? '' }} &nbsp;·&nbsp; {{ $course['creditattempt'] ?? '0' }} หน่วยกิต
                        </div>
                    </div>
                    @if ($grade)
                        <span class="badge bg-{{ $gradeClass }} px-3 py-2 fs-6 fw-bold flex-shrink-0">
                            {{ $grade }}
                        </span>
                    @else
                        <span class="badge bg-light text-muted px-3 py-2 flex-shrink-0">-</span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@empty
    <div class="card border-0 shadow-sm">
        <div class="card-body text-center py-5 text-muted">
            <i class="fas fa-inbox fs-1 d-block mb-3 opacity-50"></i>
            <p class="mb-0">ไม่พบข้อมูลการลงทะเบียน</p>
        </div>
    </div>
@endforelse

@endsection

@push('scripts')
@if (session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'แจ้งเตือน',
        text: '{{ session('error') }}',
        confirmButtonText: 'ตกลง',
        confirmButtonColor: '#d33',
    });
</script>
@endif
@endpush
