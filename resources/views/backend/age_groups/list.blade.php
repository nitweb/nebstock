@extends('admin.dashboard')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            {{-- Breadcrumb  --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Age Group List</h4>
                        <div class="page-title-right">
                            <a href="{{ route('age_group.add') }}" class="btn btn-outline-primary waves-effect waves-light">
                                <i class="bx bx-plus font-size-16 align-middle me-2"></i> Add Age Group
                            </a>
                            <a href="javascript:history.back()" class="btn btn-outline-dark waves-effect waves-light">
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
                                            <th>S/N</th>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($age_group_list as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>
                                                    {{-- Edit btn --}}
                                                    <a href="{{ route('age_group.edit', $item->id) }}" class="btn btn-outline-info waves-effect waves-light mb-2">
                                                        <i class="bx bx-edit font-size-16 align-middle"></i>
                                                    </a>
                                                    {{-- Delete btn --}}
                                                    <a href="{{ route('age_group.delete', $item->id) }}" class="btn btn-outline-danger waves-effect waves-light mb-2" onclick="return confirm('Are you sure?')">
                                                        <i class="bx bxs-trash font-size-16 align-middle"></i>
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
