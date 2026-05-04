@php
    $aosType = ($block->content['aos_type'] ?? 'fade-up') == 'none' ? '' : ($block->content['aos_type'] ?? 'fade-up');
    $aosDuration = $block->content['aos_duration'] ?? 800;
    $padding = $block->content['padding'] ?? 30;
@endphp

<ul class="feature-list" data-aos="{{ $aosType }}" data-aos-duration="{{ $aosDuration }}" style="background-color: {{ $block->content['bg_color'] ?? '#fafafa' }}; padding: {{ $padding }}px 30px;">
    @if(!empty($block->content['items']))
        @foreach($block->content['items'] as $item)
            <li style="color: {{ $block->content['text_color'] ?? '#222' }};">
                <i class="bi bi-check2-square" style="color: var(--primary);"></i> 
                {{ $item['title'] ?? '' }}
            </li>
        @endforeach
    @else
        <li style="color: {{ $block->content['text_color'] ?? '#222' }};"><i class="bi bi-check2-square"></i> কোয়ালিটি নিশ্চিত করে ডেলিভারি</li>
        <li style="color: {{ $block->content['text_color'] ?? '#222' }};"><i class="bi bi-check2-square"></i> সারা বাংলাদেশে হোম ডেলিভারি</li>
        <li style="color: {{ $block->content['text_color'] ?? '#222' }};"><i class="bi bi-check2-square"></i> পণ্য চেক করে টাকা দেওয়ার সুযোগ</li>
        <li style="color: {{ $block->content['text_color'] ?? '#222' }};"><i class="bi bi-check2-square"></i> দ্রুত কাস্টমার সাপোর্ট</li>
    @endif
</ul>
