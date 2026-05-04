@php
    $style = $block->content['style_variation'] ?? 'style-1';
    $bgColor = $block->content['bg_color'] ?? '#f8f9fa';
    $aosType = ($block->content['aos_type'] ?? 'fade-up') == 'none' ? '' : ($block->content['aos_type'] ?? 'fade-up');
    $aosDuration = $block->content['aos_duration'] ?? 800;
    $lang = $block->content['language'] ?? 'javascript';
    $code = $block->content['code'] ?? '';
@endphp

<div class="block-syntax {{ $style }}" style="background-color: {{ $bgColor }}; padding: 40px 0;" data-aos="{{ $aosType }}" data-aos-duration="{{ $aosDuration }}">
    <div class="container">
        <div style="position: relative; border-radius: 15px; overflow: hidden; box-shadow: 0 20px 50px rgba(0,0,0,0.1);">
            <div style="background: #2d2d2d; padding: 10px 20px; color: #ccc; font-size: 0.8rem; display: flex; justify-content: space-between; align-items: center;">
                <span style="text-transform: uppercase; font-weight: 700; letter-spacing: 1px;">{{ $lang }}</span>
                <button onclick="copyCode(this)" style="background: transparent; border: 1px solid #444; color: #ccc; padding: 2px 10px; border-radius: 4px; font-size: 0.7rem; cursor: pointer;">Copy</button>
            </div>
            <pre style="margin:0; padding: 20px; background: #1e1e1e; color: #d4d4d4; font-family: 'Consolas', 'Monaco', monospace; font-size: 0.95rem; overflow-x: auto;"><code>{{ $code }}</code></pre>
        </div>
    </div>
</div>

<script>
    function copyCode(btn) {
        const code = btn.parentElement.nextElementSibling.innerText;
        navigator.clipboard.writeText(code).then(() => {
            const originalText = btn.innerText;
            btn.innerText = 'Copied!';
            setTimeout(() => btn.innerText = originalText, 2000);
        });
    }
</script>
