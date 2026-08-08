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
                                            <th>Categories</th>
                                            <th>File</th>
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

                                                {{-- Product Name --}}
                                                <td>
                                                    <strong>{{ $item->name }}</strong>
                                                </td>

                                                {{-- Categories --}}
                                                <td>
                                                    @foreach ($item->categories as $cat)
                                                        <span class="badge bg-secondary me-1">{{ $cat->name }}</span>
                                                    @endforeach
                                                </td>

                                                {{-- File --}}
                                                <td>
                                                    @if ($item->pdf_file)
                                                        <a href="{{ url('upload/product_pdfs/' . $item->pdf_file) }}" target="_blank" class="badge bg-success text-decoration-none">
                                                            <i class="bx bx-file"></i> View
                                                        </a>
                                                    @else
                                                        <span class="badge bg-danger">Missing</span>
                                                    @endif
                                                </td>

                                                {{-- Status --}}
                                                <td>
                                                    <span class="badge {{ $item->status == 'active' ? 'text-bg-success' : 'text-bg-danger' }}" data-id="{{ $item->id }}" data-model="{{ \App\Models\Product::class }}">
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
                                                        </ul>
                                                    </div>

                                                    <a href="{{ route('backend.products.edit', $item->id) }}" class="btn btn-sm btn-outline-info mb-1">
                                                        <i class="bx bx-edit"></i>
                                                    </a>

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