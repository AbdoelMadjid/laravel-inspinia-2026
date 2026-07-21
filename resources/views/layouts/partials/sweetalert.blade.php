<!-- SweetAlert2 Plugin Assets -->
<link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

<style>
    /* Standardized & compact SweetAlert font sizes for Inspinia UI */
    .swal2-popup {
        font-size: 0.85rem !important;
        border-radius: 0.5rem !important;
    }

    /* Top-Right Toast Notifications - Compact 13px text size */
    .swal2-container.swal2-top-end .swal2-toast,
    .swal2-container.swal2-top-right .swal2-toast,
    .swal2-popup.swal2-toast,
    .swal2-toast-small {
        font-size: 0.8125rem !important; /* 13px */
        padding: 0.45rem 0.75rem !important;
        align-items: center !important;
        border-radius: 0.375rem !important;
        box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.1) !important;
    }

    .swal2-popup.swal2-toast .swal2-title,
    .swal2-toast-title-small {
        font-size: 0.8125rem !important; /* 13px */
        font-weight: 500 !important;
        line-height: 1.35 !important;
        color: #212529 !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .swal2-popup.swal2-toast .swal2-html-container {
        font-size: 0.75rem !important;
        margin: 0.15rem 0 0 0 !important;
    }


    /* Fix for SweetAlert2 Toast backdrop and container blur artifacts */
    body.swal2-toast-shown .swal2-container,
    .swal2-container.swal2-top-end,
    .swal2-container.swal2-top-right {
        background: transparent !important;
        backdrop-filter: none !important;
        -webkit-backdrop-filter: none !important;
        height: auto !important;
        max-height: 100vh !important;
        pointer-events: none !important;
    }

    .swal2-popup.swal2-toast {
        pointer-events: auto !important;
    }

    /* Centered Modals Font Styling */
    .swal2-popup .swal2-title {
        font-size: 1.1rem !important;
        font-weight: 600 !important;
    }

    .swal2-popup .swal2-html-container,
    .swal2-popup .swal2-content {
        font-size: 0.85rem !important;
        margin-top: 0.5rem !important;
    }

    .swal2-popup .swal2-actions {
        margin-top: 1rem !important;
    }

    .swal2-styled {
        font-size: 0.8125rem !important;
        padding: 0.375rem 0.85rem !important;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Configure Swal Toast Mixin with compact design and no backdrop
        const SwalToast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3500,
            timerProgressBar: true,
            backdrop: false,
            customClass: {
                popup: 'swal2-toast-small',
                title: 'swal2-toast-title-small'
            },
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });

        @if(session('success'))
            SwalToast.fire({
                icon: 'success',
                title: @json(session('success'))
            });
        @endif

        @if(session('error'))
            SwalToast.fire({
                icon: 'error',
                title: @json(session('error'))
            });
        @endif

        @if(session('warning'))
            SwalToast.fire({
                icon: 'warning',
                title: @json(session('warning'))
            });
        @endif

        @if(session('info'))
            SwalToast.fire({
                icon: 'info',
                title: @json(session('info'))
            });
        @endif

        // Global Event listener for elements with data-swal-confirm
        document.addEventListener('click', function (e) {
            const btn = e.target.closest('[data-swal-confirm]');
            if (btn) {
                e.preventDefault();
                const title = btn.getAttribute('data-swal-title') || 'Apakah Anda yakin?';
                const text = btn.getAttribute('data-swal-text') || 'Tindakan ini tidak dapat dibatalkan!';
                const icon = btn.getAttribute('data-swal-icon') || 'warning';
                const confirmButtonText = btn.getAttribute('data-swal-confirm-text') || 'Ya, Lanjutkan!';

                Swal.fire({
                    title: title,
                    text: text,
                    icon: icon,
                    showCancelButton: true,
                    confirmButtonText: confirmButtonText,
                    cancelButtonText: 'Batal',
                    customClass: {
                        confirmButton: 'btn btn-danger btn-sm me-2',
                        cancelButton: 'btn btn-light btn-sm'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        const formId = btn.getAttribute('data-form-id');
                        if (formId) {
                            const targetForm = document.getElementById(formId);
                            if (targetForm) targetForm.submit();
                        } else if (btn.closest('form')) {
                            btn.closest('form').submit();
                        } else if (btn.tagName === 'A' && btn.href && btn.href !== '#' && !btn.href.startsWith('javascript:')) {
                            window.location.href = btn.href;
                        }
                    }
                });
            }
        });
    });
</script>
