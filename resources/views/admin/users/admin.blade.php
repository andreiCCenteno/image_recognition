@extends('layouts.app')

@section('content')
    <style>
        body {
            background-color: #f4f7fa; /* Light background color for a modern look */
            font-family: 'Arial', sans-serif; /* Clean font for better readability */
        }

        .container {
            max-width: 1200px; /* Set maximum width for container */
            margin: 20px auto; /* Center container with margin */
            padding: 20px; /* Padding for content */
            background-color: #ffffff; /* White background for the content area */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Soft shadow for depth */
        }

        h2 {
            text-align: center; /* Centered heading */
            margin-bottom: 30px; /* Space below heading */
            color: #333; /* Dark text color for contrast */
            font-size: 24px; /* Larger font size for headings */
        }

        .alert {
            margin-bottom: 20px; /* Space below alert messages */
        }

        .btn {
            margin-right: 10px; /* Space between buttons */
            padding: 10px 15px; /* Padding for buttons */
            border-radius: 4px; /* Rounded button corners */
        }

        .table {
            width: 100%; /* Full-width table */
            border-collapse: collapse; /* Collapse borders for a cleaner look */
        }

        .table th {
            background-color: #007bff; /* Bootstrap primary color */
            color: white; /* White text for table header */
            padding: 12px; /* Padding for header cells */
            text-align: left; /* Left-align header text */
            border-bottom: 2px solid #dee2e6; /* Bottom border for header */
        }

        .table td {
            padding: 12px; /* Padding for table cells */
            border-bottom: 1px solid #dee2e6; /* Bottom border for table rows */
            vertical-align: middle; /* Center table cell contents */
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f2f2f2; /* Zebra striping for table rows */
        }

        .actions {
            display: flex; /* Flexbox for action buttons */
            gap: 10px; /* Space between action buttons */
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .container {
                padding: 10px; /* Reduce padding on smaller screens */
            }

            h2 {
                font-size: 20px; /* Smaller heading on mobile */
            }

            .btn {
                padding: 8px 10px; /* Smaller button padding on mobile */
            }
        }
    </style>

    <div class="container mt-4">
        <h2>User Management</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Add User</a>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->is_admin ? 'Admin' : 'User' }}</td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    {{-- Include any additional scripts here --}}
@endsection
