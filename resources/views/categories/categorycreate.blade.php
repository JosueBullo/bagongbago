<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Category</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #000;
            color: #fff;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            background-color: #1c1c1c;
            border: none;
        }
        .card-header {
            background-color: #333;
            border-bottom: 1px solid #444;
        }
        .card-body {
            background-color: #1c1c1c;
        }
        .card-footer {
            background-color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Create Category</h1>
        <div class="card">
            <div class="card-body">
                <form id="createCategoryForm">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#createCategoryForm').on('submit', function(e) {
                e.preventDefault();
                createCategory();
            });
        });

        function createCategory() {
            $.ajax({
                url: '{{ route("categories.store") }}',
                method: 'POST',
                data: $('#createCategoryForm').serialize(),
                success: function(response) {
                    alert('Category created successfully');
                    window.location.href = '/categories';
                },
                error: function(xhr) {
                    alert('Error creating category: ' + xhr.responseText);
                }
            });
        }
    </script>
</body>
</html>
