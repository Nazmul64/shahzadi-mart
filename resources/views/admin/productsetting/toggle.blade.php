{{--
    Toggle partial
    Usage: @include('admin.productsetting.toggle', ['name' => 'field_name', 'checked' => true/false])
--}}
<input type="checkbox"
       name="{{ $name }}"
       id="cb_{{ $name }}"
       class="toggle-hidden"
       value="1"
       {{ $checked ? 'checked' : '' }}>

<button type="button"
        class="toggle-pill {{ $checked ? 'on' : 'off' }}"
        data-target="cb_{{ $name }}"
        onclick="
            var cb = document.getElementById(this.dataset.target);
            cb.checked = !cb.checked;
            this.classList.toggle('on',  cb.checked);
            this.classList.toggle('off', !cb.checked);
            this.querySelector('.label-text').textContent = cb.checked ? 'Activated' : 'Deactivated';
        ">
    <span class="dot"></span>
    <span class="label-text">{{ $checked ? 'Activated' : 'Deactivated' }}</span>
    <span class="arrow">&#9660;</span>
</button>
