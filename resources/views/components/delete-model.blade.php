@props([
    'href',
    'message' => '',
    'title' => '',
    'target'
])

<div
    class="modal fade"
    id="{{ $target }}"
    tabindex="-1"
    aria-labelledby="{{ $target }}Label"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-warning shadow-sm">
            <div class="modal-header bg-warning text-dark border-warning border-bottom-0 pt-3 pb-2">
                <h5 class="modal-title d-flex align-items-center fw-semibold">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    {{ $title }}
                </h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body pt-2 pb-3 px-4">
                <p class="text-muted mb-0">
                    {{ $message }}
                </p>
            </div>
            <div class="modal-footer border-warning border-top-0 pt-2 pb-3 px-4 gap-2">
                <a
                    href="{{ $href }}"
                    class="btn btn-warning px-4 rounded-pill text-white"
                >
                    OUI
                </a>
                <button
                    type="button"
                    class="btn btn-outline-secondary px-4 rounded-pill"
                    data-bs-dismiss="modal"
                >
                    NON
                </button>
            </div>
        </div>
    </div>
</div>
