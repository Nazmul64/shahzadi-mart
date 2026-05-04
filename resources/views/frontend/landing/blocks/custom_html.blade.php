@php
    $aosType = ($block->content['aos_type'] ?? 'fade-up') == 'none' ? '' : ($block->content['aos_type'] ?? 'fade-up');
    $aosDuration = $block->content['aos_duration'] ?? 800;
@endphp

<style>
    .block-custom-html iframe { width: 100% !important; max-width: 100%; border-radius: 15px; }
</style>
<div class="block-custom-html" style="margin-bottom: 50px; overflow: hidden; width: 100%;" data-aos="{{ $aosType }}" data-aos-duration="{{ $aosDuration }}">
    @if(!empty($block->content['html_content']))
        {!! $block->content['html_content'] !!}
    @endif
</div>
