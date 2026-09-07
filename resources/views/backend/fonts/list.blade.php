@extends('admin.dashboard')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Font List</h4>
                        <div class="page-title-right">
                            <a href="{{ route('backend.fonts.add') }}" class="btn btn-sm btn-outline-primary">
                                <i class="bx bx-plus font-size-16 align-middle me-2"></i> Add Font
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
                                            <th>Preview</th>
                                            <th>Font Name</th>
                                            <th>File</th>
                                            <th>License</th>
                                            <th>Downloads</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($fonts as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <img src="{{ $item->preview_image_url }}" style="width:70px;height:40px;object-fit:cover;border-radius:4px;">
                                                </td>
                                                <td>
                                                    <strong>{{ $item->name }}</strong>
                                                    @if ($item->is_featured)
                                                        <span class="badge bg-warning text-dark">Featured</span>
                                                    @endif
                                                </td>
                                                <td><code>{{ $item->font_file }}</code></td>
                                                <td><span class="badge bg-light text-dark border">{{ ucfirst(str_replace('_', ' ', $item->license)) }}</span></td>
                                                <td>{{ $item->downloads_count }}</td>
                                                <td>
                                                    <span class="badge {{ $item->status == 'active' ? 'text-bg-success' : 'text-bg-danger' }}" data-id="{{ $item->id }}" data-model="{{ \App\Models\Font::class }}">
                                                        {{ ucfirst($item->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group mb-1">
                                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                                            Status
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a class="dropdown-item js-update-status" href="#" data-id="{{ $item->id }}" data-status="active" data-model="{{ \App\Models\Font::class }}" data-column="status">
                                                                    Active
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item js-update-status" href="#" data-id="{{ $item->id }}" data-status="inactive" data-model="{{ \App\Models\Font::class }}" data-column="status">
                                                                    Inactive
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                    <a href="{{ route('backend.fonts.edit', $item->id) }}" class="btn btn-sm btn-outline-info mb-1">
                                                        <i class="bx bx-edit"></i>
                                                    </a>

                                                    <a href="{{ route('backend.fonts.delete', $item->id) }}" onclick="return confirm('Delete \'{{ $item->name }}\'?')" class="btn btn-sm btn-outline-danger mb-1">
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
