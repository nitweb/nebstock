{{-- #################### TOASTR CONFIG #################### --}}
<script>
    toastr.options = {
        closeButton: true,
        progressBar: true,
        newestOnTop: true,
        preventDuplicates: true,
        positionClass: "toast-top-right",
        showDuration: "300",
        hideDuration: "800",
        timeOut: "3000",
        extendedTimeOut: "1000",
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
    };
</script>

{{-- #################### TOASTR SESSION MESSAGE #################### --}}
<script>
    @if (Session::has('message'))

        toastr.clear();

        const type = "{{ Session::get('alert-type', 'info') }}";
        const message = "{{ Session::get('message') }}";

        switch (type) {

            case 'success':
                toastr.success(message);
                break;

            case 'error':
                toastr.error(message);
                break;

            case 'warning':
                toastr.warning(message);
                break;

            default:
                toastr.info(message);
        }
    @endif
</script>

{{-- #################### SUMMERNOTE #################### --}}
<script>
    $(document).ready(function() {

        $('#summernote, .summernote').summernote({
            height: 300,
            placeholder: 'Write here...',
        });

    });
</script>

{{-- #################### STATUS UPDATE (DROPDOWN) #################### --}}
<script>
    $(document).ready(function() {

        $(document).on('click', '.js-update-status', function(e) {

            e.preventDefault();

            const recordId = $(this).data('id');
            const status = $(this).data('status');
            const model = $(this).data('model');
            const column = $(this).data('column');

            $.ajax({

                url: "{{ route('backend.status.update') }}",
                type: "POST",

                data: {
                    _token: "{{ csrf_token() }}",
                    id: recordId,
                    status: status,
                    model: model,
                    column: column,
                },

                beforeSend: function() {
                    toastr.clear();
                },

                success: function(response) {

                    toastr.clear();

                    if (response.success) {

                        toastr.success(response.message);

                        const escapedModel = model.replace(/\\/g, '\\\\');

                        const badge = $(
                            `.custom_status_badge[data-model="${escapedModel}"][data-id="${recordId}"]`
                        );

                        if (status === 'active') {

                            badge
                                .removeClass('text-bg-danger')
                                .addClass('text-bg-success')
                                .text('Active');

                        } else {

                            badge
                                .removeClass('text-bg-success')
                                .addClass('text-bg-danger')
                                .text('Inactive');
                        }

                    } else {

                        toastr.error(response.message || 'Something went wrong.');
                    }
                },

                error: function(xhr) {

                    toastr.clear();

                    toastr.error(
                        xhr.responseJSON?.message ||
                        'An unexpected error occurred.'
                    );
                }

            });

        });

    });
</script>

{{-- #################### STATUS UPDATE (TOGGLE SWITCH) #################### --}}
<script>
    $(document).ready(function() {

        $(document).on('change', '.status-toggle', function() {

            const $toggle = $(this);

            const id = $toggle.data('id');
            const model = $toggle.data('model');
            const field = $toggle.data('field');

            const active = $toggle.data('active');
            const inactive = $toggle.data('inactive');

            const newStatus = $toggle.is(':checked') ?
                active :
                inactive;

            $.ajax({

                url: "{{ route('backend.status.update') }}",
                type: "POST",

                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    model: model,
                    column: field,
                    status: newStatus,
                },

                beforeSend: function() {
                    toastr.clear();
                },

                success: function(response) {

                    toastr.clear();

                    if (response.success) {

                        toastr.success(response.message);

                    } else {

                        toastr.error(response.message || 'Update failed.');

                        // rollback toggle
                        $toggle.prop(
                            'checked',
                            !$toggle.is(':checked')
                        );
                    }
                },

                error: function(xhr) {

                    toastr.clear();

                    toastr.error(
                        xhr.responseJSON?.message ||
                        'Server error occurred.'
                    );

                    // rollback toggle
                    $toggle.prop(
                        'checked',
                        !$toggle.is(':checked')
                    );
                }

            });

        });

    });
</script>

{{-- #################### TAGIFY #################### --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {

        const tagifyInput = document.querySelector('input[name=blog_tags]');

        if (tagifyInput) {

            new Tagify(tagifyInput, {
                duplicates: false,
            });

        }

    });
</script>
