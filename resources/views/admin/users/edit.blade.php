@extends('admin.master')
@section('main-content')
<h3>Assign Roles to {{ $user->name }}</h3>
<form action="{{ route('admin.users.update', $user->id) }}" method="POST">
    @csrf @method('PUT')
    @foreach($roles as $role)
        <label>
            <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                {{ $user->roles->contains($role->id) ? 'checked' : '' }}>
            {{ $role->name }}
        </label><br>
    @endforeach
    <button class="btn btn-primary mt-2">Save</button>
    <a href="{{ route('users.index') }}" class="btn btn-secondary mt-2">Back</a>
</form>
@endsection
