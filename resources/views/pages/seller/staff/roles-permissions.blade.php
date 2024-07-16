@extends('layouts.seller')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Roles and Permissions</h3>
                    <p class="text-subtitle text-muted">Manage the relationships between roles and permissions.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Roles and Permissions</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content">
        <section class="section">
            <div class="container-fluid">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <table class="table table-hover" style="table-layout: fixed;">
                                <thead>
                                    <tr>
                                        <th>Roles</th>
                                        <th>Permissions</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $role)
                                        <form action="{{ route('roles-permissions.assign', $role->id) }}" method="POST"
                                            data-row-id="{{ $role->id }}" class="role-form">
                                            @csrf
                                            <tr>
                                                <td>{{ Str::title($role->name) }}</td>
                                                <td>
                                                    @foreach ($permissions as $permission)
                                                        <div class="form-check checkbox-group"
                                                            style="display: {{ $role->hasPermissionTo($permission) ? 'block' : 'none' }}">
                                                            <input type="checkbox" name="permissions[]"
                                                                value="{{ $permission->name }}"
                                                                {{ $role->hasPermissionTo($permission) ? 'checked' : '' }}
                                                                disabled>
                                                            <label class="form-check-label">
                                                                {{ Str::title(str_replace('_', ' ', $permission->name)) }}
                                                            </label>
                                                            <br>
                                                        </div>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-primary edit-btn"
                                                        data-row-id="{{ $role->id }}">Edit</button>
                                                    <button type="button" class="btn btn-secondary cancel-btn"
                                                        style="display: none">Cancel</button>
                                                    <button type="submit" class="btn btn-primary save-btn"
                                                        style="display: none">Save Permissions</button>
                                                </td>
                                            </tr>
                                        </form>
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

@section('scripts')
    <script>
        // Edit button click handler
        $(document).on('click', '.edit-btn', function() {
            const form = $(this).closest('tr');

            // Store the original values and checked state in data attributes
            form.find(':input').each(function() {
                const input = $(this);
                input.data('original-value', input.val());
                if (input.is(':checkbox')) {
                    input.data('original-checked', input.prop('checked'));
                }
            });

            // Enable the input fields by removing the 'disabled' attribute
            form.find(':input').prop('disabled', false);
            form.find('.edit-btn').hide();
            form.find('.cancel-btn, .save-btn').show();
            // Show the checkbox group within this form
            form.find('.checkbox-group').show();
        });

        // Cancel button click handler
        $(document).on('click', '.cancel-btn', function() {
            const form = $(this).closest('tr');

            form.find(':input').prop('disabled', true);
            form.find('.edit-btn').show();
            form.find('.edit-btn').prop('disabled', false);
            form.find('.cancel-btn, .save-btn').hide();

            // Find and iterate through all checkboxes within the form
            form.find(':checkbox').each(function() {
                const checkbox = $(this);
                const originalChecked = checkbox.data('original-checked');

                // Find the closest parent div with class "checkbox-group"
                const checkboxGroupDiv = checkbox.closest('.checkbox-group');

                // Revert the checked state based on the data attribute
                checkbox.prop('checked', originalChecked);

                if (!originalChecked) {
                    // If the checkbox is unchecked, hide its associated div
                    checkboxGroupDiv.hide();
                } else {
                    // If the checkbox is checked, show its associated div
                    checkboxGroupDiv.show();
                }
            });

            // Revert the input values to their original values
            form.find(':input').each(function() {
                $(this).val($(this).data('original-value'));
            });
        });
    </script>
@endsection
