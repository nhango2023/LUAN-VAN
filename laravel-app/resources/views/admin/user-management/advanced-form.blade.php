@extends('admin.layout') <!-- nếu dùng layout chung, còn không thì bỏ dòng này -->

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
                    src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://img.freepik.com/free-vector/add-new-user_78370-4710.jpg' }}" 
                    
                    class="rounded-circle img-thumbnail mb-3" 
                    width="140" 
                    alt="User Photo">
                   
        {{-- <label for="avatar" class="btn btn-primary btn-sm">CHANGE PHOTO</label> --}}
                </div>

                <!-- Right: Tabs -->
                <div class="col-md-9">
                    <ul class="nav nav-tabs mb-3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.user.personal.show', ['id' => $user->id]) }}" role="tab">Personal</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#dashboard" role="tab">Role</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#advanced" role="tab">Advanced</a>
                        </li>
                    </ul>
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
                    <div class="tab-content">                     
                        <div class="accordion" id="accordionExample">
                            <div class="card">
                              <div class="card-header" id="headingOne">
                                <h2 class="mb-0">
                                  <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Reset password
                                  </button>
                                </h2>
                              </div>
                          
                              <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">
                                    <form action="{{ route('admin.user.advanced.password.edit', ['id' => $user->id]) }}"  method="POST" >
                                        @csrf
                                        @method('PUT')
                                    
                                       
                                        <div class="form-group">
                                            <label>Email:</label>
                                            <input type="text" disabled class="form-control" value="{{ $user->email }}">
                                        </div>
                                        <div class="form-group">
                                            <label>New passowrd:</label>
                                            <input type="password" name="new_password"  class="form-control" value="">
                                        </div>
                                        <div class="form-group">
                                            <label>Confirm new passowrd:</label>
                                            <input type="password" name="confirm_new_password"   class="form-control" value="">
                                        </div>
                                                                                                                                                          
                                        <!-- Buttons -->
                                    <div class="text-right mt-3">
                                        <a href="{{ route('admin.user.show') }}" 
                                        class="btn btn-secondary"><- Back</a>
                                        <button type="submit" class="btn btn-primary">Change</button>                           
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                            <div class="card">
                              <div class="card-header" id="headingTwo">
                                <h2 class="mb-0">
                                  <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                   Credit
                                  </button>
                                </h2>
                              </div>
                              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                <div class="card-body">
                                    <form action=" {{ route('admin.user.advanced.credit.edit', ['id' => $user->id]) }}"  method="POST" >
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label>Old quanlity:</label>
                                            <input type="number"  disabled class="form-control" value="{{ $user->credit }}">
                                        </div>
                                        <div class="form-group">
                                            <label>New quanlity:</label>
                                            <input name="new_credit" type="number" min="0"  class="form-control" value="">
                                        </div>
                                        <div class="text-right mt-3">
                                            <a href="{{ route('admin.user.show') }}" 
                                            class="btn btn-secondary"><- Back</a>
                                            <button type="submit" class="btn btn-primary">Change</button>                           
                                        </div>
                                    </form>
                                </div>
                              </div>
                            </div>
                            
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
