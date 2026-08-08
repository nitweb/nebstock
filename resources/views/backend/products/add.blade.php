@extends('admin.dashboard')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Add New Product</h4>
                        <div class="page-title-right">
                            <a href="{{ route('backend.products.list') }}" class="btn btn-sm btn-outline-primary">
                                <i class="bx bx-list-ul font-size-16 align-middle me-2"></i> Product List
                            </a>
                            <a href="javascript:history.back()" class="btn btn-sm btn-outline-dark">
                                <i class="bx bx-undo font-size-16 align-middle me-2"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            @include('widgets.errors')

            <form action="{{ route('backend.products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
                @csrf
                <div class="row g-4">

                    {{-- ══ LEFT ══ --}}
                    <div class="col-lg-8">

                        {{-- Basic Info --}}
                        <div class="card">
                            <div class="card-header fw-semibold">Basic Information</div>
                            <div class="card-body row g-3">
                                <div class="col-12">
                                    <label class="form-label">Product Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="book_name" class="form-control" value="{{ old('name') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Product Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-select" required>
                                        <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Cover Image --}}
                        <div class="card mt-3">
                            <div class="card-header fw-semibold">Cover / Main Image <span class="text-danger">*</span></div>
                            <div class="card-body">
                                <input type="file" name="cover_image" id="cover_image_input" class="form-control mb-2" accept="image/*" required>
                                <img id="coverPreview" src="{{ asset('upload/no_image.jpg') }}" class="img-fluid rounded border" style="max-height:250px;object-fit:cover;">
                            </div>
                        </div>

                        {{-- Downloadable File --}}
                        <div class="card mt-3">
                            <div class="card-header fw-semibold">Product File <span class="text-danger">*</span></div>
                            <div class="card-body">
                                <input type="file" name="file" id="product_file_input" class="form-control" required>
                                <small class="text-muted d-block mt-2">Any format. This is the file the customer downloads after payment.</small>
                                <div id="fileNamePreview" class="mt-2 small fw-semibold text-success"></div>
                            </div>
                        </div>

                    </div>{{-- /col-lg-8 --}}

                    {{-- ══ RIGHT ══ --}}
                    <div class="col-lg-4">

                        {{-- Categories (recursive tree render) --}}
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span class="fw-semibold">Category / Sub-category <span class="text-danger">*</span></span>
                                <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                                    <i class="bx bx-plus"></i> Quick Add
                                </button>
                            </div>
                            <div class="card-body" id="categoryCheckboxes" style="max-height:300px;overflow-y:auto;">
                                @include('backend.products.partials.category_tree', ['categories' => $categories, 'depth' => 0, 'selectedCats' => old('category_ids', [])])
                            </div>
                        </div>

                    </div>{{-- /col-lg-4 --}}
                </div>{{-- /row --}}

                <div class="row mt-3 mb-5">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary px-5">
                            <i class="bx bx-save me-1"></i> Save Product
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>

    {{-- Quick Add Category Modal --}}
    @include('backend.products.partials.modal_category')

    <script>
        $(document).ready(function() {

            function makeSlug(str) {
                return str.toLowerCase().trim()
                    .replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-');
            }

            function showAlert(id, type, msg) {
                $(`#${id}`).html(`<div class="alert alert-${type} alert-dismissible fade show py-2 mb-3">${msg}<button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button></div>`);
            }

            // ── Cover Image Preview ───────────────────────────────────────────────
            $('#cover_image_input').on('change', function() {
                const reader = new FileReader();
                reader.onload = e => $('#coverPreview').attr('src', e.target.result);
                reader.readAsDataURL(this.files[0]);
            });

            // ── File Name Preview ─────────────────────────────────────────────────
            $('#product_file_input').on('change', function() {
                const f = this.files[0];
                $('#fileNamePreview').text(f ? ('Selected: ' + f.name) : '');
            });

            // ── Category Quick Add Modal ──────────────────────────────────────────
            $('#modal_cat_image').on('change', function() {
                const reader = new FileReader();
                reader.onload = e => $('#modalCatImgPreview').attr('src', e.target.result);
                reader.readAsDataURL(this.files[0]);
            });
            $('#modal_cat_name').on('keyup', function() {
                $('#modal_cat_slug').val(makeSlug($(this).val()));
            });
            $('#addCategoryModal').on('hidden.bs.modal', function() {
                $('#modal_cat_name, #modal_cat_slug').val('');
                $('#modal_cat_parent').val('');
                $('#modal_cat_image').val('');
                $('#modalCatImgPreview').attr('src', "{{ asset('upload/no_image.jpg') }}");
                $('#catModalAlert').html('');
            });
            $('#saveCategoryBtn').on('click', function() {
                const name = $('#modal_cat_name').val().trim();
                const slug = $('#modal_cat_slug').val().trim();
                if (!name || !slug) {
                    showAlert('catModalAlert', 'warning', 'Name and Slug are required.');
                    return;
                }
                const fd = new FormData();
                fd.append('_token', '{{ csrf_token() }}');
                fd.append('name', name);
                fd.append('slug', slug);
                fd.append('parent_id', $('#modal_cat_parent').val());
                fd.append('status', 'active');
                if ($('#modal_cat_image')[0].files[0]) fd.append('image', $('#modal_cat_image')[0].files[0]);
                $('#catBtnText').addClass('d-none');
                $('#catBtnSpinner').removeClass('d-none');
                $.ajax({
                    url: '{{ route('backend.categories.ajax_store') }}',
                    type: 'POST',
                    data: fd,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        if (res.success) {
                            showAlert('catModalAlert', 'success', `✅ "${res.category.name}" saved!`);
                            $('#categoryCheckboxes').prepend(`<div class="form-check"><input class="form-check-input" type="checkbox" name="category_ids[]" value="${res.category.id}" id="cat_${res.category.id}" checked><label class="form-check-label fw-semibold" for="cat_${res.category.id}">${res.category.name}</label></div>`);
                            $('#modal_cat_name, #modal_cat_slug').val('');
                            $('#modal_cat_image').val('');
                            $('#modalCatImgPreview').attr('src', "{{ asset('upload/no_image.jpg') }}");
                        } else {
                            showAlert('catModalAlert', 'danger', res.message ?? 'Failed.');
                        }
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON?.errors;
                        showAlert('catModalAlert', 'danger', errors ? Object.values(errors).map(e => e[0]).join('<br>') : 'Error.');
                    },
                    complete: function() {
                        $('#catBtnText').removeClass('d-none');
                        $('#catBtnSpinner').addClass('d-none');
                    }
                });
            });

        });
    </script>
    @include('admin.layout.custom_scripts')
@endsection
