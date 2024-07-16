@extends('layouts.seller')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Product Management</h3>
                    <p class="text-subtitle text-muted">Efficiently manage your inventory of products. Add, edit, or remove
                        products
                        with ease and keep your product information up to date.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('products.index') }}">Product
                                    Management</a></li>
                            <li class="breadcrumb-item active" aria-current="page">List</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content">
        <section class="section">
            {{-- Check for low stock products --}}
            @if ($products->where('availability', '>', 0)->where('availability', '<=', 25)->isNotEmpty())
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill me-4" style="font-size: 1.5rem;"></i>
                        <div>
                            <strong
                                class="d-block">{{ $products->where('availability', '>', 0)->where('availability', '<=', 25)->count() }}
                                products are running low on stock!</strong>
                            <p class="mb-0">Please consider restocking soon.</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Check for out-of-stock products --}}
            @if ($products->where('availability', 0)->isNotEmpty())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-x-circle-fill me-4" style="font-size: 1.5rem;"></i>
                        <div>
                            <strong class="d-block">{{ $products->where('availability', 0)->count() }} products are out
                                of
                                stock!</strong>
                            <p class="mb-0">Please update the stock to ensure availability.</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group" role="group">
                            <a href="{{ route('product.export') }}" class="btn btn-info">Generate Report</a>
                        </div>
                        <div class="btn-group" role="group">
                            <button id="filterInStock" type="button" class="btn btn-outline-success">In Stock</button>
                            <button id="filterLowStock" type="button" class="btn btn-outline-warning">Low Stock</button>
                            <button id="filterOutOfStock" type="button" class="btn btn-outline-danger">Out of Stock</button>
                            <button id="resetFilter" type="button" class="btn btn-outline-secondary">Reset</button>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Stocks</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($products as $product)
                                <tr>
                                    <td>
                                        <img class="img-50px"
                                            src="{{ asset('storage/uploads/images/' . $product->image_folder . '/' . $product->variation . '.jpg') }}"
                                            alt="{{ $product->id }}" style="padding: 10px" alt="{{ $product->id }}">
                                    </td>
                                    <td>{{ $product->product_name }} {{ $product->variation }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td class="availability-cell">{{ $product->availability }}</td>
                                    <td>
                                        <span
                                            class="badge status-badge @if ($product->availability > 25) bg-success @elseif ($product->availability > 0) bg-warning @else bg-danger @endif">
                                            @if ($product->availability > 25)
                                                In Stock
                                            @elseif ($product->availability > 0)
                                                Low Stock
                                            @else
                                                Out of Stock
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a class="btn btn-primary"
                                                href="{{ route('products.index') . '/' . $product->id }}"><i
                                                    class="fas fa-edit"></i> Edit</a>
                                            <button class="btn btn-danger delete-product"
                                                data-product-id="{{ $product->id }}"><i class="fas fa-trash"></i>
                                                Delete</button>
                                            <button class="btn btn-success addStockBtn" data-id="{{ $product->id }}">
                                                <i class="fas fa-plus"></i> Add Stock</button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </section>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet"
        href="{{ asset('assets/seller/vendors/jquery-datatables/jquery.dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/seller/css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        table.dataTable td {
            padding: 15px 8px;
        }

        .fontawesome-icons .the-icon svg {
            font-size: 24px;
        }
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('assets/seller/vendors/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/seller/vendors/jquery-datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/seller/vendors/jquery-datatables/custom.jquery.dataTables.bootstrap5.min.js') }}">
    </script>
    <script src="{{ asset('assets/seller/vendors/fontawesome/all.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {

            let jquery_datatable = $("#table1").DataTable();

            // Add event listeners to the status filter buttons
            $("#filterInStock").on("click", function() {
                filterByStatus("In Stock");
            });

            $("#filterLowStock").on("click", function() {
                filterByStatus("Low Stock");
            });

            $("#filterOutOfStock").on("click", function() {
                filterByStatus("Out of Stock");
            });

            function filterByStatus(status) {
                // Use DataTables API to set the filter and redraw the table
                jquery_datatable.column(4).search(status).draw();
            }

            // Optional: Add a button to reset the filter
            $("#resetFilter").on("click", function() {
                // Use DataTables API to clear the filter and redraw the table
                jquery_datatable.column(4).search("").draw();
            });

            $('.delete-product').click(function() {
                const productId = $(this).data('product-id');

                Swal.fire({
                    title: 'Delete Product',
                    text: 'Are you sure you want to delete this product?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Send an AJAX request to delete the product
                        $.ajax({
                            method: 'DELETE',
                            url: `/products/${productId}/delete`,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function(data) {
                                // Handle success, e.g., remove the product from the table
                                $(`.delete-product[data-product-id="${productId}"]`)
                                    .closest('tr')
                                    .remove();
                                Swal.fire('Deleted!', 'The product has been deleted.',
                                    'success');
                            },
                            error: function(xhr, status, error) {
                                // Handle error, e.g., show an error message
                                Swal.fire('Error',
                                    'An error occurred while deleting the product.',
                                    'error');
                            }
                        });
                    }
                });
            });

            // Handle Add Stock button click
            $(document).on('click', '.addStockBtn', function() {
                console.log('Test');
                var button = $(this);
                var productId = button.data('id');

                console.log(productId);
                Swal.fire({
                    title: 'Add Stock',
                    input: 'number',
                    inputLabel: 'Enter stock quantity',
                    inputAttributes: {
                        min: 1
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Add',
                    preConfirm: (quantity) => {
                        // Make an AJAX request to update the stock in the backend
                        $.ajax({
                            type: 'POST',
                            url: '/product/restock',
                            data: {
                                productId: productId,
                                quantity: quantity
                            },
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire('Stock added successfully!', '',
                                    'success');
                                // Update the UI to reflect the new stock quantity and status
                                button.closest('tr').find('.availability-cell')
                                    .text(response.availability);
                                var statusBadge = button.closest('tr').find(
                                    '.status-badge');
                                if (response.availability > 25) {
                                    statusBadge.removeClass('bg-warning bg-danger')
                                        .addClass('bg-success').text('In Stock');
                                } else if (response.availability > 0) {
                                    statusBadge.removeClass('bg-success bg-danger')
                                        .addClass('bg-warning').text('Low Stock');
                                } else {
                                    statusBadge.removeClass('bg-success bg-warning')
                                        .addClass('bg-danger').text('Out of Stock');
                                }
                            },
                            error: function(error) {
                                Swal.fire('Error adding stock',
                                    'Please try again later', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
