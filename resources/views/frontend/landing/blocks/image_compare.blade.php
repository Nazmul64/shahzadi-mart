@php
    $style = $block->content['style_variation'] ?? 'style-1';
    $titleColor = $block->content['title_color'] ?? '#1a2b6b';
    $bgColor = $block->content['bg_color'] ?? '#ffffff';
    $aosType = ($block->content['aos_type'] ?? 'fade-up') == 'none' ? '' : ($block->content['aos_type'] ?? 'fade-up');
    $aosDuration = $block->content['aos_duration'] ?? 800;
@endphp

<div class="block-image-compare {{ $style }}" style="background-color: {{ $bgColor }}; padding: 80px 0;" data-aos="{{ $aosType }}" data-aos-duration="{{ $aosDuration }}">
    <div class="container">
        <div style="max-width: 1000px; margin: 0 auto;">
            <div class="compare-container" style="position: relative; width: 100%; aspect-ratio: 16/9; overflow: hidden; border-radius: 30px; box-shadow: 0 25px 60px rgba(0,0,0,0.2);">
                <img src="{{ asset('uploads/landing/blocks/' . ($block->content['after_image'] ?? '')) }}" style="position: absolute; top:0; left:0; width:100%; height:100%; object-fit: cover;">
                <div class="before-box" style="position: absolute; top:0; left:0; width:50%; height:100%; overflow: hidden; border-right: 4px solid #fff;">
                    <img src="{{ asset('uploads/landing/blocks/' . ($block->content['before_image'] ?? '')) }}" style="position: absolute; top:0; left:0; width:1000px; height:100%; object-fit: cover;">
                    <span style="position: absolute; bottom: 20px; left: 20px; background: rgba(0,0,0,0.6); color: #fff; padding: 5px 15px; border-radius: 5px; font-weight: 700;">{{ $block->content['before_label'] ?? 'Before' }}</span>
                </div>
                <span style="position: absolute; bottom: 20px; right: 20px; background: rgba(0,0,0,0.6); color: #fff; padding: 5px 15px; border-radius: 5px; font-weight: 700;">{{ $block->content['after_label'] ?? 'After' }}</span>
                
                <div class="compare-slider" style="position: absolute; top:0; left:50%; width: 40px; height: 100%; transform: translateX(-50%); cursor: ew-resize; display: flex; align-items: center; justify-content: center; pointer-events: auto;">
                    <div style="width: 40px; height: 40px; background: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 0 20px rgba(0,0,0,0.3);">
                        <i class="bi bi-arrows-expand" style="transform: rotate(90deg); color: #111;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const containers = document.querySelectorAll('.compare-container');
        containers.forEach(container => {
            const before = container.querySelector('.before-box');
            const slider = container.querySelector('.compare-slider');
            const beforeImg = before.querySelector('img');

            const move = (e) => {
                let x = (e.pageX || e.touches[0].pageX) - container.getBoundingClientRect().left;
                let width = container.offsetWidth;
                if (x < 0) x = 0;
                if (x > width) x = width;
                let percent = (x / width) * 100;
                before.style.width = percent + '%';
                slider.style.left = percent + '%';
                beforeImg.style.width = width + 'px';
            };

            container.addEventListener('mousemove', move);
            container.addEventListener('touchmove', move);
            
            window.addEventListener('resize', () => {
                beforeImg.style.width = container.offsetWidth + 'px';
            });
            beforeImg.style.width = container.offsetWidth + 'px';
        });
    });
</script>
