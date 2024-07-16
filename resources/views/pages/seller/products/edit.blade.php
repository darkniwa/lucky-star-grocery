@extends('layouts.seller')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Edit Product</h3>
                    <p class="text-subtitle text-muted">Modify the details of your product. Update its information to keep it
                        up to date in your inventory.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('products.index') }}">Product
                                    Management</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <section class="section">
            <form action="{{ route('products.update', $product->id) }}" name="form-edit-products" method="POST"
                enctype="multipart/form-data" id="form-edit-products">
                @csrf
                @method('PUT')
                <div class="row">
                    <!-- Basic Information -->
                    <div class="col-6 col-md-6 equal-height">
                        <div class="card w-100">
                            <div class="card-header">
                                <h5 class="card-title">Basic Information</h5>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="ProductName" class="form-label"><code>* </code>Product Name</label>
                                        <input type="text" class="form-control" id="ProductName"
                                            placeholder="Enter product name" name="ProductName"
                                            value="{{ old('ProductName', $product->product_name) }}">
                                        @error('ProductName')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror

                                        <!-- Suggestions dropdown -->
                                        <div id="suggestions" class="dropdown">
                                            <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                                                <!-- Suggestions will be added here dynamically -->
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="Category" class="form-label"><code>* </code>Category</label>
                                        <select class="form-select" id="Category" name="Category">
                                            <option value="0" disabled>-- Select Categories --</option>
                                            @foreach ($allCategories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('Category', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('Category')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Image -->
                    <div class="col-6 col-md-6 equal-height">
                        <div class="card w-100">
                            <div class="card-header">
                                <h5 class="card-title">Product Image</h5>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="ProductImage" class="form-label">Upload Product Image</label>
                                        <input type="file" name="ProductImage" id="ProductImage" accept="image/jpeg">
                                    </div>
                                    @error('ProductImage')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <img src="{{ asset('storage/uploads/images/' . $product->image_folder . '/' . $product->variation . '.jpg') }}"
                                        class="d-block" style="max-width: 270px; max-height: 270px;" alt="Product Image">
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Details -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Product Details</h5>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <!-- Variation -->
                                    <div class="mb-3">
                                        <label for="Variation" class="form-label"><code>* </code>Variation</label>
                                        <input type="text" class="form-control" id="Variation"
                                            placeholder="(Ex: 500g, 1L, 250ml, 1kg)" name="Variation"
                                            value="{{ old('Variation', $product->variation) }}">
                                        @error('Variation')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Price -->
                                    <div class="mb-3">
                                        <label for="Price" class="form-label"><code>* </code>Price</label>
                                        <input type="text" class="form-control" id="Price" placeholder="Enter price"
                                            name="Price" value="{{ old('Price', $product->price) }}">
                                        @error('Price')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Quantity -->
                                    <div class="mb-3">
                                        <label for="Quantity" class="form-label"><code>* </code>Stock</label>
                                        <input type="text" class="form-control" id="Quantity"
                                            placeholder="Amount of available products" name="Quantity"
                                            value="{{ old('Quantity', $product->availability) }}">
                                        @error('Quantity')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Description -->
                                    <div class="mb-3">
                                        <label for="Description" class="form-label"><code>* </code>Description</label>
                                        <textarea name="Description" id="editor" cols="30" rows="10" placeholder="Enter Description Here">{{ old('Description', $product->description) }}</textarea>
                                        @error('Description')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Save Product Button -->
                <div class="col-12 col-md-12 mt-3">
                    <div class="text-center">
                        <button class="btn btn-primary" type="submit">Save Product</button>
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/seller/vendors/toastify/toastify.js') }}"></script>
    <script src="{{ asset('assets/seller/vendors/ckeditor/ckeditor.js') }}"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
    </script>

    <script>
        // Listen for input in the Product Name field
        $('#ProductName').on('input', function() {
            var input = $(this).val();

            // Make an AJAX request to fetch suggestions from the backend
            $.ajax({
                url: "/product/suggestion",
                method: 'GET',
                data: {
                    input: input
                },
                dataType: 'json',
                success: function(data) {
                    // Clear previous suggestions
                    $('#suggestions ul').empty();

                    // Add new suggestions to the dropdown
                    data.forEach(function(suggestion) {
                        $('#suggestions ul').append('<li>' + suggestion + '</li>');
                    });

                    // Show the suggestions dropdown
                    $('#suggestions ul').show();
                },
                error: function(err) {
                    // Handle errors
                    console.log(err);
                }
            });
        });

        // Hide the suggestions dropdown when clicking outside of it
        $(document).on('click', function(e) {
            if (!$(e.target).closest('#suggestions').length) {
                $('#suggestions ul').hide();
            }
        });

        // Event listener for suggestion clicks
        $('#suggestions ul').on('click', 'li', function() {
            // Get the clicked suggestion
            var clickedSuggestion = $(this).text();

            // Update the ProductName input field with the clicked suggestion
            $('#ProductName').val(clickedSuggestion);

            // Hide the suggestions dropdown
            $('#suggestions ul').hide();
        });
    </script>
@endsection
