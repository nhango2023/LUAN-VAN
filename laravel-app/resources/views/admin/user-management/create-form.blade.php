@extends('admin.layout') {{-- Nếu có layout --}}
@section('content')

<style>
  .body-wrapper {
      margin-top: -48px;
  }
</style>

<div class="container mt-5 mb-5">
  <div class="card shadow">
      <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
          <span>Edit your Profile</span>
          <i class="material-icons" style="cursor: pointer;">fullscreen</i>
      </div>
      <div class="card-body">
          <div class="row">
              <!-- Left: Photo -->
              <div class="col-md-3 text-center">
                  <img id="preview-avatar" 
                  src="https://img.freepik.com/free-vector/add-new-user_78370-4710.jpg" 
                  
                  class="rounded-circle img-thumbnail mb-3" 
                  width="140" 
                  alt="User Photo">
                 
      <label for="avatar" class="btn btn-primary btn-sm">CHANGE PHOTO</label>
              </div>

              <!-- Right: Tabs -->
              <div class="col-md-9">
                  <ul class="nav nav-tabs mb-3" role="tablist">
                      <li class="nav-item">
                          <a class="nav-link active" data-toggle="tab" href="#personal" role="tab">Personal</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" data-toggle="tab" href="#dashboard" role="tab">Role</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" data-toggle="tab" href="#advanced" role="tab">Advanced</a>
                      </li>
                  </ul>
                  
                  <div class="tab-content">
                      <!-- Personal Tab -->
                      <div class="tab-pane fade show active" id="personal" role="tabpanel">
                          <form action="{{ route('admin.user.create') }}" method="POST" enctype="multipart/form-data">
                              @csrf
                              <!-- Hiển thị ảnh -->
                              @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                    </div>
                    @endif
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                              <input type="file" name="avatar" id="avatar" style="display: none;">
                              <div class="form-group">
                                  <label>Email:</label>
                                  <input type="text" name='email' class="form-control" value="{{ old('email') }}">
                              </div>
                              <div class="form-group">
                                <label>password</label>
                                <input type="password" name="password" class="form-control" value="">
                            </div>
                            <div class="form-group">
                              <label>confirm password</label>
                              <input type="password" name="confirm_password" class="form-control" value="">
                          </div>
                              <div class="form-group">
                                  <label>Full name</label>
                                  <input type="text" class="form-control" name="fullname" value="{{ old('fullname') }}">
                              </div>
                              <div class="form-group">
                                  <label>Address</label>
                                  <input type="text" name='address' class="form-control" value="{{ old('address') }}">
                              </div>
                              <div class="form-group">
                                  <label>Phone number</label>
                                  <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                              </div>
                              
                              <!-- Buttons -->
                          <div class="text-right mt-3">
                            
                        
                          <a href="{{ route('admin.user.show') }}" class="btn btn-secondary"><- Back</a>
                          <button type="submit" class="btn btn-primary">Create</button>
                          </div>
                  </div>
                          </form>
                      </div>

                      
                  </div>

                  
              </div>
          </div>
      </div>
  </div>
</div>
<script>
  document.getElementById('avatar').addEventListener('change', function (e) {
      const file = e.target.files[0];
      if (file) {
          const reader = new FileReader();

          reader.onload = function (e) {
              document.getElementById('preview-avatar').src = e.target.result;
          };

          reader.readAsDataURL(file);
      }
  });
</script>
@endsection
