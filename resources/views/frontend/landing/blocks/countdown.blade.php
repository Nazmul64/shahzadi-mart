@php
    $style = $block->content['style_variation'] ?? 'style-1';
    $titleColor = $block->content['title_color'] ?? '#ffffff';
    $textColor = $block->content['text_color'] ?? '#ffffff';
    $bgColor = $block->content['bg_color'] ?? '#111111';
    $aosType = ($block->content['aos_type'] ?? 'zoom-in') == 'none' ? '' : ($block->content['aos_type'] ?? 'zoom-in');
    $aosDuration = $block->content['aos_duration'] ?? 800;
    $endTime = $block->content['end_time'] ?? now()->addDays(1)->format('Y-m-d\TH:i');
@endphp

<div class="block-countdown {{ $style }}" style="background-color: {{ $bgColor }}; padding: 60px 20px; text-align: center;" data-aos="{{ $aosType }}" data-aos-duration="{{ $aosDuration }}">
    <div class="container">
        <h2 style="color: {{ $titleColor }}; font-size: 2.5rem; font-weight: 800; margin-bottom: 30px;">
            {{ $block->content['title'] ?? 'Offer Ends In' }}
        </h2>
        
        <div id="countdown-{{ $block->id }}" style="display: flex; justify-content: center; gap: 15px; flex-wrap: wrap; color: {{ $textColor }};">
            @foreach(['Days', 'Hours', 'Mins', 'Secs'] as $unit)
                <div style="background: rgba(255,255,255,0.1); padding: 20px; border-radius: 15px; min-width: 100px; backdrop-filter: blur(5px); border: 1px solid rgba(255,255,255,0.2);">
                    <div class="cd-{{ strtolower($unit) }}" style="font-size: 3rem; font-weight: 800; line-height: 1;">00</div>
                    <div style="font-size: 0.9rem; text-transform: uppercase; opacity: 0.8; margin-top: 10px;">{{ $unit }}</div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var countDownDate = new Date("{{ $endTime }}").getTime();
            var id = "{{ $block->id }}";
            var x = setInterval(function() {
                var now = new Date().getTime();
                var distance = countDownDate - now;

                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("countdown-" + id).innerHTML = "<h3 style='width:100%; text-align:center;'>OFFER EXPIRED</h3>";
                    return;
                }

                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                var box = document.getElementById("countdown-" + id);
                if(box) {
                    box.querySelector('.cd-days').innerHTML = days < 10 ? '0' + days : days;
                    box.querySelector('.cd-hours').innerHTML = hours < 10 ? '0' + hours : hours;
                    box.querySelector('.cd-mins').innerHTML = minutes < 10 ? '0' + minutes : minutes;
                    box.querySelector('.cd-secs').innerHTML = seconds < 10 ? '0' + seconds : seconds;
                }
            }, 1000);
        });
    </script>
</div>
