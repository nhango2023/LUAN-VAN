@extends('admin.layout')
@section('content')
@section('title', 'Manage Users')
<title>Manage uers</title>
    <div class="container-xl" style="overflow-y: hidden">
        <div class="table-responsive" style="overflow-y: hidden">
          <div class="table-wrapper" style="overflow-y: hidden">
            <div class="table-title">
              <div class="row">
                <div class="col-sm-5">
                  <h2>User <b>Management</b></h2>
                </div>
                <div class="col-sm-7" style="text-align: right" style="overflow-y: hidden">
                  <a href="{{ route('admin.user.create') }}" class="btn btn-secondary d-inline-flex align-items-center"><i class="material-icons">&#xE147;</i> 
                    <span>Add New
                      User</span></a>
                  {{-- <a href="#" class="btn btn-secondary"><i class="material-icons">&#xE24D;</i> <span>Export to
                      Excel</span></a> --}}
                </div>
              </div>
            </div>
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Date Created</th>
                  <th>Role</th>
                  {{-- <th>Status</th> --}}
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>
                        <a href="#"><img style="width: 40px; height: 40px" src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://img.freepik.com/free-vector/add-new-user_78370-4710.jpg' }}" class="avatar rounded-circle img-thumbnail " alt="Avatar"> <span>{{ $user->fullname }}</span></a>

                    </td>
                    <td>{{ $user->created_at  }}</td>
                    <td>{{ $user->level }}</td>
                    {{-- <td><span class="status text-success">&bull;</span> Active</td> --}}
                    <td>
                      <a href="{{ route('admin.user.personal.edit', ['id' => $user->id]) }}" class="settings" title="Settings" data-toggle="tooltip"><i
                          class="material-icons">&#xE3C9;</i></a>
                          <a href="#" class="delete-user" data-fullname="{{ $user->fullname }}" data-id="{{ $user->id }}" style="color: red" title="Delete" data-toggle="tooltip">
                            <i class="material-icons">&#xE5C9;</i>
                        </a>
                    </td>
                  </tr>
                @endforeach
                <form id="delete-form" method="POST" style="display: none;">
                  @csrf
                  @method('DELETE')
              </form>
              </tbody>
            </table>

            <div class="clearfix">
              <div class="hint-text">Showing <b>5</b> out of <b>25</b> entries</div>
              <ul class="pagination">
                {{-- Previous Page --}}
                <li class="page-item {{ $users->onFirstPage() ? 'disabled' : '' }}">
                    <a href="{{ $users->previousPageUrl() ?? '#' }}" class="page-link">Previous</a>
                </li>
            
                {{-- Page Numbers --}}
                @for ($i = 1; $i <= $users->lastPage(); $i++)
                    <li class="page-item {{ $users->currentPage() == $i ? 'active' : '' }}">
                        <a href="{{ $users->url($i) }}" class="page-link">{{ $i }}</a>
                    </li>
                @endfor
            
                {{-- Next Page --}}
                <li class="page-item {{ $users->hasMorePages() ? '' : 'disabled' }}">
                    <a href="{{ $users->nextPageUrl() ?? '#' }}" class="page-link">Next</a>
                </li>
            </ul>
            </div>
          </div>
        </div>
      </div> 
      <!--  Header End -->
      <script>
        $(document).ready(function () {
            $('.delete-user').click(function (e) {
                e.preventDefault();
                const userId = $(this).data('id');
                const fullname = $(this).data('fullname');
                if (confirm(`Bạn có chắc muốn xoá người dùng ${fullname} không?`)) {
                    const action = '{{ url('/admin/user/delete') }}/' + userId;
                    $('#delete-form').attr('action', action).submit();
                }
            });
        });
    </script>
@endsection