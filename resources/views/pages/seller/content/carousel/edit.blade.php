@extends('layouts.seller')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12  order-md-1 order-last">
                    <h3>Edit Carousel Slide</h3>
                    <p class="text-subtitle text-muted">Effortlessly manage and customize carousel content on this page to
                        enhance your website's visual appeal and engagement.</p>
                </div>
                <div class="col-12  order-md-2 order-first">
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
                <form action="{{ route('carousel.update', ['slide' => $carouselSlideId]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <!-- Image Card -->
                        <div class="carousel-card col-md-4 ">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5>Image Section</h5>
                                </div>
                                <div class="card-body">
                                    <!-- Image display and file input here -->
                                    <div class="row">
                                        <div class="form-group ">
                                            <label for="cropped-image{{ $carouselSlideId }}">Current Slide
                                                Image</label><br>
                                            <div class="image-container"
                                                style="padding-bottom: 56.25%; position: relative;">
                                                <img src="/storage/{{ $carouselSlide['image'] }}"
                                                    alt="Cropped Image {{ $carouselSlideId }}" class="img-fluid"
                                                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;"
                                                    id="cropped-image-preview{{ $carouselSlideId }}">
                                            </div>
                                        </div>

                                        <div class="form-group  d-flex align-items-center">
                                            <input type="file" class="form-control" name="image" accept="image/*">
                                            @error('image')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- ... -->
                                </div>
                            </div>
                        </div>

                        <!-- Titles Card -->
                        <div class="carousel-card col-md-4">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5>Title Section</h5>
                                </div>
                                <div class="card-body ">
                                    <!-- Main Title and Title inputs here -->
                                    <div class="row">
                                        <!-- Main Title -->
                                        <div class="form-group ">
                                            <label for="main_title">Main Title</label>
                                            <input type="text" class="form-control" id="main_title" name="main_title"
                                                value="{{ old('main_title', $carouselSlide['first_line']) }}">
                                            @error('main_title')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Title -->
                                        <div class="form-group ">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control" id="title" name="title"
                                                value="{{ old('title', $carouselSlide['second_line']) }}">
                                            @error('title')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <input type="text" class="form-control" id="description" name="description"
                                            value="{{ old('description', $carouselSlide['third_line']) }}">
                                        @error('description')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- ... -->
                                </div>
                            </div>
                        </div>

                        <!-- Buttons Card -->
                        <div class="carousel-card col-md-4">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5>Button Section</h5>
                                </div>
                                <div class="card-body ">
                                    <!-- Button Title and Link inputs here -->
                                    <!-- Primary Button Title -->
                                    <div class="form-group ">
                                        <label for="primary_button">Primary Button Title</label>
                                        <input type="text" class="form-control" id="primary_button"
                                            name="primary_button_title"
                                            value="{{ old('primary_button_title', $carouselSlide['buttons'][0]['text']) }}">
                                        @error('primary_button_title')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Primary Button Link -->
                                    <div class="form-group ">
                                        <label for="primary_button_link">Primary Button Link</label>
                                        <input type="text" class="form-control" id="primary_button_link"
                                            name="primary_button_link"
                                            value="{{ old('primary_button_link', $carouselSlide['buttons'][0]['link']) }}">
                                        @error('primary_button_link')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- Secondary Button Title -->
                                    <div class="form-group ">
                                        <label for="secondary_button">Secondary Button Title</label>
                                        <input type="text" class="form-control" id="secondary_button"
                                            name="secondary_button_title"
                                            value="{{ old('secondary_button_title', $carouselSlide['buttons'][1]['text']) }}">
                                        @error('secondary_button_title')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Secondary Button Link -->
                                    <div class="form-group ">
                                        <label for="secondary_button_link">Secondary Button Link</label>
                                        <input type="text" class="form-control" id="secondary_button_link"
                                            name="secondary_button_link"
                                            value="{{ old('secondary_button_link', $carouselSlide['buttons'][1]['link']) }}">
                                        @error('secondary_button_link')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- ... -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-2">
                        <button type="submit" class="btn btn-primary">Update Slide</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
