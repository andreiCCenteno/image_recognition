@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit User</h2>
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
            </div>
            <div class="form-group">
                <label for="password">Password (Leave blank to keep current password)</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="form-check">
                <input type="checkbox" name="is_admin" class="form-check-input" {{ $user->is_admin ? 'checked' : '' }}>
                <label for="is_admin" class="form-check-label">Admin</label>
            </div>
            <button type="submit" class="btn btn-primary">Update User</button>
        </form>
    </div>
@endsection
