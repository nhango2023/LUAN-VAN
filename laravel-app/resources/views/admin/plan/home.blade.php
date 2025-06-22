@extends('admin.layout')

@section('title', 'Quản lý kế hoạch')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Danh sách Kế Hoạch</h2>
            <a href="" class="btn btn-success">
                <i class="fas fa-plus"></i> Thêm Kế Hoạch
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="table-title mt-5 mb-2">
            <div class="row">
                <div class="col-sm-4">
                    <h2 style="color: black"> <b>Plan table</b></h2>
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
                        <span>Export to Excel</span>
                    </a>
                </div>
            </div>

        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Tên</th>
                        <th>Giá</th>
                        <th>Số tiến trình</th>
                        <th>Giới hạn câu hỏi</th>
                        <th>Thời gian</th>
                        <th>Mô tả</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($plans as $plan)
                        <tr>
                            <td>{{ $plan->name }}</td>
                            <td>{{ number_format($plan->price, 2) }} VNĐ</td>
                            <td>{{ $plan->processes }}</td>
                            <td>{{ $plan->questions_limit }}</td>
                            <td>{{ $plan->duration }}</td>
                            <td>{{ $plan->description }} </td>
                            <td>
                                <a href="{{ route('admin.plan.detail', $plan->id) }}" class="btn mb-1 btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <form action="{{ route('admin.plan.delete', $plan->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Bạn có chắc muốn xóa kế hoạch này không?')">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
