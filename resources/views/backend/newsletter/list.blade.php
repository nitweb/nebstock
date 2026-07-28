@extends('admin.dashboard')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            {{-- Breadcrumb --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">
                            Newsletter Subscribers
                            <span class="badge bg-primary ms-2">{{ $newsletters->total() }}</span>
                        </h4>
                        <div class="page-title-right d-flex gap-2">

                            {{-- Bulk Delete --}}
                            <button id="bulkDeleteBtn" class="btn btn-sm btn-outline-danger waves-effect waves-light" style="display:none;" onclick="confirmBulkDelete()">
                                <i class="bx bx-trash me-1"></i> Delete Selected
                            </button>

                            {{-- Export CSV --}}
                            <a href="{{ route('backend.newsletter.export') }}" class="btn btn-sm btn-outline-success waves-effect waves-light">
                                <i class="bx bx-file me-1"></i> Export Excel
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
                                <table id="newsletter-table" class="table table-bordered align-middle w-100">
                                    <thead>
                                        <tr>
                                            <th style="width:40px;">
                                                <input type="checkbox" id="selectAll" title="Select All">
                                            </th>
                                            <th>S/N</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Subscribed At</th>
                                            <th style="width:100px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($newsletters as $index => $item)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="selectItem" value="{{ $item->id }}">
                                                </td>
                                                <td>{{ $newsletters->firstItem() + $index }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>
                                                    <button class="btn btn-sm toggle-status-btn {{ $item->status === 'active' ? 'btn-success' : 'btn-secondary' }}" data-id="{{ $item->id }}">
                                                        {{ $item->status === 'active' ? 'Subscribed' : 'Unsubscribed' }}
                                                    </button>
                                                </td>
                                                <td>
                                                    {{ $item->subscribed_at ? $item->subscribed_at->format('d M Y, h:i A') : '—' }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('backend.newsletter.delete', $item->id) }}" onclick="return confirm('Are you sure you want to delete this subscriber?')" class="btn btn-sm btn-outline-danger waves-effect waves-light">
                                                        <i class="bx bxs-trash font-size-16 align-middle"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            {{-- Empty: let DataTables handle the empty state message --}}
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{-- Pagination --}}
                            <div class="mt-3">
                                {{ $newsletters->links() }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        // Initialize DataTable
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#newsletter-table')) {
                $('#newsletter-table').DataTable().destroy();
            }

            $('#newsletter-table').DataTable({
                paging: false, // We use Laravel pagination, so disable DataTables pagination
                searching: true,
                ordering: true,
                info: false,
                language: {
                    emptyTable: 'No subscribers found.',
                    search: 'Search:',
                },
                columnDefs: [{
                        orderable: false,
                        searchable: false,
                        targets: [0, 3, 5]
                    }, // checkbox, status, action
                ],
            });
        });

        // Select All
        document.getElementById('selectAll').addEventListener('change', function() {
            document.querySelectorAll('.selectItem').forEach(cb => cb.checked = this.checked);
            toggleBulkBtn();
        });

        document.querySelectorAll('.selectItem').forEach(cb => {
            cb.addEventListener('change', toggleBulkBtn);
        });

        function toggleBulkBtn() {
            const anyChecked = [...document.querySelectorAll('.selectItem')].some(cb => cb.checked);
            document.getElementById('bulkDeleteBtn').style.display = anyChecked ? 'inline-flex' : 'none';
        }

        // Bulk Delete
        function confirmBulkDelete() {
            const ids = [...document.querySelectorAll('.selectItem:checked')].map(cb => cb.value);

            if (!ids.length) {
                alert('Please select at least one subscriber.');
                return;
            }

            if (!confirm('Are you sure you want to delete the selected subscribers?')) return;

            fetch('{{ route('backend.newsletter.bulk_delete') }}', {
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
                    if (data.success) location.reload();
                    else alert(data.message || 'Something went wrong.');
                })
                .catch(() => alert('Network error. Please try again.'));
        }

        // Toggle Newsletter Status
        document.addEventListener('click', async function(e) {
            const btn = e.target.closest('.toggle-status-btn');
            if (!btn) return;

            const id = btn.dataset.id;
            btn.disabled = true;

            try {
                const response = await fetch('{{ route('backend.newsletter.toggle_status') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        id
                    }),
                });

                const data = await response.json();

                if (data.success) {
                    toastr.clear();
                    toastr.success(data.message);

                    if (data.status === 'active') {
                        btn.classList.remove('btn-secondary');
                        btn.classList.add('btn-success');
                        btn.innerText = 'Active';
                    } else {
                        btn.classList.remove('btn-success');
                        btn.classList.add('btn-secondary');
                        btn.innerText = 'Unsubscribed';
                    }
                } else {
                    toastr.error(data.message || 'Something went wrong.');
                }

            } catch (error) {
                toastr.error('Network error. Please try again.');
            } finally {
                btn.disabled = false;
            }
        });
    </script>
@endsection
