@php
    $style = $block->content['style_variation'] ?? 'style-1';
    $titleColor = $block->content['title_color'] ?? '#1a2b6b';
    $textColor = $block->content['text_color'] ?? '#444444';
    $bgColor = $block->content['bg_color'] ?? '#ffffff';
    $aosType = ($block->content['aos_type'] ?? 'fade-up') == 'none' ? '' : ($block->content['aos_type'] ?? 'fade-up');
    $aosDuration = $block->content['aos_duration'] ?? 800;
@endphp

<div class="block-counter {{ $style }}" style="background-color: {{ $bgColor }}; padding: 60px 0; text-align: center;" data-aos="{{ $aosType }}" data-aos-duration="{{ $aosDuration }}">
    <div class="container">
        <div class="counter-wrap" style="max-width: 400px; margin: 0 auto; background: rgba(255,255,255,0.05); padding: 40px; border-radius: 30px; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 20px 40px rgba(0,0,0,0.03);">
            <div style="font-size: 4rem; font-weight: 900; color: {{ $titleColor }}; margin-bottom: 10px; font-family: 'Sora', sans-serif;">
                {{ $block->content['prefix'] ?? '' }}<span class="count-num" data-target="{{ $block->content['number'] ?? 0 }}">0</span>{{ $block->content['suffix'] ?? '' }}
            </div>
            <h4 style="color: {{ $textColor }}; font-weight: 700; text-transform: uppercase; letter-spacing: 2px;">{{ $block->content['title'] ?? '' }}</h4>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const counter = document.querySelector('.count-num');
        const target = +counter.getAttribute('data-target');
        const duration = 2000;
        const increment = target / (duration / 16);

        const updateCount = () => {
            const count = +counter.innerText;
            if (count < target) {
                counter.innerText = Math.ceil(count + increment);
                setTimeout(updateCount, 16);
            } else {
                counter.innerText = target;
            }
        };

        const observer = new IntersectionObserver((entries) => {
            if (entries[0].isIntersecting) {
                updateCount();
                observer.unobserve(counter);
            }
        }, { threshold: 0.5 });

        observer.observe(counter);
    });
</script>
