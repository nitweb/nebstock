@extends('admin.dashboard')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            {{-- Breadcrumb --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Slider List</h4>
                        <div class="page-title-right">
                            <a href="{{ route('backend.slider.add') }}" class="btn btn-sm btn-outline-primary waves-effect waves-light">
                                <i class="bx bx-plus font-size-16 align-middle me-2"></i> Add Slider
                            </a>
                            <a href="javascript:history.back()" class="btn btn-sm btn-outline-dark waves-effect waves-light">
                                <i class="bx bx-undo font-size-16 align-middle me-2"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable-buttons" class="table table-bordered w-100">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Slider Image</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($slider_list as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <img src="{{ !empty($item->slider_image) ? url('upload/slider_image/' . $item->slider_image) : url('upload/no_image.jpg') }}" alt="Slider Image" class="img-fluid d-block" style="width: 150px;">
                                                </td>
                                                <td>
                                                    <span class="badge status-badge {{ $item->slider_status == 'active' ? 'text-bg-success' : 'text-bg-danger' }}" data-id="{{ $item->id }}" data-model="{{ \App\Models\Slider::class }}">
                                                        {{ ucfirst($item->slider_status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    {{-- Status Dropdown --}}
                                                    <div class="btn-group" role="group" style="margin-top: -8px;">
                                                        <button type="button" class="btn btn-sm btn-outline-secondary waves-effect waves-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                            Status <i class="mdi mdi-chevron-down"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a class="dropdown-item js-update-status" href="javascript:void(0)" data-id="{{ $item->id }}" data-status="active" data-model="{{ \App\Models\Slider::class }}" data-column="slider_status">
                                                                    Active
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item js-update-status" href="javascript:void(0)" data-id="{{ $item->id }}" data-status="inactive" data-model="{{ \App\Models\Slider::class }}" data-column="slider_status">
                                                                    Inactive
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    {{-- Edit --}}
                                                    <a href="{{ route('backend.slider.edit', $item->id) }}" class="btn btn-sm btn-outline-info waves-effect waves-light mb-2">
                                                        <i class="bx bx-edit font-size-16 align-middle"></i>
                                                    </a>
                                                    {{-- Delete --}}
                                                    <a href="{{ route('backend.slider.delete', $item->id) }}" class="btn btn-sm btn-outline-danger waves-effect waves-light mb-2" onclick="return confirm('Are you sure?')">
                                                        <i class="bx bxs-trash font-size-16 align-middle"></i>
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

    <script>
        document.addEventListener('click', async function(e) {
            const btn = e.target.closest('.js-update-status');
            if (!btn) return;

            const id = btn.dataset.id;
            const status = btn.dataset.status;
            const model = btn.dataset.model;
            const column = btn.dataset.column;

            try {
                const response = await fetch('{{ route('backend.status.update') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        id,
                        status,
                        model,
                        column
                    }),
                });

                const data = await response.json();

                if (data.success) {
                    // Find the badge in the same row and update it — no reload needed
                    const row = btn.closest('tr');
                    const badge = row.querySelector('.status-badge');

                    if (badge) {
                        badge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
                        badge.classList.remove('text-bg-success', 'text-bg-danger');
                        badge.classList.add(status === 'active' ? 'text-bg-success' : 'text-bg-danger');
                    }

                    toastr.success(data.message);
                } else {
                    toastr.error(data.message || 'Failed to update status.');
                }

            } catch (err) {
                toastr.error('Network error. Please try again.');
            }
        });
    </script>
@endsection
