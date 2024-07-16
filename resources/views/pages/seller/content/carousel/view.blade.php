@extends('layouts.seller')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Carousel Content Management</h3>
                    <p class="text-subtitle text-muted">Effortlessly manage and customize carousel content on this page to
                        enhance your website's visual appeal and engagement.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('carousel.view') }}">Content Management</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Carousel</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content">
        <section class="section">
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ route('carousel.create') }}" class="btn btn-primary mb-3 p-2 float-end">Add Slide</a>
                </div>
            </div>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif


            <div id="carousel-cards-container">
                @if ($carouselContent)
                    <div class="row">
                        @foreach (json_decode($carouselContent->value, true) as $index => $slide)
                            <div class="carousel-card col-md-6" id="carousel-slide-{{$index}}">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h4>Edit Carousel Content (Slide {{ $index + 1 }})</h4>
                                    </div>
                                    <div class="card-body">
                                        <form id="carouselForm">
                                            @csrf
                                            <div class="row">
                                                <!-- Display the slide image -->
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="cropped-image{{ $index }}">Slide
                                                            Image</label><br>
                                                        <div class="col-md-12"> <!-- Adjust the column width as needed -->
                                                            <div class="image-container"
                                                                style="padding-bottom: 56.25%; position: relative;">
                                                                <img src="/storage/{{ $slide['image'] }}"
                                                                    alt="Cropped Image {{ $index }}"
                                                                    class="img-fluid"
                                                                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;"
                                                                    id="cropped-image-preview{{ $index }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Display first_line and second_line in the same row -->
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="first_line{{ $index }}">Main Title</label>
                                                    <input type="text" class="form-control"
                                                        id="first_line{{ $index }}"
                                                        name="slides[{{ $index }}][first_line]"
                                                        value="{{ $slide['first_line'] }}" disabled>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="second_line{{ $index }}">Title Line</label>
                                                    <input type="text" class="form-control"
                                                        id="second_line{{ $index }}"
                                                        name="slides[{{ $index }}][second_line]"
                                                        value="{{ $slide['second_line'] }}" disabled>
                                                </div>
                                            </div>

                                            <!-- Display third_line in its own column -->
                                            <div class="form-group">
                                                <label for="third_line{{ $index }}">Description</label>
                                                <input type="text" class="form-control"
                                                    id="third_line{{ $index }}"
                                                    name="slides[{{ $index }}][third_line]"
                                                    value="{{ $slide['third_line'] }}" disabled>
                                            </div>

                                            <!-- Display editable buttons for primary and secondary in the same row -->
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="primary_button{{ $index }}">Primary Button
                                                        Title</label>
                                                    <input type="text" class="form-control"
                                                        id="primary_button{{ $index }}"
                                                        name="slides[{{ $index }}][buttons][0][text]"
                                                        value="{{ $slide['buttons'][0]['text'] }}" disabled>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="primary_button_link{{ $index }}">Primary Button
                                                        Link</label>
                                                    <input type="text" class="form-control"
                                                        id="primary_button_link{{ $index }}"
                                                        name="slides[{{ $index }}][buttons][0][link]"
                                                        value="{{ $slide['buttons'][0]['link'] }}" disabled>
                                                </div>
                                            </div>

                                            <!-- Display editable buttons for secondary and its link in the same row -->
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="secondary_button{{ $index }}">Secondary Button
                                                        Title</label>
                                                    <input type="text" class="form-control"
                                                        id="secondary_button{{ $index }}"
                                                        name="slides[{{ $index }}][buttons][1][text]"
                                                        value="{{ $slide['buttons'][1]['text'] }}" disabled>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="secondary_button_link{{ $index }}">Secondary Button
                                                        Link</label>
                                                    <input type="text" class="form-control"
                                                        id="secondary_button_link{{ $index }}"
                                                        name="slides[{{ $index }}][buttons][1][link]"
                                                        value="{{ $slide['buttons'][1]['link'] }}" disabled>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="text-center mt-2">
                                            <a href="{{ route('carousel.edit', $index) }}" class="btn btn-success">Edit
                                                Slide</a>
                                            <button type="button" class="btn btn-danger remove-card-btn"
                                                data-slide-index="{{ $index }}">Remove Card</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>No carousel content found.</p>
                @endif
            </div>
        </section>
    </div>
@endsection

@section('scripts')
    <!-- Include SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        $(document).ready(function() {
            // Listen for click events on the "Remove Card" buttons
            $(".remove-card-btn").click(function() {
                // Get the slide index from the data attribute
                const slideIndex = $(this).data("slide-index");

                // Show a confirmation dialog with SweetAlert2
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel",
                }).then((result) => {
                    if (result.isConfirmed) {
                        // User confirmed, send an AJAX request to delete the slide
                        $.ajax({
                            type: "DELETE",
                            url: `/content-management/carousel/${slideIndex}`, // Adjust the URL to match your route
                            data: {
                                _token: "{{ csrf_token() }}", // Add the CSRF token for Laravel
                            },
                            success: function(data) {
                                // Slide deleted successfully
                                Swal.fire(
                                    "Deleted!",
                                    "Your carousel slide has been deleted.",
                                    "success"
                                );

                                // Optionally, you can remove the deleted slide from the DOM
                                // Here, we assume you have a container with slides
                                $(`#carousel-slide-${slideIndex}`).remove();
                            },
                            error: function(data) {
                                // Error occurred during deletion
                                console.log(data);
                                Swal.fire("Error!",
                                    "An error occurred while deleting the slide.",
                                    "error");
                            },
                        });
                    }
                });
            });
        });
    </script>
@endsection
