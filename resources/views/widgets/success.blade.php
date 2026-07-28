@if (session()->has('success') || session()->has('status'))
    <div class="alert alert-success alert-dismissible show fade">

        <div class="alert-body">

            <button class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>

            {{ session()->get('success') }}

        </div>

    </div>
@endif
