@extends('admin.master')

@section('main-content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between" style="padding: 20px 0;">
                    <h4 class="mb-0">Blocked Customers & Fraud Profiles</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card" style="border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Phone</th>
                                        <th>Last IP</th>
                                        <th>Status</th>
                                        <th>Blocked</th>
                                        <th>Last Updated</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($profiles as $profile)
                                    <tr>
                                        <td><strong style="color: #2d3748;">{{ $profile->phone }}</strong></td>
                                        <td><code>{{ $profile->ip_address ?: 'N/A' }}</code></td>
                                        <td>
                                            @if($profile->status === 'real')
                                                <span class="badge bg-success">REAL</span>
                                            @elseif($profile->status === 'fake')
                                                <span class="badge bg-danger">FAKE</span>
                                            @else
                                                <span class="badge bg-secondary">NONE</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($profile->is_blocked)
                                                <span class="badge bg-dark">BLOCKED</span>
                                            @else
                                                <span class="badge bg-light text-dark">ACTIVE</span>
                                            @endif
                                        </td>
                                        <td>{{ $profile->updated_at->format('d M Y, h:i A') }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="checkFraud('{{ $profile->phone }}')">
                                                <i class="bi bi-shield-check"></i> Check / Manage
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">No fraud profiles found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $profiles->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Fraud Modal Partial --}}
<div id="fraud-check-overlay"
     style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5);
            z-index:10000; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:12px; padding:28px 32px;
                width:500px; max-width:95vw; box-shadow:0 8px 32px rgba(0,0,0,0.2);
                max-height:90vh; overflow-y:auto; position: relative;">

        {{-- Header --}}
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <h5 style="margin:0; font-size:18px; font-weight:700; color:#2d3748;">
                <i class="bi bi-shield-check me-2" style="color:#e84393;"></i>
                Customer Success History
            </h5>
            <button type="button" onclick="closeFraudModal()"
                    style="background:none; border:none; font-size:22px; cursor:pointer; color:#aaa; line-height:1;">
                ×
            </button>
        </div>

        <div id="fraud-loader" style="text-align: center; padding: 30px;">
            <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem; color: #e84393 !important;">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p style="margin-top: 10px; color: #555; font-weight: 600;">Analyzing customer history...</p>
        </div>

        <div id="fraud-content" style="display: none;">
            <!-- Dynamic Content Here -->
        </div>

        {{-- Buttons --}}
        <div style="display:flex; gap:10px; justify-content:flex-end; margin-top: 20px; border-top: 1px solid #eee; padding-top: 15px;">
            <button type="button" onclick="closeFraudModal()"
                    style="background:#f4f6fb; color:#555; border:1px solid #e5e7eb;
                           border-radius:8px; padding:9px 22px; font-size:13px;
                           cursor:pointer; font-weight:600;">
                Close
            </button>
        </div>
    </div>
</div>

<script>
function checkFraud(phone) {
    document.getElementById('fraud-check-overlay').style.display = 'flex';
    document.getElementById('fraud-loader').style.display = 'block';
    document.getElementById('fraud-content').style.display = 'none';

    fetch('{{ route("admin.fraud-checker.check") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ phone: phone })
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById('fraud-loader').style.display = 'none';
        
        let content = document.getElementById('fraud-content');
        if (data.status === 'new_customer') {
            content.innerHTML = `
                <div style="padding: 15px; background: #e3f2fd; color: #0d47a1; border-radius: 8px; border: 1px solid #bbdefb; margin-bottom: 15px;">
                    <i class="bi bi-info-circle-fill me-2"></i> ${data.message}
                </div>
                <div style="margin-top: 25px; padding-top: 20px; border-top: 1px solid #eee; display: flex; flex-wrap: wrap; gap: 10px; justify-content: center;">
                    <button type="button" onclick="updateManualStatus('${data.phone}', 'real')" 
                            style="background: ${data.manual_status === 'real' ? '#2e7d32' : '#fff'}; color: ${data.manual_status === 'real' ? '#fff' : '#2e7d32'}; border: 1px solid #2e7d32; border-radius: 6px; padding: 6px 12px; font-size: 12px; font-weight: 600; cursor: pointer;">
                        <i class="bi bi-patch-check-fill me-1"></i> Mark Real
                    </button>
                    <button type="button" onclick="updateManualStatus('${data.phone}', 'fake')" 
                            style="background: ${data.manual_status === 'fake' ? '#c62828' : '#fff'}; color: ${data.manual_status === 'fake' ? '#fff' : '#c62828'}; border: 1px solid #c62828; border-radius: 6px; padding: 6px 12px; font-size: 12px; font-weight: 600; cursor: pointer;">
                        <i class="bi bi-x-octagon-fill me-1"></i> Mark Fake
                    </button>
                    <button type="button" onclick="toggleBlockCustomer('${data.phone}', '${data.ip_address || ''}')" 
                            style="background: ${data.is_blocked ? '#000' : '#fff'}; color: ${data.is_blocked ? '#fff' : '#000'}; border: 1px solid #000; border-radius: 6px; padding: 6px 12px; font-size: 12px; font-weight: 600; cursor: pointer;">
                        <i class="bi bi-slash-circle-fill me-1"></i> ${data.is_blocked ? 'Unblock User' : 'Block User & IP'}
                    </button>
                </div>
            `;
        } else {
            let fraudBg = data.fraud_color === 'danger' ? '#ffebee' : (data.fraud_color === 'success' ? '#e8f5e9' : '#fff3e0');
            let fraudBorder = data.fraud_color === 'danger' ? '#ffcdd2' : (data.fraud_color === 'success' ? '#c8e6c9' : '#ffe0b2');
            let fraudText = data.fraud_color === 'danger' ? '#c62828' : (data.fraud_color === 'success' ? '#2e7d32' : '#ef6c00');
            
            let html = `
                <div style="background: ${fraudBg}; border: 1px solid ${fraudBorder}; color: ${fraudText}; padding: 12px; border-radius: 8px; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center;">
                    <i class="bi bi-shield-exclamation me-2" style="font-size: 18px;"></i>
                    Assessment: ${data.fraud_score}
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 20px;">
                    <div style="border: 1px solid #eee; padding: 12px; border-radius: 8px; text-align: center;">
                        <div style="font-size: 24px; font-weight: 800; color: #2d3748;">${data.total_orders}</div>
                        <div style="font-size: 11px; color: #777; text-transform: uppercase; font-weight: 600;">Total Orders</div>
                    </div>
                    <div style="border: 1px solid #eee; padding: 12px; border-radius: 8px; text-align: center;">
                        <div style="font-size: 24px; font-weight: 800; color: ${data.success_rate > 50 ? '#2e7d32' : (data.success_rate < 30 ? '#c62828' : '#ef6c00')};">${data.success_rate}%</div>
                        <div style="font-size: 11px; color: #777; text-transform: uppercase; font-weight: 600;">Success Rate</div>
                    </div>
                </div>

                <div style="margin-bottom: 20px;">
                    <h6 style="font-size: 13px; font-weight: 700; color: #555; border-bottom: 1px solid #eee; padding-bottom: 5px; margin-bottom: 10px;">Order Status Breakdown</h6>
                    <div style="display: flex; justify-content: space-between; font-size: 13px;">
                        <span><span style="display:inline-block; width:10px; height:10px; background:#2e7d32; border-radius:50%; margin-right:5px;"></span> Delivered: <strong style="color:#2e7d32;">${data.delivered}</strong></span>
                        <span><span style="display:inline-block; width:10px; height:10px; background:#c62828; border-radius:50%; margin-right:5px;"></span> Cancel/Ret: <strong style="color:#c62828;">${data.cancelled}</strong></span>
                        <span><span style="display:inline-block; width:10px; height:10px; background:#f57c00; border-radius:50%; margin-right:5px;"></span> Pending: <strong>${data.pending}</strong></span>
                    </div>
                </div>

                <div style="margin-bottom: 20px;">
                    <h6 style="font-size: 13px; font-weight: 700; color: #555; border-bottom: 1px solid #eee; padding-bottom: 5px; margin-bottom: 10px;">Courier & Payment History</h6>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; font-size: 13px;">
                        <div style="background: #f8f9fc; padding: 10px; border-radius: 6px; border: 1px solid #e8eaf0;">
                            <strong style="color: #2d3748; display: block; margin-bottom: 5px;">Payment Used</strong>
                            bKash: <strong>${data.bkash_count}</strong><br>
                            Nagad: <strong>${data.nagad_count}</strong><br>
                            COD: <strong>${data.cod_count}</strong>
                        </div>
                        <div style="background: #f8f9fc; padding: 10px; border-radius: 6px; border: 1px solid #e8eaf0;">
                            <strong style="color: #2d3748; display: block; margin-bottom: 5px;">Steadfast Stats</strong>
                            Total Sent: <strong>${data.courier_stats.steadfast_total}</strong><br>
                            Delivered: <strong>${data.courier_stats.steadfast_delivered}</strong><br>
                            Cancelled/Ret: <strong>${data.courier_stats.steadfast_cancelled}</strong>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h6 style="font-size: 13px; font-weight: 700; color: #555; border-bottom: 1px solid #eee; padding-bottom: 5px; margin-bottom: 10px;">Recent Orders</h6>
                    <table style="width: 100%; font-size: 12px; border-collapse: collapse;">
                        <thead>
                            <tr style="background: #f8f9fc;">
                                <th style="padding: 6px 8px; border-bottom: 1px solid #eee; text-align: left;">Invoice</th>
                                <th style="padding: 6px 8px; border-bottom: 1px solid #eee; text-align: left;">Date</th>
                                <th style="padding: 6px 8px; border-bottom: 1px solid #eee; text-align: left;">Total</th>
                                <th style="padding: 6px 8px; border-bottom: 1px solid #eee; text-align: left;">Method</th>
                                <th style="padding: 6px 8px; border-bottom: 1px solid #eee; text-align: left;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${data.recent_orders.map(o => `
                                <tr>
                                    <td style="padding: 6px 8px; border-bottom: 1px solid #eee;">${o.order_number}</td>
                                    <td style="padding: 6px 8px; border-bottom: 1px solid #eee; color:#777;">${o.date}</td>
                                    <td style="padding: 6px 8px; border-bottom: 1px solid #eee; font-weight:600;">৳${Number(o.total).toLocaleString()}</td>
                                    <td style="padding: 6px 8px; border-bottom: 1px solid #eee;">
                                        <span style="background:#f4f6fb; padding:2px 6px; border-radius:4px; font-size:10px;">${o.method}</span>
                                    </td>
                                    <td style="padding: 6px 8px; border-bottom: 1px solid #eee;">
                                        <span class="attr-tag ${o.status === 'Delivered' ? 'attr-size' : (o.status === 'Cancelled' ? 'attr-color' : '')}" style="background: ${o.status === 'Delivered' ? '#e8f5e9' : (o.status === 'Cancelled' ? '#ffebee' : '#f4f6fb')}; color: ${o.status === 'Delivered' ? '#2e7d32' : (o.status === 'Cancelled' ? '#c62828' : '#555')}; border: none;">
                                            ${o.status}
                                        </span>
                                    </td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>

                <div style="margin-top: 25px; padding-top: 20px; border-top: 1px solid #eee; display: flex; flex-wrap: wrap; gap: 10px; justify-content: center;">
                    <button type="button" onclick="updateManualStatus('${data.phone}', 'real')" 
                            style="background: ${data.manual_status === 'real' ? '#2e7d32' : '#fff'}; color: ${data.manual_status === 'real' ? '#fff' : '#2e7d32'}; border: 1px solid #2e7d32; border-radius: 6px; padding: 6px 12px; font-size: 12px; font-weight: 600; cursor: pointer;">
                        <i class="bi bi-patch-check-fill me-1"></i> Mark Real
                    </button>
                    <button type="button" onclick="updateManualStatus('${data.phone}', 'fake')" 
                            style="background: ${data.manual_status === 'fake' ? '#c62828' : '#fff'}; color: ${data.manual_status === 'fake' ? '#fff' : '#c62828'}; border: 1px solid #c62828; border-radius: 6px; padding: 6px 12px; font-size: 12px; font-weight: 600; cursor: pointer;">
                        <i class="bi bi-x-octagon-fill me-1"></i> Mark Fake
                    </button>
                    <button type="button" onclick="toggleBlockCustomer('${data.phone}', '${data.ip_address || ''}')" 
                            style="background: ${data.is_blocked ? '#000' : '#fff'}; color: ${data.is_blocked ? '#fff' : '#000'}; border: 1px solid #000; border-radius: 6px; padding: 6px 12px; font-size: 12px; font-weight: 600; cursor: pointer;">
                        <i class="bi bi-slash-circle-fill me-1"></i> ${data.is_blocked ? 'Unblock User' : 'Block User & IP'}
                    </button>
                </div>
            `;
            content.innerHTML = html;
        }
        content.style.display = 'block';
    })
    .catch(err => {
        document.getElementById('fraud-loader').style.display = 'none';
        document.getElementById('fraud-content').innerHTML = `<div style="color:red; text-align:center; padding: 20px;">Error fetching customer data.</div>`;
        document.getElementById('fraud-content').style.display = 'block';
    });
}

function closeFraudModal() {
    document.getElementById('fraud-check-overlay').style.display = 'none';
}

function updateManualStatus(phone, status) {
    if(!confirm('Are you sure you want to mark this customer as ' + status + '?')) return;
    
    fetch('{{ route("admin.fraud-checker.update-status") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ phone: phone, status: status })
    })
    .then(res => res.json())
    .then(data => {
        if(data.status === 'success') {
            alert(data.message);
            checkFraud(phone); // refresh
        }
    });
}

function toggleBlockCustomer(phone, ip) {
    if(!confirm('Are you sure you want to change the block status for this customer?')) return;
    
    fetch('{{ route("admin.fraud-checker.toggle-block") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ phone: phone, ip_address: ip })
    })
    .then(res => res.json())
    .then(data => {
        if(data.status === 'success') {
            alert(data.message);
            if (typeof checkFraud === 'function') checkFraud(phone); // refresh if in modal
            location.reload(); // reload to update badges
        }
    });
}
</script>
@endsection
