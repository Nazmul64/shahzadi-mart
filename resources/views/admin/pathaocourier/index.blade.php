@extends('admin.master')

@section('main-content')
<div class="container-fluid">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="font-weight-bold mb-0">Pathao Courier Settings</h5>
        @if(!$pathaocourier)
            <a href="{{ route('admin.pathaocourier.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i> Add Settings
            </a>
        @endif
    </div>

    <div class="card mb-4" style="border-radius: 8px;">
        <div class="card-body p-4">

            @if($pathaocourier)

                <table class="table table-bordered table-hover">
                    <tbody>
                        <tr>
                            <th width="220" class="bg-light">Base URL</th>
                            <td>{{ $pathaocourier->base_url }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Client ID</th>
                            <td><code>{{ $pathaocourier->client_id }}</code></td>
                        </tr>
                        <tr>
                            <th class="bg-light">Client Secret</th>
                            <td><code>••••••••••••••••••••••••</code></td>
                        </tr>
                        <tr>
                            <th class="bg-light">Username</th>
                            <td>{{ $pathaocourier->username }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Password</th>
                            <td><code>••••••••</code></td>
                        </tr>
                        <tr>
                            <th class="bg-light">Grant Type</th>
                            <td><span class="badge badge-secondary">{{ $pathaocourier->grant_type }}</span></td>
                        </tr>
                        <tr>
                            <th class="bg-light">Access Token</th>
                            <td>
                                @if($pathaocourier->access_token)
                                    <span class="badge badge-success">
                                        <i class="fas fa-check-circle"></i> Generated
                                    </span>
                                    @if($pathaocourier->token_expires_at)
                                        <small class="text-muted ml-2">
                                            <i class="fas fa-clock"></i>
                                            Expires: {{ $pathaocourier->token_expires_at->format('d M Y H:i') }}
                                        </small>
                                    @endif
                                    @if($pathaocourier->isTokenExpired())
                                        <span class="badge badge-danger ml-1">
                                            <i class="fas fa-exclamation-circle"></i> Expired
                                        </span>
                                    @endif
                                @else
                                    <span class="badge badge-warning">
                                        <i class="fas fa-times-circle"></i> Not Generated
                                    </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light">Refresh Token</th>
                            <td>
                                @if($pathaocourier->refresh_token)
                                    <span class="badge badge-info">
                                        <i class="fas fa-sync"></i> Available
                                    </span>
                                @else
                                    <span class="badge badge-secondary">N/A</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light">Status</th>
                            <td>
                                @if($pathaocourier->status)
                                    <span class="badge badge-success">
                                        <i class="fas fa-toggle-on"></i> Active
                                    </span>
                                @else
                                    <span class="badge badge-danger">
                                        <i class="fas fa-toggle-off"></i> Inactive
                                    </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light">Created At</th>
                            <td>{{ $pathaocourier->created_at->format('d M Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Updated At</th>
                            <td>{{ $pathaocourier->updated_at->format('d M Y H:i') }}</td>
                        </tr>
                    </tbody>
                </table>

                {{-- Action Buttons --}}
                <div class="mt-4 d-flex flex-wrap gap-2">

                    {{-- Edit --}}
                    <a href="{{ route('admin.pathaocourier.edit', $pathaocourier->id) }}"
                       class="btn btn-primary mr-2">
                        <i class="fas fa-edit"></i> Edit Settings
                    </a>

                    {{-- Generate Token --}}
                    <a href="{{ route('admin.pathaocourier.generate-token') }}"
                       class="btn btn-info mr-2"
                       onclick="return confirm('Pathao API থেকে নতুন token generate করবেন?')">
                        <i class="fas fa-key"></i>
                        @if($pathaocourier->isTokenExpired())
                            Regenerate Token
                        @else
                            Generate Token
                        @endif
                    </a>

                    {{-- Delete --}}
                    <form action="{{ route('admin.pathaocourier.destroy', $pathaocourier->id) }}"
                          method="POST" class="d-inline"
                          onsubmit="return confirm('সত্যিই delete করবেন? এই action undo করা যাবে না!')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>

                </div>

            @else
                {{-- No settings found --}}
                <div class="text-center py-5">
                    <i class="fas fa-motorcycle fa-3x text-muted mb-3"></i>
                    <p class="text-muted mb-3">Pathao Courier এর কোনো settings পাওয়া যায়নি।</p>
                    <a href="{{ route('admin.pathaocourier.create') }}" class="btn btn-success">
                        <i class="fas fa-plus"></i> Add Pathao Courier Settings
                    </a>
                </div>
            @endif

        </div>
    </div>

</div>
@endsection
