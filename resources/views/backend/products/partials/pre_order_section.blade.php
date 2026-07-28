@php
    $isPreOrder = old('is_pre_order', isset($product) ? $product->is_pre_order : false);
    $preOrderDate = old('pre_order_date', isset($product) ? optional($product->pre_order_date)->format('Y-m-d') : '');
    $preOrderNote = old('pre_order_note', isset($product) ? $product->pre_order_note : '');
@endphp

<div class="card mt-3 border-warning" id="preOrderCard">
    <div class="card-header bg-warning bg-opacity-10 d-flex align-items-center justify-content-between">
        <span class="fw-semibold text-warning-emphasis">
            <i class="bx bx-time-five me-1 text-warning"></i> Pre-order Settings
        </span>
        <div class="form-check form-switch mb-0">
            <input class="form-check-input" type="checkbox" name="is_pre_order" value="1" id="is_pre_order" {{ $isPreOrder ? 'checked' : '' }}>
            <label class="form-check-label fw-semibold" for="is_pre_order">
                Enable Pre-order
            </label>
        </div>
    </div>

    {{-- Collapsible body — shown only when pre-order is ON --}}
    <div id="preOrderBody" style="{{ $isPreOrder ? '' : 'display:none;' }}">
        <div class="card-body row g-3">

            {{-- Info alert --}}
            <div class="col-12">
                <div class="alert alert-warning py-2 mb-0 d-flex align-items-start gap-2">
                    <i class="bx bx-info-circle fs-5 mt-1 flex-shrink-0"></i>
                    <div class="small">
                        <strong>Pre-order mode:</strong>
                        Customers can place orders even when stock is zero or the product
                        hasn't been released yet. Fill in the expected shipping date and/or
                        a short note that will be shown on the product page.
                    </div>
                </div>
            </div>

            {{-- Expected shipping / release date --}}
            <div class="col-md-5">
                <label class="form-label" for="pre_order_date">
                    Expected Ship / Release Date
                    <small class="text-muted">(optional)</small>
                </label>
                <input type="date" name="pre_order_date" id="pre_order_date" class="form-control @error('pre_order_date') is-invalid @enderror" value="{{ $preOrderDate }}" min="{{ date('Y-m-d') }}">
                @error('pre_order_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Shown to customers as "Ships by DD Mon YYYY".</small>
            </div>

            {{-- Customer-facing note --}}
            <div class="col-md-7">
                <label class="form-label" for="pre_order_note">
                    Pre-order Note
                    <small class="text-muted">(optional — overrides date label)</small>
                </label>
                <input type="text" name="pre_order_note" id="pre_order_note" class="form-control @error('pre_order_note') is-invalid @enderror" value="{{ $preOrderNote }}" maxlength="500" placeholder="e.g. Ships in 2–3 weeks after release">
                @error('pre_order_note')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Leave blank to auto-generate from date above.</small>
            </div>

            {{-- Live preview --}}
            <div class="col-12" id="preOrderPreviewWrap">
                <label class="form-label text-muted small mb-1">Preview badge:</label>
                <div>
                    <span class="badge bg-warning text-dark fs-6 px-3 py-2" id="preOrderPreviewBadge">
                        <i class="bx bx-time-five me-1"></i>
                        <span id="preOrderPreviewText">Available for Pre-order</span>
                    </span>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ── Inline JS (safe to include multiple times — guarded by flag) ──────── --}}
<script>
    (function() {
        if (window.__preOrderScriptLoaded) return;
        window.__preOrderScriptLoaded = true;

        document.addEventListener('DOMContentLoaded', function() {

            var toggle = document.getElementById('is_pre_order');
            var body = document.getElementById('preOrderBody');
            var dateInput = document.getElementById('pre_order_date');
            var noteInput = document.getElementById('pre_order_note');
            var previewTxt = document.getElementById('preOrderPreviewText');

            if (!toggle) return;

            // Show / hide body on toggle
            toggle.addEventListener('change', function() {
                body.style.display = this.checked ? '' : 'none';
            });

            // Live-update badge preview
            function updatePreview() {
                var note = noteInput ? noteInput.value.trim() : '';
                var date = dateInput ? dateInput.value : '';

                if (note) {
                    previewTxt.textContent = note;
                } else if (date) {
                    var d = new Date(date);
                    var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                    var label = 'Ships by ' + d.getDate() + ' ' + months[d.getMonth()] + ' ' + d.getFullYear();
                    previewTxt.textContent = 'Pre-order — ' + label;
                } else {
                    previewTxt.textContent = 'Available for Pre-order';
                }
            }

            if (noteInput) noteInput.addEventListener('input', updatePreview);
            if (dateInput) dateInput.addEventListener('change', updatePreview);

            // Run once on load to show saved values
            updatePreview();
        });
    })();
</script>
