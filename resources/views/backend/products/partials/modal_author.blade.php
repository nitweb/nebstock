<div class="modal fade" id="addAuthorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bx bx-user-plus me-1"></i> Quick Add Author</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="authorModalAlert"></div>
                <div class="mb-3">
                    <label class="form-label">Photo <small class="text-muted">[440×440px]</small></label>
                    <input type="file" id="modal_author_image" class="form-control" accept="image/*">
                    <img id="modalAuthorImgPreview" src="{{ asset('upload/no_image.jpg') }}" class="mt-2 rounded-circle border" style="width:80px;height:80px;object-fit:cover;">
                </div>
                <div class="mb-3">
                    <label class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" id="modal_author_name" class="form-control" placeholder="e.g. Humayun Ahmed">
                </div>
                <div class="mb-3">
                    <label class="form-label">Slug <span class="text-danger">*</span></label>
                    <input type="text" id="modal_author_slug" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea id="modal_author_desc" class="form-control" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-sm btn-success" id="saveAuthorBtn">
                    <span id="authorBtnText"><i class="bx bx-save me-1"></i> Save</span>
                    <span id="authorBtnSpinner" class="spinner-border spinner-border-sm d-none"></span>
                </button>
            </div>
        </div>
    </div>
</div>
