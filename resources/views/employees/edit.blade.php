@extends('layout.header')

@section('content')
    <div class="card">
        <div class="card-header">Update Employee</div>
        <div class="card-body">
            <form method="POST" id="empfrm" action="{{ route('employees.update', $employee->id) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $employee->id }}" />
                <div class="row mb-3">
                    <label for="first_name" class="col-sm-2 col-label-form">First Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="first_name" id="first_name" placeholder="Enter First Name"
                            class="form-control" value="{{ $employee->first_name }}" />

                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-label-form">Last Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="last_name" id="last_name" placeholder="Enter Last Name"
                            class="form-control" value="{{ $employee->last_name }}" />
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-label-form">Email</label>
                    <div class="col-sm-10">
                        <input type="email" name="email" id="email" placeholder="Enter Your Email"
                            class="form-control" value="{{ $employee->email }}" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-label-form">Mobile Number</label>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <select name="country_code" id="country_code" class="input-group-text">
                                <option value="+91" <?php if ($employee->country_code == '+91') {
                                    echo 'selected';
                                } ?>>+91</option>
                                <option value="+1" <?php if ($employee->country_code == '+1') {
                                    echo 'selected';
                                } ?>>+1</option>
                            </select>
                            <input type="text" aria-label="First name" class="form-control" name="mobile_number"
                                id="mobile_number" value="{{ $employee->mobile_number }}">
                        </div>
                        <label id="mobile_number-error" class="error" for="mobile_number"></label>
                    </div>
                </div>


                <div class="row mb-3">
                    <label class="col-sm-2 col-label-form">Address</label>
                    <div class="col-sm-10">
                        <textarea rows="5" name="address" id="address" placeholder="Enter your address" class="form-control">{{ $employee->address }}</textarea>
                    </div>
                </div>

                <div class="row mb-4">
                    <label class="col-sm-2 col-label-form">Gender</label>
                    <div class="col-sm-10">
                        <input type="radio" name="gender" value="Male" <?php if ($employee->gender == 'Male') {
                            echo 'checked';
                        } ?> /> Male
                        <input type="radio" name="gender" value="Female" <?php if ($employee->gender == 'Female') {
                            echo 'checked';
                        } ?> /> Female
                        <label id="gender-error" class="error" for="gender"></label>
                    </div>
                </div>

                <div class="row mb-4">
                    <label class="col-sm-2 col-label-form">Hobby</label>
                    <div class="col-sm-10">
                        <?php $checkarr = $employee->hobby; ?>
                        <input type="checkbox" name="hobby[]" value="Cricket" <?php if (in_array('Cricket', $checkarr)) {
                            echo 'checked';
                        } ?> /> Cricket
                        <input type="checkbox" name="hobby[]" value="Chess" <?php if (in_array('Chess', $checkarr)) {
                            echo 'checked';
                        } ?> /> Chess
                        <input type="checkbox" name="hobby[]" value="Music" <?php if (in_array('Music', $checkarr)) {
                            echo 'checked';
                        } ?> /> Music

                        <label id="hobby[]-error" class="error" for="hobby[]"></label>
                    </div>

                </div>
                <div class="row mb-4">
                    <label class="col-sm-2 col-label-form">Photo</label>
                    <div class="col-sm-10">
                        <input type="file" name="photo" id="photo" class="form-control" />
                    </div>
                </div>
                <div class="text-center">
                    <input type="submit" class="btn btn-primary" value="Update" />
                    <a href="{{ route('employees.index') }}" class="btn btn-danger">Back</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('jsscript')
    <script>
        $(document).ready(function() {
            $("#empfrm").validate({
                ignore: [],
                rules: {
                    first_name: {
                        required: true,
                        maxlength: 25,
                    },
                    last_name: {
                        required: true,
                        maxlength: 25,
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    country_code: {
                        required: true,
                    },
                    mobile_number: {
                        required: true,
                        number: true,
                    },
                    address: {
                        required: true,
                    },
                    gender: {
                        required: true,
                    },
                    "hobby[]": {
                        required: true,
                    },
                    photo: {
                        extension: "jpg|jpeg|png"
                    }
                },
                messages: {
                    first_name: {
                        required: "Enter your first name",
                        maxlength: "Enter maximum 25 characters",
                    },
                    last_name: {
                        required: "Enter your last name",
                        maxlength: "Enter maximum 25 characters",
                    },
                    email: {
                        required: "Enter your email",
                        email: "Please enter your correct email address",
                    },
                    country_code: {
                        required: "Select your country code",
                    },
                    mobile_number: {
                        required: "Enter your mobile number",
                        number: "Allowed digits only!",
                    },
                    address: {
                        required: "Enter your adderss",
                    },
                    gender: {
                        required: "Select your gender",
                    },
                    "hobby[]": {
                        required: "Select your hobby",
                    },
                    photo: {
                        extension: "Allowed JPG|JPEG|PNG only"
                    }
                }
            });
        });
    </script>
@endsection
