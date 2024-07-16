@extends('layouts.admin')
@section('content')
    <div class="page-heading">
        <h3>User Management</h3>
    </div>
    <div class="page-content">
        <div class="container card">
            <div class="wrapper card-body">
                <section class="row">
                    <table class="table table-hover" id="usersTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Contact</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key => $user)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <span class="text-capitalize" id="name-{{ $user->id }}">{{ $user->display_name }}</span>
                                        <br>
                                        <span class="text-muted text-sm text-capitalize" id="role-{{ $user->id }}">{{ $user->getRoleRelation->role }}</span>
                                    </td>
                                    <td>
                                        <span>Email: {{ $user->email ?? 'N/A' }}</span>
                                        <br>
                                        <span class="text-muted text-sm">Mobile: {{ $user->mobile ?? 'N/A' }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if ($user->getRoleRelation->role == 'ban')
                                            <span class="badge rounded-pill text-bg-danger w-100 p-2">Restricted</span>
                                        @elseif ($user->getRoleRelation->role == 'dismissed')
                                            <span class="badge rounded-pill text-bg-secondary w-100 p-2">Inactive</span>
                                        @else
                                            <span class="badge rounded-pill text-bg-success w-100 p-2">Active</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-gear"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="{{ route('admin.user_management.show', $user->id) }}">View</a></li>
                                                <li><button class="dropdown-item manage-role" data-id='{{ $user->id }}'>Manage Role</button></li>
                                                <li><button class="dropdown-item restrict-user" data-id='{{ $user->id }}'>Restrict User</button></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </section>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.css">
@endsection

@section('scripts')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            function updateRole(user_id, role, alert = true) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var url = "{{ route('admin.user_management.update', ':id') }}";
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

            $('#usersTable').DataTable();

            $('.restrict-user').click(function() {
                var user_id = $(this).data('id');
                var name = $('#name-' + user_id).text().toLowerCase().split(' ').map((word) => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
                Swal.fire({
                    title: 'Restrict ' + name,
                    text: "Are you certain you want to add this user to the banned list?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#0d6efd',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, restrict this user!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        updateRole(user_id, 'ban', false);
                        Swal.fire(
                            'Ban Successfully!',
                            "This user's account will no longer be able to access the website.",
                            'success'
                        )
                    }
                })
            });

            $('.manage-role').click(function() {
                var user_id = $(this).data('id');
                var name = $('#name-' + user_id).text().toLowerCase().split(' ').map((word) => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
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
                            customer: 'Customer',
                            cashier: 'Cashier',
                            courier: 'Courier',
                            manager: 'Manager',
                            owner: 'Business Owner'
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
