@extends('layouts.front.main')

@section('page-title', 'ข้อมูลนักศึกษา')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('select-student') }}">เลือกนักศึกษา</a></li>
    <li class="breadcrumb-item active" aria-current="page">ข้อมูลนักศึกษา</li>
@endsection

@section('content')

    @if (empty($profile))
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5 text-muted">
                <i class="fas fa-user-slash fs-1 d-block mb-3 opacity-50"></i>
                <p class="mb-0">ไม่พบข้อมูลนักศึกษา</p>
            </div>
        </div>
    @else
        {{-- ===== Hero Profile Card ===== --}}
        <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #bbd3f3 0%, #67a1f8 50%);">
            <div class="card-body p-4 text-white">
                <div class="d-flex align-items-center gap-4">

                    <div class="rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center flex-shrink-0"
                        style="width:80px;height:80px;">
                        <i class="fas fa-user-graduate fs-1 text-white"></i>
                    </div>

                    <div class="flex-grow-1">
                        <h5 class="mb-1 fw-bold fs-4">
                            {{ ($profile['prefixabb'] ?? '') . ($profile['studentname'] ?? '') . ' ' . ($profile['studentsurname'] ?? '') }}
                        </h5>
                        <p class="mb-2 opacity-75 small">
                            <i class="fas fa-graduation-cap me-1"></i>{{ $profile['programname'] ?? '-' }}
                            &nbsp;·&nbsp;
                            <i class="fas fa-university me-1"></i>{{ $profile['facultyname'] ?? '-' }}
                        </p>
                        <div class="row">
                            <div class="col-md-6  d-flex flex-wrap gap-2 mt-1">
                                <span class="badge bg-white bg-opacity-25 px-3 py-2">
                                    <i class="fas fa-id-card me-1"></i>{{ $profile['studentcode'] ?? '-' }}
                                </span>
                                <span class="badge bg-white bg-opacity-25 px-3 py-2">
                                    <i class="fas fa-calendar-alt me-1"></i>ปีรับเข้า {{ $profile['admitacadyear'] ?? '-' }}
                                </span>
                                <span class="badge bg-white bg-opacity-25 px-3 py-2">
                                    <i class="fas fa-info-circle me-1"></i>สถานะ {{ $profile['studentstatusname'] ?? '-' }}
                                </span>
                            </div>
                            <div class="col-md-6 d-flex flex-wrap gap-2 mt-1" style="float:right;">
                                <a href="{{ route('students.enrollments') }}" class="btn btn-sm btn-light">
                                    <i class="fas fa-file-alt me-1"></i>ดูการลงทะเบียน
                                </a>
                                <a href="{{ route('students.vouchers') }}" class="btn btn-sm btn-light">
                                    <i class="fas fa-file-invoice-dollar me-1"></i>ดูใบแจ้งหนี้/ใบเสร็จ
                                </a>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div class="row g-4">

            {{-- ===== ข้อมูลส่วนตัว ===== --}}
            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h6 class="mb-0 fw-bold text-dark">
                            <i class="fas fa-user me-2 text-primary"></i>ข้อมูลส่วนตัว
                        </h6>
                    </div>
                    <div class="card-body p-0">

                        @php
                            $personalFields = [
                                [
                                    'icon' => 'fas fa-signature',
                                    'label' => 'ชื่อ-นามสกุล',
                                    'value' =>
                                        ($profile['prefixabb'] ?? '') .
                                        ($profile['studentname'] ?? '') .
                                        ' ' .
                                        ($profile['studentsurname'] ?? ''),
                                ],
                                [
                                    'icon' => 'fas fa-id-badge',
                                    'label' => 'รหัสนักศึกษา',
                                    'value' => $profile['studentcode'] ?? null,
                                ],
                                [
                                    'icon' => 'fas fa-id-card',
                                    'label' => 'เลขบัตรประชาชน',
                                    'value' => $profile['citizenid'] ?? null,
                                ],
                                [
                                    'icon' => 'fas fa-calendar',
                                    'label' => 'ปีการศึกษาที่เข้า',
                                    'value' => $profile['admitacadyear'] ?? null,
                                ],
                            ];
                        @endphp

                        @foreach ($personalFields as $field)
                            @if (!empty($field['value']))
                                <div
                                    class="d-flex align-items-center gap-3 px-4 py-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                    <div class="text-primary flex-shrink-0" style="width:20px;text-align:center;">
                                        <i class="{{ $field['icon'] }} small"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="text-muted" style="font-size:0.75rem;">{{ $field['label'] }}</div>
                                        <div class="fw-semibold text-dark small">{{ $field['value'] }}</div>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                    </div>
                </div>
            </div>

            {{-- ===== ข้อมูลการศึกษา ===== --}}
            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h6 class="mb-0 fw-bold text-dark">
                            <i class="fas fa-graduation-cap me-2 text-primary"></i>ข้อมูลการศึกษา
                        </h6>
                    </div>
                    <div class="card-body p-0">

                        @php
                            $academicFields = [
                                [
                                    'icon' => 'fas fa-scroll',
                                    'label' => 'สาขาวิชา',
                                    'value' => $profile['programname'] ?? null,
                                ],
                                [
                                    'icon' => 'fas fa-university',
                                    'label' => 'คณะ',
                                    'value' => $profile['facultyname'] ?? null,
                                ],
                            ];
                        @endphp

                        @foreach ($academicFields as $field)
                            @if (!empty($field['value']))
                                <div
                                    class="d-flex align-items-center gap-3 px-4 py-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                    <div class="text-primary flex-shrink-0" style="width:20px;text-align:center;">
                                        <i class="{{ $field['icon'] }} small"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="text-muted" style="font-size:0.75rem;">{{ $field['label'] }}</div>
                                        <div class="fw-semibold text-dark small">{{ $field['value'] }}</div>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                    </div>
                </div>
            </div>

            {{-- ===== ข้อมูลครอบครัว ===== --}}
            @if (!empty($profile['studentmothername']) || !empty($profile['studentfathername']))
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3 border-bottom">
                            <h6 class="mb-0 fw-bold text-dark">
                                <i class="fas fa-users me-2 text-primary"></i>ข้อมูลผู้ปกครอง
                            </h6>
                        </div>
                        <div class="card-body p-0">

                            @if (!empty($profile['studentmothername']))
                                <div class="d-flex align-items-center gap-3 px-4 py-3 border-bottom">
                                    <div class="bg-pink bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                        style="width:42px;height:42px;background:rgba(236,72,153,.1);">
                                        <i class="fas fa-female text-danger"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="text-muted" style="font-size:0.75rem;">มารดา</div>
                                        <div class="fw-semibold text-dark small">{{ $profile['studentmothername'] }}</div>
                                        @if (!empty($profile['mothercitizenid']))
                                            <div class="text-muted" style="font-size:0.73rem;">
                                                <i class="fas fa-id-card me-1"></i>{{ $profile['mothercitizenid'] }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            @if (!empty($profile['studentfathername']))
                                <div class="d-flex align-items-center gap-3 px-4 py-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                        style="width:42px;height:42px;background:rgba(59,130,246,.1);">
                                        <i class="fas fa-male text-primary"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="text-muted" style="font-size:0.75rem;">บิดา</div>
                                        <div class="fw-semibold text-dark small">{{ $profile['studentfathername'] }}</div>
                                        @if (!empty($profile['fathercitizenid']))
                                            <div class="text-muted" style="font-size:0.73rem;">
                                                <i class="fas fa-id-card me-1"></i>{{ $profile['fathercitizenid'] }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            @endif

        </div>{{-- end .row --}}

    @endif

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
