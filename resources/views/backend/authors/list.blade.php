@extends('admin.dashboard')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Author List</h4>
                        <div class="page-title-right">
                            <a href="{{ route('backend.authors.add') }}" class="btn btn-sm btn-outline-primary">
                                <i class="bx bx-plus font-size-16 align-middle me-2"></i> Add Author
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
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Slug</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($authors as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <img src="{{ $item->image ? url('upload/author_images/' . $item->image) : url('upload/no_image.jpg') }}" style="width:55px;height:55px;object-fit:cover;border-radius:50%;border:2px solid #eee;">
                                                </td>
                                                <td>{{ $item->name }}</td>
                                                <td><code>{{ $item->slug }}</code></td>
                                                <td>
                                                    <span class="badge {{ $item->status == 'active' ? 'text-bg-success' : 'text-bg-danger' }}" data-id="{{ $item->id }}" data-model="{{ \App\Models\Author::class }}">
                                                        {{ ucfirst($item->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group mb-1">
                                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                                            Status
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item js-update-status" href="#" data-id="{{ $item->id }}" data-status="active" data-model="{{ \App\Models\Author::class }}" data-column="status">Active</a></li>
                                                            <li><a class="dropdown-item js-update-status" href="#" data-id="{{ $item->id }}" data-status="inactive" data-model="{{ \App\Models\Author::class }}" data-column="status">Inactive</a></li>
                                                        </ul>
                                                    </div>
                                                    <a href="{{ route('backend.authors.edit', $item->id) }}" class="btn btn-sm btn-outline-info mb-1">
                                                        <i class="bx bx-edit"></i>
                                                    </a>
                                                    <a href="{{ route('backend.authors.delete', $item->id) }}" onclick="return confirm('Delete this author?')" class="btn btn-sm btn-outline-danger mb-1">
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
