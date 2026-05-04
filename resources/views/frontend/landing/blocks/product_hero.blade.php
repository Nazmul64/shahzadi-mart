@php
    $aosType = ($block->content['aos_type'] ?? 'fade-up') == 'none' ? '' : ($block->content['aos_type'] ?? 'fade-up');
    $aosDuration = $block->content['aos_duration'] ?? 800;
    $title = $block->content['title'] ?: $landing->title;
    $showVideo = $block->content['show_video'] ?? true;
    $showImage = $block->content['show_image'] ?? true;
    $padding = $block->content['padding'] ?? 60;
@endphp

<div class="hero-box" style="background-color: {{ $block->content['bg_color'] ?? '#ffffff' }}; padding: {{ $padding }}px 20px;">
    <h1 data-aos="{{ $aosType }}" data-aos-duration="{{ $aosDuration }}" style="color: {{ $block->content['title_color'] ?? '#111' }};">
        {{ $title }}
    </h1>
    <div class="main-media" data-aos="zoom-in" data-aos-delay="200" data-aos-duration="{{ $aosDuration }}">
        @if($showVideo && $landing->video_url)
            @php
                $vurl = $landing->video_url;
                if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\s]+)/', $vurl, $m)) {
                    $embedUrl = 'https://www.youtube.com/embed/' . $m[1] . '?rel=0&modestbranding=1';
                } else {
                    $embedUrl = $vurl;
                }
            @endphp
            <iframe src="{{ $embedUrl }}" allowfullscreen loading="lazy"></iframe>
        @elseif($showImage && $landing->feature_image)
            <img src="{{ asset('uploads/landing/'.$landing->feature_image) }}" alt="">
        @endif
    </div>
</div>
