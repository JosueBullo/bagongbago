<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Panel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
    <style>
        body {
            background-color: #f5f5f5;
            color: #fff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .side-panel {
            background-color: #1c1c1c;
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
            text-align: left;
        }
        .main-content {
            margin-left: 250px;
            transition: margin-left 0.3s ease;
            padding: 20px;
        }
        .side-panel-logo {
            margin-bottom: 20px;
            text-align: center;
        }
        .side-panel-logo img {
            max-width: 80%;
            height: auto;
        }
        .side-panel-nav {
            margin-top: 20px;
        }
        .side-panel-nav .nav-link {
            color: #ddd;
            padding: 10px 15px;
            border-radius: 5px;
            margin: 5px 0;
            transition: background-color 0.3s, color 0.3s;
        }
        .side-panel-nav .nav-link:hover,
        .side-panel-nav .nav-link.active {
            background-color: #007bff;
            color: #fff;
        }
        .openbtn {
            font-size: 20px;
            cursor: pointer;
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            margin: 10px;
        }
    </style>
</head>
<body>
    <div class="side-panel" id="mySidepanel">
        <div class="side-panel-logo">
            <img src="logo.png" alt="Logo">
        </div>
        <nav class="side-panel-nav">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="#">
                        <span class="icon">🏠</span> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span class="icon">📦</span> Products
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span class="icon">🛒</span> Cart
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span class="icon">📂</span> Categories
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <button class="openbtn" onclick="openNav()">&#9776; Menu</button>

    <div class="main-content">
        <h2></h2>
        <!-- Your main content here -->
    </div>

    <script>
        function openNav() {
            document.getElementById("mySidepanel").style.width = "250px";
            document.querySelector(".main-content").style.marginLeft = "250px";
        }

        function closeNav() {
            document.getElementById("mySidepanel").style.width = "0";
            document.querySelector(".main-content").style.marginLeft= "0";
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="//cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    @yield('scripts')
</body>
</html>
