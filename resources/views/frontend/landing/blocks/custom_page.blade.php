@php
    $title = $block->content['cp_title'] ?? '';
    $content = $block->content['content'] ?? '';
    $aosType = ($block->content['aos_type'] ?? 'fade-up') == 'none' ? '' : ($block->content['aos_type'] ?? 'fade-up');
    $aosDuration = $block->content['aos_duration'] ?? 800;
@endphp

<section class="block-custom-page py-5" data-aos="{{ $aosType }}" data-aos-duration="{{ $aosDuration }}">
    <div class="container">
        @if($title)
            <h1 class="mb-4 fw-bold" style="color: var(--primary);">{{ $title }}</h1>
        @endif
        <div class="page-content" style="font-size: 1.1rem; line-height: 1.8; color: var(--text);">
            {!! $content !!}
        </div>
    </div>
</section>

<style>
    .page-content p { margin-bottom: 20px; }
    .page-content h2, .page-content h3 { color: var(--primary); margin-top: 30px; margin-bottom: 15px; font-weight: 700; }
    .page-content ul { margin-bottom: 20px; padding-left: 20px; }
    .page-content li { margin-bottom: 10px; }
</style>
