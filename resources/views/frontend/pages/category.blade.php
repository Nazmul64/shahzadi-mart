{{-- resources/views/frontend/pages/category.blade.php --}}
<aside class="sidebar" id="sidebar">

    <div class="sb-head">
        <i class="bi bi-grid-fill"></i>
        <span>All Categories</span>
    </div>

    <div class="cat-scroll-body">
    @foreach($sidebarCategories as $ci => $cat)

        <div class="cat-wrapper">
            <div class="cat-row">
                <div class="cat-row__left">
                    <a href="{{ route('category.page', $cat->slug) }}"
                       class="cat-row__label">{{ $cat->category_name }}</a>
                </div>
                @if($cat->subCategories->count())
                    <i class="bi bi-chevron-down cat-arrow"></i>
                @endif
            </div>

            @if($cat->subCategories->count())
                <div class="sub-menu">

                    @foreach($cat->subCategories as $si => $sub)

                        <div class="sub-row-wrapper">
                            <div class="sub-row">
                                <a href="{{ route('subcategory.page', [$cat->slug, $sub->slug]) }}"
                                   class="sub-row__label">{{ $sub->sub_name }}</a>
                                @if($sub->childCategories->count())
                                    <i class="bi bi-chevron-right sub-arrow"></i>
                                @endif
                            </div>

                            @if($sub->childCategories->count())
                                <div class="child-menu">
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
                        </div>

                    @endforeach

                </div>
            @endif
        </div>

    @endforeach
    </div>{{-- /.cat-scroll-body --}}

</aside>

<style>
/* ── PURE CSS HOVER LOGIC ── */

/* 1. Base states: Hidden by default */
.sub-menu, .child-menu {
    max-height: 0 !important;
    opacity: 0 !important;
    visibility: hidden !important;
    overflow: hidden !important;
    transition: max-height 0.3s ease-in-out, opacity 0.2s ease !important;
    display: block !important; /* Ensure it's not display:none */
}

/* 2. Hover states: Show when parent is hovered */
.cat-wrapper:hover > .sub-menu {
    max-height: 2000px !important; /* Large enough for content */
    opacity: 1 !important;
    visibility: visible !important;
}

.sub-row-wrapper:hover > .child-menu {
    max-height: 1000px !important;
    opacity: 1 !important;
    visibility: visible !important;
}

/* 3. Visual indicators (arrows and background) */
.cat-wrapper:hover > .cat-row {
    background: rgba(200, 16, 46, .04) !important;
}
.cat-wrapper:hover .cat-arrow {
    transform: rotate(180deg) !important;
    color: var(--red) !important;
}

.sub-row-wrapper:hover > .sub-row {
    background: rgba(200, 16, 46, .07) !important;
    color: var(--red) !important;
}
.sub-row-wrapper:hover .sub-arrow {
    transform: rotate(90deg) !important;
    color: var(--red) !important;
}

/* 4. Fix for any persistent 'open' classes from other JS */
.sub-menu.open, .child-menu.open {
    max-height: 0; 
}
.cat-wrapper:hover > .sub-menu.open, 
.sub-row-wrapper:hover > .child-menu.open {
    max-height: 2000px;
}

/* 5. Sub-menu row spacing */
.cat-wrapper {
    position: relative;
    width: 100%;
}
.sub-row-wrapper {
    position: relative;
    width: 100%;
}
</style>
