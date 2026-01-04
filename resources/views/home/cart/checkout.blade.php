@extends('layouts.frontend.master')

@section('title')
    Checkout - Order
@endsection

@section('content')
    <div class="mb-5 p-5">
        <h1 class="text-center mb-5">Welcome to Checkout Page.</h1>

        @if ($cartProducts->isEmpty())
            <h2 class="text-center mb-4">Cart is empty.</h2>
            <div class="d-flex justify-content-center">
                <div class="d-grid gap-2 text-center w-50">
                    <a href="{{ route('home.index') }}" class="btn btn-lg btn-primary">Shop Now!</a>
                </div>
            </div>
        @else
            <form method="POST" action="{{ route('cart.confirmOrder') }}">
                @csrf
                <div class="container-fluid">
                    <div class="row g-5">
                        <div class="col-4">
                            <h1 class="mb-5">Customer Information</h1>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-control" id="exampleInputEmail1"
                                    value="{{ old('name') }}">
                                @error('name')
                                    <div class="alert alert-danger mt-2 text-center">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Email address</label>
                                <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" value="{{ old('email') }}">
                                @error('email')
                                    <div class="alert alert-danger mt-2 text-center">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Phone Number</label>
                                <input type="phone_number" name="phone_number" class="form-control" id="exampleInputEmail1"
                                    value="{{ old('phone_number') }}">
                                @error('phone_number')
                                    <div class="alert alert-danger mt-2 text-center">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Address</label>
                                <textarea class="form-control" name="address" id="exampleFormControlTextarea1" rows="3">{{ old('address') }}</textarea>
                            </div>
                            @error('address')
                                <div class="alert alert-danger mt-2 text-center">{{ $message }}</div>
                            @enderror
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Delivery Location</label>
                                <select class="form-select" aria-label="Default select example" id="delivery_fee"
                                    name="delivery_fee">
                                    <option value="60">Inside Dhaka (Total + 60)</option>
                                    <option value="120">Outside Dhaka (Total + 120)</option>
                                </select>
                            </div>

                        </div>
                        <div class="col-8 ps-5">
                            <h1 class="text-center mb-5">Ordered Items</h1>
                            <table class="table">
                                <tr>
                                    <th>SL</th>
                                    <th>Product Name</th>
                                    <th>Product Image</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Total Price</th>
                                </tr>
                                @foreach ($cartProducts as $cartProduct)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ optional($products->firstWhere('id', $cartProduct->product_id))->name }}
                                        </td>
                                        <input type="hidden" name="product_id[]" value="{{ $cartProduct->product_id }}">
                                        <td>
                                            <img src="{{ asset($products->firstWhere('id', $cartProduct->product_id)->image) }}"
                                                alt="" class="img-thumbnail" width="75">
                                        </td>
                                        <td>{{ $cartProduct->quantity }}</td>
                                        <input type="hidden" name="quantity[]" value="{{ $cartProduct->quantity }}">
                                        <td>{{ $cartProduct->unit_price }}</td>
                                        <input type="hidden" name="unit_price[]" value="{{ $cartProduct->unit_price }}">
                                        <td>{{ $cartProduct->total_price }}</td>
                                        <input type="hidden" name="total_price[]" value="{{ $cartProduct->total_price }}">
                                    </tr>
                                @endforeach

                                <tr>
                                    <td colspan="6" class="text-end">
                                        Sub-Total:
                                        <strong id="subTotal">{{ $cartProducts->sum('total_price') }}</strong> +
                                        <strong id="deliveryCharge">60</strong> [Delivery Charge]<br>
                                        <input type="hidden" name="sub_total" id="inputSubTotal"
                                            value="{{ $cartProducts->sum('total_price') }}">

                                        <h5>
                                            Grand Total: <strong
                                                id="grandTotal">{{ $cartProducts->sum('total_price') + 60 }}</strong>
                                        </h5>
                                        <input type="hidden" name="grand_total" id="inputGrandTotal"
                                            value="{{ $cartProducts->sum('total_price') + 60 }}">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('cart.index') }}" class="btn btn-warning">Go back to Cart</a>

                    <button type="submit" class="btn btn-primary">Order Now</button>
                </div>
            </form>
        @endif
    </div>

    <script>
        const deliverySelect = document.getElementById('delivery_fee');
        const subTotal = Number(document.getElementById('subTotal').innerText);

        deliverySelect.addEventListener('change', function() {
            const deliveryCharge = Number(this.value);
            const grandTotal = subTotal + deliveryCharge;

            // Update visible text
            document.getElementById('deliveryCharge').innerText = deliveryCharge;
            document.getElementById('grandTotal').innerText = grandTotal;

            // Update hidden inputs (important!)
            document.getElementById('inputSubTotal').value = subTotal;
            document.getElementById('inputGrandTotal').value = grandTotal;
        });
    </script>

@endsection
