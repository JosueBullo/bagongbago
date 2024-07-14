@extends('adminindex')

@section('styles')
<style>
    body {
        background-color: #000;
        color: #fff;
    }
    .container, .card, .modal-content {
        background-color: #333;
    }
    .card-header, .modal-header, .modal-footer {
        background-color: #444;
    }
    .btn {
        background-color: #007bff;
        color: #fff;
    }
    .btn:hover {
        background-color: #0056b3;
    }
    .btn-secondary {
        background-color: #6c757d;
    }
    .btn-secondary:hover {
        background-color: #565e64;
    }
    .table {
        background-color: #000;
        color: #fff;
    }
    .table thead th {
        background-color: #333;
    }
    .table tbody tr {
        background-color: #444;
    }
    .table tbody tr:hover {
        background-color: #555;
    }
    .form-control {
        background-color: #444;
        color: #fff;
    }
</style>
@endsection

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            Categories
            <button class="btn btn-primary float-right" data-toggle="modal" data-target="#createCategoryModal">Create Category</button>
        </div>
        <div class="card-body">
            <table id="categoriesTable" class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- Modal for category editing -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editCategoryForm">
                <div class="modal-body">
                    <input type="hidden" id="editCategoryId" name="id">
                    <div class="form-group">
                        <label for="editCategoryName">Name</label>
                        <input type="text" class="form-control" id="editCategoryName" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="editCategoryDescription">Description</label>
                        <textarea class="form-control" id="editCategoryDescription" name="description" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for category creation -->
<div class="modal fade" id="createCategoryModal" tabindex="-1" role="dialog" aria-labelledby="createCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createCategoryModalLabel">Create Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="createCategoryForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="createCategoryName">Name</label>
                        <input type="text" class="form-control" id="createCategoryName" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="createCategoryDescription">Description</label>
                        <textarea class="form-control" id="createCategoryDescription" name="description" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function () {
        var dataTable = $('#categoriesTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "/api/categories",
                "type": "GET",
                "dataSrc": ""
            },
            "columns": [
                { "data": "id" },
                { "data": "name" },
                { "data": "description" },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        return '<button class="btn btn-warning btn-edit" data-id="' + row.id + '">Edit</button> ' +
                               '<button class="btn btn-danger btn-delete" data-id="' + row.id + '">Delete</button>';
                    }
                }
            ]
        });

        $('#editCategoryForm').on('submit', function(event) {
            event.preventDefault();
            var id = $('#editCategoryId').val();
            $.ajax({
                url: '/api/categories/' + id,
                type: 'PUT',
                data: $(this).serialize(),
                success: function(category) {
                    $('#editCategoryModal').modal('hide');
                    dataTable.ajax.reload();
                },
                error: function(xhr) {
                    console.error('Error updating category:', xhr.responseText);
                }
            });
        });

        $('#createCategoryForm').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: '/api/categories',
                type: 'POST',
                data: $(this).serialize(),
                success: function(category) {
                    $('#createCategoryModal').modal('hide');
                    dataTable.ajax.reload();
                },
                error: function(xhr) {
                    console.error('Error creating category:', xhr.responseText);
                }
            });
        });

        // Edit Category modal handling
        $('#categoriesTable').on('click', '.btn-edit', function() {
            var categoryId = $(this).data('id');
            $.ajax({
                url: '/api/categories/' + categoryId,
                method: 'GET',
                success: function(response) {
                    $('#editCategoryId').val(response.id);
                    $('#editCategoryName').val(response.name);
                    $('#editCategoryDescription').val(response.description);
                    $('#editCategoryModal').modal('show');
                }
            });
        });

        // Delete Category
        $('#categoriesTable').on('click', '.btn-delete', function() {
            var categoryId = $(this).data('id');
            if (confirm('Are you sure you want to delete this category?')) {
                $.ajax({
                    url: '/api/categories/' + categoryId,
                    type: 'DELETE',
                    success: function(response) {
                        dataTable.ajax.reload();
                    },
                    error: function(xhr) {
                        console.error('Error deleting category:', xhr.responseText);
                    }
                });
            }
        });
    });
</script>
@endsection