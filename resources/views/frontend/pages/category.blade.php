{{-- resources/views/frontend/pages/category.blade.php --}}
<aside class="sidebar" id="sidebar">

    <div class="sb-head">
        <i class="bi bi-grid-fill"></i>
        <span>All Categories</span>
    </div>

    @foreach($sidebarCategories as $ci => $cat)

        <div class="cat-row" onclick="toggleCat(this)" data-ci="{{ $ci }}">
            <div class="cat-row__left">
                <a href="{{ route('category.page', $cat->slug) }}"
                   class="cat-row__label"
                   onclick="event.stopPropagation()">{{ $cat->category_name }}</a>
            </div>
            @if($cat->subCategories->count())
                <i class="bi bi-chevron-down cat-arrow"></i>
            @endif
        </div>

        @if($cat->subCategories->count())
            <div class="sub-menu" id="sub-{{ $ci }}">

                @foreach($cat->subCategories as $si => $sub)

                    <div class="sub-row"
                         onclick="toggleSub(this, event)"
                         data-si="{{ $ci }}-{{ $si }}">
                        <a href="{{ route('subcategory.page', [$cat->slug, $sub->slug]) }}"
                           class="sub-row__label"
                           onclick="event.stopPropagation()">{{ $sub->sub_name }}</a>
                        @if($sub->childCategories->count())
                            <i class="bi bi-chevron-right sub-arrow"></i>
                        @endif
                    </div>

                    @if($sub->childCategories->count())
                        <div class="child-menu" id="child-{{ $ci }}-{{ $si }}">
                            @foreach($sub->childCategories as $child)
                                <a href="{{ route('childcategory.page', [
                                        $cat->slug,
                                        $sub->slug,
                                        $child->slug
                                    ]) }}"
                                   class="child-item">
                                    {{ $child->child_sub_name }}
                                </a>
                            @endforeach
                        </div>
                    @endif

                @endforeach

            </div>
        @endif

    @endforeach

</aside>

<script>
function toggleCat(row) {
    const ci = row.dataset.ci;
    const isOpen = row.classList.contains('open');

    document.querySelectorAll('.cat-row.open').forEach(r => {
        r.classList.remove('open');
        const sm = document.getElementById('sub-' + r.dataset.ci);
        if (sm) {
            sm.classList.remove('open');
            sm.querySelectorAll('.sub-row.open').forEach(sr => {
                sr.classList.remove('open');
                const cm = document.getElementById('child-' + sr.dataset.si);
                if (cm) cm.classList.remove('open');
            });
        }
    });

    if (!isOpen) {
        row.classList.add('open');
        document.getElementById('sub-' + ci)?.classList.add('open');
    }
}

function toggleSub(row, e) {
    e.stopPropagation();
    const si = row.dataset.si;
    const childMenu = document.getElementById('child-' + si);
    if (!childMenu) return;

    const isOpen = row.classList.contains('open');

    row.closest('.sub-menu')?.querySelectorAll('.sub-row.open').forEach(sr => {
        sr.classList.remove('open');
        document.getElementById('child-' + sr.dataset.si)?.classList.remove('open');
    });

    if (!isOpen) {
        row.classList.add('open');
        childMenu.classList.add('open');
    }
}
</script>
