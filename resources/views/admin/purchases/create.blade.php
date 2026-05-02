@extends('admin.master')
@section('title', 'Add New Purchase')
@section('main-content')
<style>
body { background: #f5f7fa; }
.pur-wrap { padding: 24px 28px; min-height: 100vh; background: #f5f7fa; font-family: 'Segoe UI', sans-serif; }
.pur-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 28px; box-shadow: 0 1px 4px rgba(0,0,0,.06); }
.pur-label { font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px; display: block; }
.pur-input { width: 100%; border: 1px solid #d1d5db; border-radius: 6px; padding: 10px 12px; font-size: 14px; color: #374151; background: #fff; transition: border .2s; box-sizing: border-box; font-family: inherit; }
.pur-input:focus { border-color: #e91e8c; outline: none; box-shadow: 0 0 0 3px rgba(233,30,140,.08); }
.pur-input option { background: #fff; }
.pur-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
.pur-full { grid-column: 1/-1; }
.pur-btn { display: inline-flex; align-items: center; gap: 7px; padding: 10px 24px; border-radius: 7px; font-size: 14px; font-weight: 600; cursor: pointer; border: none; transition: all .2s; }
.pur-btn-pink { background: #e91e8c; color: #fff; }
.pur-btn-pink:hover { background: #c4176f; }
.pur-btn-cancel { background: #fff; color: #6b7280; border: 1px solid #d1d5db; }
.pur-btn-cancel:hover { background: #f3f4f6; }
.pur-btn-plus { background: #e91e8c; color: #fff; width: 30px; height: 30px; border-radius: 6px; border: none; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; font-size: 18px; font-weight: 700; flex-shrink: 0; }
.supplier-row { display: flex; align-items: center; gap: 8px; }
.supplier-row select { flex: 1; }
.slip-box { border: 2px dashed #d1d5db; border-radius: 8px; background: #f9fafb; display: flex; align-items: center; justify-content: center; flex-direction: column; min-height: 220px; cursor: pointer; transition: border .2s; position: relative; overflow: hidden; }
.slip-box:hover { border-color: #e91e8c; }
.slip-box img { width: 100%; height: 100%; object-fit: cover; border-radius: 6px; }
.slip-label { font-size: 13px; color: #9ca3af; font-weight: 500; margin-top: 10px; }
.layout-2col { display: grid; grid-template-columns: 1fr 300px; gap: 24px; }
.section-title { font-size: 16px; font-weight: 700; color: #111827; margin-bottom: 20px; }
.section-sub { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: #9ca3af; margin-bottom: 14px; }
.pur-error { color: #ef4444; font-size: 12px; margin-top: 4px; }
.pur-footer { display: flex; justify-content: space-between; align-items: center; margin-top: 28px; padding-top: 20px; border-top: 1px solid #f3f4f6; }
@media(max-width:900px){.layout-2col{grid-template-columns:1fr;}}
</style>

<div class="pur-wrap">
    <div class="section-title">Add New Purchase</div>

    <form action="{{ route('admin.purchases.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="layout-2col">
            {{-- LEFT SIDE --}}
            <div class="pur-card">
                <div class="pur-full" style="margin-bottom:20px;">
                    <label class="pur-label">Purchase Name or Title</label>
                    <input type="text" name="title" class="pur-input" placeholder="Enter name"
                        value="{{ old('title') }}">
                </div>

                <div class="pur-row">
                    <div>
                        <label class="pur-label">Received Date <span style="color:#ef4444">*</span></label>
                        <input type="date" name="purchase_date" class="pur-input"
                            value="{{ old('purchase_date', date('m/d/Y')) }}"
                            style="color:#374151;">
                        @error('purchase_date')<p class="pur-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="pur-label">Supplier <span style="color:#ef4444">*</span></label>
                        <div class="supplier-row">
                            <select name="supplier_id" class="pur-input">
                                <option value="">Select Supplier</option>
                                @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->name }}
                                </option>
                                @endforeach
                            </select>
                            <button type="button" class="pur-btn-plus" onclick="window.open('{{ route('admin.suppliers.create') }}', '_blank')">+</button>
                        </div>
                        @error('supplier_id')<p class="pur-error">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div style="margin-top:20px;">
                    <label class="pur-label">Notes</label>
                    <textarea name="notes" class="pur-input" rows="4"
                        placeholder="Enter short notes">{{ old('notes') }}</textarea>
                </div>
            </div>

            {{-- RIGHT SIDE: Slip Image --}}
            <div>
                <div class="pur-card" style="height:100%;">
                    <div class="section-sub">Purchase Slip</div>
                    <label for="slip_input" style="display:block;">
                        <div class="slip-box" id="slipPreviewBox">
                            <img id="slipPreviewImg" src="" alt="" style="display:none;position:absolute;inset:0;width:100%;height:100%;object-fit:cover;border-radius:6px;">
                            <div id="slipPlaceholder">
                                <svg width="60" height="60" viewBox="0 0 24 24" fill="none" style="opacity:.2;display:block;margin:0 auto;">
                                    <rect width="24" height="24" rx="4" fill="#9ca3af"/>
                                    <path d="M4 16l4-4 3 3 4-5 5 6H4z" fill="#fff"/>
                                    <circle cx="8" cy="8" r="2" fill="#fff"/>
                                </svg>
                                <span class="slip-label">Lot Slip Photo</span>
                                <span style="font-size:11px;color:#d1d5db;margin-top:4px;display:block;">Click to upload image</span>
                            </div>
                        </div>
                    </label>
                    <input type="file" name="lot_slip_image" id="slip_input" accept="image/*" style="display:none;"
                        onchange="previewSlip(this)">
                    @error('lot_slip_image')<p class="pur-error">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        <div class="pur-footer">
            <a href="{{ route('admin.purchases.index') }}" class="pur-btn pur-btn-cancel">
                Cancel
            </a>
            <button type="submit" class="pur-btn pur-btn-pink">
                Submit
            </button>
        </div>
    </form>
</div>

<script>
function previewSlip(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.getElementById('slipPreviewImg');
            img.src = e.target.result;
            img.style.display = 'block';
            document.getElementById('slipPlaceholder').style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
