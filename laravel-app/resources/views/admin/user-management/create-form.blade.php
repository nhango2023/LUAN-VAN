@extends('admin.layout') {{-- Nếu có layout --}}
@section('content')


<div class="card shadow-lg p-4">
    <h4 class="mb-4 text-center"><i class="fa fa-user-plus mr-2"></i>Thêm Người Dùng Mới</h4>
    <form action="{{ route('admin.user.create') }}" method="POST">
      @csrf
      <div class="form-group">
        <label for="name">Full name</label>
        <input type="text" value="{{ old('full_name') }}" name="full_name" class="form-control"  required>
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" value="{{ old('email') }}" name="email" class="form-control"  required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" class="form-control"  required>
      </div>
      <div class="form-group">
        <label for="password">Confirm Password</label>
        <input type="password" name="confirm_password" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="password">Address</label>
        <input type="text" value="{{ old('address') }}" name="address" class="form-control"  required>
      </div>
      <div class="form-group">
        <label for="password">Phone number</label>
        <input type="text" value="{{ old('phone_number') }}" name="phone_number" class="form-control"  required>
      </div>
      @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="text-center mt-3">
                  <button class="btn btn-secondary"><-Back</button>
                  <button type="submit" class="btn btn-primary">Save</button>
                  </div>
    </form>
  </div>
</div>

@endsection
