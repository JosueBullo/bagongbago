@extends('adminindex')

@section('content')
<div class="container">
    <h1 style="color: #fff;">User List</h1>
    <button class="createUserBtn" id="createUserModalBtn">Create User</button>
    <table id="userTable" class="display">
        <thead>
            <tr>
                <th style="color: #fff;">ID</th>
                <th style="color: #fff;">Image</th>
                <th style="color: #fff;">Name</th>
                <th style="color: #fff;">Email</th>
                <th style="color: #fff;">Role</th>
                <th style="color: #fff;">Actions</th>
            </tr>
        </thead>
        <tbody style="color: #000;">
            <!-- Here you can add table rows dynamically using JavaScript -->
        </tbody>
    </table>

    <div id="createUserModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form id="createUserForm" enctype="multipart/form-data">
                @csrf
                <input type="text" name="name" placeholder="Name">
                <input type="email" name="email" placeholder="Email">
                <input type="password" name="password" placeholder="Password">
                <input type="file" name="image" accept="image/*">
                <input type="submit" value="Create User">
            </form>
        </div>
    </div>

    <div id="editUserModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form id="editUserForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="editUserId">
                <input type="text" name="name" id="editUserName" placeholder="Name">
                <input type="email" name="email" id="editUserEmail" placeholder="Email">
                <input type="password" name="password" id="editUserPassword" placeholder="New Password">
                <input type="file" name="image" id="editUserImage" accept="image/*">
                <input type="submit" value="Update User">
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        var userTable = $('#userTable').DataTable({
            ajax: "{{ route('users.index') }}",
            columns: [
                { data: 'id' },
                { data: 'image', render: function(data) {
                    return data ? '<img src="{{ asset('storage/') }}/' + data + '" alt="User Image" width="50" height="50" />' : 'No Image';
                }},
                { data: 'name' },
                { data: 'email' },
                { data: 'role' },
                { data: 'id', render: function(data) {
                    return '<a href="#" class="editUser" data-id="' + data + '">Edit</a> | <a href="#" class="deleteUser" data-id="' + data + '">Delete</a>';
                }}
            ]
        });

        $('#createUserModalBtn').click(function() {
            $('#createUserModal').css('display', 'block');
        });

        $(document).on('submit', '#createUserForm', function(event) {
            event.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url: "{{ route('users.store') }}",
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function(result) {
                    console.log(result);
                    alert(result.message);
                    userTable.ajax.reload();
                    $('#createUserModal').css('display', 'none');
                    $('#createUserForm')[0].reset();
                },
                error: function(xhr, status, error) {
                    var errors = xhr.responseJSON.errors;
                    if (errors) {
                        alert(errors.join('\n'));
                    }
                }
            });
        });

        $(document).on('click', '.editUser', function(event) {
            event.preventDefault();
            var userId = $(this).data('id');
            $('#editUserModal').css('display', 'block');

            $.ajax({
                url: "{{ url('/users') }}/" + userId + "/edit",
                type: 'GET',
                success: function(data) {
                    $('#editUserId').val(data.id);
                    $('#editUserName').val(data.name);
                    $('#editUserEmail').val(data.email);
                }
            });
        });

        $(document).on('submit', '#editUserForm', function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            var userId = $('#editUserId').val();

            $.ajax({
                url: "{{ url('/users') }}/" + userId,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function(result) {
                    console.log(result);
                    alert(result.message);
                    userTable.ajax.reload();
                    $('#editUserModal').css('display', 'none');
                },
                error: function(xhr, status, error) {
                    var errors = xhr.responseJSON.errors;
                    if (errors) {
                        alert(errors.join('\n'));
                    }
                }
            });
        });

        $(document).on('click', '.deleteUser', function(event) {
            event.preventDefault();
            var userId = $(this).data('id');
            if (confirm("Are you sure you want to delete this user?")) {
                $.ajax({
                    url: "{{ url('/users') }}/" + userId,
                    type: 'DELETE',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function(result) {
                        console.log(result);
                        alert(result.message);
                        userTable.ajax.reload();
                    },
                    error: function(xhr, status, error) {
                        var errors = xhr.responseJSON.errors;
                        if (errors) {
                            alert(errors.join('\n'));
                        }
                    }
                });
            }
        });

        $('.close').click(function() {
            $('#createUserModal').css('display', 'none');
            $('#editUserModal').css('display', 'none');
        });

        $(window).click(function(event) {
            if (event.target == $('#createUserModal')[0]) {
                $('#createUserModal').css('display', 'none');
            }
            if (event.target == $('#editUserModal')[0]) {
                $('#editUserModal').css('display', 'none');
            }
        });
    });
</script>
@endsection
