

<style>
    /* ── Vendor Hero Banner ── */
    .vendor-hero {
        background: linear-gradient(135deg, #fef3c7 0%, #fffbeb 100%);
        border: 1px solid #fde68a;
        border-radius: var(--radius-sm);
        padding: 14px 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 18px;
    }
    .vendor-hero-icon {
        width: 40px; height: 40px;
        border-radius: 10px;
        background: #f59e0b;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .vendor-hero-icon svg { width: 20px; height: 20px; color: #fff; }
    .vendor-hero p { margin: 0; font-size: 12px; color: #92400e; line-height: 1.5; }
    .vendor-hero strong { font-weight: 700; color: #78350f; }

    /* ── Plan Cards ── */
    .plan-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
        margin-top: 6px;
    }
    @media (max-width: 540px) { .plan-grid { grid-template-columns: 1fr; } }

    .plan-card {
        border: 2px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 14px 10px;
        text-align: center;
        cursor: pointer;
        transition: border-color .15s, background .15s;
        user-select: none;
    }
    .plan-card:hover { border-color: var(--accent); }
    .plan-card input[type="radio"] { display: none; }
    .plan-card.selected {
        border-color: var(--accent);
        background: var(--accent-soft);
    }
    .plan-icon  { font-size: 20px; display: block; margin-bottom: 5px; }
    .plan-name  { font-size: 13px; font-weight: 700; color: var(--ink); display: block; margin-bottom: 3px; }
    .plan-desc  { font-size: 10px; color: var(--ink-muted); line-height: 1.4; }
</style>

{{-- ── Info Banner ── --}}
<div class="vendor-hero">
    <div class="vendor-hero-icon">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z"/>
        </svg>
    </div>
    <p>
        <strong>Vendor Promotion</strong><br>
        Fill in the shop details below to grant vendor access.
        This action allows the customer to list and sell products on the platform.
    </p>
</div>

{{-- ── Shop Information ── --}}
<div class="form-section-label">Shop Information</div>

<div class="f-row">
    <div class="f-group">
        <label class="f-label">Shop Name <span class="req">*</span></label>
        <input type="text" name="shop_name" class="f-input"
            placeholder="e.g. TechZone BD" required>
    </div>
    <div class="f-group">
        <label class="f-label">Owner Name <span class="req">*</span></label>
        <input type="text" name="owner_name" class="f-input"
            placeholder="Full owner name" required>
    </div>
</div>

<div class="f-row">
    <div class="f-group">
        <label class="f-label">Shop Phone <span class="req">*</span></label>
        <input type="text" name="shop_number" class="f-input"
            placeholder="Contact number" required>
    </div>
    <div class="f-group">
        <label class="f-label">Registration No.</label>
        <input type="text" name="registration_number" class="f-input"
            placeholder="Optional — trade / reg number">
    </div>
</div>

<div class="f-row full">
    <div class="f-group">
        <label class="f-label">Shop Address <span class="req">*</span></label>
        <input type="text" name="shop_address" class="f-input"
            placeholder="Full shop address" required>
    </div>
</div>

<div class="f-row full">
    <div class="f-group">
        <label class="f-label">Shop Details <span class="req">*</span></label>
        <textarea name="shop_details" class="f-input" rows="3"
            style="resize:vertical;"
            placeholder="Describe the shop, products sold, and any additional details…"
            required></textarea>
    </div>
</div>

{{-- ── Plan Selection ── --}}
<div class="form-section-label">Choose Plan</div>

<div class="plan-grid" id="planGrid_{{ uniqid() }}">

    <label class="plan-card selected" onclick="selectVendorPlan(this)">
        <input type="radio" name="plan" value="standard" checked>
        <span class="plan-icon">🚀</span>
        <span class="plan-name">Standard</span>
        <span class="plan-desc">Basic listing &amp; sales features</span>
    </label>

    <label class="plan-card" onclick="selectVendorPlan(this)">
        <input type="radio" name="plan" value="premium">
        <span class="plan-icon">⭐</span>
        <span class="plan-name">Premium</span>
        <span class="plan-desc">Priority listing + analytics</span>
    </label>

    <label class="plan-card" onclick="selectVendorPlan(this)">
        <input type="radio" name="plan" value="enterprise">
        <span class="plan-icon">🏆</span>
        <span class="plan-name">Enterprise</span>
        <span class="plan-desc">Full features + dedicated support</span>
    </label>

</div>

<script>
function selectVendorPlan(el) {
    // Scope to the nearest .plan-grid ancestor so multiple modals don't clash
    const grid = el.closest('.plan-grid');
    if (!grid) return;
    grid.querySelectorAll('.plan-card').forEach(c => c.classList.remove('selected'));
    el.classList.add('selected');
    el.querySelector('input[type="radio"]').checked = true;
}
</script>
