{{--
    Shared form partial for Add & Edit Customer modals.
    Usage:
        @include('admin.customer.form', ['customer' => $customer])  // edit
        @include('admin.customer.form', ['customer' => null])       // add
--}}

@php
    $uid = (isset($customer) && $customer) ? $customer->id : 'new';
@endphp

{{-- ── Profile Photo Upload ── --}}
<div class="f-group mb-2">
    <label class="f-label">Profile Photo</label>
    <label class="f-upload-zone" id="uploadZone_{{ $uid }}">

        @if(isset($customer) && $customer && $customer->image && file_exists(public_path($customer->image)))
            <img src="{{ asset($customer->image) }}"
                 class="f-upload-preview"
                 id="imgPreview_{{ $uid }}"
                 alt="Profile photo">
            <p>Click to change photo</p>
        @else
            <div id="uploadPlaceholder_{{ $uid }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                </svg>
                <p>Click to upload photo</p>
                <small>JPG, PNG, WEBP · Max 2 MB · Recommended 600×600</small>
            </div>
            <img src="" class="f-upload-preview" id="imgPreview_{{ $uid }}"
                 alt="Preview" style="display:none;">
        @endif

        <input type="file" name="image" accept="image/jpeg,image/png,image/webp"
            onchange="previewCustomerImg(this, '{{ $uid }}')">
    </label>
</div>

{{-- ── Basic Information ── --}}
<div class="form-section-label">Basic Information</div>

<div class="f-row">
    <div class="f-group">
        <label class="f-label">Full Name <span class="req">*</span></label>
        <input type="text" name="name" class="f-input"
            placeholder="e.g. John Doe"
            value="{{ old('name', $customer->name ?? '') }}" required>
    </div>
    <div class="f-group">
        <label class="f-label">Email Address <span class="req">*</span></label>
        <input type="email" name="email" class="f-input"
            placeholder="e.g. john@email.com"
            value="{{ old('email', $customer->email ?? '') }}" required>
    </div>
</div>

<div class="f-row">
    <div class="f-group">
        <label class="f-label">Phone <span class="req">*</span></label>
        <input type="text" name="phone" class="f-input"
            placeholder="+880 1XXXXXXXXX"
            value="{{ old('phone', $customer->phone ?? '') }}" required>
    </div>
    <div class="f-group">
        <label class="f-label">Fax</label>
        <input type="text" name="fax" class="f-input"
            placeholder="Fax number"
            value="{{ old('fax', $customer->fax ?? '') }}">
    </div>
</div>

{{-- ── Address ── --}}
<div class="form-section-label">Address</div>

<div class="f-row full">
    <div class="f-group">
        <label class="f-label">Street Address <span class="req">*</span></label>
        <input type="text" name="address" class="f-input"
            placeholder="Street / Area"
            value="{{ old('address', $customer->address ?? '') }}" required>
    </div>
</div>

<div class="f-row">
    <div class="f-group">
        <label class="f-label">City</label>
        <input type="text" name="city" class="f-input"
            placeholder="City"
            value="{{ old('city', $customer->city ?? '') }}">
    </div>
    <div class="f-group">
        <label class="f-label">State / Division</label>
        <input type="text" name="state" class="f-input"
            placeholder="State / Division"
            value="{{ old('state', $customer->state ?? '') }}">
    </div>
</div>

<div class="f-row">
    <div class="f-group">
        <label class="f-label">Country</label>
        <select name="country" class="f-select">
            <option value="">Select Country</option>
            @foreach(['Bangladesh','India','USA','UK','Canada','Australia','Saudi Arabia','UAE','Pakistan','Other'] as $c)
            <option value="{{ $c }}"
                {{ old('country', $customer->country ?? '') == $c ? 'selected' : '' }}>
                {{ $c }}
            </option>
            @endforeach
        </select>
    </div>
    <div class="f-group">
        <label class="f-label">Postal Code</label>
        <input type="text" name="postal_code" class="f-input"
            placeholder="Postal / ZIP"
            value="{{ old('postal_code', $customer->postal_code ?? '') }}">
    </div>
</div>

{{-- ── Security ── --}}
<div class="form-section-label">Security</div>

<div class="f-row full">
    <div class="f-group">
        <label class="f-label">
            Password
            @if(isset($customer) && $customer)
                <span style="font-weight:400;color:var(--ink-muted);font-size:11px;"> — leave blank to keep current</span>
            @else
                <span class="req">*</span>
            @endif
        </label>
        <input type="password" name="password" class="f-input"
            placeholder="Min 6 characters"
            {{ (isset($customer) && $customer) ? '' : 'required' }}>
    </div>
</div>
