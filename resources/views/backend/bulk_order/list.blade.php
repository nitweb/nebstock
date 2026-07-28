@extends('admin.dashboard')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            {{-- Breadcrumb --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Bulk Orders List</h4>
                        <div class="page-title-right d-flex gap-2">
                            {{-- Bulk Delete Button --}}
                            <form id="bulkDeleteForm" action="{{ route('backend.bulk_order.bulk_delete') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger waves-effect waves-light" onclick="return confirm('Are you sure you want to delete the selected bulk orders?')">
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

            {{-- Bulk Order Table --}}
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="table-responsive">
                                <form id="bulkDeleteCheckboxForm">
                                    <table id="datatable-buttons" class="table table-bordered align-middle w-100">
                                        <thead class="table-light">
                                            <tr>
                                                <th>
                                                    <input type="checkbox" id="selectAll">
                                                </th>
                                                <th>S/N</th>
                                                <th>Product</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Quantity</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($bulk_order_list as $item)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" name="ids[]" value="{{ $item->id }}" class="selectItem">
                                                    </td>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td> {{ Str::limit($item->product->product_name ?? 'N/A', 40) }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->email }}</td>
                                                    <td>{{ $item->phone }}</td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td>
                                                        {{-- View --}}
                                                        <a href="#" class="btn btn-outline-warning waves-effect waves-light mb-2" data-bs-toggle="modal" data-bs-target="#bulkOrderModal{{ $item->id }}">
                                                            <i class="bx bx-show font-size-16 align-middle"></i>
                                                        </a>

                                                        {{-- Delete --}}
                                                        <a href="{{ route('backend.bulk_order.delete', $item->id) }}" onclick="return confirm('Are you sure you want to delete this bulk order?');" class="btn btn-outline-danger waves-effect waves-light mb-2">
                                                            <i class="bx bxs-trash font-size-16 align-middle"></i>
                                                        </a>
                                                    </td>
                                                </tr>

                                                {{-- Modal --}}
                                                <div class="modal fade" id="bulkOrderModal{{ $item->id }}" tabindex="-1" aria-labelledby="bulkOrderModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Bulk Order Details</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    {{-- Product Image --}}
                                                                    <div class="col-md-12 text-center mb-4">
                                                                        @if (!empty($item->product->product_image))
                                                                            <img src="{{ !empty($item->product->product_image) ? url('upload/product_image/' . $item->product->product_image) : url('upload/no_image.jpg') }}" alt="{{ $item->product->product_name }}" class="img-fluid rounded shadow-sm" style="max-height: 250px; object-fit: contain;">
                                                                        @else
                                                                            <img src="{{ asset('upload/no_image.jpg') }}" alt="No image" class="img-fluid rounded shadow-sm" style="max-height: 250px; object-fit: contain;">
                                                                        @endif
                                                                    </div>

                                                                    <div class="col-md-12 mb-3"><strong>Product:</strong>
                                                                        {{ $item->product->product_name ?? 'N/A' }}
                                                                    </div>
                                                                    <div class="col-md-6 mb-3"><strong>Name:</strong>
                                                                        {{ $item->name }}
                                                                    </div>
                                                                    <div class="col-md-6 mb-3"><strong>Quantity:</strong>
                                                                        {{ $item->quantity }}
                                                                    </div>
                                                                    <div class="col-md-6 mb-3"><strong>Email:</strong>
                                                                        {{ $item->email }}
                                                                    </div>
                                                                    <div class="col-md-6 mb-3"><strong>Phone:</strong>
                                                                        {{ $item->phone }}
                                                                    </div>
                                                                    <div class="col-12 mb-3"><strong>Message:</strong><br>
                                                                        {{ $item->message ?? 'No message provided.' }}
                                                                    </div>
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
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Bulk Delete Script --}}
    <script>
        document.getElementById('selectAll').addEventListener('click', function(e) {
            let checkboxes = document.querySelectorAll('.selectItem');
            checkboxes.forEach(cb => cb.checked = e.target.checked);
        });

        // Intercept bulk delete form submission to include selected IDs
        document.getElementById('bulkDeleteForm').addEventListener('submit', function(e) {
            e.preventDefault();

            let selected = document.querySelectorAll('.selectItem:checked');
            if (selected.length === 0) {
                alert('Please select at least one bulk order to delete.');
                return;
            }

            // Create hidden inputs dynamically
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
@endsection
