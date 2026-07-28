@extends('admin.dashboard')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Edit Product</h4>
                        <div class="page-title-right">
                            <a href="{{ route('backend.products.list') }}" class="btn btn-sm btn-outline-primary waves-effect waves-light">
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

            <form action="{{ route('backend.products.update') }}" method="POST" enctype="multipart/form-data" id="editProductForm">
                @csrf
                <input type="hidden" name="id" value="{{ $product->id }}">

                <div class="row g-4">

                    {{-- ══ LEFT ══ --}}
                    <div class="col-lg-8">

                        {{-- ══ Product Mode ══ --}}
                        <div class="card border-success mb-3">
                            <div class="card-header bg-success text-white fw-semibold">
                                <i class="bx bx-store me-1"></i> Product Mode
                            </div>
                            <div class="card-body">
                                <div class="d-flex gap-4 flex-wrap">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input product-mode-radio" type="radio" name="product_mode" id="mode_selling" value="selling" {{ old('product_mode', $product->product_mode ?? 'selling') == 'selling' ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold" for="mode_selling">
                                            <i class="bx bx-cart me-1"></i> Selling
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input product-mode-radio" type="radio" name="product_mode" id="mode_affiliate" value="affiliate" {{ old('product_mode', $product->product_mode ?? 'selling') == 'affiliate' ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold text-warning" for="mode_affiliate">
                                            <i class="bx bx-link-external me-1"></i> Affiliate
                                        </label>
                                    </div>
                                </div>

                                <div id="affiliatePrimarySection" class="mt-3" style="display:none;">
                                    <hr class="my-2">
                                    <p class="fw-semibold mb-2"><i class="bx bx-link me-1 text-warning"></i> Primary Affiliate Link</p>
                                    <div class="row g-2">
                                        <div class="col-md-4">
                                            <label class="form-label small">Platform Name</label>
                                            <input type="text" name="affiliate_platform" class="form-control form-control-sm" value="{{ old('affiliate_platform', $product->affiliate_platform) }}" placeholder="Amazon…">
                                        </div>
                                        <div class="col-md-5">
                                            <label class="form-label small">Affiliate URL <span class="text-danger">*</span></label>
                                            <input type="url" name="affiliate_url" class="form-control form-control-sm" value="{{ old('affiliate_url', $product->affiliate_url) }}" placeholder="https://…">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label small">Listed Price ($)</label>
                                            <input type="number" step="0.01" min="0" name="affiliate_price" class="form-control form-control-sm" value="{{ old('affiliate_price', $product->affiliate_price) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Product Type Switcher --}}
                        <div class="card border-primary">
                            <div class="card-header bg-primary text-white fw-semibold">
                                <i class="bx bx-category me-1"></i> Product Type
                            </div>
                            <div class="card-body">
                                <div class="d-flex gap-3 flex-wrap">
                                    @foreach ($productTypes as $typeKey => $typeLabel)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input product-type-radio" type="radio" name="product_type" id="type_{{ $typeKey }}" value="{{ $typeKey }}" {{ old('product_type', $product->product_type ?? 'book') == $typeKey ? 'checked' : '' }}>
                                            <label class="form-check-label fw-semibold" for="type_{{ $typeKey }}">
                                                {{ $typeLabel }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <small class="text-muted mt-2 d-block">
                                    <strong>Book</strong> → author & PDF fields.
                                    <strong>Clothing / Hat</strong> → size & colour variants.
                                </small>
                            </div>
                        </div>

                        {{-- Basic Info --}}
                        <div class="card mt-3">
                            <div class="card-header fw-semibold">Basic Information</div>
                            <div class="card-body row g-3">
                                <div class="col-12">
                                    <label class="form-label">Product Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="product_name" class="form-control" value="{{ old('name', $product->name) }}" required>
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label">Slug <span class="text-danger">*</span></label>
                                    <input type="text" name="slug" id="product_slug" class="form-control" value="{{ old('slug', $product->slug) }}" required>
                                    <small class="text-muted">⚠️ Changing slug will break existing URLs.</small>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">SKU / Barcode</label>
                                    <input type="text" name="sku" class="form-control" value="{{ old('sku', $product->sku) }}" placeholder="Optional">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Short Description</label>
                                    <textarea name="short_description" class="form-control" rows="3">{{ old('short_description', $product->short_description) }}</textarea>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Long Description</label>
                                    <textarea name="long_description" class="form-control summernote">{{ old('long_description', $product->long_description) }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Pricing & Stock --}}
                        <div class="card mt-3" id="pricingStockCard">
                            <div class="card-header fw-semibold">Pricing & Stock</div>
                            <div class="card-body row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Price ($) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" min="0" name="price" class="form-control" value="{{ old('price', $product->price) }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Discount Price ($)</label>
                                    <input type="number" step="0.01" min="0" name="discount_price" class="form-control" value="{{ old('discount_price', $product->discount_price) }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Quantity <span class="text-danger">*</span></label>
                                    <input type="number" min="0" name="quantity" class="form-control" value="{{ old('quantity', $product->quantity) }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Stock Status <span class="text-danger">*</span></label>
                                    <select name="stock_status" class="form-select">
                                        <option value="in_stock" {{ old('stock_status', $product->stock_status) == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                                        <option value="out_of_stock" {{ old('stock_status', $product->stock_status) == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Product Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-select" required>
                                        <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        <option value="draft" {{ old('status', $product->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_featured">Mark as Featured</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Pre-Order --}}
                        @include('backend.products.partials.pre_order_section', ['product' => $product])

                        {{-- BOOK ONLY: Specifications --}}
                        <div class="card mt-3 book-only-section">
                            <div class="card-header fw-semibold">Book Specifications</div>
                            <div class="card-body row g-3">
                                @php $spec = $product->specification; @endphp
                                <div class="col-md-6">
                                    <label class="form-label">Publisher</label>
                                    <input type="text" name="spec_publisher" class="form-control" value="{{ old('spec_publisher', $spec?->publisher) }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Edition</label>
                                    <input type="text" name="spec_edition" class="form-control" value="{{ old('spec_edition', $spec?->edition) }}" placeholder="e.g. 3rd">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Number of Pages</label>
                                    <input type="number" min="1" name="spec_pages" class="form-control" value="{{ old('spec_pages', $spec?->number_of_pages) }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Language</label>
                                    <input type="text" name="spec_language" class="form-control" value="{{ old('spec_language', $spec?->language ?? 'English') }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Publication Year</label>
                                    <input type="number" min="1800" max="{{ date('Y') }}" name="spec_publication_year" class="form-control" value="{{ old('spec_publication_year', $spec?->publication_year) }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Country</label>
                                    <input type="text" name="spec_country" class="form-control" value="{{ old('spec_country', $spec?->country ?? 'USA') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">ISBN</label>
                                    <input type="text" name="spec_isbn" class="form-control" value="{{ old('spec_isbn', $spec?->isbn) }}" placeholder="978-...">
                                </div>
                            </div>
                        </div>

                        {{-- VARIANT TYPES ONLY: Size & Color Variants --}}
                        <div class="card mt-3 variant-only-section">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span class="fw-semibold">Size & Colour Variants</span>
                                <button type="button" class="btn btn-sm btn-outline-primary" id="addVariantBtn">
                                    <i class="bx bx-plus"></i> Add Variant
                                </button>
                            </div>
                            <div class="card-body">
                                <div id="variants-container">
                                    @foreach ($product->variants as $variant)
                                        @php $vi = $loop->index; @endphp
                                        <div class="row g-2 mb-2 align-items-end border rounded p-2" id="vr_existing_{{ $variant->id }}">
                                            <div class="col-md-3">
                                                <label class="form-label small mb-1">Size</label>
                                                <input type="text" name="variants[{{ $vi }}][size]" class="form-control form-control-sm" value="{{ $variant->size }}" placeholder="S, M, L…">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label small mb-1">Color</label>
                                                <input type="text" name="variants[{{ $vi }}][color]" class="form-control form-control-sm" value="{{ $variant->color }}" placeholder="Red, Blue…">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label small mb-1">Hex</label>
                                                <input type="color" name="variants[{{ $vi }}][color_hex]" class="form-control form-control-sm form-control-color" value="{{ $variant->color_hex ?? '#000000' }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label small mb-1">Qty</label>
                                                <input type="number" min="0" name="variants[{{ $vi }}][quantity]" class="form-control form-control-sm" value="{{ $variant->quantity }}">
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-sm btn-outline-danger remove-variant" data-row="vr_existing_{{ $variant->id }}">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <p class="text-muted small mb-0 {{ $product->variants->isNotEmpty() ? 'd-none' : '' }}" id="noVariantMsg">
                                    No variants yet. Click "Add Variant".
                                </p>
                            </div>
                        </div>

                        {{-- Generic Attributes --}}
                        <div class="card mt-3">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span class="fw-semibold">Extra Attributes <small class="text-muted fw-normal">(Brand, Material, Weight…)</small></span>
                                <button type="button" class="btn btn-sm btn-outline-secondary" id="addAttrBtn">
                                    <i class="bx bx-plus"></i> Add
                                </button>
                            </div>
                            <div class="card-body">
                                <div id="attrs-container">
                                    @if ($product->attributes && count($product->attributes))
                                        @foreach ($product->attributes as $attrKey => $attrVal)
                                            <div class="row g-2 mb-2 align-items-end" id="attr_existing_{{ $loop->index }}">
                                                <div class="col-md-5">
                                                    <input type="text" name="attr_keys[]" class="form-control form-control-sm" value="{{ $attrKey }}" placeholder="Key (e.g. Brand)">
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" name="attr_values[]" class="form-control form-control-sm" value="{{ $attrVal }}" placeholder="Value (e.g. Adidas)">
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button" class="btn btn-sm btn-outline-danger remove-attr" data-row="attr_existing_{{ $loop->index }}">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <p class="text-muted small mb-0 {{ $product->attributes && count($product->attributes) ? 'd-none' : '' }}" id="noAttrMsg">
                                    No extra attributes yet.
                                </p>
                            </div>
                        </div>

                        {{-- Also Available On --}}
                        <div class="card mt-3">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span class="fw-semibold">Also Available On</span>
                                <button type="button" class="btn btn-sm btn-outline-primary" id="addPlatformBtn">
                                    <i class="bx bx-plus"></i> Add Platform
                                </button>
                            </div>
                            <div class="card-body">
                                <div id="platforms-container">
                                    @foreach ($product->relatedPlatforms as $platform)
                                        @php $pi = $loop->index; @endphp
                                        <div class="row g-2 mb-2 align-items-end" id="pr_{{ $pi }}">
                                            <div class="col-md-4">
                                                <label class="form-label small mb-1">Platform</label>
                                                <input type="text" name="platforms[{{ $pi }}][name]" class="form-control form-control-sm" value="{{ $platform->platform_name }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label small mb-1">URL</label>
                                                <input type="url" name="platforms[{{ $pi }}][url]" class="form-control form-control-sm" value="{{ $platform->platform_url }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label small mb-1">Price ($)</label>
                                                <input type="number" step="0.01" min="0" name="platforms[{{ $pi }}][price]" class="form-control form-control-sm" value="{{ $platform->platform_price }}">
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-sm btn-outline-danger remove-platform" data-row="pr_{{ $pi }}">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <p class="text-muted small mb-0 {{ $product->relatedPlatforms->isNotEmpty() ? 'd-none' : '' }}" id="noPlatformMsg">
                                    No platform added yet.
                                </p>
                            </div>
                        </div>

                        {{-- Gallery Management — ALL product types (not book-only!) --}}
                        <div class="card mt-3" id="galleryCard">
                            <div class="card-header fw-semibold">Gallery Images</div>
                            <div class="card-body">

                                @if ($product->galleryImages->isNotEmpty())
                                    <div class="row g-2 mb-3" id="existingGallery">
                                        @foreach ($product->galleryImages as $media)
                                            <div class="col-md-3 col-6 text-center" id="gallery_item_{{ $media->id }}">
                                                <div class="border rounded p-1">
                                                    <img src="{{ url('upload/product_gallery/' . $media->file_path) }}" style="width:100%;height:100px;object-fit:cover;border-radius:4px;">
                                                    <div class="mt-1">
                                                        <input type="file" class="form-control form-control-sm mb-1 gallery-replace-input" data-id="{{ $media->id }}" accept="image/*">
                                                        <button type="button" class="btn btn-xs btn-outline-primary w-100 gallery-replace-btn" data-id="{{ $media->id }}" style="font-size:11px;">
                                                            <i class="bx bx-refresh"></i> Replace
                                                        </button>
                                                    </div>
                                                    <div class="mt-1">
                                                        <button type="button" class="btn btn-xs btn-outline-danger w-100 gallery-delete-btn" data-id="{{ $media->id }}" style="font-size:11px;">
                                                            <i class="bx bx-trash"></i> Delete
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted small" id="noGalleryMsg">No gallery images yet.</p>
                                @endif

                                <div class="border-top pt-3">
                                    <label class="form-label fw-semibold">Add New Gallery Images</label>
                                    <input type="file" name="gallery_images[]" id="gallery_input" class="form-control mb-2" accept="image/*" multiple>
                                    <div id="galleryPreview" class="d-flex flex-wrap gap-2"></div>
                                </div>

                            </div>
                        </div>

                    </div>{{-- /col-lg-8 --}}

                    {{-- ══ RIGHT ══ --}}
                    <div class="col-lg-4">

                        {{-- Cover Image --}}
                        <div class="card">
                            <div class="card-header fw-semibold">Cover / Main Image</div>
                            <div class="card-body">
                                <input type="file" name="cover_image" id="cover_image_input" class="form-control mb-2" accept="image/*">
                                <img id="coverPreview" src="{{ $product->cover_image ? url('upload/product_covers/' . $product->cover_image) : asset('upload/no_image.jpg') }}" class="img-fluid rounded border" style="width:100%;max-height:250px;object-fit:cover;">
                            </div>
                        </div>

                        {{-- BOOK ONLY: PDF Files --}}
                        <div class="card mt-3 book-only-section">
                            <div class="card-header fw-semibold">PDF Files</div>
                            <div class="card-body row g-3">
                                <div class="col-12">
                                    <label class="form-label">PDF Sample <small class="text-muted">(free preview)</small></label>
                                    @if ($product->pdf_sample)
                                        <div class="mb-1">
                                            <a href="{{ url('upload/product_pdfs/' . $product->pdf_sample) }}" target="_blank" class="badge bg-info text-decoration-none">
                                                <i class="bx bx-file-pdf me-1"></i> View Current Sample
                                            </a>
                                        </div>
                                    @endif
                                    <input type="file" name="pdf_sample" class="form-control" accept=".pdf">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Full PDF</label>
                                    @if ($product->pdf_file)
                                        <div class="mb-1">
                                            <a href="{{ url('upload/product_pdfs/' . $product->pdf_file) }}" target="_blank" class="badge bg-success text-decoration-none">
                                                <i class="bx bx-file-pdf me-1"></i> View Current PDF
                                            </a>
                                        </div>
                                    @endif
                                    <input type="file" name="pdf_file" class="form-control" accept=".pdf">
                                </div>
                            </div>
                        </div>

                        {{-- Categories --}}
                        <div class="card mt-3">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span class="fw-semibold">Categories <span class="text-danger">*</span></span>
                                <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                                    <i class="bx bx-plus"></i> Quick Add
                                </button>
                            </div>
                            <div class="card-body" id="categoryCheckboxes" style="max-height:300px;overflow-y:auto;">
                                @include('backend.products.partials.category_tree', [
                                    'categories' => $categories,
                                    'depth' => 0,
                                    'selectedCats' => old('category_ids', $selectedCats),
                                ])
                            </div>
                        </div>

                        {{-- BOOK ONLY: Authors --}}
                        <div class="card mt-3 book-only-section" id="authorsCard">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span class="fw-semibold">Authors <span class="text-danger">*</span></span>
                                <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#addAuthorModal">
                                    <i class="bx bx-plus"></i> Quick Add
                                </button>
                            </div>
                            <div class="card-body" id="authorCheckboxes" style="max-height:220px;overflow-y:auto;">
                                @foreach ($authors as $author)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="author_ids[]" value="{{ $author->id }}" id="author_{{ $author->id }}" {{ in_array($author->id, old('author_ids', $selectedAuthors)) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="author_{{ $author->id }}">{{ $author->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>{{-- /col-lg-4 --}}
                </div>{{-- /row --}}

                <div class="row mt-3 mb-5">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary px-5">
                            <i class="bx bx-save me-1"></i> Update Product
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </div>

    {{-- Quick Add Category Modal --}}
    @include('backend.products.partials.modal_category')
    {{-- Quick Add Author Modal --}}
    @include('backend.products.partials.modal_author')

    <script>
        $(document).ready(function() {

            // ── Helpers ──────────────────────────────────────────────────────────
            function makeSlug(str) {
                return str.toLowerCase().trim()
                    .replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-');
            }

            function showAlert(id, type, msg) {
                $(`#${id}`).html(`<div class="alert alert-${type} alert-dismissible fade show py-2 mb-3">${msg}<button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button></div>`);
            }

            // ── Product Type Toggle ───────────────────────────────────────────────
            // FIX: applyTypeUI আলাদাভাবে define, applyModeUI এর আগে
            function applyTypeUI() {
                const type = $('input[name="product_type"]:checked').val();
                const isBook = type === 'book';
                const hasVariant = ['clothing', 'hat'].includes(type);

                $('.book-only-section').toggle(isBook);
                $('.variant-only-section').toggle(hasVariant);
            }

            // ── Product Mode Toggle ───────────────────────────────────────────────
            // FIX: affiliate হলে book-only + variant সব hide, pricing hide
            function applyModeUI() {
                const isAffiliate = $('input[name="product_mode"]:checked').val() === 'affiliate';

                $('#affiliatePrimarySection').toggle(isAffiliate);
                $('#pricingStockCard').toggle(!isAffiliate);

                if (isAffiliate) {
                    // Affiliate mode: type-based sections সব hide
                    $('.book-only-section').hide();
                    $('.variant-only-section').hide();
                } else {
                    // Selling mode: type অনুযায়ী দেখাও
                    applyTypeUI();
                }
            }

            // Event listeners
            $('input[name="product_type"]').on('change', function() {
                // Type change শুধু selling mode এ effect করবে
                if ($('input[name="product_mode"]:checked').val() !== 'affiliate') {
                    applyTypeUI();
                }
            });

            $('input[name="product_mode"]').on('change', applyModeUI);

            // Page load এ run করো
            applyTypeUI();
            applyModeUI();

            // ── Cover Image Preview ───────────────────────────────────────────────
            $('#cover_image_input').on('change', function() {
                const reader = new FileReader();
                reader.onload = e => $('#coverPreview').attr('src', e.target.result);
                reader.readAsDataURL(this.files[0]);
            });

            // ── Gallery Preview (new uploads) ─────────────────────────────────────
            $('#gallery_input').on('change', function() {
                $('#galleryPreview').html('');
                $.each(this.files, function(i, file) {
                    const reader = new FileReader();
                    reader.onload = e => {
                        $('#galleryPreview').append(
                            `<img src="${e.target.result}" style="width:75px;height:75px;object-fit:cover;border-radius:6px;border:1px solid #ddd;">`
                        );
                    };
                    reader.readAsDataURL(file);
                });
            });

            // ── Gallery Replace (AJAX) ────────────────────────────────────────────
            $(document).on('click', '.gallery-replace-btn', function() {
                const id = $(this).data('id');
                const file = $(`.gallery-replace-input[data-id="${id}"]`)[0].files[0];
                if (!file) {
                    alert('Please select an image first.');
                    return;
                }
                const fd = new FormData();
                fd.append('_token', '{{ csrf_token() }}');
                fd.append('gallery_image', file);
                const btn = $(this);
                btn.prop('disabled', true).html('<i class="bx bx-loader bx-spin"></i> Uploading…');
                $.ajax({
                    url: `/backend/products/gallery/update/${id}`,
                    type: 'POST',
                    data: fd,
                    processData: false,
                    contentType: false,
                    success: () => window.location.reload(),
                    error: xhr => {
                        alert(xhr.responseJSON?.message ?? 'Failed to replace image.');
                        btn.prop('disabled', false).html('<i class="bx bx-refresh"></i> Replace');
                    }
                });
            });

            // ── Gallery Delete (AJAX) ─────────────────────────────────────────────
            $(document).on('click', '.gallery-delete-btn', function() {
                if (!confirm('Delete this image?')) return;
                const id = $(this).data('id');
                const btn = $(this);
                btn.prop('disabled', true).html('<i class="bx bx-loader bx-spin"></i>');
                $.ajax({
                    url: `/backend/products/gallery/delete/${id}`,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    },
                    success: () => {
                        $(`#gallery_item_${id}`).fadeOut(300, function() {
                            $(this).remove();
                            if ($('#existingGallery').children('.col-md-3').length === 0) {
                                $('#existingGallery').replaceWith('<p class="text-muted small" id="noGalleryMsg">No gallery images yet.</p>');
                            }
                        });
                    },
                    error: xhr => {
                        alert(xhr.responseJSON?.message ?? 'Failed to delete image.');
                        btn.prop('disabled', false).html('<i class="bx bx-trash"></i> Delete');
                    }
                });
            });

            // ── Variants ──────────────────────────────────────────────────────────
            let variantIdx = {{ $product->variants->count() }};

            $('#addVariantBtn').on('click', function() {
                $('#noVariantMsg').addClass('d-none');
                const i = variantIdx++;
                $('#variants-container').append(`
                <div class="row g-2 mb-2 align-items-end border rounded p-2" id="vr_${i}">
                    <div class="col-md-3">
                        <label class="form-label small mb-1">Size</label>
                        <input type="text" name="variants[${i}][size]" class="form-control form-control-sm" placeholder="S, M, L, XL…">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small mb-1">Color</label>
                        <input type="text" name="variants[${i}][color]" class="form-control form-control-sm" placeholder="Red, Blue…">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small mb-1">Hex</label>
                        <input type="color" name="variants[${i}][color_hex]" class="form-control form-control-sm form-control-color" value="#000000">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small mb-1">Qty</label>
                        <input type="number" min="0" name="variants[${i}][quantity]" class="form-control form-control-sm" value="0">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-sm btn-outline-danger remove-variant" data-row="vr_${i}">
                            <i class="bx bx-trash"></i>
                        </button>
                    </div>
                </div>`);
            });

            $(document).on('click', '.remove-variant', function() {
                $(`#${$(this).data('row')}`).remove();
                if ($('#variants-container').children().length === 0) {
                    $('#noVariantMsg').removeClass('d-none');
                }
            });

            // ── Attributes ────────────────────────────────────────────────────────
            let attrIdx = {{ $product->attributes ? count($product->attributes) : 0 }};

            $('#addAttrBtn').on('click', function() {
                $('#noAttrMsg').addClass('d-none');
                const i = attrIdx++;
                $('#attrs-container').append(`
                <div class="row g-2 mb-2 align-items-end" id="attr_${i}">
                    <div class="col-md-5">
                        <input type="text" name="attr_keys[]" class="form-control form-control-sm" placeholder="Key (e.g. Brand)">
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="attr_values[]" class="form-control form-control-sm" placeholder="Value (e.g. Adidas)">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-sm btn-outline-danger remove-attr" data-row="attr_${i}">
                            <i class="bx bx-trash"></i>
                        </button>
                    </div>
                </div>`);
            });

            $(document).on('click', '.remove-attr', function() {
                $(`#${$(this).data('row')}`).remove();
                if ($('#attrs-container').children().length === 0) {
                    $('#noAttrMsg').removeClass('d-none');
                }
            });

            // ── Platforms ─────────────────────────────────────────────────────────
            let platformIdx = {{ $product->relatedPlatforms->count() }};

            $('#addPlatformBtn').on('click', function() {
                $('#noPlatformMsg').addClass('d-none');
                const i = platformIdx++;
                $('#platforms-container').append(`
                <div class="row g-2 mb-2 align-items-end" id="pr_${i}">
                    <div class="col-md-4">
                        <input type="text" name="platforms[${i}][name]" class="form-control form-control-sm" placeholder="Rokomari…">
                    </div>
                    <div class="col-md-4">
                        <input type="url" name="platforms[${i}][url]" class="form-control form-control-sm" placeholder="https://…">
                    </div>
                    <div class="col-md-3">
                        <input type="number" step="0.01" min="0" name="platforms[${i}][price]" class="form-control form-control-sm" placeholder="Price $">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-sm btn-outline-danger remove-platform" data-row="pr_${i}">
                            <i class="bx bx-trash"></i>
                        </button>
                    </div>
                </div>`);
            });

            $(document).on('click', '.remove-platform', function() {
                $(`#${$(this).data('row')}`).remove();
                if ($('#platforms-container').children().length === 0) {
                    $('#noPlatformMsg').removeClass('d-none');
                }
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
                    success: res => {
                        if (res.success) {
                            showAlert('catModalAlert', 'success', `✅ "${res.category.name}" saved!`);
                            $('#categoryCheckboxes').prepend(
                                `<div class="form-check"><input class="form-check-input" type="checkbox" name="category_ids[]" value="${res.category.id}" id="cat_${res.category.id}" checked><label class="form-check-label fw-semibold" for="cat_${res.category.id}">${res.category.name}</label></div>`
                            );
                            $('#modal_cat_name, #modal_cat_slug').val('');
                            $('#modal_cat_image').val('');
                            $('#modalCatImgPreview').attr('src', "{{ asset('upload/no_image.jpg') }}");
                        } else {
                            showAlert('catModalAlert', 'danger', res.message ?? 'Failed.');
                        }
                    },
                    error: xhr => {
                        showAlert('catModalAlert', 'danger',
                            xhr.responseJSON?.errors ? Object.values(xhr.responseJSON.errors).map(e => e[0]).join('<br>') : 'Error.');
                    },
                    complete: () => {
                        $('#catBtnText').removeClass('d-none');
                        $('#catBtnSpinner').addClass('d-none');
                    }
                });
            });

            // ── Author Quick Add Modal ────────────────────────────────────────────
            $('#modal_author_image').on('change', function() {
                const reader = new FileReader();
                reader.onload = e => $('#modalAuthorImgPreview').attr('src', e.target.result);
                reader.readAsDataURL(this.files[0]);
            });
            $('#modal_author_name').on('keyup', function() {
                $('#modal_author_slug').val(makeSlug($(this).val()));
            });
            $('#addAuthorModal').on('hidden.bs.modal', function() {
                $('#modal_author_name, #modal_author_slug, #modal_author_desc').val('');
                $('#modal_author_image').val('');
                $('#modalAuthorImgPreview').attr('src', "{{ asset('upload/no_image.jpg') }}");
                $('#authorModalAlert').html('');
            });
            $('#saveAuthorBtn').on('click', function() {
                const name = $('#modal_author_name').val().trim();
                const slug = $('#modal_author_slug').val().trim();
                if (!name || !slug) {
                    showAlert('authorModalAlert', 'warning', 'Name and Slug are required.');
                    return;
                }
                const fd = new FormData();
                fd.append('_token', '{{ csrf_token() }}');
                fd.append('name', name);
                fd.append('slug', slug);
                fd.append('description', $('#modal_author_desc').val());
                fd.append('status', 'active');
                if ($('#modal_author_image')[0].files[0]) fd.append('image', $('#modal_author_image')[0].files[0]);
                $('#authorBtnText').addClass('d-none');
                $('#authorBtnSpinner').removeClass('d-none');
                $.ajax({
                    url: '{{ route('backend.authors.ajax_store') }}',
                    type: 'POST',
                    data: fd,
                    processData: false,
                    contentType: false,
                    success: res => {
                        if (res.success) {
                            showAlert('authorModalAlert', 'success', `✅ "${res.author.name}" saved!`);
                            $('#authorCheckboxes').prepend(
                                `<div class="form-check"><input class="form-check-input" type="checkbox" name="author_ids[]" value="${res.author.id}" id="author_${res.author.id}" checked><label class="form-check-label" for="author_${res.author.id}">${res.author.name}</label></div>`
                            );
                            $('#modal_author_name, #modal_author_slug, #modal_author_desc').val('');
                            $('#modal_author_image').val('');
                            $('#modalAuthorImgPreview').attr('src', "{{ asset('upload/no_image.jpg') }}");
                        } else {
                            showAlert('authorModalAlert', 'danger', res.message ?? 'Failed.');
                        }
                    },
                    error: xhr => {
                        showAlert('authorModalAlert', 'danger',
                            xhr.responseJSON?.errors ? Object.values(xhr.responseJSON.errors).map(e => e[0]).join('<br>') : 'Error.');
                    },
                    complete: () => {
                        $('#authorBtnText').removeClass('d-none');
                        $('#authorBtnSpinner').addClass('d-none');
                    }
                });
            });

        }); // end document.ready
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
