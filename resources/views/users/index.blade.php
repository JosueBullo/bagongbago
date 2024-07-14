@extends('adminindex')

@section('content')
<div class="container">
    <h1 style="color: #fff;">User List</h1>
    <button class="btn btn-primary mb-3" id="createUserModalBtn">Create User</button>
    <table id="userTable" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Table rows will be dynamically added using JavaScript -->
        </tbody>
    </table>

    <!-- Create User Modal -->
    <div id="createUserModal" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createUserForm" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name" style="color: black;">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email" style="color: black;">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password" style="color: black;">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="image" style="color: black;">User Image</label>
                            <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-primary">Create User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div id="editUserModal" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="editUserId">
                        <div class="form-group">
                            <label for="editName" style="color: black;">Name</label>
                            <input type="text" class="form-control" id="editName" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="editEmail" style="color: black;">Email address</label>
                            <input type="email" class="form-control" id="editEmail" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="editPassword" style="color: black;">New Password</label>
                            <input type="password" class="form-control" id="editPassword" name="password">
                        </div>
                        <div class="form-group">
                            <label for="editImage" style="color: black;">User Image</label>
                            <input type="file" class="form-control-file" id="editImage" name="image" accept="image/*">
                        </div>
                        <div class="form-group">
                            <label for="editStatus" style="color: black;"></label>
                            <select class="form-control" id="editStatus" name="status" required>
                                <option value="active">Activate</option>
                                <option value="deactivated">Deactivate</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-info">Update User</button>
                    </form>
                </div>
            </div>
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
                { 
                    data: 'image', 
                    render: function(data) {
                        return data ? '<img src="{{ asset('storage/') }}/' + data + '" alt="User Image" width="50" height="50" />' : 'No Image';
                    }
                },
                { data: 'name' },
                { data: 'email' },
                { data: 'role' },
                { data: 'status' },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `
                            <button class="btn btn-warning editUser" data-id="${row.id}">Edit</button>
                            <button class="btn btn-danger deleteUser" data-id="${row.id}">Delete</button>
                        `;
                    }
                }
            ]
        });

        $('#createUserModalBtn').click(function() {
            $('#createUserModal').modal('show');
        });

        $('#createUserForm').submit(function(event) {
            event.preventDefault();
            $.ajax({
                url: "{{ route('users.store') }}",
                type: 'POST',
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function(response) {
                    alert(response.message);
                    userTable.ajax.reload();
                    $('#createUserModal').modal('hide');
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    if (errors) {
                        alert(errors.join('\n'));
                    }
                }
            });
        });

        $(document).on('click', '.editUser', function() {
            var userId = $(this).data('id');
            $.ajax({
                url: "{{ url('/users') }}/" + userId + "/edit",
                type: 'GET',
                success: function(user) {
                    $('#editUserId').val(user.id);
                    $('#editName').val(user.name);
                    $('#editEmail').val(user.email);
                    $('#editStatus').val(user.status); // Set the current status
                    $('#editUserModal').modal('show');
                }
            });
        });

        $('#editUserForm').submit(function(event) {
            event.preventDefault();
            var userId = $('#editUserId').val();
            $.ajax({
                url: "{{ url('/users') }}/" + userId,
                type: 'POST',
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function(response) {
                    alert(response.message);
                    userTable.ajax.reload();
                    $('#editUserModal').modal('hide');
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    if (errors) {
                        alert(errors.join('\n'));
                    }
                }
            });
        });

        $(document).on('click', '.deleteUser', function() {
            var userId = $(this).data('id');
            if (confirm("Are you sure you want to delete this user?")) {
                $.ajax({
                    url: "{{ url('/users') }}/" + userId,
                    type: 'DELETE',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function(response) {
                        alert(response.message);
                        userTable.ajax.reload();
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        if (errors) {
                            alert(errors.join('\n'));
                        }
                    }
                });
            }
        });
    });
</script>
@endsection
