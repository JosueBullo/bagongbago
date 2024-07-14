<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration - Gadget Shop</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f7f7f7; /* Light background color */
            font-family: Arial, sans-serif;
            color: #333; /* Dark text color */
        }
        .container {
            max-width: 400px;
            margin: 100px auto;
            background: #ffffff; /* White container background color */
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.1); /* Light box shadow */
        }
        .container h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #d50000; /* Lazada accent color */
        }
        .form-control {
            margin-bottom: 20px;
            background-color: #f1f1f1; /* Light input background color */
            color: #333; /* Dark text color */
            border: 1px solid #ccc; /* Light border color */
            border-radius: 5px;
        }
        .form-control:focus {
            border-color: #d50000; /* Lazada focus border color */
            background-color: #ffffff;
        }
        .btn-primary {
            width: 100%;
            padding: 10px;
            background-color: #d50000; /* Primary button color */
            border: none;
            border-radius: 5px;
        }
        .btn-primary:hover {
            background-color: #c70000; /* Darker hover color */
        }
        .login-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007bff; /* Link color */
        }
        .login-link:hover {
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
