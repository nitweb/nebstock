@if (session('error'))
    <div class="alert alert-danger alert-dismissible show fade">

        <div class="alert-body">

            <button class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>

            {{ session('error') }}

        </div>

    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
