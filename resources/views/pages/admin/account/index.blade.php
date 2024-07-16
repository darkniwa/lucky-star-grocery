@extends('layouts.admin')
@section('content')
<div class="page-heading">
    <div class="page-title pb-5">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Profile Settings</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">My Profile</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Contents Here -->
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{route('admin.account.profile.update')}}" name="form-add-products" method="POST" >
    @csrf
    <section class="section">
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header bg-dark text-light">
                        Basic Information
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <h6 for="basicInput">First Name</h6>
                                    <input type="text" class="form-control form-editable" id="basicInput" placeholder="Enter you first name" name="FirstName" value="{{Auth::user()->getCustomerRelation->first_name}}" disabled>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                    <h6 for="basicInput">Last Name</h6>
                                    <input type="text" class="form-control form-editable" id="basicInput" placeholder="Enter your last name" name="LastName" value="{{Auth::user()->getCustomerRelation->last_name}}" disabled>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <h6 for="basicInput">Email</h6>
                                    <input type="text" class="form-control {{Auth::user()->email_verified_at != NULL ? 'is-valid' : ''}}" id="basicInput" placeholder="Enter your contact number" name="EmailAddress" value="{{Auth::user()->email}}" disabled>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                    <h6 for="basicInput">Contact No.</h6>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">+63</span>
                                        <input type="text" class="form-control {{Auth::user()->mobile_verified_at != NULL ? 'is-valid' : ''}} form-editable" id="basicInput" placeholder="(+10 Digits) Mobile number" name="mobile" value="{{Auth::user()->mobile}}" disabled>
                                    </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <h6>Gender</h6>
                                    <div class="input-group mb-3">
                                        <select class="form-select form-editable" id="inputGroupSelect01" name="Gender" disabled>
                                            <option value="0" disabled {{Auth::user()->getCustomerRelation->gender == NULL ? 'selected' : ''}}>Choose ...</option>
                                            <option value="Male" {{Auth::user()->getCustomerRelation->gender == 'Male' ? 'selected' : ''}}>Male</option>
                                            <option value="Female" {{Auth::user()->getCustomerRelation->gender == 'Female' ? 'selected' : ''}}>Female</option>
                                            <option value="Prefer not to say" {{Auth::user()->getCustomerRelation->gender == 'Prefer not to say' ? 'selected' : ''}}>Prefer not to say</option>
                                        </select>
                                        <label class="input-group-text" for="inputGroupSelect01">Options</label>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <center>
                                            <button class="btn btn-secondary" type="button" id="btn-edit"> Edit </button>
                                            <button class="btn btn-secondary" type="button" id="btn-cancel" hidden> Cancel </button>
                                            <button class="btn btn-primary" type="submit" id="btn-save" hidden> Save </button>
                                        </center>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           
        </div>
    </section>
</div>
</form>

@endsection


@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#btn-edit').click(function(){
                $(this).attr('hidden', true);
                $('#btn-cancel').attr('hidden', false);
                $('#btn-save').attr('hidden', false);
                $('.form-editable').attr('disabled', false);
            });

            $('#btn-cancel').click(function(){
                $(this).attr('hidden', true);
                $('#btn-edit').attr('hidden', false);
                $('#btn-save').attr('hidden', true);
                $('.form-editable').attr('disabled', true);
            });
        });
    </script>
@endsection


