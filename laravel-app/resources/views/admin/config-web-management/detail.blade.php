@extends('admin.layout')
@section('content')
    <div class="container-xl">
        <form id="website-config-form">
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
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="website_description">{{ $configWeb->web_description }}</textarea>
                </div>
                <div class="col-12 text-end">
                    <button class="btn btn-success" id="updateWebsiteBtn">Update</button>
                </div>
            </div>
        </form>
        <form id="company-config-form">
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
                        <input type="text" class="form-control" id="exampleFormControlInput1" name='phone'
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
                        <input type="text" class="form-control" id="exampleFormControlInput1" name="facebook"
                            value="{{ $configWeb->facebook_link }}">
                    </div>
                    <div class="mb-3 col-6">
                        <label for="exampleFormControlInput1" class="form-label">Youtube link</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" value="youtube.com">
                    </div>
                </div>
                <div class="mb-3 col-12">
                    <label for="exampleFormControlInput1" class="form-label">Address</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" name="address"
                        value="{{ $configWeb->address }}">
                </div>
                <div class="mb-3 col-12">
                    <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                    <textarea name="company_description" class="form-control" id="exampleFormControlTextarea1" rows="3">{{ $configWeb->company_description }}</textarea>
                </div>
                <div class="col-12 text-end">
                    <button class="btn btn-success" id="updateCompanyBtn">Update</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.getElementById("updateWebsiteBtn").addEventListener("click", async function(e) {
            e.preventDefault();

            const btnSubmit = document.getElementById("updateWebsiteBtn");
            btnSubmit.disabled = true;

            const data = {
                title: document.querySelector('input[name="title"]').value,
                keywords: document.querySelector('input[name="keywords"]').value,
                description: document.querySelector('textarea[name="website_description"]').value,
                _method: "PUT",
                _token: "{{ csrf_token() }}"
            };

            try {
                const response = await fetch(
                    "{{ route('admin.config-web.update.website.config', ['id' => $configWeb->id]) }}", {
                        method: "POST",
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(data)
                    });

                if (!response.ok) {
                    if (response.status === 422) {
                        const errData = await response.json();
                        const firstError = Object.values(errData.errors)[0][0];
                        createToastError(firstError);
                    } else {
                        createToastError('Sửa thông tin website không thành công, vui lòng thử lại!');
                    }
                    return;
                }

                await response.json();
                createToastSuccess('Sửa thông tin website thành công!');
            } catch (err) {
                createToastError('Lỗi mạng hoặc máy chủ. Vui lòng thử lại!');
            } finally {
                btnSubmit.disabled = false;
            }
        });

        document.getElementById("updateCompanyBtn").addEventListener("click", async function(e) {
            e.preventDefault();

            const btnSubmit = document.getElementById('updateCompanyBtn');
            btnSubmit.disabled = true;

            const data = {
                email: document.querySelector('input[type="email"]').value,
                phone_number: document.querySelector('input[name="phone"]').value,
                facebook_link: document.querySelector('input[name="facebook"]').value,
                address: document.querySelector('input[name="address"]').value,
                company_description: document.querySelector('textarea[name="company_description"]').value,
                _method: "PUT",
                _token: "{{ csrf_token() }}"
            };

            try {
                const response = await fetch(
                    "{{ route('admin.config-web.update.company.config', ['id' => $configWeb->id]) }}", {
                        method: "POST",
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(data)
                    });

                if (!response.ok) {
                    if (response.status === 422) {
                        const errData = await response.json();
                        const firstError = Object.values(errData.errors)[0][0];
                        createToastError(firstError);
                    } else {
                        createToastError('Sửa thông tin công ty không thành công, vui lòng thử lại!');
                    }
                    return;
                }

                await response.json();
                createToastSuccess('Sửa thông tin công ty thành công!');
            } catch (err) {
                createToastError('Lỗi mạng hoặc máy chủ. Vui lòng thử lại!');
            } finally {
                btnSubmit.disabled = false;
            }
        });
    </script>
@endsection
