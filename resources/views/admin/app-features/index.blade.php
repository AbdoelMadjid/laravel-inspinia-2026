@extends('layouts.app')

@section('title', 'Fitur Apps | INSPINIA')

@push('styles')
    <link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/datatables/responsive.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-title-head d-flex align-items-center">
        <div class="flex-grow-1">
            <h4 class="page-main-title m-0" data-lang="apps-features">Fitur Apps</h4>
        </div>
        <div class="text-end">
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inspinia</a></li>
                <li class="breadcrumb-item"><a href="javascript: void(0);" data-lang="apps-management">Apps Management</a></li>
                <li class="breadcrumb-item active" data-lang="apps-features">Fitur Apps</li>
            </ol>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            <i class="ti ti-check-circle me-1 fs-lg"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light d-flex align-items-center justify-content-between py-2">
                    <h5 class="card-title mb-0">
                        <i class="ti ti-toggle-right me-2 text-primary"></i>Manajemen Fitur &amp; Toggle Aplikasi
                    </h5>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createFeatureModal">
                        <i class="ti ti-plus me-1"></i> Tambah Fitur
                    </button>
                </div>
                <div class="card-body">
                    <p class="text-muted fs-13 mb-3">
                        Kelola dan atur status aktif/non-aktif modul serta fitur tampilan aplikasi (seperti kotak pencarian topbar, mega menu, dropdown apps, ikon profil, pengubah tema, dan menu-menu template/demo).
                    </p>

                    <div class="table-responsive">
                        <table id="featureTable" class="table table-hover align-middle w-100">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 40px;" class="text-center">#</th>
                                    <th style="min-width: 160px;">Nama Fitur</th>
                                    <th style="min-width: 150px;">Key / Code</th>
                                    <th style="width: 110px;" class="text-center">Kategori</th>
                                    <th>Deskripsi</th>
                                    <th style="width: 160px;">Status</th>
                                    <th style="width: 90px;" class="text-end text-nowrap">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($features as $index => $feature)
                                    <tr>
                                        <td class="text-center fw-medium">{{ $index + 1 }}</td>
                                        <td class="fw-semibold text-dark">{{ $feature->name }}</td>
                                        <td>
                                            <code class="px-2 py-1 bg-light text-primary rounded border fs-12">{{ $feature->key }}</code>
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $badgeClass = match($feature->category) {
                                                    'topbar' => 'bg-info-subtle text-info border border-info-subtle',
                                                    'sidebar' => 'bg-primary-subtle text-primary border border-primary-subtle',
                                                    'demo' => 'bg-warning-subtle text-warning border border-warning-subtle',
                                                    default => 'bg-secondary-subtle text-secondary border border-secondary-subtle'
                                                };
                                            @endphp
                                            <span class="badge {{ $badgeClass }} text-uppercase fs-10 px-2 py-1">
                                                {{ $feature->category }}
                                            </span>
                                        </td>
                                        <td class="text-muted fs-13">{{ $feature->description ?? '-' }}</td>
                                        <td>
                                            <form action="{{ route('admin.app-features.toggle-status', $feature->id) }}" method="POST" class="m-0">
                                                @csrf
                                                @method('PATCH')
                                                <div class="form-check form-switch d-flex align-items-center gap-2 m-0">
                                                    <input class="form-check-input cursor-pointer" 
                                                           type="checkbox" 
                                                           role="switch" 
                                                           name="is_active"
                                                           value="1"
                                                           onchange="this.form.submit()"
                                                           id="switch-{{ $feature->id }}"
                                                           {{ $feature->is_active ? 'checked' : '' }}>
                                                    <span class="badge {{ $feature->is_active ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                                                        {{ $feature->is_active ? 'Aktif' : 'Non-Aktif' }}
                                                    </span>
                                                </div>
                                            </form>
                                        </td>
                                        <td class="text-end text-nowrap">
                                            <div class="d-inline-flex align-items-center gap-1">
                                                <button class="btn btn-sm btn-soft-primary" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#editFeatureModal-{{ $feature->id }}"
                                                        title="Edit Fitur">
                                                    <i class="ti ti-pencil"></i>
                                                </button>
                                                <form action="{{ route('admin.app-features.destroy', $feature->id) }}" method="POST" class="d-inline delete-feature-form m-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-soft-danger btn-delete-feature" title="Hapus Fitur">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">Belum ada fitur yang terdaftar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Feature Modals (Rendered outside table for clean HTML structure) -->
@foreach ($features as $feature)
    <div class="modal fade" id="editFeatureModal-{{ $feature->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="ti ti-pencil me-1 text-primary"></i> Edit Fitur - {{ $feature->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.app-features.update', $feature->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label required fw-medium">Nama Fitur</label>
                            <input type="text" name="name" class="form-control" value="{{ $feature->name }}" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label required fw-medium">Key Code</label>
                            <input type="text" name="key" class="form-control" value="{{ $feature->key }}" required />
                            <small class="text-muted">Key unik digunakan dalam koding Blade/PHP.</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-medium">Kategori</label>
                            <select name="category" class="form-select">
                                <option value="topbar" {{ $feature->category == 'topbar' ? 'selected' : '' }}>Topbar</option>
                                <option value="sidebar" {{ $feature->category == 'sidebar' ? 'selected' : '' }}>Sidebar</option>
                                <option value="demo" {{ $feature->category == 'demo' ? 'selected' : '' }}>Demo / Template</option>
                                <option value="general" {{ $feature->category == 'general' ? 'selected' : '' }}>General</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-medium">Deskripsi</label>
                            <textarea name="description" class="form-control" rows="2">{{ $feature->description }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-medium">Urutan (Sort Order)</label>
                            <input type="number" name="sort_order" class="form-control" value="{{ $feature->sort_order }}" />
                        </div>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" name="is_active" id="editActiveStatus-{{ $feature->id }}" {{ $feature->is_active ? 'checked' : '' }}>
                            <label class="form-check-label fw-medium" for="editActiveStatus-{{ $feature->id }}">Status Aktif</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<!-- Create Feature Modal -->
<div class="modal fade" id="createFeatureModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="ti ti-plus me-1 text-primary"></i> Tambah Fitur Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.app-features.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label required fw-medium">Nama Fitur</label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: Topbar Notification" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required fw-medium">Key Code</label>
                        <input type="text" name="key" class="form-control" placeholder="Contoh: topbar_notification" required />
                        <small class="text-muted">Key unik tanpa spasi.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Kategori</label>
                        <select name="category" class="form-select">
                            <option value="topbar">Topbar</option>
                            <option value="sidebar">Sidebar</option>
                            <option value="demo">Demo / Template</option>
                            <option value="general" selected>General</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="Penjelasan singkat mengenai fungsi fitur ini"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Urutan (Sort Order)</label>
                        <input type="number" name="sort_order" class="form-control" value="0" />
                    </div>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" name="is_active" id="createActiveStatus" checked>
                        <label class="form-check-label fw-medium" for="createActiveStatus">Status Aktif</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Fitur</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap5.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    $('#featureTable').DataTable({
        responsive: true,
        ordering: false,
        language: {
            search: "Cari Fitur:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ fitur",
            paginate: {
                first: "Awal",
                last: "Akhir",
                next: "►",
                previous: "◄"
            }
        }
    });

    // Delete Confirmation
    $(document).on('click', '.btn-delete-feature', function(e) {
        e.preventDefault();
        const form = $(this).closest('.delete-feature-form');

        Swal.fire({
            title: 'Hapus Fitur ini?',
            text: 'Fitur yang dihapus tidak dapat dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endpush
