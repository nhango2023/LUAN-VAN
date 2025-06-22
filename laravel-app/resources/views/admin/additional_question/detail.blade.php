@extends('admin.layout')

@section('title', 'Sửa Kế Hoạch')

@section('content')
    <div class="container">
        <h2 class="mb-4">Sửa giá: </h2>

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

        <form action="{{ route('admin.addition-question.update', $additionalQuestion->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3 mt-5">
                <label for="name" class="form-label">Price</label>
                <input type="int" class="form-control" name="price" id="name"
                    value="{{ $additionalQuestion->price }}" required>
            </div>

            <select class="form-select" aria-label="Default select example" name="is_active">
                <option value="1" {{ $additionalQuestion->isActive == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ $additionalQuestion->isActive == 0 ? 'selected' : '' }}>Inactive</option>
            </select>

            <button type="submit" class="btn btn-primary">Cập Nhật Giá</button>
        </form>
    </div>
@endsection
