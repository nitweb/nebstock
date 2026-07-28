@extends('admin.dashboard')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Edit Category</h4>
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
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-body p-4">
                            @include('widgets.errors')

                            <form action="{{ route('backend.categories.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ $category->id }}">

                                {{-- Image --}}
                                <div class="mb-3">
                                    <label class="form-label">Image <small class="text-muted">[440×440px]</small></label>
                                    <input type="file" name="image" id="cat_image" class="form-control" accept="image/*">
                                    <img id="catImgPreview" src="{{ $category->image ? url('upload/category_images/' . $category->image) : asset('upload/no_image.jpg') }}" class="mt-2 rounded border" style="width:110px;height:110px;object-fit:cover;">
                                </div>

                                {{-- Name --}}
                                <div class="mb-3">
                                    <label class="form-label">Category Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="cat_name" class="form-control" value="{{ old('name', $category->name) }}" required>
                                </div>

                                {{-- Slug --}}
                                <div class="mb-3">
                                    <label class="form-label">Slug <span class="text-danger">*</span></label>
                                    <input type="text" name="slug" id="cat_slug" class="form-control" value="{{ old('slug', $category->slug) }}" required>
                                    <small class="text-muted">⚠️ Changing slug will break existing URLs.</small>
                                </div>

                                {{-- Parent Category --}}
                                <div class="mb-3">
                                    <label class="form-label">
                                        Parent Category
                                        <small class="text-muted">(empty = root level)</small>
                                    </label>
                                    <select name="parent_id" class="form-select">
                                        <option value="">— Root Category (no parent) —</option>
                                        @foreach ($parentOptions as $id => $label)
                                            <option value="{{ $id }}" {{ old('parent_id', $category->parent_id) == $id ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($category->parent)
                                        <small class="text-muted">
                                            Current parent: <strong>{{ $category->parent->name }}</strong>
                                        </small>
                                    @endif
                                </div>

                                {{-- Description --}}
                                <div class="mb-3">
                                    <label class="form-label">Description <small class="text-muted">(optional)</small></label>
                                    <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
                                </div>

                                {{-- Sort Order --}}
                                <div class="mb-3">
                                    <label class="form-label">Sort Order</label>
                                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $category->sort_order) }}" min="0">
                                </div>

                                {{-- Status --}}
                                <div class="mb-4">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="active" {{ old('status', $category->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status', $category->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bx bx-save me-1"></i> Update Category
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Breadcrumb Preview --}}
                <div class="col-md-5">
                    <div class="card border-0 bg-light">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">Current Position in Tree</h6>
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                @php
                                    $crumbs = $category->breadcrumb();
                                @endphp
                                @foreach ($crumbs as $crumb)
                                    <span class="badge bg-primary">{{ $crumb->name }}</span>
                                    @if (!$loop->last)
                                        <span class="text-muted">›</span>
                                    @endif
                                @endforeach
                            </div>
                            <hr>
                            @if ($category->children->isNotEmpty())
                                <h6 class="fw-bold mb-2">Direct Children ({{ $category->children->count() }})</h6>
                                <ul class="list-unstyled mb-0">
                                    @foreach ($category->children as $child)
                                        <li class="text-muted small">
                                            <i class="bx bx-subdirectory-right me-1"></i>
                                            {{ $child->name }}
                                            @if ($child->children->isNotEmpty())
                                                <span class="badge bg-secondary ms-1">+{{ $child->children->count() }} more</span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted small mb-0">No child categories.</p>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#cat_image').on('change', function() {
                const reader = new FileReader();
                reader.onload = e => $('#catImgPreview').attr('src', e.target.result);
                reader.readAsDataURL(this.files[0]);
            });
        });
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

@endsection
