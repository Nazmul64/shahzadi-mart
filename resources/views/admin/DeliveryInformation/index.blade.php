@extends('admin.master')

@section('main-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Delivery Information</h4>
                    @if(!$deliveryInfo)
                        <a href="{{ route('admin.DeliveryInformation.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add Information
                        </a>
                    @else
                        <a href="{{ route('admin.DeliveryInformation.edit', $deliveryInfo->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit Information
                        </a>
                    @endif
                </div>

                <div class="card-body">

                    {{-- Alert Messages --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif
                    @if(session('info'))
                        <div class="alert alert-info alert-dismissible fade show">
                            {{ session('info') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif

                    @if(!$deliveryInfo)
                        <div class="text-center py-5">
                            <p class="text-muted">No delivery information found.</p>
                            <a href="{{ route('admin.DeliveryInformation.create') }}" class="btn btn-primary">
                                Add Delivery Information
                            </a>
                        </div>
                    @else
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th width="30%">Header Title</th>
                                    <td>{{ $deliveryInfo->header_title ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Home Delivery Title</th>
                                    <td>{{ $deliveryInfo->home_delivery_title ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Home Delivery Description</th>
                                    <td>{{ $deliveryInfo->home_delivery_description ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Pickup Title</th>
                                    <td>{{ $deliveryInfo->pickup_title ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Pickup Description</th>
                                    <td>{{ $deliveryInfo->pickup_description ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Instant Download Title</th>
                                    <td>{{ $deliveryInfo->instant_download_title ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Instant Download Description</th>
                                    <td>{{ $deliveryInfo->instant_download_description ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Secure Payment Title</th>
                                    <td>{{ $deliveryInfo->secure_title ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Secure Payment Description</th>
                                    <td>{{ $deliveryInfo->secure_description ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>COD Title</th>
                                    <td>{{ $deliveryInfo->cod_title ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>COD Description</th>
                                    <td>{{ $deliveryInfo->cod_description ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Mobile Banking Title</th>
                                    <td>{{ $deliveryInfo->mobile_banking_title ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Mobile Banking Description</th>
                                    <td>{{ $deliveryInfo->mobile_banking_description ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Footer Company Information</th>
                                    <td>{{ $deliveryInfo->footer_company_information ?? 'N/A' }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="mt-3">
                            <form action="{{ route('admin.DeliveryInformation.destroy', $deliveryInfo->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this record?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
