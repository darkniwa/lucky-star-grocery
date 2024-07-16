@extends('layouts.seller')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Products and Performance</h3>
                    <p class="text-subtitle text-muted">View daily sales overview. Compare today's performance with
                        yesterday's through informative graphs.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Sales</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Products and Performance</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content">
        <section class="section">
            <div class="row">

            </div>
        </section>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/seller/vendors/jquery/jquery.min.js') }}"></script>
@endsection
