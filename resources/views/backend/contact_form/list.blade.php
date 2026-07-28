@extends('admin.dashboard')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            {{-- Breadcrumb --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Contact Form List</h4>
                        <div class="page-title-right d-flex gap-2">
                            {{-- Bulk Delete Button --}}
                            <form id="bulkDeleteForm" action="{{ route('backend.contact_form.bulk_delete') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger waves-effect waves-light" onclick="return confirm('Are you sure you want to delete the selected contact forms?')">
                                    <i class="bx bx-trash me-1"></i> Delete Selected
                                </button>
                            </form>

                            <a href="javascript:history.back()" class="btn btn-sm btn-outline-dark waves-effect waves-light">
                                <i class="bx bx-undo font-size-16 align-middle me-2"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Contact Form Table --}}
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
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($contact_form_list as $item)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" name="ids[]" value="{{ $item->id }}" class="selectItem">
                                                    </td>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->contact_form_name }}</td>
                                                    <td>{{ $item->contact_form_email }}</td>
                                                    <td>{{ $item->contact_form_phone }}</td>
                                                    <td>
                                                        {{-- View btn --}}
                                                        <a href="#" class="btn btn-sm btn-outline-warning waves-effect waves-light mb-2" data-bs-toggle="modal" data-bs-target="#contactFormModal{{ $item->id }}">
                                                            <i class="bx bx-show font-size-16 align-middle"></i>
                                                        </a>

                                                        {{-- Delete btn --}}
                                                        <a href="{{ route('backend.contact_form.delete', $item->id) }}" onclick="return confirm('Are you sure you want to delete this contact form?');" class="btn btn-sm btn-outline-danger waves-effect waves-light mb-2">
                                                            <i class="bx bxs-trash font-size-16 align-middle"></i>
                                                        </a>
                                                    </td>
                                                </tr>

                                                {{-- Modal --}}
                                                <div class="modal fade" id="contactFormModal{{ $item->id }}" tabindex="-1" aria-labelledby="contactFormModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="contactFormModalLabel">Contact Form Details</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-md-6 mb-3"><strong>Name:</strong> {{ $item->contact_form_name }}</div>
                                                                    <div class="col-md-6 mb-3"><strong>Email:</strong> {{ $item->contact_form_email }}</div>
                                                                    <div class="col-md-6 mb-3"><strong>Phone:</strong> {{ $item->contact_form_phone }}</div>
                                                                    <div class="col-md-6 mb-3"><strong>Subject:</strong> {{ $item->contact_form_subject }}</div>
                                                                    <div class="col-12 mb-3"><strong>Message:</strong><br>{{ $item->contact_form_message }}</div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
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
                alert('Please select at least one contact form to delete.');
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
