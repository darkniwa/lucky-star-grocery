@extends('layouts.seller')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Promotion Center</h3>
                    <p class="text-subtitle text-muted">Effortlessly manage and send promotional emails to our valued
                        customers.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                            <li class="breadcrumb-item" aria-current="page">Promotions</li>
                            <li class="breadcrumb-item active" aria-current="page">Compose Email</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content">
        <form action="{{ route('mail.promotions.send') }}" name="form-mail-promotion" method="POST"
            id="form-mail-promotion">
            @csrf
            <section class="section">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <section class="section">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="card-title">Compose Promotion Email</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <textarea name="message" id="editor" cols="30" rows="10" placeholder="Enter Description Here">
                                                            </textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>

                                        <div class="col-md-12 mb-12">
                                            <h6>Send To Email</h6>
                                            <p>Select available email address</p>
                                            <div class="form-group">
                                                <label for="sendToAll">Send to All</label>
                                                <input type="checkbox" id="sendToAll">

                                                <select id="emailChoices" class="choices form-select multiple-remove"
                                                    multiple="multiple" name="email_address[]">
                                                    <optgroup label="Available Email List">
                                                        @foreach ($email_address_list as $email)
                                                            <option value="{{ $email->email }}">{{ $email->email }}</option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <center><button class="btn btn-primary" type="submit">Send</button>
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
        </form>
    </div>
@endsection


@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('scripts')
    <!-- Include Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- toastify -->
    <script src="{{ asset('assets/seller/vendors/toastify/toastify.js') }}"></script>
    <script src="{{ asset('assets/seller/vendors/ckeditor/ckeditor.js') }}"></script>

    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
    </script>

    <script>
        $(document).ready(function() {
            $('#emailChoices').select2({
                placeholder: 'Select an email',
                allowClear: true,
                tags: true, // Allow custom entries as tags
                createTag: function(params) {
                    var term = $.trim(params.term);
                    if (term === '') {
                        return null;
                    }
                    // Validate if it's a valid email address
                    // Return null to disable tag creation if it's not a valid email
                    return term.match(/@/) ? {
                        id: term,
                        text: term
                    } : null;
                }
            });
            
            $('#sendToAll').change(function() {
                if (this.checked) {
                    // If "Send to All" checkbox is checked, select all options
                    $('.choices option').prop('selected', true);
                } else {
                    // If "Send to All" checkbox is unchecked, deselect all options
                    $('.choices option').prop('selected', false);
                }

                // Trigger Choices library to update the selected options
                $('.choices').trigger('change');
            });
        });
    </script>
@endsection
