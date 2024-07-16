@extends('layouts.owner')

@section('content')
    <div class="page-heading">
        <h3>User Information</h3>
    </div>
    <section style="background-color: #eee;">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('owner.employees') }}">Employees</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{$user->display_name}}</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <img src="{{ $user->getCustomerRelation->picture ?? asset('assets/admin/images/default-avatar.png') }}" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
                            <h5 class="my-3 text-capitalize">{{ $user->display_name }}</h5>
                            <p class="text-muted mb-1 text-capitalize" id="role-{{ $user->id }}">{{ $user->getRoleRelation->role }}</p>
                            <hr>
                            <div class="d-flex justify-content-center mb-2">
                                <button type="button" class="btn btn-primary" id="manage-role">Manage Role</button>
                                <button type="button" class="btn btn-outline-danger ms-1" id="restrict-user">Dismiss</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Full Name</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0 text-capitalize">{{ $user->display_name }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Email</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $user->email ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Phone</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $user->mobile ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Gender</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $user->getCustomerRelation->gender ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Home Address</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ Auth::user()->homeAddress ? Auth::user()->homeAddress->getFormattedAddress() : '' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('styles')
@endsection

@section('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            function updateRole(user_id, role, alert = true) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var url = "{{ route('owner.employees.update', ':id') }}";
                url = url.replace(':id', user_id);

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        role: role,
                    },
                    success: function(data) {
                        $('#role-' + user_id).text(role);
                        if (alert) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Role Successfully Updated',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    },
                    error: function(data) {
                        if (alert) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed to Change the Role',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    }
                });
            }
            
            $('#restrict-user').click(function() {
                var user_id = "{{ $user->id }}";
                var name = "{{ $user->display_name }}".toLowerCase().split(' ').map((word) => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
                Swal.fire({
                    title: 'Dismiss ' + name,
                    text: "Are you sure you want to dismiss this employee?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#0d6efd',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, dismiss this employee!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        updateRole(user_id, 'dismissed', false);
                        Swal.fire(
                            'Dismissed Successfully!',
                            "This employee account will no longer be able to access the system.",
                            'success'
                        )
                    }
                })
            });



            $('#manage-role').click(function() {
                var user_id = "{{ $user->id }}";
                var name = "{{ $user->display_name }}".toLowerCase().split(' ').map((word) => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
                (async () => {

                    const {
                        value: role
                    } = await Swal.fire({
                        title: 'Change Role for ' + name,
                        icon: 'info',
                        confirmButtonColor: '#0d6efd',
                        cancelButtonColor: '#d33',
                        input: 'select',
                        inputOptions: {
                            cashier: 'Cashier',
                            courier: 'Courier',
                            manager: 'Manager',
                        },
                        inputPlaceholder: 'Select Role',
                        showCancelButton: true,
                        inputValidator: (value) => {
                            return new Promise((resolve) => {
                                if (value === 'customer') {
                                    resolve()
                                } else if (value === 'customer') {
                                    resolve()
                                } else if (value === 'cashier') {
                                    resolve()
                                } else if (value === 'courier') {
                                    resolve()
                                } else if (value === 'manager') {
                                    resolve()
                                } else if (value === 'owner') {
                                    resolve()
                                } else {
                                    resolve('You need to select role!')
                                }
                            })
                        }
                    })

                    if (role) {
                        updateRole(user_id, role);
                    }

                })()
            });
        });
    </script>
@endsection
