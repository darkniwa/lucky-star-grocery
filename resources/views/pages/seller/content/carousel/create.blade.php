@extends('layouts.seller')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Add Carousel Slide</h3>
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
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div id="carousel-cards-container">
                <div class="row">
                    <div class="carousel-card col-md-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4>Add New Carousel Slide</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('carousel.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <!-- Input and Crop Button in the same line -->
                                    <div class="form-group">
                                        <input type="file" class="form-control" name="image" accept="image/*">
                                        @error('image')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <!-- Main Title -->
                                        <div class="form-group col-md-6">
                                            <label for="main_title">Main Title</label>
                                            <input type="text" class="form-control" id="main_title" name="main_title"
                                                value="{{ old('main_title') }}">
                                            @error('main_title')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Title -->
                                        <div class="form-group col-md-6">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control" id="title" name="title"
                                                value="{{ old('title') }}">
                                            @error('title')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <input type="text" class="form-control" id="description" name="description"
                                            value="{{ old('description') }}">
                                        @error('description')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <!-- Primary Button Title -->
                                        <div class="form-group col-md-6">
                                            <label for="primary_button">Primary Button Title</label>
                                            <input type="text" class="form-control" id="primary_button"
                                                name="primary_button_title" value="{{ old('primary_button_title') }}">
                                            @error('primary_button_title')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Primary Button Link -->
                                        <div class="form-group col-md-6">
                                            <label for="primary_button_link">Primary Button Link</label>
                                            <input type="text" class="form-control" id="primary_button_link"
                                                name="primary_button_link" value="{{ old('primary_button_link') }}">
                                            @error('primary_button_link')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <!-- Secondary Button Title -->
                                        <div class="form-group col-md-6">
                                            <label for="secondary_button">Secondary Button Title</label>
                                            <input type="text" class="form-control" id="secondary_button"
                                                name="secondary_button_title" value="{{ old('secondary_button_title') }}">
                                            @error('secondary_button_title')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Secondary Button Link -->
                                        <div class="form-group col-md-6">
                                            <label for="secondary_button_link">Secondary Button Link</label>
                                            <input type="text" class="form-control" id="secondary_button_link"
                                                name="secondary_button_link" value="{{ old('secondary_button_link') }}">
                                            @error('secondary_button_link')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="text-center mt-2">
                                        <button type="submit" class="btn btn-primary">Add Slide</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
