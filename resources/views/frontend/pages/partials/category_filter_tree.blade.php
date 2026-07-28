@php
    $depthClass = match ($depth) {
        0 => '',
        1 => 'cat-filter-child',
        default => 'cat-filter-grand',
    };
@endphp

@foreach ($categories as $cat)
    <li class="widget__categories--sub__menu--list {{ $depthClass }} {{ $cat->recursiveChildren->isNotEmpty() ? 'has-children' : '' }}">

        <div class="d-flex align-items-center justify-content-between cat-toggle">

            <a class="widget__categories--sub__menu--link d-flex align-items-center flex-grow-1" href="#" data-cat-slug="{{ $cat->slug }}">

                @if ($depth === 0)
                    <img class="widget__categories--sub__menu--img" src="{{ $cat->image ? url('upload/category_images/' . $cat->image) : asset('upload/no_image.jpg') }}" alt="{{ $cat->name }}">
                @else
                    <span style="width:8px;height:8px;border-radius:50%;background:#ccc;display:inline-block;flex-shrink:0;margin-right:8px;"></span>
                @endif

                <span class="widget__categories--sub__menu--text">{{ $cat->name }}</span>
            </a>

            {{-- Arrow --}}
            @if ($cat->recursiveChildren->isNotEmpty())
                <span class="cat-arrow">›</span>
            @endif

        </div>

        {{-- Children --}}
        @if ($cat->recursiveChildren->isNotEmpty())
            <ul class="widget__categories--menu cat-children" style="padding-left:{{ ($depth + 1) * 14 }}px;list-style:none;margin:0;">

                @include('frontend.pages.partials.category_filter_tree', [
                    'categories' => $cat->recursiveChildren,
                    'depth' => $depth + 1,
                ])
            </ul>
        @endif

    </li>
@endforeach
