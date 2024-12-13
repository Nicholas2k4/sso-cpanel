@extends('layouts.base')

@section('body')
    <div class="container">
        <h1>Create Team</h1>
        <form action="{{ route('teams.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Team Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="leader_user_id" class="form-label">Team Leader</label>
                <select name="leader_user_id" id="leader_user_id" class="form-control" required>
                    <option value="" disabled selected>Select a Leader</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->display_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="logo" class="form-label">Logo</label>
                <input type="file" name="logo" id="logo" class="form-control" accept="image/*" required>
            </div>

            <button type="submit" class="btn btn-primary">Create Team</button>
        </form>
    </div>
@endsection
