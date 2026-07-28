@extends('admin.dashboard')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Category List</h4>
                        <div class="page-title-right">
                            <a href="{{ route('backend.categories.add') }}" class="btn btn-sm btn-outline-primary">
                                <i class="bx bx-plus font-size-16 align-middle me-2"></i> Add Category
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
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Image</th>
                                            <th>Category Name</th>
                                            <th>Parent</th>
                                            <th>Sort</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categories as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <img src="{{ $item->image ? url('upload/category_images/' . $item->image) : url('upload/no_image.jpg') }}" style="width:55px;height:55px;object-fit:cover;border-radius:6px;">
                                                </td>
                                                <td>
                                                    {{-- Show indentation based on depth --}}
                                                    @if ($item->parent_id)
                                                        @php
                                                            $depth = 0;
                                                            $node = $item;
                                                            while ($node->parent_id) {
                                                                $depth++;
                                                                $node = $categories->firstWhere('id', $node->parent_id);
                                                                if (!$node) {
                                                                    break;
                                                                }
                                                            }
                                                        @endphp
                                                        <span style="padding-left: {{ $depth * 20 }}px; color:#aaa;">
                                                            @for ($d = 0; $d < $depth; $d++)
                                                                @if ($d === $depth - 1)
                                                                    <i class="bx bx-subdirectory-right me-1"></i>
                                                                @endif
                                                            @endfor
                                                        </span>
                                                    @endif
                                                    <strong>{{ $item->name }}</strong>
                                                </td>
                                                <td>
                                                    @if ($item->parent)
                                                        <span class="badge bg-light text-dark border">{{ $item->parent->name }}</span>
                                                    @else
                                                        <span class="text-muted">—</span>
                                                    @endif
                                                </td>
                                                <td>{{ $item->sort_order }}</td>
                                                <td>
                                                    <span class="badge {{ $item->status == 'active' ? 'text-bg-success' : 'text-bg-danger' }}" data-id="{{ $item->id }}" data-model="{{ \App\Models\Category::class }}">
                                                        {{ ucfirst($item->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    {{-- Status Dropdown --}}
                                                    <div class="btn-group mb-1">
                                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                                            Status
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a class="dropdown-item js-update-status" href="#" data-id="{{ $item->id }}" data-status="active" data-model="{{ \App\Models\Category::class }}" data-column="status">
                                                                    Active
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item js-update-status" href="#" data-id="{{ $item->id }}" data-status="inactive" data-model="{{ \App\Models\Category::class }}" data-column="status">
                                                                    Inactive
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                    {{-- Edit --}}
                                                    <a href="{{ route('backend.categories.edit', $item->id) }}" class="btn btn-sm btn-outline-info mb-1">
                                                        <i class="bx bx-edit"></i>
                                                    </a>

                                                    {{-- Delete --}}
                                                    <a href="{{ route('backend.categories.delete', $item->id) }}" onclick="return confirm('Delete \'{{ $item->name }}\'? This may affect products and child categories.')" class="btn btn-sm btn-outline-danger mb-1">
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
