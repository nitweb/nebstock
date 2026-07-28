@extends('admin.dashboard')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            {{-- Breadcrumb  --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Font Awesome</h4>
                        <div class="page-title-right">
                            <a href="javascript:history.back()" class="btn btn-sm btn-outline-dark waves-effect waves-light">
                                <i class="bx bx-undo font-size-16 align-middle me-2"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Solid</h4>
                            <p class="card-title-desc">Use <code>&lt;i class="fas fa-ad"&gt;&lt;/i&gt;</code> <span class="badge bg-success">v 5.13.0</span>.</p>
                        </div>
                        <div class="card-body">
                            <div class="row icon-demo-content" id="solid">
                            </div>
                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Regular</h4>
                            <p class="card-title-desc">Use <code>&lt;i class="far fa-address-book"&gt;&lt;/i&gt;</code> <span class="badge bg-success">v 5.13.0</span>.</p>
                        </div>
                        <div class="card-body">
                            <div class="row icon-demo-content" id="regular">
                            </div>
                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Brands</h4>
                            <p class="card-title-desc">Use <code>&lt;i class="fab fa-500px"&gt;&lt;/i&gt;</code> <span class="badge bg-success">v 5.13.0</span>.</p>
                        </div>
                        <div class="card-body">
                            <div class="row icon-demo-content" id="brand">
                            </div>
                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                </div> <!-- end col -->
            </div>

        </div>

    </div>
@endsection
