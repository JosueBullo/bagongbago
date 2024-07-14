@extends('adminindex')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">

    <style>
        body {
            background-color: #121212;
            color: white;
        }
        .main-content {
            padding: 20px;
            text-align: center;
        }
        .top-panel {
            background-color: #1e1e1e;
            color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            border-bottom: 1px solid #333;
        }
        .top-panel a {
            color: #fff;
            margin-left: 20px;
            text-decoration: none;
        }
        .top-panel a:hover {
            color: #bb86fc;
        }
        .modal-body label {
            color: black;
        }
        .edit-btn {
            background-color: yellow;
            color: black;
        }
        .delete-btn {
            background-color: red;
            color: white;
        }
    </style>
</head>
<body>
    <div class="main-content">
        <div class="container mt-4">
            <h2>Product List</h2>
            <div class="mb-3">
                <button class="btn btn-primary" id="btnAdd">Add Product</button>
            </div>
            <table id="productList" class="display">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Table body will be populated by DataTables -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for Add Product -->
    <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addProductForm" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="productName">Name</label>
                            <input type="text" class="form-control" id="productName" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="productDescription">Description</label>
                            <textarea class="form-control" id="productDescription" name="description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="productPrice">Price</label>
                            <input type="number" class="form-control" id="productPrice" name="price" required>
                        </div>
                        <div class="form-group">
                            <label for="productImage">Product Image</label>
                            <input type="file" class="form-control" id="productImage" name="image" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Edit Product -->
    <div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editProductForm" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="editProductId" name="id">
                        <div class="form-group">
                            <label for="editProductName">Name</label>
                            <input type="text" class="form-control" id="editProductName" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="editProductDescription">Description</label>
                            <textarea class="form-control" id="editProductDescription" name="description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="editProductPrice">Price</label>
                            <input type="number" class="form-control" id="editProductPrice" name="price" required>
                        </div>
                        <div class="form-group">
                            <label for="editProductImage">Product Image</label>
                            <input type="file" class="form-control" id="editProductImage" name="image">
                        </div>
                        <button type="submit" class="btn btn-primary">Update Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {
            const table = $('#productList').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('products.index') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'image', render: function (data) {
                        return data ? '<img src="' + data + '" width="50" height="50">' : 'No Image';
                    }},
                    { data: 'name', name: 'name' },
                    { data: 'description', name: 'description' },
                    { data: 'categories', name: 'categories' },
                    { data: 'price', name: 'price' },
                    { data: 'action', orderable: false, searchable: false }
                ]
            });

            $('#btnAdd').click(function () {
                $('#addProductModal').modal('show');
            });

            $('#addProductForm').submit(function (e) {
                e.preventDefault();

                const formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: '{{ route('products.store') }}',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        $('#addProductModal').modal('hide');
                        table.ajax.reload();
                        alert('Product added successfully');
                    },
                    error: function () {
                        alert('Failed to add product');
                    }
                });
            });

            $(document).on('click', '.edit-btn', function () {
                const id = $(this).data('id');
                $.ajax({
                    type: 'GET',
                    url: '{{ route('products.show', '') }}/' + id,
                    success: function (data) {
                        $('#editProductId').val(data.id);
                        $('#editProductName').val(data.name);
                        $('#editProductDescription').val(data.description);
                        $('#editProductPrice').val(data.price);
                        $('#editProductModal').modal('show');
                    },
                    error: function () {
                        alert('Failed to fetch product details');
                    }
                });
            });

            $('#editProductForm').submit(function (e) {
                e.preventDefault();

                const id = $('#editProductId').val();
                const formData = new FormData(this);
                formData.append('_method', 'PUT');

                $.ajax({
                    type: 'POST',
                    url: '{{ route('products.update', '') }}/' + id,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        $('#editProductModal').modal('hide');
                        table.ajax.reload();
                        alert('Product updated successfully');
                    },
                    error: function () {
                        alert('Failed to update product');
                    }
                });
            });

            $(document).on('click', '.delete-btn', function () {
                const id = $(this).data('id');
                if (confirm('Are you sure you want to delete this product?')) {
                    $.ajax({
                        type: 'DELETE',
                        url: '{{ route('products.destroy', '') }}/' + id,
                        success: function (response) {
                            table.ajax.reload();
                            alert('Product deleted successfully');
                        },
                        error: function () {
                            alert('Failed to delete product');
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
