@php
    $style = $block->content['style_variation'] ?? 'style-1';
    $titleColor = $block->content['title_color'] ?? '#1a2b6b';
    $bgColor = $block->content['bg_color'] ?? '#ffffff';
    $aosType = ($block->content['aos_type'] ?? 'fade-up') == 'none' ? '' : ($block->content['aos_type'] ?? 'fade-up');
    $aosDuration = $block->content['aos_duration'] ?? 800;
@endphp

<div class="block-video {{ $style }}" style="background-color: {{ $bgColor }}; padding: 60px 0; text-align: center;" data-aos="{{ $aosType }}" data-aos-duration="{{ $aosDuration }}">
    <div style="width: 100%; max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        @if(!empty($block->content['title']))
            <h2 style="color: {{ $titleColor }}; font-size: clamp(28px, 6vw, 48px); font-weight: 900; margin-bottom: 40px; line-height: 1.2;">{{ $block->content['title'] }}</h2>
        @endif
        
        <div style="position: relative; width: 100%; border-radius: 30px; overflow: hidden; box-shadow: 0 30px 100px rgba(0,0,0,0.2); border: 8px solid #fff; background: #000;">
            <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden;">
                <iframe 
                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none;"
                    src="{{ preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\s]+)/', $block->content['video_url'] ?? '', $m) ? 'https://www.youtube.com/embed/' . $m[1] . '?rel=0&modestbranding=1&autohide=1&showinfo=0' : ($block->content['video_url'] ?? '') }}" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen>
                </iframe>
            </div>
        </div>
        
        <div style="margin-top: 30px;">
            <a href="#order" style="display: inline-block; background: var(--primary, #ff4d4d); color: #fff; padding: 15px 40px; border-radius: 50px; font-weight: 800; text-decoration: none; box-shadow: 0 10px 20px rgba(0,0,0,0.1); transition: 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">অর্ডার করতে এখানে ক্লিক করুন</a>
        </div>
    </div>
</div>

