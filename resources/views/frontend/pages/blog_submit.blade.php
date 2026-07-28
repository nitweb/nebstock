@extends('frontend.dashboard')
@section('frontend_title', 'Submit a Blog')
@section('frontend_content')

    <div class="breadcrumb__section breadcrumb__bg" style="background-image:url('{{ asset('upload/static_images/breadcrumb.jpg') }}');">
        <div class="breadcrumb__overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__title text-white mb-3">Submit a Blog</h1>
                        <ul class="breadcrumb__content--menu d-flex justify-content-center align-items-center">
                            <li class="breadcrumb__content--menu__items"><a class="text-white" href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb__content--menu__items"><a class="text-white" href="{{ route('blog') }}">Blog</a></li>
                            <li class="breadcrumb__content--menu__items"><span class="text-white">Submit</span></li>
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

                    {{-- Success message --}}
                    @if (session('success'))
                        <div style="background:#f0faf4;border:1.5px solid #b7e4c7;border-radius:10px;padding:14px 18px;margin-bottom:24px;color:#27ae60;font-size:14px;display:flex;gap:10px;align-items:center;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                <path d="M9 12l2 2 4-4M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke="#27ae60" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            {{ session('success') }}
                        </div>
                    @endif

                    <div style="background:#fff;border-radius:16px;padding:32px;box-shadow:0 2px 16px rgba(0,0,0,.07);">
                        <h3 style="font-size:20px;font-weight:700;margin-bottom:6px;">Write & Submit Your Blog</h3>
                        <p style="color:#6b7280;font-size:13.5px;margin-bottom:28px;">Your post will be reviewed by our team before publishing.</p>

                        <form action="{{ route('blog.submit.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- Title --}}
                            <div style="margin-bottom:20px;">
                                <label style="font-size:13.5px;font-weight:600;display:block;margin-bottom:6px;">Blog Title <span style="color:#e74c3c;">*</span></label>
                                <input type="text" name="blog_title" class="co-input" value="{{ old('blog_title') }}" placeholder="Enter a compelling title…" required style="width:100%;padding:11px 14px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:14px;outline:none;box-sizing:border-box;">
                                @error('blog_title')
                                    <p style="color:#e74c3c;font-size:12px;margin-top:4px;">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Category --}}
                            <div style="margin-bottom:20px;">
                                <label style="font-size:13.5px;font-weight:600;display:block;margin-bottom:6px;">Category <span style="color:#e74c3c;">*</span></label>
                                <select name="blog_category_id" required style="width:100%;padding:11px 14px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:14px;outline:none;box-sizing:border-box;background:#fff;">
                                    <option value="">Select Category</option>
                                    @foreach ($blog_categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('blog_category_id') == $cat->id ? 'selected' : '' }}>
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
                                <label style="font-size:13.5px;font-weight:600;display:block;margin-bottom:6px;">Cover Image <span style="color:#e74c3c;">*</span> <span style="color:#9ca3af;font-weight:400;">(830×553px recommended)</span></label>
                                <input type="file" name="blog_image" id="blogImageInput" accept="image/*" required style="width:100%;padding:10px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:13.5px;box-sizing:border-box;">
                                <img id="blogImagePreview" src="" alt="" style="display:none;margin-top:10px;width:100%;max-height:200px;object-fit:cover;border-radius:8px;border:1px solid #e2e8f0;">
                                @error('blog_image')
                                    <p style="color:#e74c3c;font-size:12px;margin-top:4px;">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Short Description --}}
                            {{-- <div style="margin-bottom:20px;">
                                <label style="font-size:13.5px;font-weight:600;display:block;margin-bottom:6px;">Short Description <span style="color:#9ca3af;font-weight:400;">(optional)</span></label>
                                <textarea name="blog_short_description" rows="2" placeholder="A brief summary of your blog…" style="width:100%;padding:11px 14px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:14px;outline:none;resize:vertical;box-sizing:border-box;">{{ old('blog_short_description') }}</textarea>
                            </div> --}}

                            {{-- Long Description --}}
                            <div style="margin-bottom:20px;">
                                <label style="font-size:13.5px;font-weight:600;display:block;margin-bottom:6px;">Content <span style="color:#e74c3c;">*</span> <span style="color:#9ca3af;font-weight:400;">(min 100 characters)</span></label>
                                <textarea name="blog_long_description" id="blog_submit_editor" rows="12" style="width:100%;padding:11px 14px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:14px;outline:none;resize:vertical;box-sizing:border-box;">{{ old('blog_long_description') }}</textarea>
                                @error('blog_long_description')
                                    <p style="color:#e74c3c;font-size:12px;margin-top:4px;">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Tags --}}
                            <div style="margin-bottom:28px;">
                                <label style="font-size:13.5px;font-weight:600;display:block;margin-bottom:6px;">Tags <span style="color:#9ca3af;font-weight:400;">(comma separated, optional)</span></label>
                                <input type="text" name="blog_tags" value="{{ old('blog_tags') }}" placeholder="e.g. books, reading, fiction" style="width:100%;padding:11px 14px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:14px;outline:none;box-sizing:border-box;">
                            </div>

                            {{-- Notice --}}
                            <div style="background:#fffbeb;border:1.5px solid #fde68a;border-radius:9px;padding:12px 16px;margin-bottom:24px;font-size:13px;color:#92400e;display:flex;gap:8px;align-items:flex-start;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" style="flex-shrink:0;margin-top:1px;">
                                    <circle cx="12" cy="12" r="10" stroke="#D4880A" stroke-width="2" />
                                    <path d="M12 8v4M12 16h.01" stroke="#D4880A" stroke-width="2" stroke-linecap="round" />
                                </svg>
                                <span>Your blog will be reviewed by our team. Once approved, it will appear on the blog page. You can track the status from your <a href="{{ route('customer.dashboard') }}" style="color:#b8860b;font-weight:600;">dashboard</a>.</span>
                            </div>

                            <button type="submit" style="background:#1a1a1a;color:#fff;border:none;padding:13px 32px 9px;border-radius:9px;font-size:14.5px;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:8px;transition:background .2s;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" style="margin-top:-5px;">
                                    <path d="M22 2L11 13M22 2L15 22l-4-9-9-4 20-7z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                Submit for Review
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <script>
        document.getElementById('blogImageInput').addEventListener('change', function() {
            const preview = document.getElementById('blogImagePreview');
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
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
