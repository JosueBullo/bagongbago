<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration - Gadget Shop</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #343a40; /* Dark background color */
            font-family: Arial, sans-serif;
            color: #ffffff; /* Light text color */
        }
        .container {
            max-width: 400px;
            margin: 100px auto;
            background: #454d55; /* Darker container background color */
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.5); /* Darker box shadow */
        }
        .container h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #17a2b8; /* Accent color */
        }
        .form-control {
            margin-bottom: 20px;
            background-color: #545d65; /* Darker input background color */
            color: #ffffff; /* Light text color */
            border-color: #343a40; /* Dark border color */
        }
        .btn-primary {
            width: 100%;
            padding: 10px;
            background-color: #17a2b8; /* Primary button color */
            border: none;
        }
        .btn-primary:hover {
            background-color: #138496; /* Darker hover color */
        }
        .login-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #17a2b8;
        }
        .login-link:hover {
            color: #138496;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Registration Form</h1>
        <form id="registerForm">
            @csrf <!-- CSRF token for Laravel -->
            <div class="form-group">
                <input type="text" name="name" class="form-control" placeholder="Name" required>
            </div>
            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
        <a href="{{ url('/login') }}" class="login-link">Already have an account? Log in now!</a>
    </div>

    <!-- jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $('#registerForm').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: '/api/register', // API endpoint for registration
                data: formData,
                success: function(response) {
                    console.log(response);
                    alert('Registered successfully! Please log in.');
                    window.location.href = '/login'; // Redirect to login page
                },
                error: function(xhr) {
                    console.log(xhr.responseJSON);
                    alert('Registration failed. Please try again.');
                }
            });
        });
    </script>
</body>
</html>
