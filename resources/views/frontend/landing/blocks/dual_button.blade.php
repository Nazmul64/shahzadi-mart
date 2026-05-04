@php
    $style = $block->content['style_variation'] ?? 'style-1';
    $bgColor = $block->content['bg_color'] ?? 'transparent';
    $aosType = ($block->content['aos_type'] ?? 'fade-up') == 'none' ? '' : ($block->content['aos_type'] ?? 'fade-up');
    $aosDuration = $block->content['aos_duration'] ?? 800;
@endphp

<div class="block-dual-btn {{ $style }}" style="background-color: {{ $bgColor }}; padding: 40px 0; text-align: center;" data-aos="{{ $aosType }}" data-aos-duration="{{ $aosDuration }}">
    <div class="container">
        <div style="display: inline-flex; align-items: center; gap: 0; background: #fff; border-radius: 60px; padding: 10px; box-shadow: 0 15px 40px rgba(0,0,0,0.1); border: 1px solid #eee;">
            <a href="{{ $block->content['btn1_url'] ?? '#' }}" class="btn-dual-1" style="background: var(--primary); color: #fff; padding: 15px 35px; border-radius: 50px; text-decoration: none; font-weight: 800; transition: 0.3s; white-space: nowrap;">
                {{ $block->content['btn1_text'] ?? 'Order Now' }}
            </a>
            
            <div style="width: 50px; height: 50px; background: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 -15px; position: relative; z-index: 2; border: 1px solid #eee; font-weight: 800; font-size: 0.8rem; color: #777;">
                {{ $block->content['separator'] ?? 'OR' }}
            </div>

            <a href="{{ $block->content['btn2_url'] ?? '#' }}" class="btn-dual-2" style="background: #111; color: #fff; padding: 15px 35px; border-radius: 50px; text-decoration: none; font-weight: 800; transition: 0.3s; padding-left: 30px; white-space: nowrap;">
                {{ $block->content['btn2_text'] ?? 'WhatsApp' }}
            </a>
        </div>
    </div>
</div>

<style>
    .btn-dual-1:hover { transform: scale(1.05); filter: brightness(1.1); }
    .btn-dual-2:hover { transform: scale(1.05); background: #333; }
</style>
