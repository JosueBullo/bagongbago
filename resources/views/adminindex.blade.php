<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Gadget Shop</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
    <style>
        /* CSS for dark background and top panel */
        body {
          
            color: #fff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .side-panel {
            background-color: #343a40;
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 250px;
            padding: 60px 20px 20px;
            overflow-y: auto;
            transition: left 0.3s ease;
            z-index: 1000;
            text-align: center;
        }
        .main-content {
            margin-left: 250px;
            transition: margin-left 0.3s ease;
            padding: 20px;
            text-align: center;
        }
        .side-panel.show {
            left: 0;
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
            background-color: #495057;
            text-decoration: none;
        }
        .main-content.shift {
            margin-left: 250px;
        }
        .createUserBtn {
            background-color: #0095f6;
            color: #fff;
            border: none;
            border-radius: 3px;
            padding: 8px 16px;
            cursor: pointer;
            font-size: 1rem;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .createUserBtn:hover {
            background-color: #007bb5;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #262626;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            border-radius: 5px;
            position: relative;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover,
        .close:focus {
            color: #fff;
            text-decoration: none;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="side-panel show" id="sidePanel">
        <div class="side-panel-logo">
            <img src="{{ asset('storage/images/448828896_831233942280547_5833486859053677868_n.png') }}" alt="Logo">
        </div>
        <div class="side-panel-nav">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a id="usersLink" class="nav-link" href="#">User Management</a>
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
    <div class="main-content">
        @yield('content')
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="//cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#sidePanel').addClass('show');
            $('.main-content').addClass('shift');

            $('#usersLink').click(function(event) {
                event.preventDefault();
                window.location.href = "{{ route('users.index') }}";
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
