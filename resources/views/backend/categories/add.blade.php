@extends('admin.dashboard')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Add Category</h4>
                        <div class="page-title-right">
                            <a href="{{ route('backend.categories.list') }}" class="btn btn-sm btn-outline-primary">
                                <i class="bx bx-list-ul font-size-16 align-middle me-2"></i> Category List
                            </a>
                            <a href="javascript:history.back()" class="btn btn-sm btn-outline-dark">
                                <i class="bx bx-undo font-size-16 align-middle me-2"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body p-4">
                            @include('widgets.errors')

                            <form action="{{ route('backend.categories.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                {{-- Image --}}
                                <div class="mb-3">
                                    <label class="form-label">Image <small class="text-muted">[440×440px]</small></label>
                                    <input type="file" name="image" id="cat_image" class="form-control" accept="image/*">
                                    <img id="catImgPreview" src="{{ asset('upload/no_image.jpg') }}" class="mt-2 rounded border" style="width:110px;height:110px;object-fit:cover;">
                                </div>

                                {{-- Name --}}
                                <div class="mb-3">
                                    <label class="form-label">Category Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="cat_name" class="form-control" value="{{ old('name') }}" required>
                                </div>

                                {{-- Slug --}}
                                <div class="mb-3">
                                    <label class="form-label">Slug <span class="text-danger">*</span></label>
                                    <input type="text" name="slug" id="cat_slug" class="form-control" value="{{ old('slug') }}" required>
                                    <small class="text-muted">Auto-generated from name. Must be unique.</small>
                                </div>

                                {{-- Parent Category (unlimited nesting) --}}
                                <div class="mb-3">
                                    <label class="form-label">
                                        Parent Category
                                        <small class="text-muted">(optional — leave empty for root level)</small>
                                    </label>
                                    <select name="parent_id" class="form-select">
                                        <option value="">— Root Category (no parent) —</option>
                                        @foreach ($parentOptions as $id => $label)
                                            <option value="{{ $id }}" {{ old('parent_id') == $id ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">
                                        Indentation (—) shows nesting depth.
                                        e.g. "— Women" is a child of "Clothing"
                                    </small>
                                </div>

                                {{-- Description --}}
                                <div class="mb-3">
                                    <label class="form-label">Description <small class="text-muted">(optional, for SEO)</small></label>
                                    <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                                </div>

                                {{-- Sort Order --}}
                                <div class="mb-3">
                                    <label class="form-label">Sort Order</label>
                                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0">
                                    <small class="text-muted">Lower number = shown first.</small>
                                </div>

                                {{-- Status --}}
                                <div class="mb-4">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bx bx-save me-1"></i> Save Category
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
            // Image preview
            $('#cat_image').on('change', function() {
                const reader = new FileReader();
                reader.onload = e => $('#catImgPreview').attr('src', e.target.result);
                reader.readAsDataURL(this.files[0]);
            });

            // Auto-slug from name
            $('#cat_name').on('keyup', function() {
                $('#cat_slug').val(
                    $(this).val().toLowerCase().trim()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-')
                );
            });
        });
    </script>
    @include('admin.layout.custom_scripts')
@endsection
