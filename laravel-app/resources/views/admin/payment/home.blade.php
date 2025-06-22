@extends('admin.layout')

@section('title', 'Quản lý thanh toán')

@section('content')
    <style>
        .status-success {
            color: green;
            font-weight: bold;
        }

        .status-failed {
            color: red;
            font-weight: bold;
        }

        .status-pending {
            color: orange;
            font-weight: bold;
        }

        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 5px;
        }

        /* Make the status indicator more readable */
        .status-success {
            background-color: #d4edda;
        }

        .status-failed {
            background-color: #f8d7da;
        }

        .status-pending {
            background-color: #fff3cd;
        }
    </style>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Danh sách thanh toán</h2>
            {{-- <a href="" class="btn btn-success">
                <i class="fas fa-plus"></i> Thêm Kế Hoạch
            </a> --}}
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="table-title mt-5 mb-2">
            <div class="row">
                <div class="col-sm-4">
                    <h2 style="color: black"> <b>Payment table</b></h2>
                </div>

                <div class="col-sm-8 d-flex justify-content-end">
                    <!-- Nút Refresh List -->
                    <a href="#" class="mr-1 btn btn-primary d-flex align-items-center justify-content-center">
                        <i class="material-icons">&#xE863;</i>
                        <span class="ms-2">Refresh List</span>
                    </a>

                    <!-- Nút Export to Excel -->
                    <a href="{{ route('admin.plan.show-form-create') }}"
                        class="btn btn-secondary d-flex align-items-center justify-content-center">
                        <i class="material-icons">&#xE145;</i> <!-- Dấu cộng biểu tượng -->
                        <span>Add new payment</span>
                    </a>
                </div>
            </div>

        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Created at</th>
                        <th>User</th>
                        <th>Plane name</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $payment)
                        <tr>
                            <td>{{ $payment->created_at }}</td>
                            <td>{{ $payment->fullname }}</td>
                            <td>{{ $payment->name }}</td>
                            <td>{{ number_format($payment->price, 2) }} VNĐ</td>
                            <td> <span class="status status-{{ $payment->status }}">{{ $payment->status }}</span></td>
                            <td>
                                <form action="{{ route('admin.payment.update', [$payment->id, 'confirm']) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fas fa-trash"></i> Confirm
                                    </button>
                                </form>
                                <form action="{{ route('admin.payment.update', [$payment->id, 'cancel']) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Cancel
                                    </button>
                                </form>
                                {{-- <a href="" class="btn mb-1 btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Sửa
                                </a> --}}

                                {{-- <form action="{{ route('admin.paymemt.update', $payment->id, 'confirm') }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Bạn có chắc muốn xóa kế hoạch này không?')">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                </form> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
