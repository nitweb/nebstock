@extends('admin.dashboard')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Edit Font</h4>
                        <div class="page-title-right">
                            <a href="{{ route('backend.fonts.list') }}" class="btn btn-sm btn-outline-primary">
                                <i class="bx bx-list-ul font-size-16 align-middle me-2"></i> Font List
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

                            <form action="{{ route('backend.fonts.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ $font->id }}">

                                {{-- Font File --}}
                                <div class="mb-3">
                                    <label class="form-label">Font File <small class="text-muted">(.ttf, .otf, .woff, .woff2, .zip)</small></label>
                                    <input type="file" name="font_file" id="font_file" class="form-control" accept=".ttf,.otf,.woff,.woff2,.zip">
                                    <small class="text-muted">
                                        Current file: <code>{{ $font->font_file }}</code>
                                        — leave empty to keep. Choosing a new file auto-fills Name/Slug below and renames the stored file on save.
                                    </small>
                                </div>

                                {{-- Preview Image --}}
                                <div class="mb-3">
                                    <label class="form-label">Preview / Specimen Image <small class="text-muted">[500×280px]</small></label>
                                    <input type="file" name="preview_image" id="font_preview" class="form-control" accept="image/*">
                                    <img id="fontImgPreview" src="{{ $font->preview_image_url }}" class="mt-2 rounded border" style="width:160px;height:90px;object-fit:cover;">
                                </div>

                                {{-- Name --}}
                                <div class="mb-3">
                                    <label class="form-label">Font Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="font_name" class="form-control" value="{{ old('name', $font->name) }}" required>
                                </div>

                                {{-- Slug --}}
                                <div class="mb-3">
                                    <label class="form-label">Slug <span class="text-danger">*</span></label>
                                    <input type="text" name="slug" id="font_slug" class="form-control" value="{{ old('slug', $font->slug) }}" required>
                                    <small class="text-muted">Changing this renames the stored file on next upload.</small>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Designer / Foundry</label>
                                        <input type="text" name="designer" class="form-control" value="{{ old('designer', $font->designer) }}">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Style</label>
                                        <input type="text" name="style" class="form-control" value="{{ old('style', $font->style) }}">
                                    </div>
                                </div>

                                {{-- License --}}
                                <div class="mb-3">
                                    <label class="form-label">License <span class="text-danger">*</span></label>
                                    <select name="license" class="form-select">
                                        <option value="free" {{ old('license', $font->license) == 'free' ? 'selected' : '' }}>Free</option>
                                        <option value="personal_use" {{ old('license', $font->license) == 'personal_use' ? 'selected' : '' }}>Personal Use Only</option>
                                        <option value="open_font_license" {{ old('license', $font->license) == 'open_font_license' ? 'selected' : '' }}>Open Font License</option>
                                        <option value="premium" {{ old('license', $font->license) == 'premium' ? 'selected' : '' }}>Premium</option>
                                    </select>
                                </div>

                                {{-- Description --}}
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" class="form-control" rows="3">{{ old('description', $font->description) }}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-check form-switch mt-4">
                                            <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $font->is_featured) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_featured">Featured Font</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-select">
                                            <option value="active" {{ old('status', $font->status) == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ old('status', $font->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <span class="text-muted">Downloads so far: <strong>{{ $font->downloads_count }}</strong></span>
                                </div>

                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bx bx-save me-1"></i> Update Font
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
            $('#font_preview').on('change', function() {
                const reader = new FileReader();
                reader.onload = e => $('#fontImgPreview').attr('src', e.target.result);
                reader.readAsDataURL(this.files[0]);
            });

            function slugify(str) {
                return str.toLowerCase().trim()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
            }

            // Auto-fill Font Name & Slug when a new font file is chosen
            $('#font_file').on('change', function() {
                if (!this.files || !this.files[0]) return;

                const fileName = this.files[0].name;
                const baseName = fileName.replace(/\.[^/.]+$/, '');
                const niceName = baseName
                    .replace(/[-_]+/g, ' ')
                    .replace(/([a-z])([A-Z])/g, '$1 $2')
                    .replace(/\s+/g, ' ')
                    .trim()
                    .replace(/\w\S*/g, w => w.charAt(0).toUpperCase() + w.substr(1).toLowerCase());

                $('#font_name').val(niceName);
                $('#font_slug').val(slugify(niceName));
            });

            $('#font_name').on('keyup', function() {
                $('#font_slug').val(slugify($(this).val()));
            });
        });
    </script>
    @include('admin.layout.custom_scripts')
@endsection
