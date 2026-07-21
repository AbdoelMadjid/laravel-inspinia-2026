<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Pengguna - Inspinia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 12px; color: #333; }
        .table th { background-color: #4F46E5 !important; color: white !important; font-weight: 600; text-align: center; }
        @media print {
            .no-print { display: none !important; }
            body { padding: 0; margin: 0; }
        }
    </style>
</head>
<body class="p-4 bg-white">
    <div class="no-print mb-4 d-flex justify-content-between align-items-center bg-light p-3 rounded border">
        <div>
            <h5 class="m-0 fw-bold"><i class="ti ti-printer text-primary me-1"></i> Cetak / Simpan PDF Laporan Data Pengguna</h5>
            <small class="text-muted">Gunakan tombol Cetak di sebelah kanan atau tekan <code>Ctrl + P</code> untuk menyimpan sebagai berkas PDF.</small>
        </div>
        <button onclick="window.print()" class="btn btn-primary fw-bold">
            Cetak PDF / Print
        </button>
    </div>

    <!-- Header Report -->
    <div class="border-bottom pb-3 mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bold mb-1 text-primary">REKAP DATA PENGGUNA SISTEM</h3>
            <p class="mb-0 text-muted">Aplikasi Inspinia Enterprise Management System</p>
        </div>
        <div class="text-end fs-xs text-muted">
            <div><strong>Dicetak Pada:</strong> {{ now()->format('d F Y H:i:s') }}</div>
            <div><strong>Total Pengguna:</strong> {{ $users->count() }} Akun</div>
        </div>
    </div>

    <!-- User Table -->
    <table class="table table-bordered table-striped align-middle">
        <thead>
            <tr>
                <th style="width: 40px;">No</th>
                <th>Nama Pengguna</th>
                <th>Email</th>
                <th>Role / Peran</th>
                <th style="width: 110px;">Status Akun</th>
                <th style="width: 80px;">Poin</th>
                <th>Terakhir Aktif</th>
                <th style="width: 130px;">Tgl Bergabung</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $index => $u)
                <tr>
                    <td class="text-center font-monospace">{{ $index + 1 }}</td>
                    <td class="fw-bold">{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                            {{ $u->roles->pluck('name')->map('ucfirst')->join(', ') ?: 'User' }}
                        </span>
                    </td>
                    <td class="text-center">
                        @if($u->is_approved)
                            <span class="badge bg-success-subtle text-success border border-success-subtle">Disetujui</span>
                        @else
                            <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle">Pending</span>
                        @endif
                    </td>
                    <td class="text-center font-monospace">{{ $u->points ?? 0 }}</td>
                    <td class="fs-xs">{{ $u->last_seen_text }}</td>
                    <td class="fs-xs text-center">{{ $u->created_at ? $u->created_at->format('d/m/Y H:i') : '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">Tidak ada data pengguna yang ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4 pt-3 border-top d-flex justify-content-between text-muted fs-xs">
        <div>Dokumen Resmi Sistem Informasi Manajemen Enterprise</div>
        <div>Halaman 1 dari 1</div>
    </div>
</body>
</html>
