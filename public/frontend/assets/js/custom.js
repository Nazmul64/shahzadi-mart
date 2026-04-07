// ============================================================
// HERO SLIDER
// ============================================================
(function () {
    let currentSlide = 0;
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.slider-dot');
    const totalSlides = slides.length;

    if (!totalSlides) return;

    function showSlide(index) {
        slides.forEach(function (s) { s.classList.remove('active'); });
        dots.forEach(function (d) { d.classList.remove('active'); });
        slides[index].classList.add('active');
        if (dots[index]) dots[index].classList.add('active');
    }

    window.nextSlide = function () {
        currentSlide = (currentSlide + 1) % totalSlides;
        showSlide(currentSlide);
    };

    window.previousSlide = function () {
        currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
        showSlide(currentSlide);
    };

    window.goToSlide = function (index) {
        currentSlide = index;
        showSlide(currentSlide);
    };

    // Auto slide every 5 seconds
    setInterval(window.nextSlide, 5000);
})();


// ============================================================
// SIDEBAR CATEGORY TOGGLE
// ============================================================
window.toggleCategory = function (element) {
    const subcategory = element.nextElementSibling;
    element.classList.toggle('active');
    if (subcategory && subcategory.classList.contains('subcategory-menu')) {
        subcategory.classList.toggle('show');
    }
};


// ============================================================
// SIDEBAR TOGGLE FOR MOBILE
// ============================================================
window.toggleSidebar = function () {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.querySelector('.sidebar-overlay');
    if (!sidebar) return;
    sidebar.classList.toggle('show');
    if (overlay) overlay.classList.toggle('show');
};

document.addEventListener('click', function (e) {
    const sidebar = document.getElementById('sidebar');
    const toggle = document.querySelector('.mobile-menu-toggle');
    if (!sidebar || !toggle) return;
    if (window.innerWidth <= 1024) {
        if (!sidebar.contains(e.target) && !toggle.contains(e.target)) {
            sidebar.classList.remove('show');
            const overlay = document.querySelector('.sidebar-overlay');
            if (overlay) overlay.classList.remove('show');
        }
    }
});


// ============================================================
// FLASH SALE TIMER (HOMEPAGE)
// ============================================================
(function () {
    let flashHours = 2, flashMinutes = 26, flashSeconds = 17;

    function updateFlashTimer() {
        flashSeconds--;
        if (flashSeconds < 0) { flashSeconds = 59; flashMinutes--; }
        if (flashMinutes < 0) { flashMinutes = 59; flashHours--; }
        if (flashHours < 0) { flashHours = 23; flashMinutes = 59; flashSeconds = 59; }

        const timerElement = document.getElementById('flashTimer');
        if (timerElement) {
            timerElement.textContent =
                'Ends in: ' +
                String(flashHours).padStart(2, '0') + 'h : ' +
                String(flashMinutes).padStart(2, '0') + 'm : ' +
                String(flashSeconds).padStart(2, '0') + 's';
        }
    }

    setInterval(updateFlashTimer, 1000);
})();


// ============================================================
// MOBILE ACCOUNT DROPDOWN
// ============================================================
(function () {
    if (window.innerWidth > 768) return;

    const accountDropdown = document.querySelector('.account-dropdown');
    const dropdownContent = document.querySelector('.dropdown-content');

    if (!accountDropdown || !dropdownContent) return;

    accountDropdown.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        const isVisible = dropdownContent.style.opacity === '1';
        dropdownContent.style.opacity = isVisible ? '0' : '1';
        dropdownContent.style.visibility = isVisible ? 'hidden' : 'visible';
        dropdownContent.style.transform = isVisible ? 'translateY(-10px)' : 'translateY(0)';
    });

    document.addEventListener('click', function (e) {
        if (!accountDropdown.contains(e.target)) {
            dropdownContent.style.opacity = '0';
            dropdownContent.style.visibility = 'hidden';
            dropdownContent.style.transform = 'translateY(-10px)';
        }
    });
})();


// ============================================================
// AUTO SLIDE — CATEGORY CIRCLES
// CSS animation handles it; JS only needed for pause-on-hover
// ============================================================
(function () {
    const categoryCircles = document.getElementById('categoryCircles');
    if (!categoryCircles) return;
    // CSS animation already runs — nothing extra needed
})();


// ============================================================
// AUTO SLIDE — HOT CATEGORIES
// CSS animation handles it
// ============================================================
(function () {
    const hotGrid = document.querySelector('.hot-categories-grid');
    if (!hotGrid) return;
    // CSS animation already runs — nothing extra needed
})();


