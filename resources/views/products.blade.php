<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mini E-Commerce Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card:hover {
            box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease-in-out;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Products</h2>
            <a href="{{ route('cart.show') }}" class="btn btn-outline-dark">🛒 View Cart</a>
        </div>

        <div class="row g-4">
            @foreach($products as $product)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $product['name'] }}</h5>
                            <p class="card-text mb-2 text-muted">₹{{ $product['price'] }}</p>
                            <form action="{{ route('cart.add', $product['id']) }}" method="POST" class="mt-auto">
                                @csrf
                                <button type="submit" class="btn btn-primary w-100">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
