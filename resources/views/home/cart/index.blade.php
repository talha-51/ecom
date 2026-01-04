@extends('layouts.frontend.master')

@section('title')
    Checkout -Cart
@endsection

@section('content')
    <div class="mt-5 mb-5">
        <h1 class="text-center mb-5">Welcome to Your Cart.</h1>

        @if ($cartProducts->isEmpty())
            <h2 class="text-center mb-4">Cart is empty.</h2>
            <div class="d-flex justify-content-center">
                <div class="d-grid gap-2 text-center w-50">
                    <a href="{{ route('home.index') }}" class="btn btn-lg btn-primary">Shop Now!</a>
                </div>
            </div>
        @else
            <div class="d-flex justify-content-center">
                <table class="table w-75">
                    <tr>
                        <th>SL</th>
                        <th>Product Name</th>
                        <th>Product Image</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total Price</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($cartProducts as $cartProduct)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ optional($products->firstWhere('id', $cartProduct->product_id))->name }}</td>
                            <td>
                                <img src="{{ asset($products->firstWhere('id', $cartProduct->product_id)->image) }}"
                                    alt="" class="img-thumbnail" width="75">
                            </td>
                            <td>{{ $cartProduct->quantity }}</td>
                            <td>{{ $cartProduct->unit_price }}</td>
                            <td>{{ $cartProduct->total_price }}</td>
                            <td>
                                <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal"
                                    data-bs-target="#editQuantityModal{{ $cartProduct->id }}">
                                    Edit Quantity
                                </button>

                                <form action="{{ route('cart.deleteItem', $cartProduct->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf @method('delete')
                                    <button type="submit" class="btn btn-outline-danger">Remove</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Quantity Modal -->
                        <div class="modal fade" id="editQuantityModal{{ $cartProduct->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <form action="{{ route('cart.updateCart', $cartProduct->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Change Quantity</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label>Product Name</label>
                                                <input type="text" class="form-control"
                                                    value="{{ optional($products->firstWhere('id', $cartProduct->product_id))->name }}"
                                                    disabled>
                                            </div>

                                            <div class="mb-3">
                                                <label for="qty{{ $cartProduct->id }}">New Quantity</label>
                                                <input type="number" name="quantity" id="qty{{ $cartProduct->id }}"
                                                    class="form-control" value="{{ $cartProduct->quantity }}"
                                                    min="1" required>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-success">Save</button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    @endforeach
                    <tr>
                        <td colspan="2">
                            <div class="d-grid gap-2">
                                <a href="{{ route('home.index') }}" class="btn btn-primary">Continue Shopping</a>
                            </div>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            Sub-Total: <strong>{{ $cartProducts->sum('total_price') }}</strong><br>
                        </td>
                        <td>
                            <div class="d-grid gap-2">
                                <a href="{{ route('cart.checkout') }}" class="btn btn-primary">Checkout</a>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        @endif
    </div>
@endsection
