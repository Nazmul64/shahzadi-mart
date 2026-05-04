@php
    $style = $block->content['style_variation'] ?? 'style-1';
    $bgColor = $block->content['bg_color'] ?? 'transparent';
    $aosType = ($block->content['aos_type'] ?? 'fade-up') == 'none' ? '' : ($block->content['aos_type'] ?? 'fade-up');
    $aosDuration = $block->content['aos_duration'] ?? 800;
    $phone = $block->content['phone'] ?? '';
    $message = urlencode($block->content['message'] ?? '');
    $waUrl = "https://wa.me/{$phone}?text={$message}";
@endphp

<div class="block-whatsapp {{ $style }}" style="background-color: {{ $bgColor }}; padding: 30px 0; text-align: center;" data-aos="{{ $aosType }}" data-aos-duration="{{ $aosDuration }}">
    <div class="container">
        <a href="{{ $waUrl }}" target="_blank" class="whatsapp-btn shadow-lg" style="display: inline-flex; align-items: center; gap: 12px; background: #25D366; color: #fff; padding: 18px 40px; border-radius: 50px; text-decoration: none; font-weight: 800; font-size: 1.2rem; transition: 0.3s;">
            <i class="bi bi-whatsapp" style="font-size: 1.8rem;"></i>
            {{ $block->content['btn_text'] ?? 'Chat on WhatsApp' }}
        </a>
    </div>
</div>

<style>
    .whatsapp-btn:hover {
        transform: translateY(-5px) scale(1.05);
        background: #128C7E;
        color: #fff;
        box-shadow: 0 15px 30px rgba(37, 211, 102, 0.4) !important;
    }
</style>
