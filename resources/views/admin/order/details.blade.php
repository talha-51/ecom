@extends('layouts.backend.master')

@section('title')
    Order Details
@endsection

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Order Details</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Order Details</li>
        </ol>

        <div class="d-grid gap-2 mb-4">
            <a href="{{ route('order.index') }}" class="btn btn-lg btn-primary">Back To Orders</a>
        </div>

        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total Price</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total Price</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($orderItems as $orderItem)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ optional($products->firstWhere('id', $orderItem->product_id))->name }}</td>
                        <td>{{ $orderItem->quantity }}</td>
                        <td>{{ $orderItem->unit_price }}</td>
                        <td>{{ $orderItem->total_price }}</td>
                        <td>{{ $orderItem->created_at }}</td>
                        <td>{{ $orderItem->updated_at }}</td>
                        <td>
                            <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal"
                                data-bs-target="#editQuantityModal{{ $orderItem->id }}">
                                Edit Quantity
                            </button>

                            <form action="{{ route('order-item.destroy', $orderItem->id) }}" method="POST"
                                class="d-inline">
                                @csrf @method('delete')
                                <button type="submit" class="btn btn-outline-danger">Remove</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Quantity Modal -->
                    <div class="modal fade" id="editQuantityModal{{ $orderItem->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <form action="{{ route('order-item.update', $orderItem->id) }}" method="POST">
                                @csrf @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Change Quantity</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label>Product Name</label>
                                            <input type="text" class="form-control"
                                                value="{{ optional($products->firstWhere('id', $orderItem->product_id))->name }}"
                                                disabled>
                                        </div>

                                        <div class="mb-3">
                                            <label for="qty{{ $orderItem->id }}">New Quantity</label>
                                            <input type="number" name="quantity" id="qty{{ $orderItem->id }}"
                                                class="form-control" value="{{ $orderItem->quantity }}" min="1"
                                                required>
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
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        Sub-Total: <strong>{{ $orderItems->sum('total_price') }}</strong><br>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
