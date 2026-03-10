<!DOCTYPE html>
<html>
<head>
    <title>School Management</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f7f7f7;
        }

        .navbar {
            background: #1f2937;
            padding: 15px 30px;
            color: white;
            font-size: 20px;
            font-weight: bold;
        }

        .container {
            padding: 30px 50px;
        }

        h1, h2 {
            margin-bottom: 20px;
            color: #333;
        }

        /* ALERT BOXES */
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .alert-success { background: #d1e7dd; color: #0f5132; }
        .alert-danger { background: #f8d7da; color: #842029; }

        /* BUTTONS */
        .btn {
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            font-size: 14px;
            margin-right: 5px;
            display: inline-block;
        }

        .btn-blue { background: #0d6efd; }
        .btn-green { background: #198754; }
        .btn-red { background: #dc3545; }
        .btn-yellow { background: #ffc107; color: black; }
        .btn-grey { background: #6c757d; }
        .btn-sm { padding: 5px 10px; font-size: 12px; }

        /* FORM INPUTS */
        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 20px;
        }

        /* TABLES */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            background: white;
            table-layout: auto; /* allows natural size columns */
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 10px 12px;
        }

        table th {
            background: #f2f2f2;
        }

        /* Column width helpers */
        .col-small {
            width: 60px;
            text-align: center;
        }

        .col-medium {
            width: 150px;
        }

        .col-auto {
            width: auto;
        }

        /* Actions column */
        .actions-col {
            width: 160px;
            white-space: nowrap;
            text-align: center;
        }

        /* SEARCH BAR */
        .search-box {
            margin-bottom: 20px;
        }

        /* PAGINATION */
        .pagination {
            margin-top: 20px;
        }

        .pagination a {
            padding: 5px 10px;
            background: #0d6efd;
            color: white;
            margin-right: 5px;
            border-radius: 4px;
            text-decoration: none;
        }

    </style>

</head>

<body>

    <div class="navbar">
        School Management
    </div>

    <div class="container">

        <!-- GLOBAL SUCCESS MESSAGE -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- GLOBAL ERROR MESSAGE -->
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @yield('content')
    </div>

</body>
</html>
