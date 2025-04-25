@extends('admin.layout')
@section('content')
    <style>
        .body-wrapper {
            margin-top: -48px;
        }
    </style>

    <div class="container-fluid mt-5 mb-5" style="background: white">
        <div class="card shadow">

            <div class="card-body">
                <div class="row">
                    <!-- Right: Tabs -->
                    <div class="col-md-12">
                        <div class="tab-content">
                            <div class="accordion" id="accordionExample">
                                <div class="card">
                                    <div class="card-header" id="headingOne">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link btn-block text-left" type="button"
                                                data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                                                aria-controls="collapseOne" style="text-decoration: none;color: black">
                                                <img style="width: 45px; height: 45px"
                                                    src="{{ asset('storage/images/ChatGPT-Logo.svg.png') }}"
                                                    alt=""><span class="ml-2">OpenAI</span>
                                            </button>
                                        </h2>
                                    </div>

                                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                                        data-parent="#accordionExample">
                                        <div class="card-body">
                                            @error('api_key', 'ai_model_' . $AiModel[0]->id)
                                                <div style="color: #e53e3e; margin-top: 3px;">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            <form action="{{ route('admin.ai-model.api-key.edit') }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="number" name="id" class="form-control d-none"
                                                    value="{{ $AiModel[0]->id }}">
                                                <div class="form-group">
                                                    <label>MODEL:</label>
                                                    <input type="text" disabled class="form-control"
                                                        value="{{ $AiModel[0]->name }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>API KEY:</label>
                                                    <input name="api_key" type="text" class="form-control"
                                                        value="{{ $AiModel[0]->api_key }}">
                                                </div>
                                                <div class="text-right mt-3">
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="headingTwo">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link btn-block text-left collapsed" type="button"
                                                data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                                                aria-controls="collapseTwo" style="text-decoration: none; color: black">
                                                <img style="width: 45px; height: 45px"
                                                    src="{{ asset('storage/images/Gemini-Icon.png') }}" alt=""><span
                                                    class="ml-2">Gemini</span>
                                            </button>
                                        </h2>
                                    </div>
                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                        data-parent="#accordionExample">
                                        <div class="card-body">

                                            @error('api_key', 'ai_model_' . $AiModel[1]->id)
                                                <div style="color: #e53e3e; margin-top: 3px;">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                            <form action="{{ route('admin.ai-model.api-key.edit') }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="number" name="id" class="form-control d-none"
                                                    value="{{ $AiModel[1]->id }}">
                                                <div class="form-group">
                                                    <label>MODEL:</label>
                                                    <input type="text" disabled class="form-control"
                                                        value="{{ $AiModel[1]->name }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>API KEY:</label>
                                                    <input name="api_key" type="text" class="form-control"
                                                        value="{{ $AiModel[1]->api_key }}">
                                                </div>
                                                <div class="text-right mt-3">
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="headingThree">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link btn-block text-left" type="button"
                                                data-toggle="collapse" data-target="#collapseThree" aria-expanded="true"
                                                aria-controls="collapseThree" style="text-decoration: none;color: black">
                                                <img style="width: 45px; height: 45px"
                                                    src="{{ asset('storage/images/grok-logo.png') }}" alt=""><span
                                                    class="ml-2">Grok</span>
                                            </button>
                                        </h2>
                                    </div>

                                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                        data-parent="#accordionExample">
                                        <div class="card-body">
                                            @error('api_key', 'ai_model_' . $AiModel[2]->id)
                                                <div style="color: #e53e3e; margin-top: 3px;">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            <form action="{{ route('admin.ai-model.api-key.edit') }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="number" name="id" class="form-control d-none"
                                                    value="{{ $AiModel[2]->id }}">
                                                <div class="form-group">
                                                    <label>MODEL:</label>
                                                    <input type="text" disabled class="form-control"
                                                        value="{{ $AiModel[2]->name }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>API KEY:</label>
                                                    <input name="api_key" type="text" class="form-control"
                                                        value="{{ $AiModel[2]->api_key }}">
                                                </div>
                                                <div class="text-right mt-3">

                                                    <button type="submit" class="btn btn-primary">Update</button>
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
@endsection
