@extends('admin.master')

@section('main-content')

<div class="container-fluid">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <h5 class="mb-3 font-weight-bold">Steadfast Courier</h5>

    <div class="card mb-4" style="border-radius: 8px;">
        <div class="card-body p-4">

            <form action="{{ route('admin.steadfastcourier.update', $steadfastcourier->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    {{-- API Key --}}
                    <div class="col-md-6 mb-3">
                        <label for="api_key">API key <span class="text-danger">*</span></label>
                        <input
                            type="text"
                            name="api_key"
                            id="api_key"
                            class="form-control @error('api_key') is-invalid @enderror"
                            value="{{ old('api_key', $steadfastcourier->api_key) }}"
                            placeholder="Enter API Key"
                        >
                        @error('api_key')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Secret Key --}}
                    <div class="col-md-6 mb-3">
                        <label for="secret_key">Secret key <span class="text-danger">*</span></label>
                        <input
                            type="text"
                            name="secret_key"
                            id="secret_key"
                            class="form-control @error('secret_key') is-invalid @enderror"
                            value="{{ old('secret_key', $steadfastcourier->secret_key) }}"
                            placeholder="Enter Secret Key"
                        >
                        @error('secret_key')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- URL --}}
                    <div class="col-md-6 mb-3">
                        <label for="url">URL <span class="text-danger">*</span></label>
                        <input
                            type="url"
                            name="url"
                            id="url"
                            class="form-control @error('url') is-invalid @enderror"
                            value="{{ old('url', $steadfastcourier->url) }}"
                            placeholder="https://portal.steadfast.com.bd/api/v1/create_order"
                        >
                        @error('url')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="col-md-6 mb-3">
                        <label>Status</label><br>
                        <div class="custom-control custom-switch mt-1">
                            <input
                                type="checkbox"
                                name="status"
                                class="custom-control-input"
                                id="steadfast_status"
                                {{ $steadfastcourier->status ? 'checked' : '' }}
                            >
                            <label class="custom-control-label" for="steadfast_status"></label>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-success px-4" style="background-color:#2ec4b6; border-color:#2ec4b6;">
                    Submit
                </button>

            </form>
        </div>
    </div>

</div>

@endsection
