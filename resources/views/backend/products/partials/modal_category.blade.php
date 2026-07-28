<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bx bx-category-alt me-1"></i> Quick Add Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="catModalAlert"></div>
                <div class="mb-3">
                    <label class="form-label">Image <small class="text-muted">[440×440px]</small></label>
                    <input type="file" id="modal_cat_image" class="form-control" accept="image/*">
                    <img id="modalCatImgPreview" src="{{ asset('upload/no_image.jpg') }}" class="mt-2 rounded border" style="width:80px;height:80px;object-fit:cover;">
                </div>
                <div class="mb-3">
                    <label class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" id="modal_cat_name" class="form-control" placeholder="e.g. Fiction">
                </div>
                <div class="mb-3">
                    <label class="form-label">Slug <span class="text-danger">*</span></label>
                    <input type="text" id="modal_cat_slug" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Parent <small class="text-muted">(optional)</small></label>
                    <select id="modal_cat_parent" class="form-select">
                        <option value="">— Root —</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @foreach ($cat->recursiveChildren as $child)
                                <option value="{{ $child->id }}">— {{ $child->name }}</option>
                            @endforeach
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-sm btn-success" id="saveCategoryBtn">
                    <span id="catBtnText"><i class="bx bx-save me-1"></i> Save</span>
                    <span id="catBtnSpinner" class="spinner-border spinner-border-sm d-none"></span>
                </button>
            </div>
        </div>
    </div>
</div>
