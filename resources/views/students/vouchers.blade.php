@extends('layouts.front.main')

@section('page-title', 'ใบเสร็จค่าลงทะเบียน')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('select-student') }}">เลือกนักศึกษา</a></li>
    <li class="breadcrumb-item active" aria-current="page">ใบเสร็จค่าลงทะเบียน</li>
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

        @php
            $hasBalance = $vouchersBySemester->contains(fn($s) => (float) str_replace(',', '', $s['grandtotalbalance'] ?? '0') > 0);
        @endphp
        @if ($hasBalance)
        <div class="mt-3 p-2 rounded bg-warning bg-opacity-25 d-flex align-items-center gap-2">
            <i class="fas fa-exclamation-triangle text-warning"></i>
            <span class="small">มียอดค้างชำระค่าลงทะเบียน</span>
        </div>
        @endif
    </div>
</div>

{{-- ===== Vouchers by Semester ===== --}}
@forelse ($vouchersBySemester as $sem)
    @php
        $balance   = (float) str_replace(',', '', $sem['grandtotalbalance'] ?? '0');
        $isPaid    = $balance <= 0;
        $enrollFee = $sem['enrollfee'] ?? [];
        $voucher   = $sem['vocucher'] ?? [];
        $canPrint  = $voucher['canprint'] ?? false;
        $remark    = $voucher['remark'] ?? '';
    @endphp

    <div class="card border-0 shadow-sm mb-3">

        {{-- Semester header --}}
        <div class="card-header bg-white py-3">
            <div class="d-flex align-items-start justify-content-between flex-wrap gap-3">
                <div>
                    <div class="fw-bold text-dark mb-1">
                        <i class="fas fa-receipt me-2 text-primary"></i>
                        ภาคเรียนที่ {{ $voucher['semester'] ?? '' }}
                        ปีการศึกษา {{ $voucher['acadyear'] ?? $sem['fullacadyear'] ?? '-' }}
                    </div>
                    @if ($isPaid && !empty($voucher['vouchercode']))
                    <div class="d-flex align-items-center gap-2 flex-wrap mt-1">
                        <span class="text-muted" style="font-size:0.82rem;">
                            <i class="fas fa-hashtag me-1 text-secondary opacity-75"></i>เลขที่ใบเสร็จ&nbsp;<strong class="text-dark">{{ $voucher['vouchercode'] }}</strong>
                        </span>
                        @if (!empty($voucher['recrivecode']))
                        <span class="text-muted" style="font-size:0.82rem;">
                            <span class="text-secondary opacity-50">|</span>&nbsp;รหัสรับชำระ&nbsp;<strong class="text-dark">{{ $voucher['recrivecode'] }}</strong>
                        </span>
                        @endif
                    </div>
                    @endif
                </div>

                <div class="d-flex align-items-center gap-2 flex-wrap">
                    @if ($isPaid)
                        <span class="badge bg-success-subtle text-success px-3 py-2">
                            <i class="fas fa-check-circle me-1"></i>ชำระครบแล้ว
                        </span>
                        @if ($canPrint)
                            <a href="https://student.pkru.ac.th/pdf/pdfvoucher/{{ $voucher['voucherkeys'] }}" class="btn btn-primary btn-sm" target="_blank">
                                <i class="fas fa-print me-1"></i>พิมพ์ใบเสร็จ
                            </a>
                        @else
                            <span class="badge bg-secondary-subtle text-secondary px-3 py-2"
                                  @if($remark) title="{{ $remark }}" data-bs-toggle="tooltip" @endif>
                                <i class="fas fa-ban me-1"></i>ไม่สามารถพิมพ์ได้
                            </span>
                        @endif
                    @else
                        <span class="badge bg-danger-subtle text-danger px-3 py-2">
                            <i class="fas fa-clock me-1"></i>มียอดค้างชำระ
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="card-body p-0">

            {{-- Enrollment fee items --}}
            @foreach ($enrollFee as $fee)
            <div class="d-flex justify-content-between align-items-center px-4 py-3 border-bottom">
                <div>
                    <div class="fw-semibold text-dark small">{{ $fee['feeidname'] ?? '-' }}</div>

                </div>
                <div class="text-end">
                    <div class="fw-bold text-dark">฿{{ $fee['amount'] ?? '-' }}</div>
                </div>
            </div>
            @endforeach

            {{-- Grand total row --}}
            <div class="d-flex justify-content-between align-items-center px-4 py-3 border-bottom bg-light">
                <span class="text-muted small fw-semibold">ยอดรวมทั้งหมด</span>
                <span class="fw-bold text-dark">฿{{ $sem['grandtotalamount'] ?? '-' }}</span>
            </div>
            <div class="d-flex justify-content-between align-items-center px-4 py-2 border-bottom">
                <span class="text-muted small">ชำระแล้ว</span>
                @php $paid = (float) str_replace(',', '', $sem['grandtotalamount'] ?? '0') - $balance; @endphp
                <span class="fw-semibold text-success">฿{{ number_format($paid, 2) }}</span>
            </div>
            <div class="d-flex justify-content-between align-items-center px-4 py-2 border-bottom">
                <span class="text-muted small">คงเหลือ</span>
                <span class="fw-semibold {{ $isPaid ? 'text-success' : 'text-danger' }}">
                    ฿{{ $sem['grandtotalbalance'] ?? '0.00' }}
                </span>
            </div>

            {{-- Remark when print is disabled --}}
            @if (!empty($voucher) && !$canPrint && $remark)
            <div class="px-4 py-2 border-top">
                <span class="text-muted" style="font-size:0.78rem;">
                    <i class="fas fa-info-circle me-1"></i>{{ $remark }}
                </span>
            </div>
            @endif

        </div>
    </div>
@empty
    <div class="card border-0 shadow-sm">
        <div class="card-body text-center py-5 text-muted">
            <i class="fas fa-receipt fs-1 d-block mb-3 opacity-50"></i>
            <p class="mb-0">ไม่พบข้อมูลใบเสร็จค่าลงทะเบียน</p>
        </div>
    </div>
@endforelse

@endsection

@push('scripts')
<script>
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
        new bootstrap.Tooltip(el);
    });
</script>
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
