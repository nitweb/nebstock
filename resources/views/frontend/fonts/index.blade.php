@extends('frontend.dashboard')
@section('frontend_title', 'Fonts')
@section('frontend_contents')

    @if ($fonts->count())
        <style>
            @foreach ($fonts as $font)
                @font-face {
                    font-family: "font-preview-{{ $font->id }}";
                    src: url('{{ $font->font_file_url }}');
                    font-display: swap;
                }
            @endforeach

            .font-row { border-bottom: 1px solid #eee; padding: 22px 0; }
            .font-row__label { font-size: 13px; color: #999; margin-bottom: 6px; }
            .font-row__preview {
                font-size: 52px;
                line-height: 1.2;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                color: #1a1a1a;
            }
            .font-toolbar {
                position: sticky;
                bottom: 0;
                z-index: 30;
                background: #fff;
                border-top: 1px solid #e2e2e2;
                box-shadow: 0 -4px 14px rgba(0,0,0,.06);
            }
            .font-toolbar input[type="text"] { border: none; outline: none; box-shadow: none; }
        </style>
    @endif

    {{-- Breadcrumb Section --}}
    <section class="breadcrumb border-bottom p-0 d-block section-bg position-relative z-index-1">
        <div class="breadcrumb-two">
            <img src="{{ asset('frontend/assets/images/gradients/breadcrumb-gradient-bg.png') }}" alt="" class="bg--gradient">
            <div class="container container-two">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="breadcrumb-two-content text-center">

                            <ul class="breadcrumb-list flx-align gap-2 mb-2 justify-content-center">
                                <li class="breadcrumb-list__item font-14 text-body">
                                    <a href="{{ route('index') }}" class="breadcrumb-list__link text-body hover-text-main">Home</a>
                                </li>
                                <li class="breadcrumb-list__item font-14 text-body">
                                    <span class="breadcrumb-list__icon font-10"><i class="fas fa-chevron-right"></i></span>
                                </li>
                                <li class="breadcrumb-list__item font-14 text-body">
                                    <span class="breadcrumb-list__text">Fonts</span>
                                </li>
                            </ul>
                            <h3 class="breadcrumb-two-content__title mb-0 text-capitalize">Fonts</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-4 border-bottom">
        <div class="container container-two">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <form action="{{ route('fonts.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search fonts by name..." value="{{ request('q') }}">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                    @if (request('q'))
                        <p class="mt-2 mb-0 text-muted text-center small">
                            {{ $fonts->total() }} result(s) for "<strong>{{ request('q') }}</strong>"
                            — <a href="{{ route('fonts.index') }}">clear</a>
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- Font List --}}
    <section class="py-3">
        <div class="container container-two">

            @php
                $__authUser = Auth::guard('user')->user();
                $__canDownloadFonts = $__authUser && $__authUser->role === 'customer' && $__authUser->payment_status === 'approved';
            @endphp

            @forelse ($fonts as $font)
                <div class="font-row d-flex justify-content-between align-items-center">
                    <a href="{{ route('fonts.download', $font->slug) }}" class="text-decoration-none text-dark flex-grow-1 me-3" style="min-width:0;">
                        <div class="font-row__label">{{ $font->name }}</div>
                        <div class="font-row__preview js-font-preview" style="font-family:'font-preview-{{ $font->id }}', sans-serif;">
                            {{ $font->name }}
                        </div>
                    </a>

                    @if ($__canDownloadFonts)
                        <a href="{{ route('fonts.download', $font->slug) }}" class="btn btn-main pill flex-shrink-0">
                            <i class="fas fa-download me-1"></i> Download
                        </a>
                    @elseif ($__authUser)
                        <a href="{{ route('customer.payment') }}" class="btn btn-main pill flex-shrink-0">
                            <i class="fas fa-lock me-1"></i> Unlock
                        </a>
                    @else
                        <a href="{{ route('customer.login') }}" class="btn btn-outline-main pill flex-shrink-0">
                            <i class="fas fa-lock me-1"></i> Login to Download
                        </a>
                    @endif
                </div>
            @empty
                <div class="text-center py-5">
                    <p class="text-muted fs-5">No fonts found @if (request('q')) for "{{ request('q') }}" @endif.</p>
                </div>
            @endforelse

            <div class="mt-4 mb-5">
                {{ $fonts->links() }}
            </div>

        </div>
    </section>

    @if ($fonts->count())
        {{-- Sticky preview toolbar — type your own text / change size, all rows update live --}}
        <div class="font-toolbar py-2">
            <div class="container container-two">
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <input type="text" id="js-preview-text" class="form-control flex-grow-1" placeholder="Type your own text to preview it in every font above..." style="min-width:220px;">
                    <select id="js-preview-size" class="form-select" style="width:auto;">
                        <option value="24">24px</option>
                        <option value="36">36px</option>
                        <option value="52" selected>52px</option>
                        <option value="72">72px</option>
                        <option value="96">96px</option>
                    </select>
                </div>
            </div>
        </div>

        <script>
            (function () {
                const textInput = document.getElementById('js-preview-text');
                const sizeSelect = document.getElementById('js-preview-size');
                const previews = document.querySelectorAll('.js-font-preview');

                textInput.addEventListener('input', function () {
                    const val = this.value.trim();
                    previews.forEach(function (el) {
                        el.textContent = val !== '' ? val : el.closest('.font-row').querySelector('.font-row__label').textContent;
                    });
                });

                sizeSelect.addEventListener('change', function () {
                    previews.forEach(function (el) {
                        el.style.fontSize = this.value + 'px';
                    }.bind(this));
                });
            })();
        </script>
    @endif

@endsection