@extends('admin.master')

@section('main-content')

<div class="container-fluid">

    <h5 class="mb-3 font-weight-bold">Pathao Courier</h5>

    <div class="card mb-4" style="border-radius: 8px;">
        <div class="card-body p-4">

            <form action="{{ route('admin.pathaocourier.store') }}" method="POST">
                @csrf

                <div class="row">
                    {{-- URL --}}
                    <div class="col-md-6 mb-3">
                        <label for="url">URL <span class="text-danger">*</span></label>
                        <input
                            type="url"
                            name="url"
                            id="url"
                            class="form-control @error('url') is-invalid @enderror"
                            value="{{ old('url') }}"
                            placeholder="https://api-hermes.pathao.com/aladdin"
                        >
                        @error('url')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Token --}}
                    <div class="col-md-6 mb-3">
                        <label for="token">Token <span class="text-danger">*</span></label>
                        <input
                            type="text"
                            name="token"
                            id="token"
                            class="form-control @error('token') is-invalid @enderror"
                            value="{{ old('token') }}"
                            placeholder="Enter Token"
                        >
                        @error('token')
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
                                id="pathao_status"
                                checked
                            >
                            <label class="custom-control-label" for="pathao_status"></label>
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
