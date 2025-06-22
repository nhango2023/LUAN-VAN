@extends('admin.layout')

@section('title', 'Thêm Kế Hoạch')

@section('content')
    <div class="container" style="width: 100%">
        <h2 class="mb-4">Thêm Kế Hoạch Mới</h2>

        <!-- Hiển thị thông báo thành công nếu có -->
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.plan.create') }}" method="POST">
            @csrf
            <div class="mb-3 mt-5">
                <label for="name" class="form-label">Tên Kế Hoạch</label>
                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}"
                    required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Giá</label>
                <input type="number" step="0.01" class="form-control" name="price" id="price"
                    value="{{ old('price') }}" required>
                @error('price')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="processes" class="form-label">Số Tiến Trình</label>
                <input type="number" class="form-control" name="processes" id="processes" value="{{ old('processes') }}"
                    required>
                @error('processes')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>



            <div class="mb-3">
                <label for="questions_limit" class="form-label">Số Câu Hỏi</label>
                <input type="number" class="form-control" name="questions_limit" id="questions_limit"
                    value="{{ old('questions_limit') }}" required>
                @error('questions_limit')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Mô Tả</label>
                <textarea class="form-control" name="description" id="description" rows="3">{{ old('description') }}</textarea>
                @error('description')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Lưu Kế Hoạch</button>
        </form>
    </div>
@endsection