// ============================================================
// DRAG SCROLL HELPER
// Converts any container into a draggable/swipeable scroll area
// ============================================================
function makeDraggable(container) {
    if (!container) return;

    container.style.overflowX = 'auto';
    container.style.cursor = 'grab';
    container.style.userSelect = 'none';
    container.style.scrollbarWidth = 'none';
    container.style.msOverflowStyle = 'none';
    container.style.webkitOverflowScrolling = 'touch';

    // Hide webkit scrollbar
    const styleTag = document.createElement('style');
    const uid = 'drag-' + Math.random().toString(36).slice(2, 7);
    container.dataset.dragId = uid;
    styleTag.textContent = '[data-drag-id="' + uid + '"]::-webkit-scrollbar { display: none; }';
    document.head.appendChild(styleTag);

    let isDown = false;
    let startX = 0;
    let scrollLeft = 0;
    let hasDragged = false;

    // Mouse events
    container.addEventListener('mousedown', function (e) {
        isDown = true;
        hasDragged = false;
        container.style.cursor = 'grabbing';
        startX = e.pageX - container.offsetLeft;
        scrollLeft = container.scrollLeft;
        e.preventDefault();
    });

    container.addEventListener('mouseleave', function () {
        isDown = false;
        container.style.cursor = 'grab';
    });

    container.addEventListener('mouseup', function () {
        isDown = false;
        container.style.cursor = 'grab';
    });

    container.addEventListener('mousemove', function (e) {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - container.offsetLeft;
        const walk = (x - startX) * 1.5;
        if (Math.abs(walk) > 5) hasDragged = true;
        container.scrollLeft = scrollLeft - walk;
    });

    // Prevent clicks when dragging
    container.addEventListener('click', function (e) {
        if (hasDragged) e.stopPropagation();
    }, true);

    // Touch events
    let touchStartX = 0;
    let touchScrollLeft = 0;

    container.addEventListener('touchstart', function (e) {
        touchStartX = e.touches[0].pageX;
        touchScrollLeft = container.scrollLeft;
    }, { passive: true });

    container.addEventListener('touchmove', function (e) {
        const x = e.touches[0].pageX;
        const walk = (touchStartX - x) * 1.2;
        container.scrollLeft = touchScrollLeft + walk;
    }, { passive: true });
}


// ============================================================
// DRAG SCROLL — FLASH SALES PRODUCT GRID
// Auto-animation OFF; only drag/swipe
// ============================================================
(function () {
    const container = document.querySelector('.product-grid-container');
    if (!container) return;

    const grid = container.querySelector('.product-grid');
    if (!grid) return;

    // Stop CSS animation — user drags manually
    grid.style.animation = 'none';
    grid.style.transform = 'none';
    grid.style.flexWrap = 'nowrap';
    grid.style.width = 'max-content';

    makeDraggable(container);
})();


// ============================================================
// DRAG SCROLL — ALL OTHER PRODUCT GRIDS (New Arrivals, etc.)
// Auto-animation OFF; only drag/swipe
// ============================================================
(function () {
    const allGrids = document.querySelectorAll('.product-grid');

    allGrids.forEach(function (grid) {
        // Flash sales grid is inside .product-grid-container — skip it
        if (grid.closest('.product-grid-container')) return;

        // Stop any CSS animation
        grid.style.animation = 'none';
        grid.style.transform = 'none';
        grid.style.flexWrap = 'nowrap';
        grid.style.width = 'max-content';

        // Create a draggable wrapper
        const wrapper = document.createElement('div');
        wrapper.classList.add('product-drag-wrapper');
        wrapper.style.paddingBottom = '10px';

        grid.parentNode.insertBefore(wrapper, grid);
        wrapper.appendChild(grid);

        makeDraggable(wrapper);
    });
})();


// ============================================================
// PRODUCT LISTING PAGE — FILTER TOGGLE
// ============================================================
window.productlistingeToggleCategory = function (element) {
    const content = element.nextElementSibling;
    const icon = element.querySelector('.productlistinge-collapse-icon');
    if (!content) return;

    if (content.classList.contains('productlistinge-collapsed')) {
        content.classList.remove('productlistinge-collapsed');
        if (icon) icon.textContent = '−';
    } else {
        content.classList.add('productlistinge-collapsed');
        if (icon) icon.textContent = '+';
    }
};

