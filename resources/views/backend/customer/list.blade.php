@extends('admin.dashboard')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            {{-- Page Title --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">
                            Customers
                            <span class="badge bg-primary ms-2">{{ $customers->total() }}</span>
                        </h4>
                        <div class="page-title-right d-flex gap-2">
                            <button id="bulkDeleteBtn" class="btn btn-sm btn-outline-danger waves-effect waves-light" style="display:none;" onclick="confirmBulkDelete()">
                                <i class="bx bx-trash me-1"></i> Delete Selected
                            </button>
                            <a href="{{ route('backend.customers.add') }}" class="btn btn-sm btn-outline-primary waves-effect waves-light">
                                <i class="bx bx-plus font-size-16 align-middle me-1"></i> Add Customer
                            </a>
                            <a href="javascript:history.back()" class="btn btn-sm btn-outline-dark waves-effect waves-light">
                                <i class="bx bx-undo font-size-16 align-middle me-1"></i> Back
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
                                <table id="customer-table" class="table table-bordered align-middle w-100">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width:40px;">
                                                <input type="checkbox" id="selectAll" title="Select All">
                                            </th>
                                            <th>S/N</th>
                                            <th>Photo</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Status</th>
                                            <th>Joined</th>
                                            <th style="width:130px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($customers as $index => $customer)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="selectItem" value="{{ $customer->id }}">
                                                </td>
                                                <td>{{ $customers->firstItem() + $index }}</td>
                                                <td>
                                                    <img src="{{ asset('upload/customer_images/' . ($customer->photo ?? 'avatar.png')) }}" alt="{{ $customer->name }}" class="rounded-circle" style="width:40px;height:40px;object-fit:cover;">
                                                </td>
                                                <td>
                                                    <strong>{{ $customer->name }}</strong>
                                                    @if ($customer->role === 'guest')
                                                        <span class="badge bg-warning text-dark ms-1" style="font-size:10px;">Guest</span>
                                                    @endif
                                                </td>
                                                <td>{{ $customer->email }}</td>
                                                <td>{{ $customer->phone ?? '—' }}</td>
                                                <td>
                                                    <button class="btn btn-sm toggle-status-btn {{ $customer->status == '1' ? 'btn-success' : 'btn-secondary' }}" data-id="{{ $customer->id }}">
                                                        {{ $customer->status == '1' ? 'Active' : 'Inactive' }}
                                                    </button>
                                                </td>
                                                <td>{{ $customer->created_at->format('d M Y') }}</td>
                                                <td>
                                                    <div class="d-flex gap-1">
                                                        {{-- Detail --}}
                                                        <a href="{{ route('backend.customers.detail', $customer->id) }}" class="btn btn-sm btn-outline-info waves-effect" title="View Orders">
                                                            <i class="bx bx-show font-size-16 align-middle"></i>
                                                        </a>
                                                        {{-- Edit --}}
                                                        <a href="{{ route('backend.customers.edit', $customer->id) }}" class="btn btn-sm btn-outline-warning waves-effect" title="Edit">
                                                            <i class="bx bx-edit font-size-16 align-middle"></i>
                                                        </a>
                                                        {{-- Delete --}}
                                                        <a href="{{ route('backend.customers.delete', $customer->id) }}" onclick="return confirm('Delete this customer?')" class="btn btn-sm btn-outline-danger waves-effect" title="Delete">
                                                            <i class="bx bxs-trash font-size-16 align-middle"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3">
                                {{ $customers->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#customer-table')) {
                $('#customer-table').DataTable().destroy();
            }
            $('#customer-table').DataTable({
                paging: false,
                searching: true,
                ordering: true,
                info: false,
                language: {
                    emptyTable: 'No customers found.',
                    search: 'Search:',
                },
                columnDefs: [{
                    orderable: false,
                    searchable: false,
                    targets: [0, 2, 6, 8]
                }],
            });
        });

        // Select All
        document.getElementById('selectAll').addEventListener('change', function() {
            document.querySelectorAll('.selectItem').forEach(cb => cb.checked = this.checked);
            toggleBulkBtn();
        });
        document.querySelectorAll('.selectItem').forEach(cb => cb.addEventListener('change', toggleBulkBtn));

        function toggleBulkBtn() {
            const any = [...document.querySelectorAll('.selectItem')].some(cb => cb.checked);
            document.getElementById('bulkDeleteBtn').style.display = any ? 'inline-flex' : 'none';
        }

        // Bulk Delete
        function confirmBulkDelete() {
            const ids = [...document.querySelectorAll('.selectItem:checked')].map(cb => cb.value);
            if (!ids.length) return alert('Please select at least one customer.');
            if (!confirm('Delete selected customers? This cannot be undone.')) return;

            fetch('{{ route('backend.customers.bulk_delete') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        ids
                    }),
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        toastr.success(data.message);
                        setTimeout(() => location.reload(), 800);
                    } else {
                        toastr.error(data.message || 'Something went wrong.');
                    }
                })
                .catch(() => toastr.error('Network error.'));
        }

        // Toggle Status
        document.addEventListener('click', async function(e) {
            const btn = e.target.closest('.toggle-status-btn');
            if (!btn) return;
            btn.disabled = true;

            try {
                const res = await fetch('{{ route('backend.customers.toggle_status') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        id: btn.dataset.id
                    }),
                });
                const data = await res.json();

                if (data.success) {
                    toastr.success(data.message);
                    if (data.status == '1') {
                        btn.classList.replace('btn-secondary', 'btn-success');
                        btn.innerText = 'Active';
                    } else {
                        btn.classList.replace('btn-success', 'btn-secondary');
                        btn.innerText = 'Inactive';
                    }
                } else {
                    toastr.error(data.message || 'Something went wrong.');
                }
            } catch {
                toastr.error('Network error.');
            } finally {
                btn.disabled = false;
            }
        });
    </script>
@endsection
