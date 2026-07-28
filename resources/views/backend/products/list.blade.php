@extends('admin.dashboard')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Product List</h4>
                        <div class="page-title-right">
                            <a href="{{ route('backend.products.add') }}" class="btn btn-sm btn-outline-primary waves-effect waves-light">
                                <i class="bx bx-plus font-size-16 align-middle me-2"></i> Add Product
                            </a>
                            <a href="javascript:history.back()" class="btn btn-sm btn-outline-dark">
                                <i class="bx bx-undo font-size-16 align-middle me-2"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable-buttons" class="table table-bordered w-100">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Cover</th>
                                            <th>Product Name</th>
                                            <th>Type</th>
                                            <th>Authors / Info</th>
                                            <th>Categories</th>
                                            <th>Price</th>
                                            <th>Stock</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>

                                                {{-- Cover --}}
                                                <td>
                                                    <img src="{{ $item->cover_image ? url('upload/product_covers/' . $item->cover_image) : url('upload/no_image.jpg') }}" alt="cover" style="height:70px;width:55px;object-fit:cover;border-radius:4px;">
                                                </td>

                                                {{-- ── Product Name ─────────────────────────────── --}}
                                                <td>
                                                    <strong>{{ $item->name }}</strong>

                                                    @if ($item->is_featured)
                                                        <span class="badge bg-warning text-dark ms-1">Featured</span>
                                                    @endif

                                                    @if (($item->product_mode ?? 'selling') === 'affiliate')
                                                        <span class="badge bg-info ms-1">Affiliate</span>
                                                    @endif

                                                    {{-- ▶ PRE-ORDER BADGE (NEW) --}}
                                                    @if ($item->is_pre_order)
                                                        <span class="badge bg-warning text-dark ms-1" title="{{ $item->pre_order_label }}">
                                                            <i class="bx bx-time-five"></i> Pre-order
                                                        </span>
                                                    @endif

                                                    @if ($item->sku)
                                                        <br><small class="text-muted">SKU: {{ $item->sku }}</small>
                                                    @endif

                                                    {{-- Pre-order date hint --}}
                                                    @if ($item->is_pre_order && $item->pre_order_date)
                                                        <br>
                                                        <small class="text-warning">
                                                            <i class="bx bx-calendar me-1"></i>
                                                            Ships: {{ $item->pre_order_date->format('d M Y') }}
                                                        </small>
                                                    @endif
                                                </td>

                                                {{-- Product Type Badge --}}
                                                <td>
                                                    <span class="badge bg-dark text-capitalize">
                                                        {{ $item->product_type_label ?? ucfirst($item->product_type ?? 'book') }}
                                                    </span>
                                                </td>

                                                {{-- Authors / Variants --}}
                                                <td>
                                                    @if (in_array($item->product_type ?? 'book', ['book']))
                                                        @foreach ($item->authors as $author)
                                                            <span class="badge bg-info me-1">{{ $author->name }}</span>
                                                        @endforeach
                                                    @elseif (in_array($item->product_type, ['clothing', 'hat']))
                                                        @php $variantCount = $item->variants->count(); @endphp
                                                        <span class="badge bg-light text-dark border">
                                                            {{ $variantCount }} variant{{ $variantCount !== 1 ? 's' : '' }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted">—</span>
                                                    @endif
                                                </td>

                                                {{-- Categories --}}
                                                <td>
                                                    @foreach ($item->categories as $cat)
                                                        <span class="badge bg-secondary me-1">{{ $cat->name }}</span>
                                                    @endforeach
                                                </td>

                                                {{-- Price --}}
                                                <td>
                                                    @if (($item->product_mode ?? 'selling') === 'affiliate')
                                                        @if ($item->affiliate_price)
                                                            <span class="text-info">${{ number_format($item->affiliate_price, 2) }}</span>
                                                        @else
                                                            <span class="text-muted">—</span>
                                                        @endif
                                                        <br><small class="text-muted">Affiliate</small>
                                                    @elseif ($item->discount_price)
                                                        <span class="text-decoration-line-through text-muted small">${{ number_format($item->price, 2) }}</span><br>
                                                        <strong class="text-success">${{ number_format($item->discount_price, 2) }}</strong>
                                                    @else
                                                        ${{ number_format($item->price, 2) }}
                                                    @endif
                                                </td>

                                                {{-- ── Stock ──────────────────────────────────── --}}
                                                <td>
                                                    @if (($item->product_mode ?? 'selling') === 'affiliate')
                                                        <span class="badge bg-secondary">N/A</span>
                                                    @elseif ($item->is_pre_order)
                                                        {{-- Pre-order overrides normal stock badge --}}
                                                        <span class="badge bg-warning text-dark">
                                                            <i class="bx bx-time-five"></i> Pre-order
                                                        </span>
                                                    @else
                                                        <span class="badge {{ $item->stock_status == 'in_stock' ? 'bg-success' : 'bg-danger' }}">
                                                            {{ $item->stock_status == 'in_stock' ? 'In Stock' : 'Out of Stock' }}
                                                        </span>
                                                    @endif
                                                </td>

                                                {{-- Status --}}
                                                <td>
                                                    <span class="badge {{ $item->status == 'active' ? 'text-bg-success' : ($item->status == 'draft' ? 'text-bg-warning' : 'text-bg-danger') }}" data-id="{{ $item->id }}" data-model="{{ \App\Models\Product::class }}">
                                                        {{ ucfirst($item->status) }}
                                                    </span>
                                                </td>

                                                {{-- Action --}}
                                                <td>
                                                    <div class="btn-group mb-1">
                                                        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                                            Status
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item js-update-status" href="#" data-id="{{ $item->id }}" data-status="active" data-model="{{ \App\Models\Product::class }}" data-column="status">Active</a></li>
                                                            <li><a class="dropdown-item js-update-status" href="#" data-id="{{ $item->id }}" data-status="inactive" data-model="{{ \App\Models\Product::class }}" data-column="status">Inactive</a></li>
                                                            <li><a class="dropdown-item js-update-status" href="#" data-id="{{ $item->id }}" data-status="draft" data-model="{{ \App\Models\Product::class }}" data-column="status">Draft</a></li>
                                                        </ul>
                                                    </div>

                                                    <a href="{{ route('backend.products.edit', $item->id) }}" class="btn btn-sm btn-outline-info mb-1">
                                                        <i class="bx bx-edit"></i>
                                                    </a>

                                                    @if (($item->product_mode ?? 'selling') === 'affiliate' && $item->affiliate_url)
                                                        <a href="{{ $item->affiliate_url }}" target="_blank" class="btn btn-sm btn-outline-info mb-1" title="Visit Affiliate Link">
                                                            <i class="bx bx-link-external"></i>
                                                        </a>
                                                    @endif

                                                    <a href="{{ route('backend.products.delete', $item->id) }}" onclick="return confirm('Delete this product?')" class="btn btn-sm btn-outline-danger mb-1">
                                                        <i class="bx bxs-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
