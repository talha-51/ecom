@extends('layouts.backend.master')

@section('title')
    Orders
@endsection

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Orders</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Orders</li>
        </ol>

        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Order User Name</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>Delivery Fee</th>
                    <th>Sub Total</th>
                    <th>Grand Total</th>
                    <th>Order Status</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>Order User Name</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>Delivery Fee</th>
                    <th>Sub Total</th>
                    <th>Grand Total</th>
                    <th>Order Status</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ optional($users->firstWhere('id', $order->user_id))->name }}</td>
                        <td>{{ $order->name }}</td>
                        <td>{{ $order->email }}</td>
                        <td>{{ $order->phone_number }}</td>
                        <td>{{ $order->address }}</td>
                        <td>{{ $order->delivery_fee }}</td>
                        <td>{{ $order->sub_total }}</td>
                        <td>{{ $order->grand_total }}</td>
                        <td>
                            @if ($order->status == 'pending')
                                <div class="d-grid gap-2">
                                    <button class="btn btn-warning" type="button">Pending</button>
                                </div>
                            @elseif ($order->status == 'confirmed')
                                <div class="d-grid gap-2">
                                    <button class="btn btn-primary" type="button">Confirmed</button>
                                </div>
                            @elseif ($order->status == 'delivered')
                                <div class="d-grid gap-2">
                                    <button class="btn btn-success" type="button">Delivered</button>
                                </div>
                            @endif

                        </td>
                        <td>{{ $order->created_at }}</td>
                        <td>{{ $order->updated_at }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">

                                <form method="POST" action="{{ route('order.update', $order->id) }}">
                                    @csrf @method('PUT')
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-info dropdown-toggle btn-sm"
                                            data-bs-toggle="dropdown">
                                            Status
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-dark">
                                            <li><button class="dropdown-item" type="submit" name="status"
                                                    value="pending">Pending</button></li>
                                            <li><button class="dropdown-item" type="submit" name="status"
                                                    value="confirmed">Confirmed</button></li>
                                            <li><button class="dropdown-item" type="submit" name="status"
                                                    value="delivered">Delivered</button></li>
                                        </ul>
                                    </div>
                                </form>

                                <a href="{{ route('order.show', $order->id) }}" class="btn btn-outline-primary btn-sm">
                                    Details
                                </a>

                                <form action="{{ route('order.destroy', $order->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                                </form>

                            </div>
                        </td>

                        {{-- <td>
                            <form method="POST" action="{{ route('order.update', $order->id) }}" class="d-inline">
                                @csrf @method('PUT')
                                <div class="btn-group">
                                    <button type="button btn-sm" class="btn btn-info dropdown-toggle"
                                        data-bs-toggle="dropdown">
                                        Order Status
                                    </button>

                                    <ul class="dropdown-menu dropdown-menu-dark">
                                        <li><button class="dropdown-item" type="submit" name="status"
                                                value="pending">Pending</button></li>
                                        <li><button class="dropdown-item" type="submit" name="status"
                                                value="confirmed">Confirmed</button></li>
                                        <li><button class="dropdown-item" type="submit" name="status"
                                                value="delivered">Delivered</button></li>
                                    </ul>
                                </div>
                            </form>

                            <a href="{{ route('order.show', $order->id) }}" class="btn btn-outline-primary btn-sm">
                                Details
                            </a>

                            <form action="{{ route('order.destroy', $order->id) }}" method="POST" class="d-inline">
                                @csrf @method('delete')
                                <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                            </form>
                        </td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
