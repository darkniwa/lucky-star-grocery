@extends('layouts.seller')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Remittance Center</h3>
                    <p class="text-subtitle text-muted">Effortlessly manage remittance transactions and stay informed about
                        financial transfers.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Remittance</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="page-content">
        <section class="section">
            <div class="row">
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon green">
                                        <?xml version="1.0" encoding="utf-8"?>
                                        <!DOCTYPE svg
                                            PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="24px"
                                            height="24px" viewBox="0 0 24 24" enable-background="new 0 0 24 24"
                                            xml:space="preserve">
                                            <g id="Frames-24px">
                                                <rect fill="none" width="24" height="24" />
                                            </g>
                                            <g id="Solid">
                                                <g>
                                                    <path fill="#fff"
                                                        d="M4.086,5C4.562,4.595,6.216,4,8,4s3.438,0.595,3.914,1H14c0-2.243-4.121-3-6-3S2,2.757,2,5v12			c0,2.245,4.121,3,6,3c0.287,0,0.631-0.021,1-0.058v-2.009C8.675,17.974,8.342,18,8,18c-1.916,0-3.682-0.684-4-1.086v-0.693			C5.32,16.776,6.985,17,8,17c0.288,0,0.631-0.021,1-0.058v-2.009C8.675,14.974,8.342,15,8,15c-1.937,0-3.709-0.697-4-1.098v-0.682			C5.32,13.776,6.985,14,8,14c0.288,0,0.631-0.021,1-0.058v-2.009C8.675,11.974,8.342,12,8,12c-1.937,0-3.709-0.697-4-1.098v-0.682			C5.32,10.776,6.985,11,8,11c0.288,0,0.631-0.021,1-0.058V8.934C8.675,8.974,8.342,9,8,9C6.063,9,4.291,8.303,4,7.902V7.221			C5.32,7.776,6.985,8,8,8c0.288,0,0.631-0.021,1-0.058V5.935C8.675,5.974,8.342,6,8,6C6.216,6,4.562,5.407,4.086,5z" />
                                                    <path fill="#fff"
                                                        d="M16,7c-1.879,0-6,0.757-6,3v9c0,2.245,4.121,3,6,3s6-0.755,6-3v-9C22,7.757,17.879,7,16,7z M20,12.902			C19.709,13.303,17.937,14,16,14s-3.709-0.697-4-1.098v-0.682C13.32,12.776,14.985,13,16,13s2.68-0.224,4-0.779V12.902z M20,15.902			C19.709,16.303,17.937,17,16,17s-3.709-0.697-4-1.098v-0.682C13.32,15.776,14.985,16,16,16s2.68-0.224,4-0.779V15.902z M16,9			c1.784,0,3.438,0.595,3.914,1c-0.476,0.407-2.13,1-3.914,1s-3.438-0.593-3.914-1C12.562,9.595,14.216,9,16,9z M16,20			c-1.916,0-3.682-0.684-4-1.086v-0.693C13.32,18.776,14.985,19,16,19s2.68-0.224,4-0.779v0.693C19.682,19.316,17.916,20,16,20z" />
                                                </g>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Collected Cash<br>Today</h6>
                                    {{-- @dd($collected_cash_today) --}}
                                    <h6 class="font-extrabold mb-0">{{ $collected_cash_today }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon red">
                                        <?xml version="1.0" encoding="utf-8"?>
                                        <!-- Generator: Adobe Illustrator 16.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
                                        <!DOCTYPE svg
                                            PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="24px"
                                            height="24px" viewBox="0 0 24 24" enable-background="new 0 0 24 24"
                                            xml:space="preserve">
                                            <g id="Frames-24px">
                                                <rect fill="none" width="24" height="24" />
                                            </g>
                                            <g id="Solid">
                                                <g>
                                                    <path fill="#fff"
                                                        d="M4.086,5C4.562,4.595,6.216,4,8,4s3.438,0.595,3.914,1H14c0-2.243-4.121-3-6-3S2,2.757,2,5v12			c0,2.245,4.121,3,6,3c0.287,0,0.631-0.021,1-0.058v-2.009C8.675,17.974,8.342,18,8,18c-1.916,0-3.682-0.684-4-1.086v-0.693			C5.32,16.776,6.985,17,8,17c0.288,0,0.631-0.021,1-0.058v-2.009C8.675,14.974,8.342,15,8,15c-1.937,0-3.709-0.697-4-1.098v-0.682			C5.32,13.776,6.985,14,8,14c0.288,0,0.631-0.021,1-0.058v-2.009C8.675,11.974,8.342,12,8,12c-1.937,0-3.709-0.697-4-1.098v-0.682			C5.32,10.776,6.985,11,8,11c0.288,0,0.631-0.021,1-0.058V8.934C8.675,8.974,8.342,9,8,9C6.063,9,4.291,8.303,4,7.902V7.221			C5.32,7.776,6.985,8,8,8c0.288,0,0.631-0.021,1-0.058V5.935C8.675,5.974,8.342,6,8,6C6.216,6,4.562,5.407,4.086,5z" />
                                                    <path fill="#fff"
                                                        d="M16,7c-1.879,0-6,0.757-6,3v9c0,2.245,4.121,3,6,3s6-0.755,6-3v-9C22,7.757,17.879,7,16,7z M20,12.902			C19.709,13.303,17.937,14,16,14s-3.709-0.697-4-1.098v-0.682C13.32,12.776,14.985,13,16,13s2.68-0.224,4-0.779V12.902z M20,15.902			C19.709,16.303,17.937,17,16,17s-3.709-0.697-4-1.098v-0.682C13.32,15.776,14.985,16,16,16s2.68-0.224,4-0.779V15.902z M16,9			c1.784,0,3.438,0.595,3.914,1c-0.476,0.407-2.13,1-3.914,1s-3.438-0.593-3.914-1C12.562,9.595,14.216,9,16,9z M16,20			c-1.916,0-3.682-0.684-4-1.086v-0.693C13.32,18.776,14.985,19,16,19s2.68-0.224,4-0.779v0.693C19.682,19.316,17.916,20,16,20z" />
                                                </g>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Collected Cash<br>Yesterday</h6>
                                    <h6 class="font-extrabold mb-0">{{ $collected_cash_yesterday }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6 d-flex">
                    <div class="card">
                        <button class="btn btn-primary h-100" id="btn-collect-cash">Collect Cash Remittance</button>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h6>Couriers</h6>
                        </div>
                        <br>
                        <div class="card-body">
                            <table class="table" id="table-remittance-history">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Amount to Remit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($couriers as $courier)
                                        <tr>
                                            <td>#2022{{ $courier->id }}</td>
                                            <td>{{ $courier->display_name }}</td>
                                            <td>
                                                PHP {{ number_format($courier->total_uncollected_amount, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
@endsection


@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.css">
@endsection

@section('scripts')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            function recordRemittance(courier_id, amount) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var url = "{{ route('remittance.collect') }}";
                var csrfToken = '{{ csrf_token() }}';

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        _token: csrfToken,
                        courier_id: courier_id,
                        amount: amount,
                    },
                    success: function(data) {
                        if (alert) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Remittance has been recorded.',
                                confirmButtonColor: '#0d6efd',
                            });
                        }
                    },
                    error: function(data) {
                        console.log(data);
                        if (alert) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed to record remittance.',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    }
                });
            }

            $('#btn-collect-cash').click(function() {
                Swal.fire({
                    title: 'Cash Remittance',
                    html: `
                    <select class="form-select p-3" name="courier_id" id="courier_id">
                        <option disabled selected>Select Courier</option>
                        @foreach ($couriers as $courier)
                            <option value="{{ $courier->id }}" data-balance="{{ $courier->total_uncollected_amount }}">
                                {{ Str::title($courier->display_name) }}
                            </option>
                        @endforeach
                    </select>
                    <input type="text" id="remittance_amount" class="form-control p-3 mt-4" placeholder="Amount" value="" readonly>
                    `,
                    confirmButtonText: 'Submit',
                    confirmButtonColor: '#0d6efd',
                    focusConfirm: false,
                    preConfirm: () => {
                        const courier_id = Swal.getPopup().querySelector('#courier_id').value
                        const amount = Swal.getPopup().querySelector('#remittance_amount').value
                        const courier_name = $('#courier_id option:selected').text();
                        if (!courier_id || !amount) {
                            Swal.showValidationMessage(`Please enter a value`)
                        }
                        return {
                            courier_id: courier_id,
                            courier_name: courier_name,
                            amount: amount
                        }
                    }
                }).then((result) => {
                    Swal.fire({
                        title: 'Are you sure the following information is correct?',
                        html: `
                        Rider ID: 2022${result.value.courier_id} <br> 
                        Courier: ${result.value.courier_name} <br> 
                        Amount: ${Number(result.value.amount).toLocaleString('en-US', {style: 'currency', currency: 'PHP',})}`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, the information was correct!',
                    }).then((result2) => {
                        if (result2.isConfirmed) {
                            recordRemittance(result.value.courier_id, result.value.amount);
                        }
                    })
                })
            });

        });

        $(document).on('change', '#courier_id', function() {
            var selectedCourier = $(this).find(':selected');
            console.log(selectedCourier.data('balance')); // Check if this logs the correct balance

            var balance = parseFloat(selectedCourier.data('balance'));
            console.log('Balance:', balance); // Check if this logs the correct balance

            // Format the balance with two decimal places
            var formattedBalance = Math.abs(balance).toFixed(2);

            // Update the remittance_amount input
            $('#remittance_amount').val(balance < 0 ? formattedBalance : formattedBalance);
        });
    </script>
@endsection
