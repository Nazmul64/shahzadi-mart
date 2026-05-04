@php
    $style = $block->content['style_variation'] ?? 'style-1';
    $titleColor = $block->content['title_color'] ?? '#1a2b6b';
    $textColor = $block->content['text_color'] ?? '#444444';
    $bgColor = $block->content['bg_color'] ?? '#ffffff';
    $aosType = ($block->content['aos_type'] ?? 'fade-up') == 'none' ? '' : ($block->content['aos_type'] ?? 'fade-up');
    $aosDuration = $block->content['aos_duration'] ?? 800;
@endphp

<div class="block-faq {{ $style }}" style="background-color: {{ $bgColor }}; padding: 60px 20px;" data-aos="{{ $aosType }}" data-aos-duration="{{ $aosDuration }}">
    <div class="container">
        <h2 style="color: {{ $titleColor }}; text-align: center; font-size: 2.5rem; font-weight: 800; margin-bottom: 40px;">
            {{ $block->content['title'] ?? 'Frequently Asked Questions' }}
        </h2>
        <div style="max-width: 800px; margin: 0 auto;">
            @if(!empty($block->content['items']))
                @foreach($block->content['items'] as $index => $item)
                    <div class="faq-item" style="margin-bottom: 15px; border: 1px solid #eee; border-radius: 12px; overflow: hidden; background: #fff;">
                        <div class="faq-question" style="padding: 20px; font-weight: 700; cursor: pointer; display: flex; justify-content: space-between; align-items: center; color: {{ $titleColor }};" onclick="this.nextElementSibling.classList.toggle('d-none'); this.querySelector('i').classList.toggle('bi-chevron-up'); this.querySelector('i').classList.toggle('bi-chevron-down');">
                            <span>{{ $item['question'] ?? '' }}</span>
                            <i class="bi bi-chevron-down text-muted"></i>
                        </div>
                        <div class="faq-answer d-none" style="padding: 20px; border-top: 1px solid #eee; color: {{ $textColor }}; line-height: 1.6;">
                            {!! nl2br(e($item['answer'] ?? '')) !!}
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
