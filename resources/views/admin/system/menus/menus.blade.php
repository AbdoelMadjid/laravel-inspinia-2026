@extends('layouts.app')

@section('title', 'Menu Management | INSPINIA')
@section('title_lang', 'title-menu-management')

@push('styles')
    <link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/datatables/responsive.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-title-head d-flex align-items-center">
        <div class="flex-grow-1">
            <h4 class="page-main-title m-0" data-lang="menu-management">Menu Management</h4>
        </div>
        <div class="text-end">
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="javascript: void(0);" data-lang="apps-management">Apps Management</a></li>
                <li class="breadcrumb-item active" data-lang="menu-management">Menu Management</li>
            </ol>
        </div>
    </div>


    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light d-flex align-items-center justify-content-between py-2">
                    <h5 class="card-title mb-0"><i class="ti ti-sitemap me-2"></i>Database Menus &amp; Spatie Role Access</h5>
                    <div>
                        <button class="btn btn-soft-info btn-sm me-2" data-bs-toggle="modal" data-bs-target="#menuGuideModal">
                            <i class="ti ti-help-circle fs-16 me-1"></i> Petunjuk Pembuatan Menu
                        </button>
                        <button class="btn btn-outline-primary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#createGroupModal">
                            <i class="ti ti-folder-plus me-1"></i> Tambah Group (Header)
                        </button>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createMenuModal">
                            <i class="ti ti-plus me-1"></i> Tambah Menu / Submenu
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="menuTable" class="table table-hover align-middle w-100">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;">Icon</th>
                                    <th>Menu Name</th>
                                    <th>Type</th>
                                    <th>Route / URL</th>
                                    <th>Spatie Roles</th>
                                    <th>Permission</th>
                                    <th>Order</th>
                                    <th>Status</th>
                                    <th class="text-end" style="min-width: 120px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($menus as $menu)
                                    @include('admin.system.menus.partials.menu-row', ['menu' => $menu, 'level' => 0])
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Petunjuk Pembuatan Menu -->
<div class="modal fade" id="menuGuideModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title text-white"><i class="ti ti-help-circle me-1"></i> Petunjuk Pembuatan &amp; Pengaturan Menu Sidebar</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-4">
                    <!-- Step 1 -->
                    <div class="col-md-6">
                        <div class="card h-100 border bg-light-subtle">
                            <div class="card-body">
                                <h6 class="fw-bold text-primary mb-2"><i class="ti ti-folders me-1"></i> 1. Jenis &amp; Level Menu</h6>
                                <ul class="mb-0 ps-3 fs-13 text-muted">
                                    <li class="mb-2"><strong>Group (Header):</strong> Digunakan sebagai judul kelompok menu di sidebar (misal: <em>System Management</em>, <em>Users Management</em>).</li>
                                    <li class="mb-2"><strong>Menu Utama (Root):</strong> Menu tingkat atas tanpa parent. Bisa berupa link langsung atau kontainer dropdown.</li>
                                    <li><strong>Submenu (Child):</strong> Menu turunan di dalam Parent Menu (pilih <em>Parent Menu</em> saat menambahkan).</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="col-md-6">
                        <div class="card h-100 border bg-light-subtle">
                            <div class="card-body">
                                <h6 class="fw-bold text-warning mb-2"><i class="ti ti-shield-lock me-1"></i> 2. Hak Akses (Role &amp; Permission)</h6>
                                <ul class="mb-0 ps-3 fs-13 text-muted">
                                    <li class="mb-2"><strong>Role Spatie (Wajib):</strong> Centang role (misal <code>admin</code>) agar user dengan role tersebut bisa melihat menu di sidebar.</li>
                                    <li><strong>Permission Requirement:</strong> Jika diisi (contoh: <code>manage-users</code>), sistem akan otomatis membuat permission tersebut dan memberikannya ke role <code>admin</code> agar menu langsung tampil.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="col-md-6">
                        <div class="card h-100 border bg-light-subtle">
                            <div class="card-body">
                                <h6 class="fw-bold text-success mb-2"><i class="ti ti-sort-ascending-numbers me-1"></i> 3. Urutan Tampilan (Sort Order)</h6>
                                <p class="fs-13 text-muted mb-0">
                                    Setiap menu diurutkan berdasarkan angka <code>sort_order</code>. Jika kolom urutan dikosongkan atau diisi <code>0</code>, sistem akan otomatis menentukan urutan terakhir (<em>auto-increment</em>).
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="col-md-6">
                        <div class="card h-100 border bg-light-subtle">
                            <div class="card-body">
                                <h6 class="fw-bold text-danger mb-2"><i class="ti ti-alert-circle me-1"></i> 4. Troubleshooting Menu Tidak Tampil</h6>
                                <p class="fs-13 text-muted mb-0">
                                    Jika menu baru tidak muncul di sidebar:
                                    <br>1. Pastikan status menu <strong>Active</strong>.
                                    <br>2. Pastikan role akun Anda (misal <code>admin</code>) di-centang pada menu tersebut.
                                    <br>3. Jika menggunakan Permission, pastikan Permission di-assign ke Role Anda di menu <em>Users Management &rarr; Permissions</em>.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light py-2">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup Petunjuk</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Create Group (Header) -->
