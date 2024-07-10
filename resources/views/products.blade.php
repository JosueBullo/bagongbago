<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">

    <style>
        /* CSS for dark background and top panel */
        body {
        }
        .side-panel {
            background-color: #343a40; /* Dark panel background */
            color: #fff; /* Light text color */
            position: fixed;
            top: 0;
            left: -250px; /* Initially hide the side panel */
            bottom: 0;
            width: 250px;
            padding: 60px 20px 20px; /* Add padding-top for toggle switch */
            overflow-y: auto;
            transition: left 0.3s ease; /* Smooth transition for sliding effect */
            z-index: 1000; /* Ensure it's above other content */
            text-align: center; /* Center text inside the panel */
        }
        .side-panel.show {
            left: 0; /* Show the side panel */
        }
        .side-panel-logo {
            margin-bottom: 20px;
        }
        .side-panel-logo img {
            max-width: 100%;
            height: auto;
        }
        .side-panel-nav {
            margin-top: 20px;
        }
        .side-panel-nav .nav-link {
            color: #fff;
            padding: 10px 20px;
            display: block;
        }
        .side-panel-nav .nav-link:hover {
            background-color: #495057; /* Darker shade on hover */
            text-decoration: none;
        }
        .main-content {
            margin-left: 0;
            transition: margin-left 0.3s ease; /* Smooth transition for content shift */
            padding: 20px;
            text-align: center; /* Center text in main content */
        }
        .main-content.shift {
            margin-left: 250px; /* Shift content right when panel is shown */
        }
        .top-panel {
            background-color: #1e1e1e; /* Darker top panel background */
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
    </style>
</head>
<body>
    <!-- Toggle Button for Side Panel -->
    <div id="toggleSwitch" class="toggle-switch"></div>

    <!-- Side Panel -->
    <div class="side-panel show" id="sidePanel"> <!-- Add 'show' class to make it visible by default -->
        <div class="side-panel-logo">
            <img src="{{ asset('storage/images/448828896_831233942280547_5833486859053677868_n.png') }}" alt="Logo"> <!-- Ensure this path is correct -->
        </div>
        <div class="side-panel-nav">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a id="usersLink" class="nav-link" href="/users">User Management</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/products">Product Management</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/category">Category Management</a>
                </li> 
            </ul>
        </div>
    </div>

    <!-- Main Content -->
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
                        <div class="form-group">
                            <label for="productName">Product Name</label>
                            <input type="text" class="form-control" id="productName" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="productDescription">Product Description</label>
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
                    <form id="editProductForm">
                        <input type="hidden" id="editProductId" name="id">
                        <div class="form-group">
                            <label for="editProductName">Product Name</label>
                            <input type="text" class="form-control" id="editProductName" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="editProductDescription">Product Description</label>
                            <textarea class="form-control" id="editProductDescription" name="description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="editProductPrice">Price</label>
                            <input type="number" class="form-control" id="editProductPrice" name="price" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Toggle side panel
            $('#toggleSwitch').click(function() {
                $('#sidePanel').toggleClass('show');
                $(this).toggleClass('active');
                $('.main-content').toggleClass('shift');
            });

            // Initialize DataTable
            var dataTable = $('#productList').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "/api/products",
                    "type": "GET"
                },
                "columns": [
                    { "data": "id" },
                    { "data": "name" },
                    { "data": "description" },
                    { "data": "categories" },
                    { "data": "price" },
                    { 
                        "data": "id",
                        "render": function(data) {
                            return `<button class="btn btn-sm btn-info btn-edit" data-id="${data}">Edit</button>
                                    <button class="btn btn-sm btn-danger btn-delete" data-id="${data}">Delete</button>`;
                        }
                    }
                ]
            });

            // Add Product modal handling
            $('#btnAdd').click(function() {
                $('#addProductModal').modal('show');
            });

            // Add Product form submission
            $('#addProductForm').submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: '/api/products',
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#addProductModal').modal('hide');
                        dataTable.ajax.reload();
                    }
                });
            });

            // Edit Product modal handling
            $('#productList').on('click', '.btn-edit', function() {
                var productId = $(this).data('id');
                $.ajax({
                    url: '/api/products/' + productId,
                    method: 'GET',
                    success: function(response) {
                        $('#editProductId').val(response.id);
                        $('#editProductName').val(response.name);
                        $('#editProductDescription').val(response.description);
                        $('#editProductPrice').val(response.price);
                        $('#editProductModal').modal('show');
                    }
                });
            });

            // Update Product form submission
            $('#editProductForm').submit(function(event) {
                event.preventDefault();
                var productId = $('#editProductId').val();
                $.ajax({
                    url: '/api/products/' + productId,
                    method: 'PUT',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#editProductModal').modal('hide');
                        dataTable.ajax.reload();
                    }
                });
            });

            // Delete Product
            $('#productList').on('click', '.btn-delete', function() {
                var productId = $(this).data('id');
                if (confirm('Are you sure you want to delete this product?')) {
                    $.ajax({
                        url: '/api/products/' + productId,
                        method: 'DELETE',
                        success: function(response) {
                            dataTable.ajax.reload();
                        }
                    });
                }
            });

            // Highlight active link
            var path = window.location.pathname;
            $('.side-panel-nav .nav-link').each(function() {
                var href = $(this).attr('href');
                if (path.substring(0, href.length) === href) {
                    $(this).addClass('active');
                }
            });

            // Ensure proper state of side panel on page load
            if ($(window).width() > 768) {
                $('#sidePanel').addClass('show');
                $('#toggleSwitch').addClass('active');
                $('.main-content').addClass('shift');
            }
        });
    </script>
</body>
</html>
