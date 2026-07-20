@extends('layouts.app')

@section('title', 'Backup Database | INSPINIA')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-title-head d-flex align-items-center">
        <div class="flex-grow-1">
            <h4 class="page-main-title m-0">Backup Database</h4>
        </div>
        <div class="text-end">
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inspinia</a></li>
                <li class="breadcrumb-item"><a href="javascript: void(0);">Apps Management</a></li>
                <li class="breadcrumb-item active">Backup Database</li>
            </ol>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ti ti-circle-check me-1 fs-18 align-middle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="ti ti-alert-triangle me-1 fs-18 align-middle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Quick Stats Widgets -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 mb-3 mb-md-0">
                <div class="card-body d-flex align-items-center">
                    <div class="avatar-md bg-primary-subtle text-primary rounded me-3 d-flex align-items-center justify-content-center">
                        <i class="ti ti-database fs-24"></i>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase fw-semibold fs-12 mb-1">Total Backups</h6>
                        <h3 class="mb-0 fw-bold">{{ $stats['total_count'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 mb-3 mb-md-0">
                <div class="card-body d-flex align-items-center">
                    <div class="avatar-md bg-success-subtle text-success rounded me-3 d-flex align-items-center justify-content-center">
                        <i class="ti ti-file-symlink fs-24"></i>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase fw-semibold fs-12 mb-1">Total Size</h6>
                        <h3 class="mb-0 fw-bold">{{ $stats['total_size'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex align-items-center">
                    <div class="avatar-md bg-info-subtle text-info rounded me-3 d-flex align-items-center justify-content-center">
                        <i class="ti ti-clock-hour-4 fs-24"></i>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase fw-semibold fs-12 mb-1">Latest Backup</h6>
                        <h3 class="mb-0 fw-bold fs-20">{{ $stats['latest_backup'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions & Backup List Table -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between py-3 flex-wrap gap-2">
            <h5 class="card-title mb-0">
                <i class="ti ti-database-export me-2 text-primary"></i> Database Backup Files
            </h5>
            <div class="d-flex align-items-center gap-2">
                <!-- Backup Specific Tables Button -->
                <button type="button" class="btn btn-outline-primary d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#customTableBackupModal">
                    <i class="ti ti-list-check fs-18"></i>
                    <span>Backup Selected Tables</span>
                </button>

                <!-- Full Backup Form -->
                <form method="POST" action="{{ route('admin.backups.store') }}" class="m-0">
                    @csrf
                    <input type="hidden" name="backup_type" value="all">
                    <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-1" onclick="return confirm('Are you sure you want to generate a full database backup?')">
                        <i class="ti ti-plus fs-18"></i>
                        <span>Create Full Backup</span>
                    </button>
                </form>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px;" class="ps-3">#</th>
                            <th>File Name</th>
                            <th>Size</th>
                            <th>Date Created</th>
                            <th style="width: 160px;" class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($backups as $index => $backup)
                            <tr>
                                <td class="ps-3 text-muted">{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="ti ti-file-type-sql text-primary fs-24 me-2"></i>
                                        <span class="fw-semibold text-dark">{{ $backup['name'] }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border px-2 py-1 fs-12 fw-medium">{{ $backup['size'] }}</span>
                                </td>
                                <td>
                                    <span class="text-muted fs-13">
                                        <i class="ti ti-calendar me-1"></i>{{ $backup['created_at']->format('M d, Y - H:i:s') }}
                                        <small class="text-secondary ms-1">({{ $backup['created_at']->diffForHumans() }})</small>
                                    </span>
                                </td>
                                <td class="text-end pe-3">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.backups.download', $backup['name']) }}" class="btn btn-sm btn-outline-primary" title="Download Backup">
                                            <i class="ti ti-download"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" title="Delete Backup" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $index }}">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $index }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Confirm Delete</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-start">
                                                    Are you sure you want to delete the backup file <strong class="text-danger">{{ $backup['name'] }}</strong>?
                                                    This action cannot be undone.
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                    <form method="POST" action="{{ route('admin.backups.destroy', $backup['name']) }}" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Delete Backup</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="ti ti-database-off fs-48 text-secondary mb-2 d-block"></i>
                                    <p class="mb-1 fw-medium">No database backups found.</p>
                                    <small>Click "Create Full Backup" or "Backup Selected Tables" above to generate your first backup.</small>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Select Tables for Custom Backup -->
<div class="modal fade" id="customTableBackupModal" tabindex="-1" aria-labelledby="customTableBackupModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.backups.store') }}">
                @csrf
                <input type="hidden" name="backup_type" value="partial">
                <div class="modal-header">
                    <h5 class="modal-title" id="customTableBackupModalLabel">
                        <i class="ti ti-table me-2 text-primary"></i>Select Database Tables to Backup
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted fs-13 mb-3">
                        Choose the specific tables you want to include in this backup file. The generated SQL file will include the structure and data for the selected tables only.
                    </p>

                    <div class="d-flex align-items-center justify-content-between mb-3 bg-light p-2 rounded border">
                        <div class="form-check m-0">
                            <input class="form-check-input" type="checkbox" id="selectAllTables">
                            <label class="form-check-label fw-semibold text-dark user-select-none" for="selectAllTables">
                                Select / Deselect All Tables
                            </label>
                        </div>
                        <span class="badge bg-primary-subtle text-primary fs-12 fw-medium" id="selectedTableCount">0 selected</span>
                    </div>

                    <div class="table-responsive" style="max-height: 350px; overflow-y: auto;">
                        <table class="table table-sm table-hover align-middle border mb-0">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th style="width: 40px;" class="text-center">#</th>
                                    <th>Table Name</th>
                                    <th class="text-end">Estimated Rows</th>
                                    <th class="text-end pe-3">Size</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tables as $table)
                                    <tr>
                                        <td class="text-center">
                                            <input class="form-check-input table-checkbox" type="checkbox" name="tables[]" value="{{ $table['name'] }}" id="table_{{ $table['name'] }}">
                                        </td>
                                        <td>
                                            <label for="table_{{ $table['name'] }}" class="fw-semibold text-dark m-0 cursor-pointer user-select-none">
                                                <i class="ti ti-table-alias me-1 text-secondary"></i> {{ $table['name'] }}
                                            </label>
                                        </td>
                                        <td class="text-end text-muted fs-13">
                                            {{ number_format($table['rows']) }}
                                        </td>
                                        <td class="text-end text-muted fs-13 pe-3">
                                            {{ $table['size'] }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-1" id="submitPartialBackupBtn">
                        <i class="ti ti-download fs-18"></i>
                        <span>Generate Partial Backup</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAllCheckbox = document.getElementById('selectAllTables');
        const tableCheckboxes = document.querySelectorAll('.table-checkbox');
        const selectedCountBadge = document.getElementById('selectedTableCount');

        function updateCount() {
            const checkedCount = document.querySelectorAll('.table-checkbox:checked').length;
            if (selectedCountBadge) {
                selectedCountBadge.textContent = checkedCount + ' selected';
            }
            if (selectAllCheckbox) {
                selectAllCheckbox.checked = checkedCount > 0 && checkedCount === tableCheckboxes.length;
                selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < tableCheckboxes.length;
            }
        }

        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function () {
                tableCheckboxes.forEach(cb => cb.checked = selectAllCheckbox.checked);
                updateCount();
            });
        }

        tableCheckboxes.forEach(cb => {
            cb.addEventListener('change', updateCount);
        });

        // Initialize initial count
        updateCount();
    });
</script>
@endpush
@endsection