window.productlistingeToggleFilters = function () {
    const sidebar = document.getElementById('productlistingeFilterSidebar');
    if (sidebar) sidebar.classList.toggle('productlistinge-active');
};


// ============================================================
// PRODUCT LISTING PAGE — PRICE RANGE SLIDER
// ============================================================
window.productlistingeUpdatePriceRange = function () {
    const minPrice = document.getElementById('productlistingeMinPrice');
    const maxPrice = document.getElementById('productlistingeMaxPrice');
    const minPriceInput = document.getElementById('productlistingeMinPriceInput');
    const maxPriceInput = document.getElementById('productlistingeMaxPriceInput');
    const trackFilled = document.getElementById('productlistingePriceTrackFilled');

    if (!minPrice || !maxPrice) return;

    let minVal = parseInt(minPrice.value);
    let maxVal = parseInt(maxPrice.value);

    if (minVal > maxVal - 100) { minVal = maxVal - 100; minPrice.value = minVal; }
    if (maxVal < minVal + 100) { maxVal = minVal + 100; maxPrice.value = maxVal; }

    if (minPriceInput) minPriceInput.value = minVal;
    if (maxPriceInput) maxPriceInput.value = maxVal;

    if (trackFilled) {
        const range = 26025 - 20;
        const percentMin = ((minVal - 20) / range) * 100;
        const percentMax = ((maxVal - 20) / range) * 100;
        trackFilled.style.left = percentMin + '%';
        trackFilled.style.right = (100 - percentMax) + '%';
    }
};

window.productlistingeUpdateFromInput = function () {
    const minPrice = document.getElementById('productlistingeMinPrice');
    const maxPrice = document.getElementById('productlistingeMaxPrice');
    const minPriceInput = document.getElementById('productlistingeMinPriceInput');
    const maxPriceInput = document.getElementById('productlistingeMaxPriceInput');

    if (minPrice && minPriceInput) minPrice.value = minPriceInput.value;
    if (maxPrice && maxPriceInput) maxPrice.value = maxPriceInput.value;
    window.productlistingeUpdatePriceRange();
};

if (document.getElementById('productlistingeMinPrice')) {
    window.productlistingeUpdatePriceRange();
}


// ============================================================
// PRODUCT DETAILS PAGE — IMAGE GALLERY & ZOOM
// ============================================================
(function () {
    const mainImageContainer = document.getElementById('mainImageContainer');
    const mainImage = document.getElementById('mainImage');
    const zoomImage = document.getElementById('zoomImage');
    const zoomLens = document.getElementById('zoomLens');
    const zoomPreview = document.getElementById('zoomPreview');
    const imageCounter = document.getElementById('imageCounter');
    const thumbnails = document.querySelectorAll('.thumbnail-item');

    if (!mainImageContainer) return;

    thumbnails.forEach(function (thumbnail) {
        thumbnail.addEventListener('click', function () {
            thumbnails.forEach(function (t) { t.classList.remove('active'); });
            this.classList.add('active');

            const imageUrl = this.getAttribute('data-image');
            const zoomUrl = this.getAttribute('data-zoom');
            const index = this.getAttribute('data-index');

            if (mainImage) mainImage.src = imageUrl;
            if (zoomImage) zoomImage.src = zoomUrl;
            if (imageCounter) imageCounter.textContent = index + '/6';
        });
    });

    mainImageContainer.addEventListener('mousemove', function (e) {
        if (!zoomLens || !zoomPreview || !zoomImage || !mainImage) return;

        const rect = this.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        const lensW = zoomLens.offsetWidth / 2;
        const lensH = zoomLens.offsetHeight / 2;

        let posX = Math.max(0, Math.min(x - lensW, rect.width - zoomLens.offsetWidth));
        let posY = Math.max(0, Math.min(y - lensH, rect.height - zoomLens.offsetHeight));

        zoomLens.style.left = posX + 'px';
        zoomLens.style.top = posY + 'px';

        const cx = zoomPreview.offsetWidth / zoomLens.offsetWidth;
        const cy = zoomPreview.offsetHeight / zoomLens.offsetHeight;

        zoomImage.style.width = (mainImage.width * cx) + 'px';
        zoomImage.style.height = (mainImage.height * cy) + 'px';
        zoomImage.style.left = -(posX * cx) + 'px';
        zoomImage.style.top = -(posY * cy) + 'px';
    });
})();