<div class="modal fade" id="createGroupModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.menus.store') }}" method="POST" class="modal-content">
            @csrf
            <input type="hidden" name="type" value="header">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white"><i class="ti ti-folder-plus me-1"></i> Tambah Group Menu Baru (Header)</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label fw-bold">Nama Group / Section Header</label>
                        <input type="text" name="name" class="form-control" required placeholder="Contoh: Academic Management">
                        <small class="text-muted">Header akan muncul sebagai judul kelompok menu di sidebar.</small>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">Urutan (Sort Order)</label>
                        <input type="number" name="sort_order" class="form-control" placeholder="Kosongkan untuk otomatis urutan terakhir">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">Hak Akses Role Spatie</label>
                        <div class="d-flex flex-wrap gap-3">
                            @foreach ($roles as $role)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}" id="group_role_{{ $role->id }}" checked>
                                    <label class="form-check-label" for="group_role_{{ $role->id }}">
                                        <span class="badge bg-info text-dark">{{ $role->name }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active_group" checked>
                            <label class="form-check-label fw-bold" for="is_active_group">Aktifkan Group</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Group Menu</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Create Menu -->
<div class="modal fade" id="createMenuModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('admin.menus.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title"><i class="ti ti-plus me-1"></i> Add New Menu Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Menu Name</label>
                        <input type="text" name="name" class="form-control" required placeholder="e.g. Dashboard">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Parent Menu (Optional)</label>
                        <select name="parent_id" class="form-select">
                            <option value="">-- Top Level / Root --</option>
                            @foreach ($allMenus as $parent)
                                <option value="{{ $parent->id }}">{{ $parent->name }} ({{ $parent->type }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Menu Type</label>
                        <select name="type" class="form-select" required>
                            <option value="item" selected>Item / Link</option>
                            <option value="header">Section Header</option>
                            <option value="divider">Divider</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Icon (Tabler Icon class)</label>
                        <input type="text" name="icon" class="form-control" placeholder="ti ti-dashboard">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control" value="0">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Route Name</label>
                        <input type="text" name="route_name" class="form-control" placeholder="e.g. dashboard or page">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Custom URL</label>
                        <input type="text" name="url" class="form-control" placeholder="e.g. /custom-url or #">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Badge Text</label>
                        <input type="text" name="badge_text" class="form-control" placeholder="e.g. New or Hot">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Badge CSS Class</label>
                        <input type="text" name="badge_class" class="form-control" placeholder="badge bg-danger text-white float-end">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Spatie Permission Requirement</label>
                        <select name="permission_name" class="form-select">
                            <option value="">-- No Permission Required --</option>
                            @foreach ($permissions as $perm)
                                <option value="{{ $perm->name }}">{{ $perm->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Data Lang (Multi-language Key)</label>
                        <input type="text" name="data_lang" class="form-control" placeholder="e.g. dashboard">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">Assign Spatie Roles Access</label>
                        <div class="d-flex flex-wrap gap-3">
                            @foreach ($roles as $role)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}" id="role_{{ $role->id }}" checked>
                                    <label class="form-check-label" for="role_{{ $role->id }}">
                                        <span class="badge bg-info text-dark">{{ $role->name }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active_new" checked>
                            <label class="form-check-label fw-bold" for="is_active_new">Active Menu</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Menu Item</button>
            </div>
        </form>
    </div>
</div>

<!-- Modals for Editing Menus -->
@foreach ($allMenus as $menuItem)
    @include('admin.system.menus.partials.edit-modal', ['menu' => $menuItem])
@endforeach

@endsection

@push('scripts')
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/responsive.bootstrap5.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
    <script>
        $(document).ready(function() {
            if (!$.fn.DataTable.isDataTable('#menuTable')) {
                $('#menuTable').DataTable({
                    "pageLength": 100,
                    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
                    "ordering": false,
                    "responsive": true,
                    "columnDefs": [
                        { "searchable": false, "orderable": false, "targets": 8 }
                    ],
                    "language": {
                        "search": "Cari Menu:",
                        "lengthMenu": "Tampilkan _MENU_ baris",
                        "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ menu",
                        "infoEmpty": "Menampilkan 0 sampai 0 dari 0 menu",
                        "infoFiltered": "(disaring dari _MAX_ total menu)",
                        "zeroRecords": "Tidak ada menu yang sesuai",
                        "paginate": {
                            "first": '<i class="ti ti-chevrons-left"></i>',
                            "last": '<i class="ti ti-chevrons-right"></i>',
                            "next": '<i class="ti ti-chevron-right"></i>',
                            "previous": '<i class="ti ti-chevron-left"></i>'
                        }
                    }
                });
            }

            // Drag and Drop Sortable Rows
            var tbody = document.querySelector('#menuTable tbody');
            if (tbody) {
                new Sortable(tbody, {
                    handle: '.drag-handle',
                    animation: 150,
                    ghostClass: 'table-active',
                    onEnd: function(evt) {
                        var orders = [];
                        var parentCounters = {};

                        $('#menuTable tbody tr[data-id]').each(function() {
                            var id = $(this).data('id');
                            var parentId = $(this).attr('data-parent-id') || 'root';

                            if (!parentCounters[parentId]) {
                                parentCounters[parentId] = 1;
                            } else {
                                parentCounters[parentId]++;
                            }

                            if (id) {
                                orders.push({
                                    id: id,
                                    sort_order: parentCounters[parentId]
                                });
                            }
                        });

                        if (orders.length > 0) {
                            $.ajax({
                                url: "{{ route('admin.menus.reorder') }}",
                                method: 'POST',
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    orders: orders
                                },
                                success: function(response) {
                                    if (typeof Swal !== 'undefined') {
                                        const Toast = Swal.mixin({
                                            toast: true,
                                            position: 'top-end',
                                            showConfirmButton: false,
                                            timer: 1500,
                                            timerProgressBar: true
                                        });
                                        Toast.fire({
                                            icon: 'success',
                                            title: response.message || 'Urutan menu berhasil diperbarui!'
                                        });
                                    }
                                    setTimeout(function() {
                                        window.location.reload();
                                    }, 800);
                                },
                                error: function(xhr) {
                                    if (typeof Swal !== 'undefined') {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Gagal Menyimpan Urutan',
                                            text: 'Terjadi kesalahan saat memperbarui urutan menu.'
                                        });
                                    }
                                }
                            });
                        }
                    }
                });
            }
        });
    </script>
@endpush
