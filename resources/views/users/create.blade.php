@extends('adminindex')

@section('content')
<div class="container">
    <h1>Create User</h1>
    <form id="createUserForm" enctype="multipart/form-data">
        @csrf
        <input type="text" name="name" placeholder="Name">
        <input type="email" name="email" placeholder="Email">
        <input type="password" name="password" placeholder="Password">
        <input type="file" name="image" accept="image/*">
        <input type="submit" value="Create User">
    </form>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
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
    });
</script>
@endsection
