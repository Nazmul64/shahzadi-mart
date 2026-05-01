@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px; background: #ecfdf5; border: 1.5px solid #10b981; color: #065f46; display: flex; align-items: center; gap: 10px; font-weight: 500;">
    <i class="bi bi-check-circle-fill" style="font-size: 18px; color: #10b981;"></i>
    <div>{{ session('success') }}</div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="margin-left: auto; filter: none; opacity: 0.6;"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px; background: #fef2f2; border: 1.5px solid #ef4444; color: #991b1b; display: flex; align-items: center; gap: 10px; font-weight: 500;">
    <i class="bi bi-exclamation-octagon-fill" style="font-size: 18px; color: #ef4444;"></i>
    <div>{{ session('error') }}</div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="margin-left: auto; filter: none; opacity: 0.6;"></button>
</div>
@endif

@if(session('warning'))
<div class="alert alert-warning alert-dismissible fade show" role="alert" style="border-radius: 12px; background: #fffbeb; border: 1.5px solid #f59e0b; color: #92400e; display: flex; align-items: center; gap: 10px; font-weight: 500;">
    <i class="bi bi-exclamation-triangle-fill" style="font-size: 18px; color: #f59e0b;"></i>
    <div>{{ session('warning') }}</div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="margin-left: auto; filter: none; opacity: 0.6;"></button>
</div>
@endif
