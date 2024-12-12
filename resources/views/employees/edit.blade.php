<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Employee</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name', $employee->first_name) }}" required>
            </div>

            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name', $employee->last_name) }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $employee->email) }}" required>
            </div>
            <div class="mb-3">
                <label for="country_code" class="form-label">Country Code</label>
                <select class="form-select" name="country_code" id="country_code" required>
                    <option value="+1">+1 (USA)</option>
                    <option value="+91">+91 (India)</option>
                    
                </select>
            </div>
            <div class="mb-3">
                <label for="mobile_number" class="form-label">Mobile Number</label>
                <input type="text" name="mobile_number" id="mobile_number" class="form-control" value="{{ old('mobile_number', $employee->mobile_number) }}" required>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea name="address" id="address" class="form-control" rows="3" required>{{ old('address', $employee->address) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Gender</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="gender_male" value="Male" {{ old('gender', $employee->gender) == 'Male' ? 'checked' : '' }}>
                    <label class="form-check-label" for="gender_male">Male</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="gender_female" value="Female" {{ old('gender', $employee->gender) == 'Female' ? 'checked' : '' }}>
                    <label class="form-check-label" for="gender_female">Female</label>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Hobbies</label><br>
                @php
                    $hobbies = ['Reading', 'Traveling', 'Sports'];
                    $selectedHobbies = explode(',', $employee->hobby);
                @endphp
                @foreach ($hobbies as $hobby)
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="hobby[]" value="{{ $hobby }}" id="hobby_{{ $hobby }}" {{ in_array($hobby, $selectedHobbies) ? 'checked' : '' }}>
                        <label class="form-check-label" for="hobby_{{ $hobby }}">{{ $hobby }}</label>
                    </div>
                @endforeach
            </div>

            <div class="mb-3">
                <label for="photo" class="form-label">Photo</label><br>
                @if ($employee->photo)
                    <img src="{{ asset('storage/' . $employee->photo) }}" alt="Employee Photo" class="img-thumbnail" width="100">
                @endif
                <input type="file" name="photo" id="photo" class="form-control mt-2">
            </div>

            <button type="submit" class="btn btn-primary">Update Employee</button>
            <a href="{{ route('employees.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>