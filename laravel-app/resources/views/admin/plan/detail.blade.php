@extends('admin.layout')

@section('title', 'Sửa Kế Hoạch')

@section('content')
    <div class="container">
        <h2 class="mb-4">Sửa Kế Hoạch: {{ $plan->name }}</h2>

        <!-- Hiển thị thông báo thành công -->
        @if (session('success'))
            <div class="alert alert-success mt-5 ">
                {{ session('success') }}
            </div>
        @endif

        <!-- Hiển thị thông báo thất bại -->
        @if (session('error'))
            <div class="alert alert-danger mt-5">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.plan.update', $plan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3 mt-5">
                <label for="name" class="form-label">Tên Kế Hoạch</label>
                <input type="text" class="form-control" name="name" id="name" value="{{ $plan->name }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Giá</label>
                <input type="number" step="0.01" class="form-control" name="price" id="price"
                    value="{{ $plan->price }}" required>
            </div>

            <div class="mb-3">
                <label for="processes" class="form-label">Số Tiến Trình</label>
                <input type="number" class="form-control" name="processes" id="processes" value="{{ $plan->processes }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="questions_limit" class="form-label">Số Câu Hỏi</label>
                <input type="number" class="form-control" name="questions_limit" id="questions_limit"
                    value="{{ $plan->questions_limit }}" required>
            </div>
            <div class="mb-3">
                <label for="duration" class="form-label">Thời gian</label>
                <input type="number" class="form-control" name="duration" id="duration" value="{{ $plan->duration }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Mô Tả</label>
                <textarea class="form-control" name="description" id="description" rows="3">{{ $plan->description }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Cập Nhật Kế Hoạch</button>
        </form>
    </div>
@endsection
