@extends('admin.layout')
@section('content')
    <div class="container-xl">
        <form action="">
            <div class="row">
                <div>
                    <h3>Website config</h3>
                    <hr class="mt-1 mb-3" />
                </div>
                <div class="mb-3 col-6">
                    <label for="exampleFormControlInput1" class="form-label">Title</label>
                    <input name="title" type="text" class="form-control" id="exampleFormControlInput1"
                        value="{{ $configWeb->title }}">
                </div>
                <div class="mb-3 col-6">
                    <label for="exampleFormControlInput1" class="form-label">Keywords</label>
                    <input type="text" name="keywords" class="form-control" id="exampleFormControlInput1"
                        value="{{ $configWeb->keywords }}">
                </div>
                <div class="mb-3 col-12">
                    <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description">{{ $configWeb->web_description }}</textarea>
                </div>
                <div class="col-12 text-end">
                    <button class="btn btn-success">Update</button>
                </div>
            </div>
        </form>
        <div class="row mt-3">
            <div class="col-12">
                <h3>Company config</h3>
                <hr class="mt-1 mb-3" />
            </div>
            <div class="col-6">
                <div class="col-12">
                    <h5>Contact infor</h5>
                    <hr class="mt-1 mb-3" />
                </div>
                <div class="mb-3 col-6">
                    <label for="exampleFormControlInput1" class="form-label">Email</label>
                    <input type="email" class="form-control" id="exampleFormControlInput1"
                        value="{{ $configWeb->email }}">
                </div>
                <div class="mb-3 col-6">
                    <label for="exampleFormControlInput1" class="form-label">Phone</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1"
                        value="{{ $configWeb->phone_number }}">
                </div>
            </div>
            <div class="col-6">
                <div class="col-12">
                    <h5>Social infor</h5>
                    <hr class="mt-1 mb-3" />
                </div>
                <div class="mb-3 col-6">
                    <label for="exampleFormControlInput1" class="form-label">Facebook link</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1"
                        value="{{ $configWeb->facebook_link }}">
                </div>
                <div class="mb-3 col-6">
                    <label for="exampleFormControlInput1" class="form-label">Youtube link</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" value="youtube.com">
                </div>
            </div>
            <div class="mb-3 col-12">
                <label for="exampleFormControlInput1" class="form-label">Address</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" value="{{ $configWeb->address }}">
            </div>
            <div class="mb-3 col-12">
                <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3">{{ $configWeb->company_description }}</textarea>
            </div>
            <div class="col-12 text-end">
                <button class="btn btn-success">Update</button>
            </div>
        </div>
    </div>
@endsection
