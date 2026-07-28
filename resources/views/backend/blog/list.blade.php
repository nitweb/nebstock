@extends('admin.dashboard')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            {{-- Page Title --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">
                            Blog List
                            @if ($pending_count > 0)
                                <span class="badge bg-warning text-dark ms-2">{{ $pending_count }} Pending</span>
                            @endif
                        </h4>
                        <div class="page-title-right">
                            <a href="{{ route('backend.blog.add') }}" class="btn btn-sm btn-outline-primary waves-effect waves-light">
                                <i class="bx bx-plus font-size-16 align-middle me-2"></i> Add Blog
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
                                            <th>Image</th>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>Submitted By</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($blog_list as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <img src="{{ !empty($item->blog_image) ? url('upload/blog_image/' . $item->blog_image) : url('upload/no_image.jpg') }}" alt="Blog Image" class="img-fluid d-block" style="width:100px;height:66px;object-fit:cover;border-radius:6px;">
                                                </td>
                                                <td style="max-width:220px;">
                                                    <strong>{{ Str::limit($item->blog_title, 60) }}</strong>
                                                </td>
                                                <td>{{ $item->blogCategory->blog_category_name ?? 'No Category' }}</td>
                                                <td>
                                                    @if ($item->submittedBy)
                                                        <div style="font-size:13px;">
                                                            <strong>{{ $item->submittedBy->name }}</strong>
                                                            <div class="text-muted" style="font-size:11px;">{{ $item->submittedBy->email }}</div>
                                                        </div>
                                                    @else
                                                        <span class="text-muted">Admin</span>
                                                    @endif
                                                </td>
                                                <td style="font-size:12.5px;white-space:nowrap;">
                                                    {{ $item->blog_published_date ? \Carbon\Carbon::parse($item->blog_published_date)->format('d M Y') : ($item->submitted_at ? $item->submitted_at->format('d M Y') : '—') }}
                                                </td>
                                                <td>
                                                    <span class="badge {{ $item->blog_status === 'active' ? 'text-bg-success' : ($item->blog_status === 'pending' ? 'text-bg-warning' : ($item->blog_status === 'rejected' ? 'text-bg-danger' : 'text-bg-secondary')) }}" @if ($item->blog_status !== 'pending' && $item->blog_status !== 'rejected') data-id="{{ $item->id }}" data-model="{{ \App\Models\Blog::class }}" @endif>
                                                        {{ ucfirst($item->blog_status) }}
                                                        @if ($item->submitted_by)
                                                            <small style="opacity:.75;"> · User</small>
                                                        @endif
                                                    </span>
                                                </td>
                                                <td>
                                                    @if ($item->blog_status === 'pending')
                                                        <div class="d-flex gap-1 flex-wrap align-items-center">
                                                            <button class="btn btn-sm btn-outline-primary waves-effect view-btn" data-id="{{ $item->id }}" data-title="{{ addslashes($item->blog_title) }}" data-category="{{ $item->blogCategory->blog_category_name ?? 'N/A' }}" data-image="{{ asset('upload/blog_image/' . $item->blog_image) }}" data-short="{{ addslashes($item->blog_short_description ?? '') }}" data-submitted="{{ $item->submittedBy->name ?? 'Admin' }}" data-submitted-email="{{ $item->submittedBy->email ?? '' }}" data-date="{{ $item->submitted_at ? $item->submitted_at->format('d M Y h:i A') : 'N/A' }}" data-tags="{{ $item->blog_tags ?? '' }}" data-status="{{ $item->blog_status }}" title="Preview Blog">
                                                                <i class="bx bx-show font-size-16 align-middle"></i> View
                                                            </button>
                                                            <button class="btn btn-sm btn-success waves-effect approve-btn" data-id="{{ $item->id }}" title="Approve">
                                                                <i class="bx bx-check font-size-16 align-middle"></i> Approve
                                                            </button>
                                                            <button class="btn btn-sm btn-danger waves-effect reject-btn" data-id="{{ $item->id }}" title="Reject">
                                                                <i class="bx bx-x font-size-16 align-middle"></i> Reject
                                                            </button>
                                                            <a href="{{ route('backend.blog.edit', $item->id) }}" class="btn btn-sm btn-outline-info waves-effect" title="Edit">
                                                                <i class="bx bx-edit font-size-16 align-middle"></i>
                                                            </a>
                                                        </div>
                                                    @else
                                                        <div class="d-flex gap-1 flex-wrap align-items-center">
                                                            <div class="btn-group" role="group">
                                                                <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    Status <i class="mdi mdi-chevron-down"></i>
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <a class="dropdown-item js-update-status" href="javascript:void(0)" data-id="{{ $item->id }}" data-status="active" data-model="{{ \App\Models\Blog::class }}" data-column="blog_status">
                                                                            Active
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item js-update-status" href="javascript:void(0)" data-id="{{ $item->id }}" data-status="inactive" data-model="{{ \App\Models\Blog::class }}" data-column="blog_status">
                                                                            Inactive
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <button class="btn btn-sm btn-outline-primary waves-effect view-btn" data-id="{{ $item->id }}" data-title="{{ addslashes($item->blog_title) }}" data-category="{{ $item->blogCategory->blog_category_name ?? 'N/A' }}" data-image="{{ asset('upload/blog_image/' . $item->blog_image) }}" data-short="{{ addslashes($item->blog_short_description ?? '') }}" data-submitted="{{ $item->submittedBy->name ?? 'Admin' }}" data-submitted-email="{{ $item->submittedBy->email ?? '' }}" data-date="{{ $item->submitted_at ? $item->submitted_at->format('d M Y h:i A') : 'N/A' }}" data-tags="{{ $item->blog_tags ?? '' }}" data-status="{{ $item->blog_status }}" title="Preview Blog">
                                                                <i class="bx bx-show font-size-16 align-middle"></i>
                                                            </button>
                                                            <a href="{{ route('backend.blog.edit', $item->id) }}" class="btn btn-sm btn-outline-info waves-effect waves-light" title="Edit">
                                                                <i class="bx bx-edit font-size-16 align-middle"></i>
                                                            </a>
                                                            <a href="{{ route('backend.blog.delete', $item->id) }}" onclick="return confirm('Are you sure you want to delete this blog?')" class="btn btn-sm btn-outline-danger waves-effect waves-light" title="Delete">
                                                                <i class="bx bxs-trash font-size-16 align-middle"></i>
                                                            </a>
                                                        </div>
                                                    @endif
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

    {{-- ═══════════════════════════════════════════════════════════════
         BLOG PREVIEW MODAL
    ═══════════════════════════════════════════════════════════════ --}}
    <div class="modal fade" id="blogPreviewModal" tabindex="-1" aria-labelledby="blogPreviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content" style="border:none;border-radius:16px;overflow:hidden;">

                {{-- Cover Image with overlay header --}}
                <div style="position:relative;width:100%;height:280px;overflow:hidden;background:#1a1a2e;">
                    <img id="preview-image" src="" alt="" style="width:100%;height:100%;object-fit:cover;opacity:0.75;">
                    <div style="position:absolute;inset:0;background:linear-gradient(to bottom, rgba(0,0,0,0.15) 0%, rgba(0,0,0,0.65) 100%);"></div>

                    {{-- Close button on image --}}
                    <button type="button" data-bs-dismiss="modal" aria-label="Close" style="position:absolute;top:16px;right:16px;width:36px;height:36px;border-radius:50%;background:rgba(255,255,255,0.2);border:1px solid rgba(255,255,255,0.35);color:#fff;display:flex;align-items:center;justify-content:center;cursor:pointer;backdrop-filter:blur(4px);transition:background .2s;" onmouseover="this.style.background='rgba(255,255,255,0.35)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'">
                        <i class="bx bx-x" style="font-size:20px;"></i>
                    </button>

                    {{-- Title & meta on image --}}
                    <div style="position:absolute;bottom:0;left:0;right:0;padding:24px 28px 20px;">
                        <div class="d-flex gap-2 flex-wrap align-items-center mb-2">
                            <span id="preview-category" style="background:rgba(255,255,255,0.2);backdrop-filter:blur(6px);color:#fff;border:1px solid rgba(255,255,255,0.3);font-size:11.5px;font-weight:600;padding:3px 10px;border-radius:20px;letter-spacing:.4px;text-transform:uppercase;"></span>
                            <span id="preview-date" style="color:rgba(255,255,255,0.8);font-size:12px;display:flex;align-items:center;gap:4px;">
                                <i class="bx bx-calendar" style="font-size:13px;"></i>
                            </span>
                        </div>
                        <h4 id="preview-title" style="color:#fff;font-size:22px;font-weight:700;line-height:1.35;margin:0;text-shadow:0 1px 4px rgba(0,0,0,.4);"></h4>
                    </div>
                </div>

                {{-- Modal Body --}}
                <div class="modal-body" style="padding:0;">

                    {{-- Submitted by bar --}}
                    <div style="background:#f8f9fa;border-bottom:1px solid #e9ecef;padding:12px 28px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;">
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div id="preview-avatar" style="width:34px;height:34px;border-radius:50%;background:#4f46e5;color:#fff;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:600;flex-shrink:0;"></div>
                            <div>
                                <p id="preview-submitted-by" style="margin:0;font-size:13px;font-weight:600;color:#1a1a1a;"></p>
                                <p id="preview-submitted-email" style="margin:0;font-size:11.5px;color:#6c757d;"></p>
                            </div>
                        </div>
                        <div id="preview-tags-wrap" style="display:flex;flex-wrap:wrap;gap:5px;"></div>
                    </div>

                    <div style="padding:24px 28px 28px;">

                        {{-- Short description --}}
                        <div id="preview-short-wrap" style="display:none;margin-bottom:20px;">
                            <div style="background:#fffbeb;border-left:4px solid #f59e0b;border-radius:0 8px 8px 0;padding:12px 16px;">
                                <p class="mb-0 fst-italic text-muted" id="preview-short" style="font-size:14.5px;line-height:1.7;"></p>
                            </div>
                        </div>

                        {{-- Long description --}}
                        <div id="preview-content" style="font-size:15px;line-height:1.9;color:#374151;"></div>

                    </div>
                </div>

                {{-- Modal Footer — only Close --}}
                <div class="modal-footer" style="background:#f8f9fa;border-top:1px solid #e9ecef;padding:12px 20px;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x me-1"></i> Close
                    </button>
                </div>

            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════
         REJECT MODAL
    ═══════════════════════════════════════════════════════════════ --}}
    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bx bx-x-circle text-danger me-2"></i>Reject Blog
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted" style="font-size:13.5px;">
                        The user will see this reason in their dashboard. Provide a helpful explanation if possible.
                    </p>
                    <label class="form-label fw-semibold">
                        Rejection Reason <small class="text-muted fw-normal">(optional)</small>
                    </label>
                    <textarea class="form-control" id="rejectReason" rows="3" placeholder="e.g. Content does not meet our guidelines…"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmRejectBtn">
                        <i class="bx bx-x me-1"></i> Reject
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════
         SCRIPTS
    ═══════════════════════════════════════════════════════════════ --}}
    <script>
        let rejectingId = null;

        // ─── VIEW / PREVIEW ───────────────────────────────────────────────────
        $(document).on('click', '.view-btn', function() {
            const btn = $(this);
            const id = btn.data('id');

            // Cover image & title
            $('#preview-image').attr('src', btn.data('image'));
            $('#preview-title').text(btn.data('title'));
            $('#preview-category').text(btn.data('category'));
            $('#preview-date').html('<i class="bx bx-calendar" style="font-size:13px;"></i> ' + btn.data('date'));

            // Avatar initials
            const name = String(btn.data('submitted') || 'Admin');
            const email = String(btn.data('submitted-email') || '');
            const initials = name.split(' ').map(w => w[0]).join('').toUpperCase().slice(0, 2);
            $('#preview-avatar').text(initials);
            $('#preview-submitted-by').text(name);
            $('#preview-submitted-email').text(email);

            // Short description
            const short = String(btn.data('short') || '').trim();
            if (short) {
                $('#preview-short').text(short);
                $('#preview-short-wrap').show();
            } else {
                $('#preview-short-wrap').hide();
            }

            // Tags
            const tags = String(btn.data('tags') || '').trim();
            if (tags) {
                const tagHtml = tags.split(',')
                    .map(t => `<span style="background:#e0e7ff;color:#3730a3;font-size:11.5px;font-weight:500;padding:3px 9px;border-radius:20px;">#${t.trim()}</span>`)
                    .join('');
                $('#preview-tags-wrap').html(tagHtml);
            } else {
                $('#preview-tags-wrap').html('');
            }

            // Loading spinner
            $('#preview-content').html(`
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status" style="width:2.5rem;height:2.5rem;"></div>
                    <p class="text-muted mt-3 mb-0" style="font-size:13.5px;">Loading blog content…</p>
                </div>
            `);

            $('#blogPreviewModal').modal('show');

            // AJAX: load long description
            $.ajax({
                url: `/backend/blog/${id}/content`,
                method: 'GET',
                success: function(res) {
                    if (res.success) {
                        $('#preview-content').html(res.content);
                    } else {
                        $('#preview-content').html('<p class="text-danger">Failed to load content.</p>');
                    }
                },
                error: function() {
                    $('#preview-content').html('<p class="text-danger">Network error. Please try again.</p>');
                }
            });
        });

        // ─── APPROVE — from list row ──────────────────────────────────────────
        $(document).on('click', '.approve-btn', function() {
            const id = $(this).data('id');
            const btn = $(this);
            if (!confirm('Approve and publish this blog?')) return;
            btn.prop('disabled', true).html('<i class="bx bx-loader-alt bx-spin"></i>');
            $.ajax({
                url: `/backend/blog/${id}/approve`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    if (res.success) {
                        toastr.success(res.message);
                        setTimeout(() => location.reload(), 900);
                    }
                },
                error: function() {
                    toastr.error('Failed to approve.');
                    btn.prop('disabled', false).html('<i class="bx bx-check"></i> Approve');
                }
            });
        });

        // ─── REJECT — from list row ───────────────────────────────────────────
        $(document).on('click', '.reject-btn', function() {
            rejectingId = $(this).data('id');
            $('#rejectReason').val('');
            $('#rejectModal').modal('show');
        });

        // ─── REJECT CONFIRM ───────────────────────────────────────────────────
        $('#confirmRejectBtn').on('click', function() {
            if (!rejectingId) return;
            const btn = $(this);
            btn.prop('disabled', true).html('<i class="bx bx-loader-alt bx-spin me-1"></i> Rejecting…');
            $.ajax({
                url: `/backend/blog/${rejectingId}/reject`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    reason: $('#rejectReason').val().trim(),
                },
                success: function(res) {
                    if (res.success) {
                        toastr.warning(res.message);
                        $('#rejectModal').modal('hide');
                        setTimeout(() => location.reload(), 900);
                    }
                },
                error: function() {
                    toastr.error('Failed to reject.');
                },
                complete: function() {
                    btn.prop('disabled', false).html('<i class="bx bx-x me-1"></i> Reject');
                }
            });
        });
    </script>
@endsection
