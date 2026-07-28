@extends('admin.dashboard')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            {{-- Breadcrumb --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Product Review List</h4>
                        <div class="page-title-right d-flex gap-2">
                            {{-- Bulk Delete --}}
                            <form id="bulkDeleteForm" action="{{ route('product_review.bulk_delete') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger waves-effect waves-light" onclick="return confirm('Are you sure you want to delete the selected reviews?')">
                                    <i class="bx bx-trash me-1"></i> Delete Selected
                                </button>
                            </form>

                            <a href="javascript:history.back()" class="btn btn-outline-dark waves-effect waves-light">
                                <i class="bx bx-undo font-size-16 align-middle me-2"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle w-100">
                                    <thead class="table-light">
                                        <tr>
                                            <th><input type="checkbox" id="selectAll"></th>
                                            <th>S/N</th>
                                            <th>Product Image</th>
                                            <th>Product Name</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($product_review_list as $item)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="ids[]" value="{{ $item->id }}" class="selectItem">
                                                </td>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <img src="{{ $item->product && $item->product->product_image ? url('upload/product_image/' . $item->product->product_image) : url('upload/no_image.jpg') }}" alt="Product Image" class="img-fluid d-block" style="width: 80px;">
                                                </td>
                                                <td>{{ $item->product ? Str::limit($item->product->product_name, 40) : '-' }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>{{ $item->phone ?? '-' }}</td>
                                                <td>
                                                    <span class="badge review-status-badge {{ $item->status == 'accept' ? 'bg-success' : ($item->status == 'pending' ? 'bg-warning' : 'bg-danger') }}" data-id="{{ $item->id }}">
                                                        {{ ucfirst($item->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    {{-- Status Dropdown --}}
                                                    <div class="btn-group me-2 mb-2">
                                                        <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                                            <i class="fas fa-sync"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            @foreach (['accept', 'pending', 'reject'] as $statusOption)
                                                                <li>
                                                                    <a href="javascript:void(0);" class="dropdown-item js-update-review-status" data-id="{{ $item->id }}" data-status="{{ $statusOption }}">
                                                                        {{ ucfirst($statusOption) }}
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>

                                                    {{-- View --}}
                                                    <a href="#" class="btn btn-outline-warning waves-effect waves-light mb-2" data-bs-toggle="modal" data-bs-target="#productReviewModal{{ $item->id }}">
                                                        <i class="bx bx-show font-size-16 align-middle"></i>
                                                    </a>

                                                    {{-- Delete --}}
                                                    <a href="{{ route('product_review.delete', $item->id) }}" onclick="return confirm('Are you sure you want to delete this review?');" class="btn btn-outline-danger waves-effect waves-light mb-2">
                                                        <i class="bx bxs-trash font-size-16 align-middle"></i>
                                                    </a>
                                                </td>
                                            </tr>

                                            {{-- Modal --}}
                                            <div class="modal fade" id="productReviewModal{{ $item->id }}" tabindex="-1" aria-labelledby="productReviewModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Product Review Details</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-12 mb-3">
                                                                    <img src="{{ $item->product && $item->product->product_image ? url('upload/product_image/' . $item->product->product_image) : url('upload/no_image.jpg') }}" class="img-fluid d-block" style="width: 200px">
                                                                </div>
                                                                <div class="col-md-12 mb-3"><strong>Product Name:</strong> {{ $item->product ? $item->product->product_name : '-' }}</div>
                                                                <div class="col-md-6 mb-3"><strong>Name:</strong> {{ $item->name }}</div>
                                                                <div class="col-md-6 mb-3"><strong>Email:</strong> {{ $item->email }}</div>
                                                                <div class="col-md-6 mb-3"><strong>Phone:</strong> {{ $item->phone ?? '-' }}</div>
                                                                <div class="col-md-6 mb-3">
                                                                    <strong>Status:</strong>
                                                                    <span class="badge modal-review-status-badge {{ $item->status == 'accept' ? 'bg-success' : ($item->status == 'pending' ? 'bg-warning' : 'bg-danger') }}" data-id="{{ $item->id }}">
                                                                        {{ ucfirst($item->status) }}
                                                                    </span>
                                                                </div>
                                                                <div class="col-md-12 mb-3"><strong>Rating:</strong>
                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                        <i class="fa fa-star {{ $i <= $item->rating ? 'text-warning' : 'text-secondary' }}"></i>
                                                                    @endfor
                                                                </div>
                                                                <div class="col-12 mb-3"><strong>Comment:</strong><br>{!! $item->comment !!}</div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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

    {{-- Bulk Delete --}}
    <script>
        document.getElementById('selectAll').addEventListener('click', function(e) {
            document.querySelectorAll('.selectItem').forEach(cb => cb.checked = e.target.checked);
        });

        document.getElementById('bulkDeleteForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const selected = document.querySelectorAll('.selectItem:checked');
            if (selected.length === 0) {
                alert('Please select at least one review.');
                return;
            }
            selected.forEach(cb => {
                let input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = cb.value;
                this.appendChild(input);
            });
            this.submit();
        });
    </script>

    {{-- Status Update --}}
    <script>
        document.querySelectorAll('.js-update-review-status').forEach(btn => {
            btn.addEventListener('click', function() {
                let id = this.dataset.id;
                let status = this.dataset.status;

                fetch("{{ route('product_review.update_status') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            id,
                            status
                        })
                    })
                    .then(res => res.json())
                    .then(res => {
                        if (res.success) {
                            // ✅ Update table badge
                            const tableBadge = document.querySelector('.review-status-badge[data-id="' + id + '"]');
                            tableBadge.textContent = res.status.charAt(0).toUpperCase() + res.status.slice(1);
                            tableBadge.classList.remove('bg-success', 'bg-warning', 'bg-danger');
                            if (res.status === 'accept') tableBadge.classList.add('bg-success');
                            else if (res.status === 'pending') tableBadge.classList.add('bg-warning');
                            else tableBadge.classList.add('bg-danger');

                            // ✅ Update modal badge if modal exists
                            const modalBadge = document.querySelector('.modal-review-status-badge[data-id="' + id + '"]');
                            if (modalBadge) {
                                modalBadge.textContent = res.status.charAt(0).toUpperCase() + res.status.slice(1);
                                modalBadge.classList.remove('bg-success', 'bg-warning', 'bg-danger');
                                if (res.status === 'accept') modalBadge.classList.add('bg-success');
                                else if (res.status === 'pending') modalBadge.classList.add('bg-warning');
                                else modalBadge.classList.add('bg-danger');
                            }
                        } else {
                            alert(res.message);
                        }
                    })
                    .catch(err => console.error(err));
            });
        });
    </script>
@endsection
