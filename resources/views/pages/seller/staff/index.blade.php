@extends('layouts.seller')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Staff Management</h3>
                    <p class="text-subtitle text-muted">Efficiently manage your team of staff members. Add, edit, or remove
                        staff with ease and assign them appropriate roles for better organization and control.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('staff.index') }}">Staff
                                    Management</a></li>
                            <li class="breadcrumb-item active" aria-current="page">List</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">Staff List</h2>
                        <a href="{{ route('staff.create') }}" class="btn btn-success">Add Staff</a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-hover" id="staff-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr data-user-id="{{ $user->id }}" data-staff-id="{{$user->staff->id}}">
                                    <td>{{ $user->staff->getDisplayNameAttribute() }}</td>
                                    <td>
                                        {{ $user->mobile }}<br>
                                        @if ($user->email)
                                            <small class="text-muted">Email: {{ $user->email }}</small>
                                        @endif
                                    </td>
                                    <td class="user-roles">
                                        @foreach ($user->roles as $role)
                                            @if (in_array($role->name, ['owner', 'manager', 'cashier', 'courier', 'promodiser']))
                                                @php
                                                    $badgeClass = '';
                                                    switch ($role->name) {
                                                        case 'manager':
                                                            $badgeClass = 'badge-manager';
                                                            break;
                                                        case 'cashier':
                                                            $badgeClass = 'badge-cashier';
                                                            break;
                                                        case 'courier':
                                                            $badgeClass = 'badge-courier';
                                                            break;
                                                        case 'promodiser':
                                                            $badgeClass = 'badge-promodiser';
                                                            break;
                                                    }
                                                @endphp
                                                <span class="badge {{ $badgeClass }}">{{ $role->name }}</span>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="User Actions">
                                            <a href="{{ route('staff.edit', $user->staff->id) }}"
                                                class="btn btn-primary btn-sm">Edit</a>
                                            <button type="button" class="btn btn-danger btn-sm delete-user"
                                                data-toggle="modal" data-target="#deleteModal">Delete</button>
                                            <button type="button" class="btn btn-info btn-sm view-details">View
                                                Details</button>
                                            <button type="button" class="btn btn-secondary btn-sm assign-role"
                                                data-user-id="{{ $user->id }}"
                                                data-staff-id="{{ $user->staff->id }}"
                                                data-user-roles="{{ implode(',', $user->roles->pluck('name')->toArray()) }}">Assign
                                                Role</button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">No staff members found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="modal fade" id="staffDetailsModal" tabindex="-1" aria-labelledby="staffDetailsModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staffDetailsModalLabel">Staff Details</h5>
                                    <button type="button" class="btn-close modal-close" data-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Add your staff details content here -->
                                    <div id="staffDetailsContent">
                                        <!-- Staff details will be loaded here dynamically -->
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary modal-close"
                                        data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Increase the z-index for Select2 dropdown */
        .select2-container--default .select2-dropdown {
            z-index: 999999;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#staff-table').DataTable();

            // Enable Bootstrap tooltips
            $('[data-toggle="tooltip"]').tooltip();

            // Assign Role
            $('.assign-role').click(function() {
                // Implement assign role functionality here
                // You can use the data-user-id attribute to identify the user
            });

            // Delete User
            $('.delete-user').click(function() {
                // Show SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Delete Staff Member',
                    text: 'Are you sure you want to delete this user?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    var userIdToDelete = $(this).closest('tr').data('user-id');
                    var $trToDelete = $(this).closest('tr'); // Select the <tr> element

                    if (result.isConfirmed) {
                        // Replace :userId with the actual user ID
                        console.log(userIdToDelete);
                        var url = `/roles-and-permissions/remove-staff/${userIdToDelete}`;

                        // Get the CSRF token from Laravel
                        var csrfToken = '{{ csrf_token() }}';

                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken // Set the CSRF token in the headers
                            },
                            success: function(response) {
                                // Handle the successful response
                                console.log(response);
                                $trToDelete.remove();
                                Swal.fire(
                                    'Deleted!',
                                    response.message,
                                    'success'
                                );
                            },
                            error: function(error) {
                                // Handle any errors that occur during the request
                                Swal.fire(
                                    'Error!',
                                    'An error occurred while deleting the account.',
                                    'error'
                                );
                                console.error(error);
                            }
                        });
                    }
                });
            });
        });

        $(document).ready(function() {
            // Function to handle role assignment
            function assignRole(userId, userRoles) {
                Swal.fire({
                    title: 'Assign Roles',
                    html: '<select class="form-select" id="assignedRoles" multiple>' +
                        '<option value="manager">Manager</option>' +
                        '<option value="cashier">Cashier</option>' +
                        '<option value="courier">Courier</option>' +
                        '<option value="promodiser">Promodiser</option>' +
                        '</select>',
                    showCancelButton: true,
                    confirmButtonText: 'Assign',
                    preConfirm: () => {
                        const selectedRoles = $('#assignedRoles').val();
                        // Handle role assignment here, you can send a request to your server
                        // with the selectedRoles and userId to update the roles.
                        $.ajax({
                            url: `/roles-and-permissions/update-user-roles/${userId}`,
                            method: 'POST',
                            data: {
                                roles: selectedRoles,
                                _token: '{{ csrf_token() }}', // Add CSRF token for Laravel
                            },
                            success: function(response) {
                                const badges = response.updatedRoles.map(role => {
                                    let badgeClass = '';
                                    switch (role) {
                                        case 'manager':
                                            badgeClass = 'badge-manager';
                                            break;
                                        case 'cashier':
                                            badgeClass = 'badge-cashier';
                                            break;
                                        case 'courier':
                                            badgeClass = 'badge-courier';
                                            break;
                                        case 'promodiser':
                                            badgeClass = 'badge-promodiser';
                                            break;
                                        default:
                                            badgeClass =
                                                'bg-primary'; // You can specify a default class for other roles
                                    }
                                    return `<span class="badge ${badgeClass}">${role}</span>`;
                                });

                                // Find the corresponding <td> element by data-user-id and update its content with badges
                                $(`tr[data-user-id="${userId}"] .user-roles`).html(badges
                                    .join(' '));

                                // Find the button element with the specific data-user-id attribute
                                const assignRoleButton = $(
                                    `[data-user-id="${userId}"] .assign-role`);

                                // Update the data-user-roles attribute with the updated roles using .data()
                                assignRoleButton.data('user-roles', response.updatedRoles
                                    .join(','));

                                Swal.fire('Success', response.message, 'success');
                            },
                            error: function(xhr) {
                                Swal.fire('Error',
                                    'An error occurred while updating roles.', 'error');
                            }
                        });
                    },
                    didOpen: () => {
                        // Set the selected roles in the dropdown
                        $('#assignedRoles').val(userRoles);
                        // Initialize Select2 for the dropdown
                        $('#assignedRoles').select2();
                    }
                });
            }

            // Add click event listener to the "Assign Role" button
            $('.assign-role').on('click', function() {
                const userId = $(this).data('user-id');
                const userRoles = $(this).data('user-roles').split(',');
                assignRole(userId, userRoles);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Handle the "View Details" button click
            $('.view-details').on('click', function() {
                const staffId = $(this).closest('tr').data('staff-id');

                // Send an AJAX request to fetch staff details
                $.ajax({
                    url: `/staff/${staffId}`, // Updated route to fetch staff details
                    method: 'GET',
                    success: function(data) {
                        // Populate the modal content with the fetched data
                        $('#staffDetailsContent').html(data);
                        $('#staffDetailsModal').modal('show');
                    },
                    error: function(error) {
                        // Handle any errors
                        console.error(error);
                    }
                });
            });

            // Function to close the Bootstrap modal
            function closeModal() {
                $('#staffDetailsModal').modal('hide');
            }

            // Add click event listener to close button and "x" button in the modal
            $('#staffDetailsModal .modal-close').click(function() {
                closeModal();
            });
        });
    </script>
@endsection
