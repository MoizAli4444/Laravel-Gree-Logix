<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Webhook Form</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-center mb-4">Process Order</h2>

        <div class="card p-4 shadow">
            <form action="{{ route('webhook') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="order_id" class="form-label">Order ID</label>
                    <input type="text" class="form-control" id="order_id" name="order_id" required
                        value="{{ old('order_id') }}">
                    @error('order_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="subtotal_price" class="form-label">Subtotal Price</label>
                    <input type="number" step="0.01" class="form-control" id="subtotal_price" name="subtotal_price"
                        required value="{{ old('subtotal_price') }}">
                    @error('subtotal_price')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="merchant_domain" class="form-label">Merchant Domain</label>
                    <input type="text" class="form-control" id="merchant_domain" name="merchant_domain" required
                        value="{{ old('merchant_domain') }}">
                    @error('merchant_domain')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="discount_code" class="form-label">Discount Code</label>
                    <input type="text" class="form-control" id="discount_code" name="discount_code"
                        value="{{ old('discount_code') }}">
                    @error('discount_code')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="customer_email" class="form-label">Customer Email</label>
                    <input type="email" class="form-control" id="customer_email" name="customer_email" required
                        value="{{ old('customer_email') }}">
                    @error('customer_email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="customer_name" class="form-label">Customer Name</label>
                    <input type="text" class="form-control" id="customer_name" name="customer_name" required
                        value="{{ old('customer_name') }}">
                    @error('customer_name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Start Date Field -->
                <div class="mb-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" required
                        value="{{ old('start_date') }}">
                    @error('start_date')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- End Date Field -->
                <div class="mb-3">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" required
                        value="{{ old('end_date') }}">
                    @error('end_date')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100">Process Order</button>
            </form>


        </div>
    </div>

    <!-- Bootstrap JS CDN (Optional, for features like modals) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
