<!DOCTYPE html>
<html>
<head>
    <title>Product Supplier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f7f7f7;
        }
        .navbar {
            background: #1f2937 !important;
        }
        .navbar-brand {
            color: white !important;
            font-weight: bold;
            font-size: 20px;
        }
        .container {
            padding-top: 30px;
        }
        .table th {
            background: #f0f0f0;
        }
        .actions-col {
            width: 180px;
            white-space: nowrap;
        }

        table thead th {
            background: #f2f2f2 !important;
            color: #333 !important;
            font-weight: bold;
        }

    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}">Product Supplier</a>
    </div>
</nav>

<div class="container">

    {{-- GLOBAL SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- GLOBAL ERROR MESSAGE --}}
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @yield('content')
</div>

</body>
</html>
