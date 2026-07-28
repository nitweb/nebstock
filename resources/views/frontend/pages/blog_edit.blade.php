@extends('frontend.dashboard')
@section('frontend_title', 'Edit Blog')
@section('frontend_content')

    <div class="breadcrumb__section breadcrumb__bg" style="background-image:url('{{ asset('upload/static_images/breadcrumb.jpg') }}');">
        <div class="breadcrumb__overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__title text-white mb-3">Edit Blog</h1>
                        <ul class="breadcrumb__content--menu d-flex justify-content-center align-items-center">
                            <li class="breadcrumb__content--menu__items"><a class="text-white" href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb__content--menu__items"><a class="text-white" href="{{ route('customer.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb__content--menu__items"><span class="text-white">Edit Blog</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="section--padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">

                    <div style="background:#fff8f0;border:1.5px solid #fed7aa;border-radius:10px;
                            padding:12px 16px;margin-bottom:24px;font-size:13px;color:#c2410c;
                            display:flex;gap:8px;align-items:center;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" style="flex-shrink:0;">
                            <circle cx="12" cy="12" r="10" stroke="#c2410c" stroke-width="2" />
                            <path d="M12 8v4M12 16h.01" stroke="#c2410c" stroke-width="2" stroke-linecap="round" />
                        </svg>
                        You can only edit blogs that are <strong>&nbsp;pending review</strong>. Once approved, editing is disabled.
                    </div>

                    <div style="background:#fff;border-radius:16px;padding:32px;box-shadow:0 2px 16px rgba(0,0,0,.07);">
                        <h3 style="font-size:20px;font-weight:700;margin-bottom:24px;">Edit Your Blog</h3>

                        <form action="{{ route('blog.edit.store', $blog->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- Title --}}
                            <div style="margin-bottom:20px;">
                                <label style="font-size:13.5px;font-weight:600;display:block;margin-bottom:6px;">Blog Title <span style="color:#e74c3c;">*</span></label>
                                <input type="text" name="blog_title" value="{{ old('blog_title', $blog->blog_title) }}" required style="width:100%;padding:11px 14px;border:1.5px solid #e2e8f0;
                                   border-radius:9px;font-size:14px;outline:none;box-sizing:border-box;">
                                @error('blog_title')
                                    <p style="color:#e74c3c;font-size:12px;margin-top:4px;">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Category --}}
                            <div style="margin-bottom:20px;">
                                <label style="font-size:13.5px;font-weight:600;display:block;margin-bottom:6px;">Category <span style="color:#e74c3c;">*</span></label>
                                <select name="blog_category_id" required style="width:100%;padding:11px 14px;border:1.5px solid #e2e8f0;
                                           border-radius:9px;font-size:14px;outline:none;box-sizing:border-box;background:#fff;">
                                    <option value="">Select Category</option>
                                    @foreach ($blog_categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('blog_category_id', $blog->blog_category_id) == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->blog_category_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('blog_category_id')
                                    <p style="color:#e74c3c;font-size:12px;margin-top:4px;">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Cover Image --}}
                            <div style="margin-bottom:20px;">
                                <label style="font-size:13.5px;font-weight:600;display:block;margin-bottom:6px;">
                                    Cover Image <span style="color:#9ca3af;font-weight:400;">(leave blank to keep current)</span>
                                </label>
                                <div style="margin-bottom:10px;">
                                    <img src="{{ asset('upload/blog_image/' . $blog->blog_image) }}" id="currentImage" style="width:100%;max-height:180px;object-fit:cover;border-radius:8px;border:1px solid #e2e8f0;">
                                </div>
                                <input type="file" name="blog_image" id="blogImageInput" accept="image/*" style="width:100%;padding:10px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:13.5px;box-sizing:border-box;">
                            </div>

                            {{-- Short Description --}}
                            {{-- <div style="margin-bottom:20px;">
                                <label style="font-size:13.5px;font-weight:600;display:block;margin-bottom:6px;">Short Description</label>
                                <textarea name="blog_short_description" rows="2" style="width:100%;padding:11px 14px;border:1.5px solid #e2e8f0;border-radius:9px;
                                             font-size:14px;outline:none;resize:vertical;box-sizing:border-box;">{{ old('blog_short_description', $blog->blog_short_description) }}</textarea>
                            </div> --}}

                            {{-- Content --}}
                            <div style="margin-bottom:20px;">
                                <label style="font-size:13.5px;font-weight:600;display:block;margin-bottom:6px;">Content <span style="color:#e74c3c;">*</span></label>
                                <textarea name="blog_long_description" id="blog_submit_editor" rows="14" style="width:100%;padding:11px 14px;border:1.5px solid #e2e8f0;border-radius:9px;
                                             font-size:14px;outline:none;resize:vertical;box-sizing:border-box;">{{ old('blog_long_description', $blog->blog_long_description) }}</textarea>
                                @error('blog_long_description')
                                    <p style="color:#e74c3c;font-size:12px;margin-top:4px;">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Tags --}}
                            <div style="margin-bottom:28px;">
                                <label style="font-size:13.5px;font-weight:600;display:block;margin-bottom:6px;">Tags <span style="color:#9ca3af;font-weight:400;">(comma separated)</span></label>
                                <input type="text" name="blog_tags" value="{{ old('blog_tags', $blog->blog_tags) }}" placeholder="e.g. books, reading, fiction" style="width:100%;padding:11px 14px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:14px;outline:none;box-sizing:border-box;">
                            </div>

                            <div style="display:flex;gap:12px;flex-wrap:wrap;">
                                <button type="submit" style="background:#1a1a1a;color:#fff;border:none;padding:13px 28px 9px;
                                           border-radius:9px;font-size:14px;font-weight:600;cursor:pointer;
                                           display:inline-flex;align-items:center;gap:8px;">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" style="margin-top:-5px;">
                                        <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                        <polyline points="17 21 17 13 7 13 7 21" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                    </svg>
                                    Update Blog
                                </button>
                                <a href="{{ route('customer.dashboard') }}" style="background:transparent;color:#6b7280;border:1.5px solid #e5e7eb;
                                      padding:12px 24px 8px;border-radius:9px;font-size:14px;font-weight:600;
                                      text-decoration:none;display:inline-flex;align-items:center;">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <script>
        // Image preview on change
        document.getElementById('blogImageInput').addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    document.getElementById('currentImage').src = e.target.result;
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    </script>

    {{-- Summernote CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">

    {{-- Summernote JS --}}
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#blog_submit_editor').summernote({
                placeholder: 'Write your blog content here...',
                tabsize: 2,
                height: 350,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']],
                    ['view', ['fullscreen', 'codeview']],
                ],
            });
        });
    </script>
@endsection
