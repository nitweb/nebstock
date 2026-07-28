@extends('admin.dashboard')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            {{-- Breadcrumb  --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Mission/Vision/Values</h4>
                        <div class="page-title-right">
                            <a href="javascript:history.back()" class="btn btn-sm btn-outline-dark waves-effect waves-light">
                                <i class="bx bx-undo font-size-16 align-middle me-2"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Custom Table --}}
            <div class="row">

                <div class="col-12">

                    <div class="card">

                        <div class="card-body">

                            <div class="table-responsive">

                                <table id="datatable-buttons" class="table table-bordered w-100">

                                    <thead>
                                        <tr>
                                            <th>Icon</th>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($mission_vision_list as $item)
                                            <tr>
                                                <td><i class="{{ $item->mission_vision_icon }}" style="font-size: 25px;"></i></td>
                                                <td>{{ $item->mission_vision_title }}</td>
                                                <td>{{ \Illuminate\Support\Str::limit($item->mission_vision_description, 150) }}</td>
                                                <td>
                                                    <a href="{{ route('backend.mission_vision.edit', $item->id) }}" class="btn btn-sm btn-outline-success waves-effect waves-light">
                                                        <i class="bx bx-edit font-size-16 align-middle me-2"></i> Edit
                                                    </a>
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
@endsection
