<!DOCTYPE html>
<html>
<head>
    <title>Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex justify-content-center align-items-center" style="height: 100vh;">

    <div class="text-center">
        <h1 class="mb-4 fw-bold">Home Page</h1>

        <div class="d-flex justify-content-center gap-3">
            <a href="{{ route('products.index') }}" class="btn btn-primary px-4 py-2">
                Manage Products
            </a>

            <a href="{{ route('suppliers.index') }}" class="btn btn-success px-4 py-2">
                Manage Suppliers
            </a>
        </div>
    </div>

</body>
</html>
