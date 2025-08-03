<!DOCTYPE html>
<html>
<head>
    <title>Shopping Cart</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
            background: #f8f9fa;
        }

        h1 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background: #343a40;
            color: white;
        }

        tr:nth-child(even) {
            background: #f2f2f2;
        }

        .btn {
            padding: 8px 12px;
            margin-right: 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-update { background-color: #007bff; color: white; }
        .btn-remove { background-color: #dc3545; color: white; }
        .btn-clear { background-color: #6c757d; color: white; }
        .btn-checkout { background-color: #28a745; color: white; }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .action-buttons {
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <h1>Your Cart</h1>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(count($cart) > 0)
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($cart as $id => $item)
                    @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>₹{{ number_format($item['price'], 2) }}</td>
                        <td>
                            <form action="{{ route('cart.update', $id) }}" method="POST">
                                @csrf
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1">
                                <button type="submit" class="btn btn-update">Update</button>
                            </form>
                        </td>
                        <td>₹{{ number_format($subtotal, 2) }}</td>
                        <td>
                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-remove">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3"><strong>Total:</strong></td>
                    <td><strong>₹{{ number_format($total, 2) }}</strong></td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <div class="action-buttons">
            <form action="{{ route('cart.clear') }}" method="POST" style="display: inline-block;">
                @csrf
                <button type="submit" class="btn btn-clear">Clear Cart</button>
            </form>

            <form action="{{ route('cart.checkout') }}" method="POST" style="display: inline-block;">
                @csrf
                <button type="submit" class="btn btn-checkout">Fake Checkout</button>
            </form>
        </div>

    @else
        <p>Your cart is empty.</p>
    @endif

</body>
</html>
