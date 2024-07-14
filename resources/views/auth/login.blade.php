<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - GadgetHub</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f7f7f7;
            font-family: Arial, sans-serif;
            color: #333;
        }
        .container {
            max-width: 400px;
            margin: 100px auto;
            background: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
        }
        .container h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #d50000;
        }
        .form-control {
            margin-bottom: 20px;
            background-color: #f1f1f1;
            color: #333;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-control:focus {
            border-color: #d50000;
            background-color: #ffffff;
        }
        .btn-primary {
            width: 100%;
            padding: 10px;
            background-color: #d50000;
            border: none;
            border-radius: 5px;
        }
        .btn-primary:hover {
            background-color: #c70000;
        }
        .text-center a {
            color: #007bff;
            text-decoration: none;
        }
        .text-center a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login to GadgetHub</h1>
        <form id="loginForm">
            @csrf
            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
            <div class="text-center mt-3">
                <a href="/forgot-password">Forgot Password?</a>
            </div>
            <div class="text-center mt-2">
                <a href="/register">Create an Account</a>
            </div>
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
                    if (xhr.status === 401) {
                        alert('Login failed. Check your credentials.');
                    } else if (xhr.status === 403) {
                        alert('This account is deactivated.');
                    } else {
                        alert('An error occurred. Please try again.');
                    }
                }
            });
        });
    </script>
</body>
</html>
