@extends('adminindex')

@section('content')
<div class="container">
    <h1>Edit User</h1>
    <form id="editUserForm" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{ $user->id }}">
        <input type="text" name="name" placeholder="Name" value="{{ $user->name }}">
        <input type="email" name="email" placeholder="Email" value="{{ $user->email }}">
        <input type="password" name="password" placeholder="New Password">
        <input type="file" name="image" accept="image/*">
        <input type="submit" value="Update User">
    </form>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $(document).on('submit', '#editUserForm', function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            var userId = formData.get('id');

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
                    $('#editUserModal').css('display', 'none');
                    // Optionally reload the user list or update UI
                },
                error: function(xhr, status, error) {
                    var errors = xhr.responseJSON.errors;
                    if (errors) {
                        alert(errors.join('\n'));
                    }
                }
            });
        });
    });
</script>
@endsection
