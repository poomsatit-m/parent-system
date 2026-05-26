@extends('layouts.front.main')

@section('page-title', 'เลือกนักศึกษา')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">เลือกนักศึกษา</li>
@endsection

@section('content')

    <div class="mb-3">
        <p class="text-muted mb-0">
            <i class="fas fa-hand-pointer me-1"></i>กรุณาแตะเลือกนักศึกษาที่ต้องการดูข้อมูล
        </p>
    </div>

    @forelse ($students as $student)
        <a href="{{ route('profile.student', $student['studentcode']) }}"
           class="text-decoration-none d-block mb-3">
            <div class="card shadow-sm border-0 student-card">
                <div class="card-body px-4 py-3">
                    <div class="d-flex align-items-center gap-3">

                        {{-- Avatar --}}
                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                             style="width:54px;height:54px;">
                            <i class="fas fa-user-graduate text-primary fs-4"></i>
                        </div>

                        {{-- Info --}}
                        <div class="flex-grow-1 overflow-hidden">
                            <div class="fw-bold text-dark fs-6 text-truncate">
                                {{ ($student['prefixabb'] ?? '') . ($student['studentname'] ?? '') . ' ' . ($student['studentsurname'] ?? '') }}
                            </div>
                            <div class="text-muted small mt-1 d-flex flex-wrap gap-2">
                                <span>
                                    <i class="fas fa-id-card me-1"></i>{{ $student['studentcode'] ?? '-' }}
                                </span>
                                <span>
                                    <i class="fas fa-calendar-alt me-1"></i>ปี {{ $student['admitacadyear'] ?? '-' }}
                                </span>
                            </div>
                            @if (!empty($student['programname']))
                                <div class="text-muted small text-truncate mt-1">
                                    <i class="fas fa-graduation-cap me-1"></i>{{ $student['programname'] }}
                                </div>
                            @endif
                        </div>

                        {{-- Arrow --}}
                        <div class="text-primary flex-shrink-0">
                            <i class="fas fa-chevron-right fs-5"></i>
                        </div>

                    </div>
                </div>
            </div>
        </a>
    @empty
        <div class="card shadow-sm border-0">
            <div class="card-body text-center py-5 text-muted">
                <i class="fas fa-inbox fs-1 d-block mb-3 opacity-50"></i>
                <p class="mb-0">ไม่พบข้อมูลนักศึกษา</p>
            </div>
        </div>
    @endforelse

@endsection

@push('styles')
<style>
    .student-card {
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }
    .student-card:active {
        transform: scale(0.98);
        box-shadow: 0 1px 4px rgba(0,0,0,.1) !important;
    }
    @media (hover: hover) {
        .student-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(0,0,0,.1) !important;
        }
    }
</style>
@endpush

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
