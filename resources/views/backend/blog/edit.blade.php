@extends('admin.dashboard')
@section('admin')
    <div class="page-content">

        <div class="container-fluid">

            {{-- Breadcrumb  --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Blog Edit</h4>
                        <div class="page-title-right">
                            <a href="{{ route('backend.blog.list') }}" class="btn btn-sm btn-outline-primary waves-effect waves-light">
                                <i class="bx bx-list-ul font-size-16 align-middle me-2"></i> Blog List
                            </a>
                            <a href="javascript:history.back()" class="btn btn-sm btn-outline-dark waves-effect waves-light">
                                <i class="bx bx-undo font-size-16 align-middle me-2"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Custom Form --}}
            <div class="row">

                <div class="col-12">

                    <div class="card">

                        <div class="card-body p-4">

                            @include('widgets.errors')

                            <form class="row g-3" action="{{ route('backend.blog.update') }}" method="post" enctype="multipart/form-data">

                                @csrf

                                <input type="hidden" name="id" value="{{ $blog_info->id }}">

                                <div class="col-md-8">
                                    <label for="example-text-input" class="form-label">Image [830px by 553px]</label>
                                    <input type="file" class="form-control" name="blog_image" id="image">
                                    <img id="showImage" src="{{ !empty($blog_info->blog_image) ? url('upload/blog_image/' . $blog_info->blog_image) : url('upload/no_image.jpg') }}" alt="Blog Image" class="p-1 bg-primary mt-3" style="width: 110px; height: 110px; object-fit: cover; border-radius: 8px;">
                                </div>

                                <div class="col-md-8">
                                    <label for="blog_title" class="form-label">Title</label>
                                    <input type="text" class="form-control" id="blog_title" name="blog_title" value="{{ $blog_info->blog_title }}" required>
                                </div>

                                <div class="col-md-8">
                                    <label for="blog_slug" class="form-label">Blog Slug <span class="text-danger">[except unique slug only]</span></label>
                                    <input type="text" class="form-control" id="blog_slug" name="blog_slug" value="{{ $blog_info->blog_slug }}" required>
                                </div>

                                <div class="col-md-8">
                                    <label for="blog_category_id" class="form-label">Blog Category</label>
                                    <div class="d-flex gap-2 align-items-center">
                                        <div class="flex-grow-1">
                                            <select class="form-select select2-category" id="blog_category_id" name="blog_category_id" required>
                                                <option value="">Select Category</option>
                                                @foreach ($blog_categories as $category)
                                                    <option value="{{ $category->id }}" {{ old('blog_category_id', $blog_info->blog_category_id) == $category->id ? 'selected' : '' }}>
                                                        {{ $category->blog_category_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addCategoryModal" title="Add New Category">
                                            <i class="bx bx-plus font-size-16"></i>
                                        </button>
                                    </div>
                                </div>

                                {{-- <div class="col-md-8">
                                    <label for="blog_short_description" class="form-label">Short Description</label>
                                    <textarea class="form-control" id="blog_short_description" name="blog_short_description" rows="4" required>{{ $blog_info->blog_short_description }}</textarea>
                                </div> --}}

                                <div class="col-8">
                                    <label class="form-label">Long Description</label>
                                    <textarea class="form-control" name="blog_long_description" id="summernote" required>{!! $blog_info->blog_long_description !!}</textarea>
                                </div>

                                <div class="col-md-8">
                                    <label for="blog_tags" class="form-label">Tags <span class="text-muted">(comma separated)</span></label>
                                    <input type="text" class="form-control" id="blog_tags" name="blog_tags" value="{{ $blog_info->blog_tags }}">
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-sm btn-primary">Update Blog</button>
                                </div>

                            </form>

                            {{-- Add Category Modal --}}
                            <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addCategoryModalLabel">
                                                <i class="bx bx-category me-2"></i>Add New Blog Category
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div id="categoryModalAlert" class="d-none"></div>
                                            <div class="mb-3">
                                                <label for="new_category_name" class="form-label">Category Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="new_category_name" placeholder="Enter category name">
                                                <div class="invalid-feedback" id="categoryNameError"></div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="button" class="btn btn-sm btn-primary" id="saveCategoryBtn">
                                                <span id="saveCategoryBtnText">Save Category</span>
                                                <span id="saveCategorySpinner" class="spinner-border spinner-border-sm ms-1 d-none" role="status"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            })
        })
    </script>

    @include('admin.layout.custom_scripts')

    @if (session('message'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @if (session('alert-type') === 'success')
                    toastr.success('{{ session('message') }}');
                @elseif (session('alert-type') === 'error')
                    toastr.error('{{ session('message') }}');
                @else
                    toastr.info('{{ session('message') }}');
                @endif
            });
        </script>
    @endif

    {{-- ✅ Blog Category Select2 + Modal Script --}}
    <script>
        $(document).ready(function() {

            $('.select2-category').select2({
                placeholder: 'Select Category',
                allowClear: true,
                width: '100%',
            });

            $('#addCategoryModal').on('show.bs.modal', function() {
                $('#new_category_name').val('').removeClass('is-invalid');
                $('#categoryNameError').text('');
                $('#categoryModalAlert').addClass('d-none').html('');
            });

            $('#addCategoryModal').on('shown.bs.modal', function() {
                $('#new_category_name').trigger('focus');
            });

            $('#new_category_name').on('keydown', function(e) {
                if (e.key === 'Enter') $('#saveCategoryBtn').trigger('click');
            });

            $('#saveCategoryBtn').on('click', function() {
                const name = $('#new_category_name').val().trim();
                const $btn = $(this);
                const $spinner = $('#saveCategorySpinner');
                const $text = $('#saveCategoryBtnText');

                if (!name) {
                    $('#new_category_name').addClass('is-invalid');
                    $('#categoryNameError').text('Category name is required');
                    return;
                }

                $('#new_category_name').removeClass('is-invalid');
                $btn.prop('disabled', true);
                $spinner.removeClass('d-none');
                $text.text('Saving...');

                $.ajax({
                    url: '{{ route('backend.blog_categories.ajax_store') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        blog_category_name: name,
                    },
                    success: function(res) {
                        if (res.success) {
                            const newOption = new Option(res.category.name, res.category.id, true, true);
                            $('.select2-category').append(newOption).trigger('change');

                            $('#categoryModalAlert')
                                .removeClass('d-none alert-danger')
                                .addClass('alert alert-success')
                                .html('<i class="bx bx-check-circle me-1"></i>' + res.message);

                            setTimeout(function() {
                                $('#addCategoryModal').modal('hide');
                            }, 1500);
                        }
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON?.errors;
                        if (errors?.blog_category_name) {
                            $('#new_category_name').addClass('is-invalid');
                            $('#categoryNameError').text(errors.blog_category_name[0]);
                        } else {
                            $('#categoryModalAlert')
                                .removeClass('d-none alert-success')
                                .addClass('alert alert-danger')
                                .html('<i class="bx bx-x-circle me-1"></i>' + (xhr.responseJSON?.message || 'Something went wrong!'));
                        }
                    },
                    complete: function() {
                        $btn.prop('disabled', false);
                        $spinner.addClass('d-none');
                        $text.text('Save Category');
                    },
                });
            });

        });
    </script>
@endsection
