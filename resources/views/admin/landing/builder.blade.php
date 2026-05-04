@extends('admin.master')

@section('main-content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

<style>
    .builder-container { max-width: 1000px; margin: 0 auto; }
    .page-title-box h4 { font-size: 1.2rem; font-weight: 700; color: #1a2b6b; }
    
    .block-list { min-height: 100px; margin-top: 20px; }
    .block-item {
        background: #fff;
        border: 1px solid #e0e5f2;
        border-radius: 10px;
        padding: 15px 20px;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 2px 5px rgba(0,0,0,0.02);
        cursor: grab;
    }
    .block-item:active { cursor: grabbing; }
    .block-icon {
        width: 40px; height: 40px;
        background: #f1f4f9; color: #1a2b6b;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.2rem; margin-right: 15px;
    }
    .block-title { font-weight: 600; font-size: 1.05rem; margin-bottom: 0; }
    .block-type { font-size: 0.8rem; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px; }
    
    .btn-add-block {
        border: 2px dashed #1a2b6b;
        background: #f8f9fc;
        color: #1a2b6b;
        font-weight: 600;
        width: 100%; padding: 15px;
        border-radius: 10px;
        transition: 0.3s;
    }
    .btn-add-block:hover { background: #eef2fa; }

    .block-option {
        border: 1px solid #ddd;
        border-radius: 10px; padding: 20px;
        text-align: center; cursor: pointer; transition: 0.3s;
    }
    .block-option:hover { border-color: #1a2b6b; background: #f8f9fc; transform: translateY(-3px); }
    .block-option i { font-size: 2rem; color: #1a2b6b; margin-bottom: 10px; display: block; }
    .block-option strong { font-size: 1rem; color: #333; }

    .modal-content { border-radius: 15px; border: none; }
    .modal-header { background: #1a2b6b; color: #fff; border-radius: 15px 15px 0 0; }
    .modal-title { font-weight: 600; font-size: 1.1rem; }
    .form-label { font-weight: 600; color: #333; }
</style>

<div class="builder-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="page-title-box">
            <h4><i class="bi bi-columns-gap me-2"></i> Page Builder: {{ $landing->title }}</h4>
            <small class="text-muted">Drag and drop blocks to reorder them.</small>
        </div>
        <div>
            <a href="{{ route('landing.show', $landing->slug) }}" target="_blank" class="btn btn-outline-primary fw-bold me-2"><i class="bi bi-eye"></i> Preview</a>
            <a href="{{ route('admin.landing-pages.index') }}" class="btn btn-outline-secondary fw-bold">Back</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="selectAllBlocks" style="width: 20px; height: 20px;">
                <label class="form-check-label fw-bold" for="selectAllBlocks">Select All</label>
            </div>
            <button type="button" class="btn btn-danger btn-sm shadow-sm px-3 d-none" id="btnBulkDelete" onclick="bulkDelete()">
                <i class="bi bi-trash"></i> Delete Selected
            </button>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-dark shadow" data-bs-toggle="modal" data-bs-target="#settingsModal" style="border-radius: 8px; padding: 10px 25px;">
                <i class="bi bi-gear"></i> Page Settings
            </button>
            <button type="button" class="btn btn-primary shadow" data-bs-toggle="modal" data-bs-target="#addBlockModal" style="background:#1a2b6b; border:none; border-radius: 8px; padding: 10px 25px;">
                <i class="bi bi-plus-lg"></i> Add New Section
            </button>
        </div>
    </div>

    <div class="block-list" id="sortable-blocks">
        @forelse($landing->blocks as $block)
            <div class="block-item" data-id="{{ $block->id }}">
                <div class="d-flex align-items-center gap-3">
                    <input type="checkbox" class="block-checkbox form-check-input" value="{{ $block->id }}" style="width: 18px; height: 18px; cursor: pointer;">
                    <div class="block-icon">
                        @if($block->type == 'banner') <i class="bi bi-image"></i>
                        @elseif($block->type == 'text_image') <i class="bi bi-layout-split"></i>
                        @elseif($block->type == 'reviews_slider') <i class="bi bi-star"></i>
                        @elseif($block->type == 'features') <i class="bi bi-list-check"></i>
                        @elseif($block->type == 'video') <i class="bi bi-play-circle"></i>
                        @elseif($block->type == 'call_to_action') <i class="bi bi-megaphone"></i>
                        @endif
                    </div>
                    <div>
                        <p class="block-title">{{ $block->content['title'] ?? 'Untitled Block' }}</p>
                        <span class="block-type">{{ str_replace('_', ' ', $block->type) }}</span>
                    </div>
                </div>
                <div class="d-flex gap-2 align-items-center">
                    <span class="text-muted me-3" style="cursor: grab;"><i class="bi bi-arrows-move"></i> Move</span>
                    <button type="button" class="btn btn-sm btn-primary" onclick="editBlock({{ $block->id }}, '{{ $block->type }}')">
                        <i class="bi bi-pencil"></i> Edit
                    </button>
                    <form action="{{ route('admin.landing-pages.builder.destroy', $block->id) }}" method="POST" onsubmit="return confirm('Delete this block?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </div>
            </div>
        @empty
            <div class="text-center py-5 text-muted border rounded" style="background:#fff;">
                <i class="bi bi-grid" style="font-size:3rem; opacity:0.5;"></i>
                <h5 class="mt-3">No Blocks Yet</h5>
                <p>Click the button below to add your first section.</p>
            </div>
        @endforelse
    </div>
</div>

<!-- Add Block Modal -->
<div class="modal fade" id="addBlockModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Choose Section Type</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="block-option" onclick="openForm('product_hero')">
                            <i class="bi bi-star-fill" style="color: #ff9800;"></i>
                            <strong>Product Hero (Title/Video)</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="block-option" onclick="openForm('product_price')">
                            <i class="bi bi-tag-fill" style="color: #4caf50;"></i>
                            <strong>Product Price Box</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="block-option" onclick="openForm('product_feature_list')">
                            <i class="bi bi-check-circle-fill" style="color: #2196f3;"></i>
                            <strong>Product Feature List</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="block-option" onclick="openForm('banner')">
                            <i class="bi bi-image"></i>
                            <strong>Banner Image/Text</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="block-option" onclick="openForm('text_image')">
                            <i class="bi bi-layout-split"></i>
                            <strong>Text & Image</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="block-option" onclick="openForm('features')">
                            <i class="bi bi-list-check"></i>
                            <strong>Benefits/Features</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="block-option" onclick="openForm('video')">
                            <i class="bi bi-play-btn"></i>
                            <strong>Video Section</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="block-option" onclick="openForm('reviews_slider')">
                            <i class="bi bi-star"></i>
                            <strong>Review Slider</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="block-option" onclick="openForm('call_to_action')">
                            <i class="bi bi-megaphone"></i>
                            <strong>Call To Action</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="block-option" onclick="openForm('custom_reviews_slider')">
                            <i class="bi bi-images"></i>
                            <strong>Custom Image Reviews</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="block-option" onclick="openForm('faq')">
                            <i class="bi bi-question-circle"></i>
                            <strong>FAQ / Accordion</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="block-option" onclick="openForm('countdown')">
                            <i class="bi bi-clock-history"></i>
                            <strong>Countdown Timer</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="block-option" onclick="openForm('gallery')">
                            <i class="bi bi-grid-3x3"></i>
                            <strong>Image Gallery</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="block-option" onclick="openForm('custom_html')">
                            <i class="bi bi-code-slash"></i>
                            <strong>Custom HTML / Text</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="block-option" onclick="openForm('whatsapp_button')">
                            <i class="bi bi-whatsapp"></i>
                            <strong>WhatsApp Chat</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="block-option" onclick="openForm('counter')">
                            <i class="bi bi-clock-history"></i>
                            <strong>Number Counter</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="block-option" onclick="openForm('image_compare')">
                            <i class="bi bi-aspect-ratio"></i>
                            <strong>Image Compare</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="block-option" onclick="openForm('dual_button')">
                            <i class="bi bi-distribute-horizontal"></i>
                            <strong>Dual Button</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="block-option" onclick="openForm('star_ratings')">
                            <i class="bi bi-star-half"></i>
                            <strong>Star Ratings</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="block-option" onclick="openForm('text_typing')">
                            <i class="bi bi-keyboard"></i>
                            <strong>Typing Text</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="block-option" onclick="openForm('elegant_card')">
                            <i class="bi bi-card-heading"></i>
                            <strong>Elegant Card</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="block-option" onclick="openForm('syntax_highlighter')">
                            <i class="bi bi-code-square"></i>
                            <strong>Syntax Highlighter</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="block-option" onclick="openForm('ribbon')">
                            <i class="bi bi-bookmark-star"></i>
                            <strong>Premium Ribbon</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="block-option" onclick="openForm('header_classic')">
                            <i class="bi bi-window-dock"></i>
                            <strong>Classic Header</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="block-option" onclick="openForm('footer_classic')">
                            <i class="bi bi-window-stack"></i>
                            <strong>Classic Footer</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="block-option" onclick="openForm('banner_slider')">
                            <i class="bi bi-images"></i>
                            <strong>Banner Slider</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="block-option" onclick="openForm('section_shape')">
                            <i class="bi bi-bezier2"></i>
                            <strong>Section Shape</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="block-option" onclick="openForm('product_grid')">
                            <i class="bi bi-bag-heart"></i>
                            <strong>Product Grid</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="block-option" onclick="openForm('custom_page')">
                            <i class="bi bi-file-earmark-text"></i>
                            <strong>Custom Page</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Forms Modal -->
<div class="modal fade" id="formModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalTitle">Add Block</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="blockForm" action="{{ route('admin.landing-pages.builder.store', $landing->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div id="methodField"></div>
                <input type="hidden" name="type" id="blockTypeInput">
                <div class="modal-body p-0">
                    <ul class="nav nav-tabs px-4 pt-3" id="blockTabs" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active fw-bold" id="content-tab" data-bs-toggle="tab" data-bs-target="#tab-content" type="button">Content</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link fw-bold" id="style-tab" data-bs-toggle="tab" data-bs-target="#tab-style" type="button">Style & Animation</button>
                        </li>
                    </ul>
                    <div class="tab-content p-4">
                        <div class="tab-pane fade show active" id="tab-content">
                            <div id="formBody"></div>
                        </div>
                        <div class="tab-pane fade" id="tab-style">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Design Style</label>
                                    <select name="style_variation" class="form-select">
                                        <option value="style-1">Style 1 (Modern)</option>
                                        <option value="style-2">Style 2 (Premium/Dark)</option>
                                        <option value="style-3">Style 3 (Clean/White)</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Block Background</label>
                                    <input type="color" name="block_bg_color" class="form-control form-control-color w-100" value="#ffffff">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Title Color</label>
                                    <input type="color" name="title_color" class="form-control form-control-color w-100" value="#1a2b6b">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Text Color</label>
                                    <input type="color" name="text_color" class="form-control form-control-color w-100" value="#444444">
                                </div>
                                <hr>
                                <div class="col-md-6">
                                    <label class="form-label">Animation Type</label>
                                    <select name="aos_type" class="form-select">
                                        <option value="fade-up">Fade Up</option>
                                        <option value="fade-down">Fade Down</option>
                                        <option value="zoom-in">Zoom In</option>
                                        <option value="zoom-out">Zoom Out</option>
                                        <option value="flip-left">Flip Left</option>
                                        <option value="none">None</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Animation Duration (ms)</label>
                                    <input type="number" name="aos_duration" class="form-control" value="800">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Vertical Padding (Top/Bottom Spacing)</label>
                                    <div class="input-group">
                                        <input type="number" name="block_padding" class="form-control" value="60">
                                        <span class="input-group-text">px</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 pe-4">
                    <button type="submit" class="btn btn-primary px-5 py-2 fw-bold shadow" style="background:#1a2b6b; border:none;">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Form Templates (Hidden) -->
<div id="templates" style="display: none;">
    <!-- Banner -->
    <div id="tpl-banner">
        <div class="mb-3"><label class="form-label">Banner Image</label><input type="file" name="banner_image" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Main Title</label><input type="text" name="banner_title" class="form-control" placeholder="E.g. 100% Pure Organic Honey"></div>
        <div class="mb-3"><label class="form-label">Subtitle / Short Text</label><textarea name="banner_subtitle" class="form-control"></textarea></div>
        <div class="mb-3"><label class="form-label">Button Text</label><input type="text" name="banner_btn_text" class="form-control" placeholder="Order Now"></div>
    </div>
    
    <!-- Text & Image -->
    <div id="tpl-text_image">
        <div class="mb-3"><label class="form-label">Title</label><input type="text" name="ti_title" class="form-control"></div>
        <div class="mb-3"><label class="form-label">Description Text</label><textarea name="ti_text" class="form-control" rows="4"></textarea></div>
        <div class="mb-3"><label class="form-label">Image</label><input type="file" name="ti_image" class="form-control" required></div>
        <div class="mb-3">
            <label class="form-label">Image Position</label>
            <select name="ti_image_position" class="form-select">
                <option value="left">Image Left, Text Right</option>
                <option value="right">Text Left, Image Right</option>
            </select>
        </div>
    </div>

    <!-- Features -->
    <div id="tpl-features">
        <div class="mb-3"><label class="form-label">Section Title</label><input type="text" name="f_title" class="form-control" placeholder="Why choose our product?"></div>
        <div id="feature-list">
            <div class="feature-row d-flex gap-2 mb-2">
                <input type="text" name="feature_titles[]" class="form-control" placeholder="Feature title (e.g. 100% Natural)" required>
                <input type="text" name="feature_texts[]" class="form-control" placeholder="Short description (optional)">
            </div>
            <div class="feature-row d-flex gap-2 mb-2">
                <input type="text" name="feature_titles[]" class="form-control" placeholder="Feature title">
                <input type="text" name="feature_texts[]" class="form-control" placeholder="Short description">
            </div>
        </div>
        <button type="button" class="btn btn-sm btn-outline-secondary mt-2" onclick="addFeatureRow()">+ Add Another Feature</button>
    </div>

    <!-- Video -->
    <div id="tpl-video">
        <div class="mb-3"><label class="form-label">Title</label><input type="text" name="v_title" class="form-control"></div>
        <div class="mb-3"><label class="form-label">YouTube Video URL</label><input type="text" name="v_url" class="form-control" required></div>
    </div>

    <!-- Reviews Slider -->
    <div id="tpl-reviews_slider">
        <div class="mb-3"><label class="form-label">Section Title</label><input type="text" name="rs_title" class="form-control" value="Customer Reviews"></div>
        <p class="text-muted">This block will automatically load the reviews approved in the Reviews section.</p>
    </div>

    <!-- Call to action -->
    <div id="tpl-call_to_action">
        <div class="mb-3"><label class="form-label">Title</label><input type="text" name="cta_title" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Subtitle</label><textarea name="cta_subtitle" class="form-control"></textarea></div>
        <div class="mb-3"><label class="form-label">Button Text</label><input type="text" name="cta_btn_text" class="form-control" value="Order Now"></div>
    </div>

    <!-- Custom Image Reviews -->
    <div id="tpl-custom_reviews_slider">
        <div class="mb-3"><label class="form-label">Section Title</label><input type="text" name="crs_title" class="form-control" value="Real Customer Reviews"></div>
        <div class="mb-3">
            <label class="form-label">Upload Review Images (Multiple)</label>
            <input type="file" name="crs_images[]" class="form-control" multiple accept="image/*" required>
            <small class="text-muted">You can select multiple images (like WhatsApp/Messenger screenshots) at once.</small>
        </div>
    </div>

    <!-- FAQ -->
    <div id="tpl-faq">
        <div class="mb-3"><label class="form-label">Section Title</label><input type="text" name="faq_title" class="form-control" value="Frequently Asked Questions"></div>
        <div id="faq-list">
            <div class="feature-row mb-2 border p-3 rounded bg-light">
                <input type="text" name="faq_questions[]" class="form-control mb-2" placeholder="Question (e.g. How to use it?)" required>
                <textarea name="faq_answers[]" class="form-control" placeholder="Answer..." rows="2"></textarea>
            </div>
        </div>
        <button type="button" class="btn btn-sm btn-outline-secondary mt-2" onclick="addFaqRow()">+ Add Another Question</button>
    </div>

    <!-- Countdown Timer -->
    <div id="tpl-countdown">
        <div class="mb-3"><label class="form-label">Title (e.g. Offer Ends In:)</label><input type="text" name="cd_title" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">End Date & Time</label><input type="datetime-local" name="cd_end_time" class="form-control" required></div>
    </div>

    <!-- Image Gallery -->
    <div id="tpl-gallery">
        <div class="mb-3"><label class="form-label">Section Title</label><input type="text" name="gal_title" class="form-control" value="Our Gallery"></div>
        <div class="mb-3">
            <label class="form-label">Upload Images (Multiple)</label>
            <input type="file" name="gal_images[]" class="form-control" multiple accept="image/*" required>
        </div>
    </div>

    <!-- Custom HTML -->
    <div id="tpl-custom_html">
        <div class="mb-3"><label class="form-label">Custom Content (HTML or Plain Text)</label>
            <textarea name="ch_content" class="form-control" rows="8" placeholder="<h1>Hello</h1><p>World</p>" required></textarea>
            <small class="text-muted">You can write raw HTML here, e.g., an iframe map or simple paragraphs.</small>
        </div>
    </div>
    
    <!-- WhatsApp Button -->
    <div id="tpl-whatsapp_button">
        <div class="mb-3"><label class="form-label">WhatsApp Number (e.g. 8801700000000)</label><input type="text" name="wa_phone" class="form-control"></div>
        <div class="mb-3"><label class="form-label">Custom Message</label><input type="text" name="wa_message" class="form-control" placeholder="Hello, I want to order..."></div>
        <div class="mb-3"><label class="form-label">Button Text</label><input type="text" name="wa_btn_text" class="form-control" value="Chat on WhatsApp"></div>
    </div>

    <!-- Number Counter -->
    <div id="tpl-counter">
        <div class="mb-3"><label class="form-label">Title</label><input type="text" name="count_title" class="form-control"></div>
        <div class="mb-3"><label class="form-label">Number</label><input type="number" name="count_number" class="form-control" value="1000"></div>
        <div class="row">
            <div class="col-6 mb-3"><label class="form-label">Prefix</label><input type="text" name="count_prefix" class="form-control" placeholder="+"></div>
            <div class="col-6 mb-3"><label class="form-label">Suffix</label><input type="text" name="count_suffix" class="form-control" placeholder="k"></div>
        </div>
    </div>

    <!-- Image Compare -->
    <div id="tpl-image_compare">
        <div class="mb-3"><label class="form-label">Before Image</label><input type="file" name="ic_before" class="form-control"></div>
        <div class="mb-3"><label class="form-label">After Image</label><input type="file" name="ic_after" class="form-control"></div>
        <div class="row">
            <div class="col-6 mb-3"><label class="form-label">Before Label</label><input type="text" name="ic_before_label" class="form-control" value="Before"></div>
            <div class="col-6 mb-3"><label class="form-label">After Label</label><input type="text" name="ic_after_label" class="form-control" value="After"></div>
        </div>
    </div>

    <!-- Dual Button -->
    <div id="tpl-dual_button">
        <div class="row">
            <div class="col-6 mb-3"><label class="form-label">Btn 1 Text</label><input type="text" name="db_btn1_text" class="form-control" value="Order Now"></div>
            <div class="col-6 mb-3"><label class="form-label">Btn 1 URL</label><input type="text" name="db_btn1_url" class="form-control" value="#order"></div>
            <div class="col-12 mb-3 text-center"><label class="form-label">Separator</label><input type="text" name="db_separator" class="form-control w-25 mx-auto text-center" value="OR"></div>
            <div class="col-6 mb-3"><label class="form-label">Btn 2 Text</label><input type="text" name="db_btn2_text" class="form-control" value="WhatsApp Chat"></div>
            <div class="col-6 mb-3"><label class="form-label">Btn 2 URL</label><input type="text" name="db_btn2_url" class="form-control" value="#"></div>
        </div>
    </div>

    <!-- Star Ratings -->
    <div id="tpl-star_ratings">
        <div class="mb-3"><label class="form-label">Title</label><input type="text" name="sr_title" class="form-control"></div>
        <div class="mb-3"><label class="form-label">Rating (1-5)</label><input type="number" name="sr_rating" class="form-control" step="0.1" value="4.9" min="1" max="5"></div>
        <div class="mb-3"><label class="form-label">Rating Count (Text)</label><input type="text" name="sr_count" class="form-control" placeholder="500+ Reviews"></div>
    </div>

    <!-- Typing Text -->
    <div id="tpl-text_typing">
        <div class="mb-3"><label class="form-label">Prefix Text</label><input type="text" name="tt_prefix" class="form-control"></div>
        <div class="mb-3"><label class="form-label">Typing Strings (Comma sep)</label><input type="text" name="tt_strings" class="form-control" placeholder="Fast, Safe, Reliable"></div>
        <div class="mb-3"><label class="form-label">Suffix Text</label><input type="text" name="tt_suffix" class="form-control"></div>
    </div>

    <!-- Elegant Card -->
    <div id="tpl-elegant_card">
        <div class="mb-3"><label class="form-label">Card Image</label><input type="file" name="ec_image" class="form-control"></div>
        <div class="mb-3"><label class="form-label">Title</label><input type="text" name="ec_title" class="form-control"></div>
        <div class="mb-3"><label class="form-label">Description Text</label><textarea name="ec_text" class="form-control" rows="3"></textarea></div>
        <div class="row">
            <div class="col-6 mb-3"><label class="form-label">Btn Text</label><input type="text" name="ec_btn_text" class="form-control"></div>
            <div class="col-6 mb-3"><label class="form-label">Btn URL</label><input type="text" name="ec_btn_url" class="form-control"></div>
        </div>
    </div>
    <!-- Syntax Highlighter -->
    <div id="tpl-syntax_highlighter">
        <div class="mb-3">
            <label class="form-label">Language</label>
            <select name="sh_lang" class="form-select">
                <option value="javascript">JavaScript</option>
                <option value="php">PHP</option>
                <option value="html">HTML</option>
                <option value="css">CSS</option>
                <option value="python">Python</option>
            </select>
        </div>
        <div class="mb-3"><label class="form-label">Code</label><textarea name="sh_code" class="form-control" rows="10" placeholder="// Write code here"></textarea></div>
    </div>

    <!-- Ribbon -->
    <div id="tpl-ribbon">
        <div class="mb-3"><label class="form-label">Ribbon Text</label><input type="text" name="rb_text" class="form-control" value="Special Offer"></div>
        <div class="mb-3">
            <label class="form-label">Position</label>
            <select name="rb_pos" class="form-select">
                <option value="top-left">Top Left</option>
                <option value="top-right">Top Right</option>
            </select>
        </div>
        <div class="mb-3"><label class="form-label">Ribbon Color</label><input type="color" name="rb_color" class="form-control form-control-color w-100" value="#ff0000"></div>
    </div>
    <!-- Header Classic -->
    <div id="tpl-header_classic">
        <div class="mb-3"><label class="form-label">Logo</label><input type="file" name="h_logo" class="form-control"></div>
        <div class="mb-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="h_sticky" id="h_sticky" checked>
                <label class="form-check-label" for="h_sticky">Sticky Header</label>
            </div>
        </div>
        <div class="row">
            <div class="col-6 mb-3"><label class="form-label">Contact Phone</label><input type="text" name="h_phone" class="form-control" placeholder="+8801700000000"></div>
            <div class="col-6 mb-3"><label class="form-label">Contact Email</label><input type="email" name="h_email" class="form-control" placeholder="info@example.com"></div>
        </div>
        <div id="header-menu-list">
            <label class="form-label">Menu Items</label>
            <div class="d-flex gap-2 mb-2">
                <input type="text" name="h_menu_titles[]" class="form-control" placeholder="Home">
                <input type="text" name="h_menu_urls[]" class="form-control" placeholder="#">
            </div>
        </div>
        <button type="button" class="btn btn-sm btn-outline-secondary mt-2" onclick="addHeaderMenuRow()">+ Add Menu Item</button>
    </div>

    <!-- Footer Classic -->
    <div id="tpl-footer_classic">
        <div class="mb-3"><label class="form-label">Footer Logo</label><input type="file" name="f_logo" class="form-control"></div>
        <div class="mb-3"><label class="form-label">Description</label><textarea name="f_description" class="form-control" rows="2"></textarea></div>
        <div class="row">
            <div class="col-6 mb-3"><label class="form-label">Phone Number</label><input type="text" name="f_phone" class="form-control" placeholder="+8801700000000"></div>
            <div class="col-6 mb-3"><label class="form-label">Email Address</label><input type="email" name="f_email" class="form-control" placeholder="info@example.com"></div>
        </div>
        <div class="mb-3"><label class="form-label">Office Address</label><input type="text" name="f_address" class="form-control" placeholder="Dhaka, Bangladesh"></div>
        <div id="footer-link-list">
            <label class="form-label">Quick Links (Privacy, Terms, etc.)</label>
            <div class="d-flex gap-2 mb-2">
                <input type="text" name="f_link_titles[]" class="form-control" placeholder="Privacy Policy">
                <input type="text" name="f_link_urls[]" class="form-control" placeholder="/privacy">
            </div>
        </div>
        <button type="button" class="btn btn-sm btn-outline-secondary mt-2" onclick="addFooterLinkRow()">+ Add Link</button>
        <div class="mt-3"><label class="form-label">Copyright Text</label><input type="text" name="f_copyright" class="form-control" value="© 2024 Your Company. All rights reserved."></div>
    </div>

    <!-- Banner Slider -->
    <div id="tpl-banner_slider">
        <div class="mb-3">
            <label class="form-label">Upload Slider Images (Multiple)</label>
            <input type="file" name="bs_images[]" class="form-control" multiple accept="image/*" required>
        </div>
    </div>

    <!-- Section Shape -->
    <div id="tpl-section_shape">
        <div class="mb-3">
            <label class="form-label">Shape Type</label>
            <select name="shape_type" class="form-select">
                <option value="wave">Wave</option>
                <option value="curve">Curve</option>
                <option value="triangle">Triangle</option>
                <option value="slant">Slant</option>
            </select>
        </div>
        <div class="mb-3"><label class="form-label">Shape Color</label><input type="color" name="shape_color" class="form-control form-control-color w-100" value="#ffffff"></div>
        <div class="mb-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="shape_is_bottom" id="shape_is_bottom" checked>
                <label class="form-check-label" for="shape_is_bottom">Position at Bottom</label>
            </div>
        </div>
    </div>

    <!-- Product Grid -->
    <div id="tpl-product_grid">
        <div class="mb-3"><label class="form-label">Section Title</label><input type="text" name="title" class="form-control" value="Our Products"></div>
        <div class="mb-3">
            <label class="form-label">Select Products</label>
            <select name="pg_product_ids[]" class="form-select" multiple style="height: 200px;">
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }} - {{ $product->current_price }}৳</option>
                @endforeach
            </select>
            <small class="text-muted">Hold Ctrl/Cmd to select multiple products.</small>
        </div>
    </div>

    <!-- Custom Page -->
    <div id="tpl-custom_page">
        <div class="mb-3"><label class="form-label">Page Title</label><input type="text" name="cp_title" class="form-control" placeholder="e.g. About Us"></div>
        <div class="mb-3">
            <label class="form-label">Page Content (HTML Allowed)</label>
            <textarea name="cp_content" class="form-control" rows="10" placeholder="Write your content here..."></textarea>
        </div>
    </div>

    <!-- Product Hero -->
    <div id="tpl-product_hero">
        <div class="mb-3"><label class="form-label">Hero Title (Leave empty to use Landing Page Title)</label><input type="text" name="ph_title" class="form-control"></div>
        <div class="mb-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="ph_show_video" id="ph_show_video" checked>
                <label class="form-check-label" for="ph_show_video">Show Video (if exists)</label>
            </div>
        </div>
        <div class="mb-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="ph_show_image" id="ph_show_image" checked>
                <label class="form-check-label" for="ph_show_image">Show Feature Image (if no video)</label>
            </div>
        </div>
    </div>

    <!-- Product Price -->
    <div id="tpl-product_price">
        <div class="mb-3"><label class="form-label">Price Box Title</label><input type="text" name="pp_title" class="form-control" value="আজকের বিশেষ দাম:"></div>
    </div>

    <!-- Product Feature List -->
    <div id="tpl-product_feature_list">
        <div id="pfl-list">
            <div class="feature-row d-flex gap-2 mb-2">
                <input type="text" name="pfl_titles[]" class="form-control" placeholder="Feature title" value="কোয়ালিটি নিশ্চিত করে ডেলিভারি" required>
            </div>
            <div class="feature-row d-flex gap-2 mb-2">
                <input type="text" name="pfl_titles[]" class="form-control" placeholder="Feature title" value="সারা বাংলাদেশে হোম ডেলিভারি" required>
            </div>
        </div>
        <button type="button" class="btn btn-sm btn-outline-secondary mt-2" onclick="addPflRow()">+ Add Feature</button>
    </div>
</div>

<!-- Settings Modal -->
<div class="modal fade" id="settingsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Global Page Settings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.landing-pages.builder.update_settings', $landing->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-4">
                        <label class="form-label fw-bold">Page Layout (ফুল কন্টেইনার এবং উইডথ ম্যানেজ)</label>
                        <select name="is_full_width" class="form-select">
                            <option value="1" {{ $landing->is_full_width ? 'selected' : '' }}>Full Width Layout (সম্পূর্ণ বড় হবে)</option>
                            <option value="0" {{ !$landing->is_full_width ? 'selected' : '' }}>Boxed Container (মাঝখানে ফাঁকা থাকবে)</option>
                        </select>
                        <small class="text-muted">কন্টেইনার দিলে সবগুলো কন্টেন্ট একদম মেডেল আইসা পরবো।</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Global Background Color</label>
                        <input type="color" name="bg_color" class="form-control form-control-color w-100" value="{{ $landing->bg_color }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Global Text Color</label>
                        <input type="color" name="text_color" class="form-control form-control-color w-100" value="{{ $landing->text_color }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Global Button Color</label>
                        <input type="color" name="btn_color" class="form-control form-control-color w-100" value="{{ $landing->btn_color }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Settings</button>
                </div>
            </form>
        </div>
    </div>
</div>
        </div>
    </div>
</div>

<script>
    // Bulk Delete Logic
    const selectAll = document.getElementById('selectAllBlocks');
    const bulkDeleteBtn = document.getElementById('btnBulkDelete');
    const checkboxes = document.getElementsByClassName('block-checkbox');

    if (selectAll) {
        selectAll.addEventListener('change', function() {
            Array.from(checkboxes).forEach(cb => cb.checked = this.checked);
            toggleBulkDeleteBtn();
        });
    }

    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('block-checkbox')) {
            toggleBulkDeleteBtn();
        }
    });

    function toggleBulkDeleteBtn() {
        const checkedCount = Array.from(checkboxes).filter(cb => cb.checked).length;
        if (checkedCount > 0) {
            bulkDeleteBtn.classList.remove('d-none');
        } else {
            bulkDeleteBtn.classList.add('d-none');
        }
    }

    function bulkDelete() {
        const selectedIds = Array.from(checkboxes).filter(cb => cb.checked).map(cb => cb.value);
        if (selectedIds.length === 0) return;

        if (confirm('Are you sure you want to delete selected blocks?')) {
            fetch("{{ route('admin.landing-pages.builder.bulk-delete') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ ids: selectedIds })
            }).then(() => location.reload());
        }
    }

    // Sortable
    const sortable = new Sortable(document.getElementById('sortable-blocks'), {
        animation: 150,
        handle: '.block-item',
        onEnd: function (evt) {
            let order = [];
            document.querySelectorAll('.block-item').forEach(el => {
                order.push(el.getAttribute('data-id'));
            });
            
            fetch("{{ route('admin.landing-pages.builder.reorder') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ order: order })
            });
        }
    });

    function addHeaderMenuRow() {
        const row = `<div class="d-flex gap-2 mb-2">
            <input type="text" name="h_menu_titles[]" class="form-control" placeholder="Menu Title">
            <input type="text" name="h_menu_urls[]" class="form-control" placeholder="#">
        </div>`;
        document.getElementById('header-menu-list').insertAdjacentHTML('beforeend', row);
    }

    function addFooterLinkRow() {
        const row = `<div class="d-flex gap-2 mb-2">
            <input type="text" name="f_link_titles[]" class="form-control" placeholder="Link Title">
            <input type="text" name="f_link_urls[]" class="form-control" placeholder="#">
        </div>`;
        document.getElementById('footer-link-list').insertAdjacentHTML('beforeend', row);
    }

    function openForm(type) {
        document.getElementById('blockForm').action = "{{ route('admin.landing-pages.builder.store', $landing->id) }}";
        document.getElementById('methodField').innerHTML = '';
        document.getElementById('blockTypeInput').value = type;
        
        let title = type.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase());
        document.getElementById('formModalTitle').innerText = 'Add ' + title;
        
        let html = document.getElementById('tpl-' + type).innerHTML;
        document.getElementById('formBody').innerHTML = html;

        // Reset Styles to defaults
        document.querySelector('[name="style_variation"]').value = 'style-1';
        document.querySelector('[name="block_bg_color"]').value = '#ffffff';
        document.querySelector('[name="title_color"]').value = '#1a2b6b';
        document.querySelector('[name="text_color"]').value = '#444444';
        document.querySelector('[name="aos_type"]').value = 'fade-up';
        document.querySelector('[name="aos_duration"]').value = '800';
        
        // Hide add modal, show form modal
        var addModalEl = document.getElementById('addBlockModal');
        var addModal = bootstrap.Modal.getInstance(addModalEl) || new bootstrap.Modal(addModalEl);
        addModal.hide();
        var formModal = new bootstrap.Modal(document.getElementById('formModal'));
        formModal.show();
    }

    function editBlock(id, type) {
        fetch(`/admin/landing-pages/builder/block/${id}`)
            .then(res => res.json())
            .then(block => {
                document.getElementById('blockForm').action = `/admin/landing-pages/builder/block/${id}/update`;
                document.getElementById('methodField').innerHTML = ''; // We use POST for simplicity with updates+files
                document.getElementById('blockTypeInput').value = type;
                document.getElementById('formModalTitle').innerText = 'Edit ' + type.replace('_', ' ').toUpperCase();
                
                let html = document.getElementById('tpl-' + type).innerHTML;
                document.getElementById('formBody').innerHTML = html;

                // Populate Content
                for (let key in block.content) {
                    let fieldName = getFieldName(type, key);
                    let field = document.querySelector(`[name="${fieldName}"]`);
                    if (field && field.type !== 'file') {
                        if (field.multiple && Array.isArray(block.content[key])) {
                            Array.from(field.options).forEach(option => {
                                option.selected = block.content[key].includes(option.value.toString()) || block.content[key].includes(parseInt(option.value));
                            });
                        } else {
                            field.value = block.content[key];
                        }
                    }
                }


                // Handle Features/FAQ arrays
                if (type === 'features' && block.content.items) {
                    document.getElementById('feature-list').innerHTML = '';
                    block.content.items.forEach(item => {
                        addFeatureRow(item.title, item.text);
                    });
                }
                if (type === 'faq' && block.content.items) {
                    document.getElementById('faq-list').innerHTML = '';
                    block.content.items.forEach(item => {
                        addFaqRow(item.question, item.answer);
                    });
                }
                if (type === 'product_feature_list' && block.content.items) {
                    document.getElementById('pfl-list').innerHTML = '';
                    block.content.items.forEach(item => {
                        addPflRow(item.title);
                    });
                }

                // Populate Styles
                if (block.content.style_variation) document.querySelector('[name="style_variation"]').value = block.content.style_variation;
                if (block.content.bg_color) document.querySelector('[name="block_bg_color"]').value = block.content.bg_color;
                if (block.content.title_color) document.querySelector('[name="title_color"]').value = block.content.title_color;
                if (block.content.text_color) document.querySelector('[name="text_color"]').value = block.content.text_color;
                if (block.content.aos_type) document.querySelector('[name="aos_type"]').value = block.content.aos_type;
                if (block.content.aos_duration) document.querySelector('[name="aos_duration"]').value = block.content.aos_duration;
                if (block.content.padding) document.querySelector('[name="block_padding"]').value = block.content.padding;

                var formModal = new bootstrap.Modal(document.getElementById('formModal'));
                formModal.show();
            });
    }

    function getFieldName(type, key) {
        const maps = {
            banner: { title: 'banner_title', subtitle: 'banner_subtitle', btn_text: 'banner_btn_text' },
            text_image: { title: 'ti_title', text: 'ti_text', image_position: 'ti_image_position' },
            video: { title: 'v_title', video_url: 'v_url' },
            reviews_slider: { title: 'rs_title' },
            call_to_action: { title: 'cta_title', subtitle: 'cta_subtitle', btn_text: 'cta_btn_text' },
            custom_reviews_slider: { title: 'crs_title' },
            faq: { title: 'faq_title' },
            countdown: { title: 'cd_title', end_time: 'cd_end_time' },
            gallery: { title: 'gal_title' },
            custom_html: { html_content: 'ch_content' },
            whatsapp_button: { phone: 'wa_phone', message: 'wa_message', btn_text: 'wa_btn_text' },
            counter: { title: 'count_title', number: 'count_number', prefix: 'count_prefix', suffix: 'count_suffix' },
            image_compare: { before_label: 'ic_before_label', after_label: 'ic_after_label' },
            dual_button: { btn1_text: 'db_btn1_text', btn1_url: 'db_btn1_url', btn2_text: 'db_btn2_text', btn2_url: 'db_btn2_url', separator: 'db_separator' },
            star_ratings: { title: 'sr_title', rating: 'sr_rating', count: 'sr_count' },
            text_typing: { prefix: 'tt_prefix', strings: 'tt_strings', suffix: 'tt_suffix' },
            elegant_card: { title: 'ec_title', text: 'ec_text', btn_text: 'ec_btn_text', btn_url: 'ec_btn_url' },
            syntax_highlighter: { language: 'sh_lang', code: 'sh_code' },
            ribbon: { text: 'rb_text', position: 'rb_pos', color: 'rb_color' },
            header_classic: { sticky: 'h_sticky', phone: 'h_phone', email: 'h_email' },
            footer_classic: { description: 'f_description', copyright: 'f_copyright', phone: 'f_phone', email: 'f_email', address: 'f_address' },
            section_shape: { shape_type: 'shape_type', shape_color: 'shape_color', is_bottom: 'shape_is_bottom' },
            product_grid: { title: 'title', product_ids: 'pg_product_ids[]' },
            custom_page: { title: 'cp_title', content: 'cp_content' },
            product_hero: { title: 'ph_title', show_video: 'ph_show_video', show_image: 'ph_show_image' },
            product_price: { title: 'pp_title' }
        };
        return maps[type] ? maps[type][key] : key;
    }

    function addFeatureRow(title = '', text = '') {
        let div = document.createElement('div');
        div.className = 'feature-row d-flex gap-2 mb-2';
        div.innerHTML = `<input type="text" name="feature_titles[]" class="form-control" value="${title}" placeholder="Feature title" required> <input type="text" name="feature_texts[]" class="form-control" value="${text}" placeholder="Short description"> <button type="button" class="btn btn-danger" onclick="this.parentElement.remove()">X</button>`;
        document.getElementById('feature-list').appendChild(div);
    }

    function addFaqRow(q = '', a = '') {
        let div = document.createElement('div');
        div.className = 'feature-row mb-2 border p-3 rounded bg-light position-relative';
        div.innerHTML = `<button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1" onclick="this.parentElement.remove()">X</button><input type="text" name="faq_questions[]" class="form-control mb-2" value="${q}" placeholder="Question" required> <textarea name="faq_answers[]" class="form-control" placeholder="Answer..." rows="2">${a}</textarea>`;
        document.getElementById('faq-list').appendChild(div);
    }

    function addPflRow(title = '') {
        let div = document.createElement('div');
        div.className = 'feature-row d-flex gap-2 mb-2';
        div.innerHTML = `<input type="text" name="pfl_titles[]" class="form-control" value="${title}" placeholder="Feature title" required> <button type="button" class="btn btn-danger" onclick="this.parentElement.remove()">X</button>`;
        document.getElementById('pfl-list').appendChild(div);
    }
</script>

@endsection
