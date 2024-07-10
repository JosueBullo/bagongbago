<!-- resources/views/users/users_list.blade.php -->

@foreach ($users as $user)
    <div class="user-profile">
        <img src="{{ asset($user->image ? 'storage/' . $user->image : 'images/default-profile.jpg') }}" alt="User Profile Image">
        <div class="user-details">
            <strong>{{ $user->name }}</strong><br>
            {{ $user->email }}<br>
            Role: {{ $user->role }} <!-- Display user role here -->
        </div>
        <div class="user-actions">
            <a href="#" class="editUser" data-id="{{ $user->id }}">Edit</a>
            <a href="#" class="deleteUser" data-id="{{ $user->id }}">Delete</a>
        </div>
    </div>
@endforeach
