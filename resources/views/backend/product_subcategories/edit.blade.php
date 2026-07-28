@extends('admin.dashboard')
@section('admin')
    <div class="page-content">

        <div class="container-fluid">

            {{-- Breadcrumb  --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Product Category Edit</h4>
                        <div class="page-title-right">
                            <a href="javascript:history.back()" class="btn btn-outline-dark waves-effect waves-light">
                                <i class="bx bx-undo font-size-16 align-middle me-2"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Custom Form --}}
            <div class="row">

                <div class="col-12">

                    <div class="card">

                        <div class="card-body p-4">

                            @include('widgets.errors')

                            <form class="row g-3" action="{{ route('backend.product_subcategories.update') }}" method="post" enctype="multipart/form-data">

                                @csrf

                                <input type="hidden" name="id" value="{{ $subcategory->id }}">

                                <div class="col-md-8">
                                    <label for="product_category_id" class="form-label">Parent Category</label>
                                    <select name="product_category_id" id="product_category_id" class="form-select" required>
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ $subcategory->product_category_id == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->product_category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-8">
                                    <label for="product_sub_category_name" class="form-label">SubCategory Name</label>
                                    <input type="text" class="form-control" id="product_sub_category_name" name="product_sub_category_name" value="{{ $subcategory->product_sub_category_name }}" required>
                                </div>

                                <div class="col-md-8">
                                    <label for="product_sub_category_slug" class="form-label">Slug</label>
                                    <input type="text" class="form-control" id="product_sub_category_slug" name="product_sub_category_slug" value="{{ $subcategory->product_sub_category_slug }}" required>
                                </div>

                                <div class="col-md-8">
                                    <label for="product_sub_category_image" class="form-label">Image [440px by 440px]</label>
                                    <input type="file" class="form-control" name="product_sub_category_image" id="image">
                                    <img id="showImage" src="{{ !empty($subcategory->product_sub_category_image) ? url('upload/product_sub_category_image/' . $subcategory->product_sub_category_image) : url('upload/no_image.jpg') }}" alt="SubCategory Image" class="p-1 bg-primary mt-3" style="width: 110px; height: 110px; object-fit: cover; border-radius: 8px;">
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            })
        })
    </script>
    @include('admin.layout.custom_scripts')

    {{-- Toastr Script --}}
@endsection
