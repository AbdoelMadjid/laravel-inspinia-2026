<section>
    <header class="mb-3">
        <h6 class="fs-15 fw-semibold text-danger mb-1">Penghapusan Akun Permanen</h6>
        <p class="text-muted fs-13 mb-0">
            Setelah akun Anda dihapus, semua data dan sumber daya terkait akan dihapus secara permanen. Sebelum menghapus akun Anda, harap simpan atau unduh informasi penting yang Anda perlukan.
        </p>
    </header>

    <div class="mt-3">
        <button type="button" class="btn btn-danger d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
            <i class="ti ti-trash fs-16"></i> Hapus Akun Saya
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
                            <i class="ti ti-alert-triangle fs-20"></i> Konfirmasi Hapus Akun
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body py-4">
                        <p class="fs-14 text-dark fw-medium mb-2">
                            Apakah Anda benar-benar yakin ingin menghapus akun Anda?
                        </p>
                        <p class="fs-13 text-muted mb-4">
                            Tindakan ini permanen dan tidak dapat dibatalkan. Masukkan password Anda untuk mengonfirmasi penghapusan akun.
                        </p>

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
                            <i class="ti ti-trash fs-16"></i> Ya, Hapus Akun
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
</section>
