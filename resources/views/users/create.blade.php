@extends('layouts.app')

@section('title', 'User')

@section('content')

@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card">
    <div class="card-header">
        <h2>Create User</h2>

    </div>
    <form method="POST" action="{{ route('users.store') }}">
        <div class="card-body">
            @csrf
            <div class="mb-3 d-flex align-items-center">
                <label for="name" class="form-label me-3" style="width: 120px;">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required autofocus>
            </div>
            <div class="mb-3 d-flex align-items-center">
                <label for="email" class="form-label me-3" style="width: 120px;">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
            </div>
            <div class="mb-3 d-flex align-items-center">
                <label for="role" class="form-label me-3" style="width: 120px;">Role:</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            <div class="mb-3 d-flex align-items-center">
                <label for="password" class="form-label me-3" style="width: 120px;">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3 d-flex align-items-center">
                <label for="password_confirmation" class="form-label me-3" style="width: 120px;">Confirm Password:</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
            </div>

        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Create User</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>


@endsection