// ============================================================
// PRODUCT DETAILS — WISHLIST TOGGLE
// ============================================================
(function () {
    const wishlistBtn = document.getElementById('wishlistBtn');
    if (!wishlistBtn) return;

    wishlistBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        const icon = this.querySelector('i');
        icon.classList.toggle('far');
        icon.classList.toggle('fas');

        if (icon.classList.contains('fas')) {
            icon.style.color = '#f85606';
            this.style.backgroundColor = '#fff0e6';
        } else {
            icon.style.color = '#666';
            this.style.backgroundColor = 'rgba(255,255,255,0.95)';
        }
    });
})();


// ============================================================
// PRODUCT DETAILS — QUANTITY CONTROLS
// ============================================================
(function () {
    const qtyInput = document.getElementById('qtyInput');
    const decreaseBtn = document.getElementById('decreaseQty');
    const increaseBtn = document.getElementById('increaseQty');

    if (!qtyInput) return;

    if (decreaseBtn) {
        decreaseBtn.addEventListener('click', function () {
            const value = parseInt(qtyInput.value);
            if (value > 1) qtyInput.value = value - 1;
        });
    }

    if (increaseBtn) {
        increaseBtn.addEventListener('click', function () {
            const value = parseInt(qtyInput.value);
            if (value < 11) qtyInput.value = value + 1;
        });
    }
})();


// ============================================================
// PRODUCT DETAILS — OPTION BUTTONS (size, color, etc.)
// ============================================================
document.querySelectorAll('.option-button').forEach(function (button) {
    button.addEventListener('click', function () {
        if (!this.classList.contains('disabled')) {
            const siblings = this.parentElement.querySelectorAll('.option-button');
            siblings.forEach(function (btn) { btn.classList.remove('active'); });
            this.classList.add('active');
        }
    });
});


// ============================================================
// PRODUCT DETAILS — FLASH SALE COUNTDOWN TIMER
// ============================================================
(function () {
    const hoursEl = document.getElementById('hoursTimer');
    const minutesEl = document.getElementById('minutesTimer');
    const secondsEl = document.getElementById('secondsTimer');

    if (!hoursEl) return;

    let hours = 1, minutes = 39, seconds = 54;

    setInterval(function () {
        seconds--;
        if (seconds < 0) { seconds = 59; minutes--; }
        if (minutes < 0) { minutes = 59; hours--; }
        if (hours < 0) { hours = 0; minutes = 0; seconds = 0; }

        hoursEl.textContent = String(hours).padStart(2, '0') + 'h';
        minutesEl.textContent = String(minutes).padStart(2, '0') + 'm';
        secondsEl.textContent = String(seconds).padStart(2, '0') + 's';
    }, 1000);
})();


// ============================================================
// PRODUCT DETAILS — SOCIAL SHARE
// ============================================================
document.querySelectorAll('.social-icon').forEach(function (icon) {
    icon.addEventListener('click', function () {
        const platform = this.title || 'Unknown';
        console.log('Sharing on ' + platform);
    });
});


// ============================================================
// PRODUCT DETAILS — ADD TO CART & BUY NOW
// ============================================================
(function () {
    const addCartBtn = document.querySelector('.btn-add-cart');
    const buyNowBtn = document.querySelector('.btn-buy-now');

    if (addCartBtn) {
        addCartBtn.addEventListener('click', function () {
            alert('Product added to cart!');
        });
    }

    if (buyNowBtn) {
        buyNowBtn.addEventListener('click', function () {
            alert('Proceeding to checkout...');
        });
    }
})();


// ============================================================
// PRODUCT DETAILS — TAB SWITCHING
// ============================================================
window.switchTab = function (evt, tabName) {
    document.querySelectorAll('.tab-content').forEach(function (content) {
        content.style.display = 'none';
    });

    document.querySelectorAll('.tab-button').forEach(function (button) {
        button.classList.remove('active');
    });

    const target = document.getElementById(tabName);
    if (target) target.style.display = 'block';
    evt.currentTarget.classList.add('active');
};


// ============================================================
// CART PAGE — SELECT ALL TOGGLE
// ============================================================
window.toggleSelectAll = function () {
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    const itemCheckboxes = document.querySelectorAll('.item-checkbox');
    if (!selectAllCheckbox) return;

    itemCheckboxes.forEach(function (checkbox) {
        checkbox.checked = selectAllCheckbox.checked;
    });
    updateCartTotal();
};


