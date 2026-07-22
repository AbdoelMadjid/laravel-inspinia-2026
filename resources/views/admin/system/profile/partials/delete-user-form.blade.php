<section>
    <header class="mb-3">
        <h6 class="fs-15 fw-semibold text-danger mb-1">Penghapusan Akun (Danger Zone)</h6>
        <p class="text-muted fs-13 mb-0">
            Penghapusan akun memerlukan persetujuan dari Administrator. Setelah disetujui dan dihapus, semua data dan sumber daya terkait akan dihapus secara permanen.
        </p>
    </header>

    @if ($user->hasRequestedDeletion())
        <div class="alert alert-warning border border-warning-subtle rounded-3 p-3 mt-3 mb-0">
            <div class="d-flex align-items-start gap-3">
                <div class="avatar-sm bg-warning-subtle text-warning rounded-circle d-flex align-items-center justify-content-center flex-shrink-0">
                    <i class="ti ti-alert-triangle fs-20"></i>
                </div>
                <div class="flex-grow-1">
                    <h6 class="fs-14 fw-bold text-dark mb-1">Permohonan Penghapusan Akun Sedang Diproses</h6>
                    <p class="fs-13 text-muted mb-2">
                        Anda telah mengajukan permohonan penghapusan akun pada 
                        <strong class="text-dark">{{ $user->deletion_requested_at->format('d M Y, H:i') }}</strong>. 
                        Permohonan Anda saat ini sedang dalam peninjauan oleh Administrator.
                    </p>

                    @if ($user->deletion_reason)
                        <div class="bg-white p-2 rounded border fs-12 text-secondary mb-3">
                            <strong>Alasan Alasan Penghapusan:</strong> {{ $user->deletion_reason }}
                        </div>
                    @endif

                    <form method="post" action="{{ route('profile.cancel-deletion') }}" id="cancelUserDeletionForm">
                        @csrf
                        <button type="button" class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center gap-1"
                            data-swal-confirm="true"
                            data-swal-title="Batalkan Permohonan Hapus Akun?"
                            data-swal-text="Permohonan penghapusan akun Anda akan dibatalkan."
                            data-swal-icon="question"
                            data-swal-confirm-text="Ya, Batalkan Permohonan!"
                            data-form-id="cancelUserDeletionForm">
                            <i class="ti ti-rotate-clockwise fs-15"></i> Batalkan Permohonan Penghapusan Akun
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @else
        <div class="mt-3">
            <button type="button" class="btn btn-danger d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
                <i class="ti ti-trash fs-16"></i> Ajukan Penghapusan Akun
            </button>
        </div>

        <!-- Bootstrap 5 Modal -->
        <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form method="post" action="{{ route('profile.destroy') }}">
                        @csrf
                        @method('delete')

                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title text-white d-flex align-items-center gap-2" id="confirmUserDeletionModalLabel">
                                <i class="ti ti-alert-triangle fs-20"></i> Permohonan Hapus Akun
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body py-4">
                            <p class="fs-14 text-dark fw-medium mb-2">
                                Apakah Anda yakin ingin mengajukan permohonan penghapusan akun Anda?
                            </p>
                            <p class="fs-13 text-muted mb-4">
                                Permohonan Anda akan dikirimkan ke Administrator untuk disetujui sebelum akun dihapus secara permanen. Masukkan password Anda untuk mengonfirmasi permohonan ini.
                            </p>

                            <div class="mb-3">
                                <label for="delete_account_reason" class="form-label fw-semibold">Alasan Penghapusan (Opsional)</label>
                                <textarea id="delete_account_reason" name="reason" class="form-control" rows="2" placeholder="Tuliskan alasan Anda ingin menghapus akun..."></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="delete_account_password" class="form-label fw-semibold">Password Anda <span class="text-danger">*</span></label>
                                <input type="password" id="delete_account_password" name="password" class="form-control @error('password', 'userDeletion') is-invalid @enderror" placeholder="Masukkan password untuk konfirmasi" required />
                                @error('password', 'userDeletion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="modal-footer bg-light-subtle">
                            <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger d-inline-flex align-items-center gap-1">
                                <i class="ti ti-send fs-16"></i> Kirim Permohonan Hapus
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @if($errors->userDeletion->isNotEmpty())
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var deleteModal = new bootstrap.Modal(document.getElementById('confirmUserDeletionModal'));
                    deleteModal.show();
                });
            </script>
        @endif
    @endif
</section>
