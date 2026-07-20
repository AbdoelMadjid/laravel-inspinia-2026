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
        <div class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between py-3">
            <h5 class="card-title mb-0">
                <i class="ti ti-database-export me-2 text-primary"></i> Database Backup Files
            </h5>
            <form method="POST" action="{{ route('admin.backups.store') }}" class="m-0">
                @csrf
                <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-1" onclick="return confirm('Are you sure you want to generate a new database backup?')">
                    <i class="ti ti-plus fs-18"></i>
                    <span>Create Backup Now</span>
                </button>
            </form>
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
                                    <small>Click "Create Backup Now" above to generate your first backup.</small>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