// ============================================================
// CART PAGE — QUANTITY CONTROLS
// ============================================================
window.increaseQty = function (button) {
    const input = button.previousElementSibling;
    const value = parseInt(input.value);
    if (value < 99) { input.value = value + 1; updateCartTotal(); }
};

window.decreaseQty = function (button) {
    const input = button.nextElementSibling;
    const value = parseInt(input.value);
    if (value > 1) { input.value = value - 1; updateCartTotal(); }
};


// ============================================================
// CART PAGE — REMOVE ITEM
// ============================================================
window.removeItem = function (element) {
    if (!confirm('Remove this item from cart?')) return;

    const item = element.closest('.cardpage-item');
    item.style.transition = 'all 0.3s ease';
    item.style.opacity = '0';
    item.style.transform = 'translateX(-20px)';

    setTimeout(function () {
        item.remove();
        updateCartCount();
        updateCartTotal();
    }, 300);
};


// ============================================================
// CART PAGE — CLEAR CART
// ============================================================
window.clearCart = function () {
    if (!confirm('Clear your entire cart?')) return;

    const items = document.querySelectorAll('.cardpage-item');
    items.forEach(function (item) {
        item.style.transition = 'all 0.3s ease';
        item.style.opacity = '0';
        item.style.transform = 'scale(0.9)';
    });

    setTimeout(function () {
        items.forEach(function (item) { item.remove(); });
        updateCartCount();
        updateCartTotal();
    }, 300);
};


// ============================================================
// CART PAGE — UPDATE CART COUNT
// ============================================================
function updateCartCount() {
    const cartCountEl = document.getElementById('cartCount');
    if (!cartCountEl) return;
    cartCountEl.textContent = document.querySelectorAll('.cardpage-item').length;
}


// ============================================================
// CART PAGE — UPDATE CART TOTAL
// ============================================================
function updateCartTotal() {
    const checkedItems = document.querySelectorAll('.item-checkbox:checked');
    let total = 0;

    checkedItems.forEach(function (checkbox) {
        const item = checkbox.closest('.cardpage-item');
        if (!item) return;

        const priceElement = item.querySelector('.cardpage-item-current-price');
        const qtyInput = item.querySelector('.cardpage-qty-input');
        if (!priceElement || !qtyInput) return;

        const priceText = priceElement.textContent.replace(/[^0-9.]/g, '');
        const price = parseFloat(priceText) || 0;
        const qty = parseInt(qtyInput.value) || 1;
        total += price * qty;
    });

    const formattedTotal = total.toLocaleString('en-KE', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    });

    const subtotalEl = document.getElementById('subtotalAmount');
    const checkoutEl = document.getElementById('checkoutAmount');

    if (subtotalEl) subtotalEl.textContent = 'KSh ' + formattedTotal;
    if (checkoutEl) checkoutEl.textContent = formattedTotal;
}


// ============================================================
// CART PAGE — PROCEED TO CHECKOUT
// ============================================================
window.proceedToCheckout = function () {
    const checkedItems = document.querySelectorAll('.item-checkbox:checked');
    if (checkedItems.length === 0) {
        alert('Please select at least one item to checkout.');
        return;
    }
    alert('Proceeding to checkout with ' + checkedItems.length + ' item(s)...');
};


// ============================================================
// CART PAGE — INIT ON DOM READY
// ============================================================
document.addEventListener('DOMContentLoaded', function () {
    const itemCheckboxes = document.querySelectorAll('.item-checkbox');
    const selectAll = document.getElementById('selectAllCheckbox');

    if (itemCheckboxes.length > 0) {
        itemCheckboxes.forEach(function (checkbox) {
            checkbox.checked = true;
        });
        if (selectAll) selectAll.checked = true;
        updateCartTotal();
    }
});


// ============================================================
// CHECKOUT — CUSTOMER LOGIN TAB SWITCHING
// ============================================================
(function () {
    const tabBtns = document.querySelectorAll('.tab-btn');
    if (!tabBtns.length) return;

    tabBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            const target = this.getAttribute('data-tab');

            tabBtns.forEach(function (b) { b.classList.remove('active'); });
            document.querySelectorAll('.form-container').forEach(function (f) {
                f.classList.remove('active');
            });

            this.classList.add('active');
            const targetForm = document.getElementById(target);
            if (targetForm) targetForm.classList.add('active');
        });
    });
})();


// ============================================================
// GLOBAL — SMOOTH SCROLL TO TOP UTILITY
// ============================================================
window.scrollToTop = function () {
    window.scrollTo({ top: 0, behavior: 'smooth' });
};
