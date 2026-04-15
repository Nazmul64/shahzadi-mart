@extends('frontend.master')

@section('main-content')
<style>
  .os-page *, .os-page *::before, .os-page *::after {
    box-sizing: border-box; margin: 0; padding: 0;
  }
  .os-page {
    --primary: #be0318; --primary-d: #960212;
    --primary-light: #fff0f0;
    --text: #1a1a1a; --muted: #6b7280;
    --border: #e5e7eb; --bg: #f9fafb; --white: #ffffff;
    --green: #16a34a; --green-light: #f0fdf4;
    --radius: 12px;
    --shadow: 0 4px 24px rgba(0,0,0,.09);
    font-family: 'DM Sans', sans-serif; font-size: 14px;
    color: var(--text); background: var(--bg); line-height: 1.6;
    min-height: 80vh; padding: 40px 0 60px;
  }

  .os-container { max-width: 800px; margin: 0 auto; padding: 0 20px; }

  #os-confetti { position: fixed; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: 999; }

  .os-card {
    background: var(--white);
    border-radius: 20px;
    box-shadow: var(--shadow);
    overflow: hidden;
    margin-bottom: 24px;
  }

  .os-hero {
    background: linear-gradient(135deg, #be0318 0%, #7c0110 100%);
    padding: 40px 32px 50px;
    text-align: center;
    position: relative;
    overflow: hidden;
  }
  .os-hero::before {
    content: '';
    position: absolute; inset: 0;
    background-image: radial-gradient(circle at 20% 30%, rgba(255,255,255,.08) 0%, transparent 50%),
                      radial-gradient(circle at 80% 70%, rgba(255,255,255,.06) 0%, transparent 50%);
  }
  .os-hero::after {
    content: '';
    position: absolute; bottom: -1px; left: 0; right: 0;
    height: 32px; background: var(--white);
    border-radius: 50% 50% 0 0 / 100% 100% 0 0;
  }

  .os-check-wrap {
    width: 90px; height: 90px;
    background: rgba(255,255,255,.15);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 20px;
    position: relative; z-index: 1;
    animation: os-pop .6s cubic-bezier(.34,1.56,.64,1) both;
  }
  .os-check-wrap svg { width: 48px; height: 48px; }
  .os-check-circle {
    stroke: #fff; stroke-width: 3;
    stroke-dasharray: 166; stroke-dashoffset: 166;
    fill: none; animation: os-circle .8s ease forwards .2s;
  }
  .os-check-tick {
    stroke: #fff; stroke-width: 3.5;
    stroke-linecap: round; stroke-linejoin: round;
    stroke-dasharray: 48; stroke-dashoffset: 48;
    fill: none; animation: os-tick .5s ease forwards .8s;
  }
  @keyframes os-circle { to { stroke-dashoffset: 0; } }
  @keyframes os-tick   { to { stroke-dashoffset: 0; } }
  @keyframes os-pop    { from { transform: scale(0); opacity: 0; } to { transform: scale(1); opacity: 1; } }

  .os-hero-title {
    color: #fff; font-size: 26px; font-weight: 800;
    margin-bottom: 8px; position: relative; z-index: 1;
    animation: os-fadein .5s ease both .4s;
  }
  .os-hero-sub {
    color: rgba(255,255,255,.82); font-size: 14px;
    position: relative; z-index: 1;
    animation: os-fadein .5s ease both .6s;
  }
  @keyframes os-fadein { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

  .os-order-chip {
    display: inline-flex; align-items: center; gap: 8px;
    background: var(--primary-light); border: 1.5px dashed #fecdd3;
    border-radius: 40px; padding: 8px 20px; margin: 0 auto 24px;
    font-size: 14px; font-weight: 700; color: var(--primary);
    animation: os-fadein .5s ease both .7s;
  }

  .os-body { padding: 24px 32px 32px; }

  .os-info-grid {
    display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px;
    margin-bottom: 28px; animation: os-fadein .5s ease both .5s;
  }
  @media(max-width:600px){ .os-info-grid { grid-template-columns: 1fr 1fr; } }
  @media(max-width:400px){ .os-info-grid { grid-template-columns: 1fr; } }

  .os-info-box {
    background: var(--bg); border-radius: 10px;
    padding: 14px 16px; border: 1px solid var(--border);
  }
  .os-info-box-label {
    font-size: 11px; color: var(--muted); font-weight: 600;
    text-transform: uppercase; letter-spacing: .5px; margin-bottom: 4px;
    display: flex; align-items: center; gap: 5px;
  }
  .os-info-box-label i { color: var(--primary); }
  .os-info-box-val { font-size: 14px; font-weight: 700; color: var(--text); }

  .os-section-title {
    font-size: 14px; font-weight: 700; color: var(--text);
    margin-bottom: 14px; padding-bottom: 10px;
    border-bottom: 1px solid var(--border);
    display: flex; align-items: center; gap: 7px;
  }
  .os-section-title i { color: var(--primary); }

  .os-item {
    display: flex; align-items: flex-start; gap: 12px;
    padding: 12px 0; border-bottom: 1px solid #f3f4f6;
  }
  .os-item:last-child { border-bottom: none; }
  .os-item-img {
    width: 52px; height: 52px; object-fit: cover;
    border-radius: 8px; border: 1px solid var(--border); flex-shrink: 0;
  }
  .os-item-img-placeholder {
    width: 52px; height: 52px; border-radius: 8px;
    border: 1px solid var(--border); flex-shrink: 0;
    background: #f3f4f6; display: flex;
    align-items: center; justify-content: center; color: var(--muted);
  }
  .os-item-name { font-size: 13px; font-weight: 600; color: var(--text); flex: 1; line-height: 1.4; }
  .os-item-meta { font-size: 11px; color: var(--muted); margin-top: 2px; }
  .os-item-qty {
    display: inline-block; background: #f3f4f6;
    padding: 1px 7px; border-radius: 10px;
    font-size: 11px; color: var(--muted); margin-top: 4px;
  }
  .os-item-price { font-weight: 700; color: var(--text); font-size: 14px; white-space: nowrap; }

  .os-total-block { margin-top: 16px; }
  .os-total-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 7px 0; font-size: 13px; color: var(--muted);
    border-bottom: 1px dashed #f3f4f6;
  }
  .os-total-row:last-child { border-bottom: none; }
  .os-total-row .val { font-weight: 600; color: var(--text); }
  .os-total-row.grand {
    font-size: 16px; font-weight: 800;
    border-top: 2px solid var(--border); margin-top: 6px; padding-top: 12px;
    border-bottom: none;
  }
  .os-total-row.grand .val { color: var(--primary); }
  .os-discount-val { color: var(--green); font-weight: 700; }

  .os-address-box {
    background: var(--bg); border-radius: 10px;
    border: 1px solid var(--border); padding: 16px;
    font-size: 13px; line-height: 1.8; margin-bottom: 24px;
  }
  .os-address-label {
    font-size: 11px; font-weight: 700; color: var(--muted);
    text-transform: uppercase; letter-spacing: .5px;
    margin-bottom: 6px; display: flex; align-items: center; gap: 5px;
  }
  .os-address-label i { color: var(--primary); }

  .os-timeline {
    display: flex; justify-content: space-between;
    position: relative; margin: 28px 0 32px; padding: 0 10px;
  }
  .os-timeline::before {
    content: '';
    position: absolute; top: 20px; left: 10%; right: 10%;
    height: 2px; background: var(--border); z-index: 0;
  }
  .os-tl-step { display: flex; flex-direction: column; align-items: center; gap: 8px; z-index: 1; flex: 1; }
  .os-tl-icon {
    width: 40px; height: 40px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 16px; background: #f3f4f6;
    border: 2px solid var(--border); color: var(--muted); transition: all .3s;
  }
  .os-tl-icon.done  { background: var(--green-light); border-color: #86efac; color: var(--green); }
  .os-tl-icon.active {
    background: var(--primary-light); border-color: #fecdd3; color: var(--primary);
    animation: os-pulse 1.5s ease-in-out infinite;
  }
  @keyframes os-pulse {
    0%,100% { box-shadow: 0 0 0 0 rgba(190,3,24,.2); }
    50%      { box-shadow: 0 0 0 8px rgba(190,3,24,0); }
  }
  .os-tl-label { font-size: 11px; font-weight: 600; color: var(--muted); text-align: center; }
  .os-tl-label.done   { color: var(--green); }
  .os-tl-label.active { color: var(--primary); }

  .os-cta-row {
    display: flex; gap: 12px; flex-wrap: wrap;
    margin-top: 28px; animation: os-fadein .5s ease both .9s;
  }
  .os-btn-primary {
    flex: 1; min-width: 140px;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    background: var(--primary); color: #fff;
    padding: 13px 20px; border-radius: 10px;
    font-size: 14px; font-weight: 700; text-decoration: none; transition: all .2s;
  }
  .os-btn-primary:hover { background: var(--primary-d); box-shadow: 0 4px 16px rgba(190,3,24,.35); color: #fff; }
  .os-btn-outline {
    flex: 1; min-width: 140px;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    background: var(--white); color: var(--text);
    border: 1.5px solid var(--border);
    padding: 13px 20px; border-radius: 10px;
    font-size: 14px; font-weight: 600; text-decoration: none; transition: all .2s;
  }
  .os-btn-outline:hover { border-color: var(--primary); color: var(--primary); }

  .os-trust-row {
    display: flex; justify-content: center; gap: 24px; flex-wrap: wrap;
    margin-top: 20px; padding-top: 20px; border-top: 1px solid var(--border);
  }
  .os-trust-item { display: flex; align-items: center; gap: 6px; font-size: 12px; color: var(--muted); }
  .os-trust-item i { color: var(--primary); }

  @media(max-width:600px){
    .os-hero { padding: 32px 20px 42px; }
    .os-body { padding: 18px 20px 24px; }
    .os-hero-title { font-size: 20px; }
  }
</style>

<canvas id="os-confetti"></canvas>

@php
  /*
   * ── NULL-SAFE item collection ──────────────────────────────────
   * Controller এ 'items' বা 'orderItems' যেকোনো নামে লোড হোক,
   * অথবা একদমই লোড না হোক — সব ক্ষেত্রে নিরাপদ।
   */
  $orderItems = collect();

  if (!is_null($order->orderItems)) {
      $orderItems = collect($order->orderItems);
  } elseif (!is_null($order->items)) {
      $orderItems = collect($order->items);
  }

  // ── Safe totals (Order model এ column name যাই হোক) ──────────
  $safeDiscount = (float) ($order->discount        ?? $order->coupon_discount   ?? 0);
  $safeShipping = (float) ($order->delivery_fee    ?? $order->shipping_charge   ?? 0);
  $safeTotal    = (float) ($order->total           ?? $order->total_amount      ?? 0);
  $safeSubtotal = (float) ($order->subtotal        ?? max(0, $safeTotal - $safeShipping + $safeDiscount));
@endphp

<div class="os-page">
  <div class="os-container">
    <div class="os-card">

      {{-- HERO --}}
      <div class="os-hero">
        <div class="os-check-wrap">
          <svg viewBox="0 0 52 52" xmlns="http://www.w3.org/2000/svg">
            <circle class="os-check-circle" cx="26" cy="26" r="24"/>
            <polyline class="os-check-tick" points="14,26 22,34 38,18"/>
          </svg>
        </div>
        <h1 class="os-hero-title">🎉 অর্ডার সফলভাবে সম্পন্ন!</h1>
        <p class="os-hero-sub">আপনার অর্ডারটি আমরা পেয়েছি। শীঘ্রই ডেলিভারি করা হবে।</p>
      </div>

      <div class="os-body">

        {{-- Order Number --}}
        <div style="text-align:center; margin-bottom:24px;">
          <div class="os-order-chip">
            <i class="fas fa-hashtag"></i>
            অর্ডার নং: #{{ $order->order_number ?? $order->id }}
          </div>
        </div>

        {{-- Info Grid --}}
        <div class="os-info-grid">
          <div class="os-info-box">
            <div class="os-info-box-label"><i class="fas fa-calendar-alt"></i> তারিখ</div>
            <div class="os-info-box-val">
              {{ $order->created_at ? $order->created_at->format('d M, Y') : '—' }}
            </div>
          </div>
          <div class="os-info-box">
            <div class="os-info-box-label"><i class="fas fa-credit-card"></i> পেমেন্ট</div>
            <div class="os-info-box-val">
              @php $pm = $order->payment_method ?? ''; @endphp
              @if($pm==='cod')         💵 ক্যাশ অন ডেলিভারি
              @elseif($pm==='bkash')      📱 bKash
              @elseif($pm==='shurjopay')  💳 SurjoPay
              @elseif($pm==='uddoktapay') 🏦 UddoktaPay
              @elseif($pm==='aamarpay')   🌐 AamarPay
              @else {{ ucfirst($pm) ?: '—' }}
              @endif
            </div>
          </div>
          <div class="os-info-box">
            <div class="os-info-box-label"><i class="fas fa-info-circle"></i> স্ট্যাটাস</div>
            <div class="os-info-box-val" style="color:var(--green)">✅ নিশ্চিত হয়েছে</div>
          </div>
        </div>

        {{-- Timeline --}}
        <div class="os-section-title"><i class="fas fa-route"></i> ডেলিভারি ট্র্যাক</div>
        <div class="os-timeline">
          <div class="os-tl-step">
            <div class="os-tl-icon done"><i class="fas fa-check"></i></div>
            <span class="os-tl-label done">অর্ডার<br>নিশ্চিত</span>
          </div>
          <div class="os-tl-step">
            <div class="os-tl-icon active"><i class="fas fa-box"></i></div>
            <span class="os-tl-label active">প্রস্তুত<br>হচ্ছে</span>
          </div>
          <div class="os-tl-step">
            <div class="os-tl-icon"><i class="fas fa-shipping-fast"></i></div>
            <span class="os-tl-label">পথে<br>আছে</span>
          </div>
          <div class="os-tl-step">
            <div class="os-tl-icon"><i class="fas fa-home"></i></div>
            <span class="os-tl-label">ডেলিভারি<br>সম্পন্ন</span>
          </div>
        </div>

        {{-- Delivery Address --}}
        <div class="os-section-title"><i class="fas fa-map-marker-alt"></i> ডেলিভারি তথ্য</div>
        <div class="os-address-box">
          <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
            <div>
              <div class="os-address-label"><i class="fas fa-user"></i> নাম</div>
              <div style="font-weight:600">{{ $order->customer_name ?? '—' }}</div>
            </div>
            <div>
              <div class="os-address-label"><i class="fas fa-phone"></i> ফোন</div>
              <div style="font-weight:600">{{ $order->phone ?? '—' }}</div>
            </div>
            <div style="grid-column:1/-1;">
              <div class="os-address-label"><i class="fas fa-home"></i> ঠিকানা</div>
              <div>{{ $order->address ?? '—' }}</div>
            </div>
            @if(!empty($order->delivery_area))
            <div>
              <div class="os-address-label"><i class="fas fa-map-pin"></i> এলাকা</div>
              <div style="font-weight:600">{{ $order->delivery_area }}</div>
            </div>
            @endif
            @if(!empty($order->note))
            <div>
              <div class="os-address-label"><i class="fas fa-sticky-note"></i> নোট</div>
              <div>{{ $order->note }}</div>
            </div>
            @endif
          </div>
        </div>

        {{-- Order Items --}}
        <div class="os-section-title"><i class="fas fa-shopping-bag"></i> অর্ডার আইটেম</div>

        @forelse($orderItems as $item)
        @php
          // ── Column names — সব common variation cover করা হয়েছে ──
          $unitPrice = (float) ($item->price        ?? $item->unit_price    ?? 0);
          $qty       = (int)   ($item->quantity      ?? 1);
          $lineTotal = $unitPrice * $qty;

          $itemName  = $item->product_name
                    ?? $item->name
                    ?? optional($item->product)->name
                    ?? 'Product';

          $itemImage = $item->product_image
                    ?? $item->image
                    ?? optional(optional($item)->product)->feature_image
                    ?? null;

          $selColor  = $item->selected_color ?? null;
          $selSize   = $item->selected_size  ?? null;
        @endphp
        <div class="os-item">

          {{-- Thumbnail --}}
          @if($itemImage)
            <img src="{{ asset('uploads/products/' . $itemImage) }}"
                 alt="{{ $itemName }}" class="os-item-img"
                 onerror="this.src='{{ asset('images/placeholder.png') }}'">
          @else
            <div class="os-item-img-placeholder">
              <i class="fas fa-box"></i>
            </div>
          @endif

          {{-- Info --}}
          <div style="flex:1; min-width:0;">
            <div class="os-item-name">{{ $itemName }}</div>
            @if($selColor || $selSize)
            <div class="os-item-meta">
              @if($selColor)
                <span style="background:#f3f4f6;padding:1px 6px;border-radius:4px;margin-right:4px">🎨 {{ $selColor }}</span>
              @endif
              @if($selSize)
                <span style="background:#f3f4f6;padding:1px 6px;border-radius:4px">📐 {{ $selSize }}</span>
              @endif
            </div>
            @endif
            <div><span class="os-item-qty">Qty: {{ $qty }}</span></div>
          </div>

          {{-- Price --}}
          <div class="os-item-price">৳{{ number_format($lineTotal, 2) }}</div>
        </div>
        @empty
        <div style="text-align:center; padding:20px; color:var(--muted); font-size:13px;">
          <i class="fas fa-box-open" style="font-size:24px; margin-bottom:8px; display:block;"></i>
          আইটেম তথ্য পাওয়া যায়নি।
        </div>
        @endforelse

        {{-- Totals --}}
        <div class="os-total-block">
          <div class="os-total-row">
            <span>সাবটোটাল</span>
            <span class="val">৳{{ number_format($safeSubtotal, 2) }}</span>
          </div>
          @if($safeDiscount > 0)
          <div class="os-total-row">
            <span>
              কুপন ডিসকাউন্ট
              @if(!empty($order->coupon_code))
                <span style="font-size:11px;color:var(--primary);background:#fff0f0;padding:1px 7px;border-radius:10px;margin-left:4px">
                  {{ $order->coupon_code }}
                </span>
              @endif
            </span>
            <span class="os-discount-val">−৳{{ number_format($safeDiscount, 2) }}</span>
          </div>
          @endif
          <div class="os-total-row">
            <span>শিপিং চার্জ</span>
            <span class="val">৳{{ number_format($safeShipping, 2) }}</span>
          </div>
          <div class="os-total-row grand">
            <span>সর্বমোট</span>
            <span class="val">৳{{ number_format($safeTotal, 2) }}</span>
          </div>
        </div>

        {{-- CTA --}}
        <div class="os-cta-row">
          <a href="{{ route('frontend') }}" class="os-btn-outline">
            <i class="fas fa-store"></i> শপিং চালিয়ে যান
          </a>
          @if(Route::has('orders.show'))
            <a href="{{ route('orders.show', $order->id) }}" class="os-btn-primary">
              <i class="fas fa-receipt"></i> অর্ডার ট্র্যাক করুন
            </a>
          @else
            <a href="{{ route('frontend') }}" class="os-btn-primary">
              <i class="fas fa-home"></i> হোমে ফিরুন
            </a>
          @endif
        </div>

        {{-- Trust --}}
        <div class="os-trust-row">
          <div class="os-trust-item"><i class="fas fa-shield-alt"></i> নিরাপদ ট্রানজেকশন</div>
          <div class="os-trust-item"><i class="fas fa-undo"></i> সহজ রিটার্ন</div>
          <div class="os-trust-item"><i class="fas fa-headset"></i> ২৪/৭ সাপোর্ট</div>
          <div class="os-trust-item"><i class="fas fa-truck"></i> দ্রুত ডেলিভারি</div>
        </div>

      </div>{{-- /body --}}
    </div>{{-- /card --}}
  </div>{{-- /container --}}
</div>{{-- /page --}}

<script>
(function(){
  var canvas = document.getElementById('os-confetti');
  if (!canvas) return;
  var ctx = canvas.getContext('2d');
  canvas.width  = window.innerWidth;
  canvas.height = window.innerHeight;
  var colors = ['#be0318','#fbbf24','#34d399','#60a5fa','#f472b6','#a78bfa'];
  var pieces = [], running = true;
  for (var i = 0; i < 120; i++) {
    pieces.push({
      x: Math.random() * canvas.width,
      y: Math.random() * canvas.height - canvas.height,
      w: Math.random() * 10 + 5, h: Math.random() * 5 + 3,
      color: colors[Math.floor(Math.random() * colors.length)],
      rot: Math.random() * Math.PI * 2,
      vx: (Math.random() - .5) * 2, vy: Math.random() * 3 + 2,
      vr: (Math.random() - .5) * .15, alpha: 1
    });
  }
  function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    pieces.forEach(function(p) {
      ctx.save();
      ctx.globalAlpha = p.alpha;
      ctx.translate(p.x + p.w/2, p.y + p.h/2);
      ctx.rotate(p.rot);
      ctx.fillStyle = p.color;
      ctx.fillRect(-p.w/2, -p.h/2, p.w, p.h);
      ctx.restore();
      p.x += p.vx; p.y += p.vy; p.rot += p.vr;
      if (p.y > canvas.height) p.alpha -= .03;
    });
    pieces = pieces.filter(function(p){ return p.alpha > 0; });
    if (pieces.length > 0 && running) requestAnimationFrame(draw);
    else canvas.style.display = 'none';
  }
  draw();
  setTimeout(function(){ running = false; }, 5000);
  window.addEventListener('resize', function(){
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
  });
})();
</script>
@endsection
