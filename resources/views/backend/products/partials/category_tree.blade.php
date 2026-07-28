@foreach ($categories as $cat)
    <div class="form-check" style="padding-left: {{ $depth * 16 + 20 }}px;">
        <input class="form-check-input" type="checkbox" name="category_ids[]" value="{{ $cat->id }}" id="cat_{{ $cat->id }}" {{ in_array($cat->id, $selectedCats) ? 'checked' : '' }}>
        <label class="form-check-label {{ $depth === 0 ? 'fw-semibold' : '' }}" for="cat_{{ $cat->id }}">
            @if ($depth > 0)
                <span class="text-muted me-1">{{ str_repeat('↳', 1) }}</span>
            @endif
            {{ $cat->name }}
        </label>
    </div>

    {{-- Recurse into children --}}
    @if ($cat->recursiveChildren->isNotEmpty())
        @include('backend.products.partials.category_tree', [
            'categories' => $cat->recursiveChildren,
            'depth' => $depth + 1,
            'selectedCats' => $selectedCats,
        ])
    @endif
@endforeach
