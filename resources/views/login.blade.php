<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - GadgetHub</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #343a40;
            font-family: Arial, sans-serif;
            color: #ffffff;
        }
        .container {
            max-width: 400px;
            margin: 100px auto;
            background: #454d55;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
        }
        .container h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #17a2b8;
        }
        .form-control {
            margin-bottom: 20px;
            background-color: #545d65;
            color: #ffffff;
            border-color: #343a40;
        }
        .btn-primary {
            width: 100%;
            padding: 10px;
            background-color: #17a2b8;
            border: none;
        }
        .btn-primary:hover {
            background-color: #138496;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login to Gadget Shop</h1>
        <form id="loginForm">
            @csrf
            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $('#loginForm').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: '/api/login',
                data: formData,
                success: function(response) {
                    console.log(response);
                    alert('Logged in successfully!');
                    window.location.href = response.redirect_url;
                },
                error: function(xhr) {
                    console.log(xhr.responseJSON);
                    alert('Login failed. Check your credentials.');
                }
            });
        });
    </script>
</body>
</html>
