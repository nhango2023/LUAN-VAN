@extends('admin.layout')

@section('title', 'Thêm giá mua thêm câu hỏi')

@section('content')
    <div class="container" style="width: 100%">
        <h2 class="mb-4">Thêm giá mua thêm câu hỏi</h2>

        <!-- Hiển thị thông báo thành công nếu có -->
        @if (session('success'))
            <div class="alert alert-success mt-5">{{ session('success') }}</div>
        @endif

        <form class="mt-5" action="{{ route('admin.addition-question.create') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="price" class="form-label">Giá</label>
                <input type="number" step="0.01" class="form-control" name="price" id="price"
                    value="{{ old('price') }}" required>
                @error('price')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <select class="form-select mb-2" aria-label="Default select example" name="is_active">
                <option value="1">Active</option>
                <option value="0" selected>Inactive</option>
            </select>

            <button type="submit" class="btn btn-primary">Lưu Kế Hoạch</button>
        </form>
    </div>
@endsection
