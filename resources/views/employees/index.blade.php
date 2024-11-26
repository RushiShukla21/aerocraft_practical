@extends('layout.header')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col col-md-6"><b>Employee Data</b></div>
                <div class="col col-md-6">
                    <a href="{{ route('employees.create') }}" class="btn btn-success btn-sm float-end">Add Employee</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered" id="empdata">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Gender</th>
                        <th>Hobby</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee)
                        <tr>
                            <td><img height="100px" width="100px" src="{{ $employee->photo }}" /></td>
                            <td>{{ $employee->first_name }}</td>
                            <td>{{ $employee->last_name }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->country_code }} {{ $employee->mobile_number }}</td>
                            <td>{{ $employee->gender }}</td>
                            <td>{{ json_encode($employee->hobby) }}</td>
                            <td>
                                <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-primary mb-2">Edit</a>
                                <form action="{{ route('employees.destroy', $employee->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-primary">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('jsscript')
    <script>
        $(document).ready(function() {
            $("#empdata").DataTable();
        });
    </script>
@endsection
