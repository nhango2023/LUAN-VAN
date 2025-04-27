@extends('admin.layout')
@section('content')
    <style>
        .body-wrapper {
            margin-top: -48px;
        }

        .sync-appear {
            animation: syncFadeIn 0.7s cubic-bezier(.46, 1.48, .54, .99);
        }

        @keyframes syncFadeIn {
            0% {
                transform: scale(0.5) rotate(-20deg);
                opacity: 0;
            }

            60% {
                transform: scale(1.1) rotate(3deg);
                opacity: 1;
            }

            80% {
                transform: scale(0.97) rotate(-2deg);
            }

            100% {
                transform: scale(1) rotate(0deg);
                opacity: 1;
            }
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container-fluid mt-5 mb-5" style="background: white">
        <div class="card shadow">
            <div class="card-body">
                <div class="row">
                    <!-- Right: Tabs -->
                    <div class="col-md-12">
                        <div class="tab-content">
                            <div class="accordion" id="accordionExample">
                                @foreach ($AiModel as $model)
                                    <div class="card">
                                        <div class="card-header" id="heading-{{ $model->id }}">
                                            <h2 class="mb-0">
                                                <button
                                                    class="btn btn-link btn-block text-left {{ !$loop->first ? 'collapsed' : '' }}"
                                                    type="button" data-toggle="collapse"
                                                    data-target="#collapse-{{ $model->id }}"
                                                    aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                                    aria-controls="collapse-{{ $model->id }}"
                                                    style="text-decoration: none; color: black">
                                                    <img style="width: 45px; height: 45px"
                                                        src="{{ asset('storage/images/' . $model->logo) }}" alt="">
                                                    <span class="ml-2">{{ $model->company }}</span>
                                                </button>
                                            </h2>
                                        </div>

                                        <div id="collapse-{{ $model->id }}" class="collapse"
                                            aria-labelledby="heading-{{ $model->id }}" data-parent="#accordionExample">
                                            <div class="card-body">
                                                @error('api_key', 'ai_model_' . $model->id)
                                                    <div style="color: #e53e3e; margin-top: 3px;">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                                <form action="{{ route('admin.ai-model.api-key.edit') }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="number" name="id" class="form-control d-none"
                                                        value="{{ $model->id }}">
                                                    <div class="form-group">
                                                        <label>MODEL:</label>
                                                        <input type="text" disabled class="form-control"
                                                            value="{{ $model->name }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>API KEY:</label>
                                                        <input name="api_key" type="text" class="form-control"
                                                            value="{{ $model->api_key }}">
                                                    </div>
                                                    <div
                                                        class="text-right mt-3 d-flex justify-content-end align-items-center">
                                                        <span id="sync-btn-wrapper-{{ $model->id }}">
                                                            @if ($model->isSync == 1)
                                                                <button disabled class="btn btn-success mr-2">
                                                                    <span
                                                                        class="default-text d-block d-flex align-items-center">
                                                                        <i class="fa fa-check mr-2"></i>
                                                                        <span class="">Sync</span>
                                                                    </span>
                                                                </button>
                                                            @else
                                                                <button class="btn btn-warning mr-2"
                                                                    onclick="syncApiKey('{{ $model->company }}', '{{ $model->api_key }}', {{ $model->id }}, event)">
                                                                    <span
                                                                        class="default-text d-block d-flex align-items-center">
                                                                        <span class="mr-2">Sync now</span>
                                                                        <span class="material-symbols-outlined"
                                                                            style="font-size: 22px;">
                                                                            sync
                                                                        </span>
                                                                    </span>
                                                                </button>
                                                            @endif
                                                        </span>
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        async function syncApiKey(modelName, apiKey, idModel, event) {
            if (event) event.preventDefault();
            try {
                const response = await fetch('/admin/ai-model/api-key/sync', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: JSON.stringify({
                        model_name: modelName,
                        api_key: apiKey,
                        id_model: idModel
                    })
                });

                const data = await response.json();
                if (response.status === 200 && data.success) {
                    const wrapper = document.getElementById(`sync-btn-wrapper-${idModel}`);
                    // Remove existing content
                    wrapper.innerHTML = "";
                    wrapper.innerHTML = `
                        <button disabled class="btn btn-success mr-2 sync-appear">
                            <span class="default-text d-block d-flex align-items-center">
                                <i class="fa fa-check mr-2"></i>
                                <span class="">Sync</span>
                            </span>
                        </button>
                    `;
                } else {
                    alert(data.message || 'Sync failed!');
                }
            } catch (error) {

                alert('Sync error!');
                console.error(error);
            }
        }
    </script>
@endsection
