@extends('admin.dashboard')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Add Author</h4>
                        <div class="page-title-right">
                            <a href="{{ route('backend.authors.list') }}" class="btn btn-sm btn-outline-primary waves-effect waves-light">
                                <i class="bx bx-list-ul font-size-16 align-middle me-2"></i> Author List
                            </a>
                            <a href="javascript:history.back()" class="btn btn-sm btn-outline-dark">
                                <i class="bx bx-undo font-size-16 align-middle me-2"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-body p-4">
                            @include('widgets.errors')
                            <form action="{{ route('backend.authors.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">Author Photo <small class="text-muted">[440×440px]</small></label>
                                    <input type="file" name="image" id="author_image" class="form-control" accept="image/*">
                                    <img id="authorImgPreview" src="{{ asset('upload/no_image.jpg') }}" class="mt-2 rounded-circle border" style="width:100px;height:100px;object-fit:cover;">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Author Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="author_name" class="form-control" value="{{ old('name') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Slug <span class="text-danger">*</span></label>
                                    <input type="text" name="slug" id="author_slug" class="form-control" value="{{ old('slug') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-sm btn-primary px-4">
                                    <i class="bx bx-save me-1"></i> Save Author
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#author_image').on('change', function() {
                const reader = new FileReader();
                reader.onload = e => $('#authorImgPreview').attr('src', e.target.result);
                reader.readAsDataURL(this.files[0]);
            });
            $('#author_name').on('keyup', function() {
                const slug = $(this).val().toLowerCase().trim()
                    .replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-');
                $('#author_slug').val(slug);
            });
        });
    </script>
    @include('admin.layout.custom_scripts')
@endsection
