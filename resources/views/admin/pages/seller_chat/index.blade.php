@extends('admin.master')

@section('main-content')
<style>
    .chat-wrapper {
        display: flex;
        height: calc(100vh - 120px);
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        overflow: hidden;
        margin-top: 20px;
    }
    .chat-sidebar {
        width: 300px;
        border-right: 1px solid #e2e8f0;
        display: flex;
        flex-direction: column;
    }
    .chat-sidebar-header {
        padding: 15px;
        border-bottom: 1px solid #e2e8f0;
        background: #f8fafc;
    }
    .seller-list {
        flex: 1;
        overflow-y: auto;
    }
    .seller-item {
        padding: 15px;
        border-bottom: 1px solid #f1f5f9;
        cursor: pointer;
        transition: background 0.2s;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .seller-item:hover, .seller-item.active {
        background: #e0f2fe;
    }
    .seller-item img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #ccc;
    }
    .seller-item-info {
        flex: 1;
    }
    .seller-item-name {
        margin: 0;
        font-weight: 600;
        font-size: 14px;
        color: #1e293b;
    }
    .chat-window {
        flex: 1;
        display: flex;
        flex-direction: column;
        background: #f1f5f9;
    }
    .chat-header {
        padding: 15px 20px;
        background: white;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .chat-messages {
        flex: 1;
        padding: 20px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    .message {
        max-width: 70%;
        padding: 12px 16px;
        border-radius: 12px;
        font-size: 14px;
        position: relative;
    }
    .message.admin {
        align-self: flex-end;
        background: #3b82f6;
        color: white;
        border-bottom-right-radius: 2px;
    }
    .message.seller {
        align-self: flex-start;
        background: white;
        color: #1e293b;
        border-bottom-left-radius: 2px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.02);
    }
    .message img {
        max-width: 250px;
        max-height: 250px;
        object-fit: contain;
        border-radius: 8px;
        margin-top: 8px;
        background: #f8fafc;
        padding: 4px;
        border: 1px solid #e2e8f0;
    }
    .message-time {
        font-size: 11px;
        opacity: 0.7;
        margin-top: 5px;
        display: block;
        text-align: right;
    }
    .chat-input {
        padding: 15px 20px;
        background: white;
        border-top: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .chat-input input[type="text"] {
        flex: 1;
        padding: 10px 15px;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        outline: none;
    }
    .chat-input input[type="file"] {
        display: none;
    }
    .attach-btn, .send-btn {
        background: none;
        border: none;
        font-size: 20px;
        color: #64748b;
        cursor: pointer;
    }
    .send-btn {
        color: #3b82f6;
    }
    #image-preview-container {
        display: none;
        padding: 10px 20px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
    }
    #image-preview {
        max-height: 60px;
        border-radius: 5px;
    }
    .no-chat-selected {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
    }
</style>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Seller Live Chat</h1>
        </div>
    </div>
    
    <section class="content">
        <div class="container-fluid">
            <div class="chat-wrapper">
                
                <!-- Left Sidebar: Sellers List -->
                <div class="chat-sidebar">
                    <div class="chat-sidebar-header">
                        <h5 class="m-0">Conversations</h5>
                    </div>
                    <div class="seller-list">
                        @foreach($sellers as $seller)
                        @php
                            $unread = \App\Models\SellerAdminChat::where('seller_id', $seller->id)
                                        ->where('sender', 'seller')
                                        ->where('is_read', false)
                                        ->count();
                        @endphp
                        <div class="seller-item" onclick="openChat({{ $seller->id }}, '{{ addslashes($seller->name) }}', '{{ $seller->photo_url }}')">
                            <img src="{{ $seller->photo_url }}" alt="Seller">
                            <div class="seller-item-info">
                                <h4 class="seller-item-name">{{ $seller->name }}</h4>
                            </div>
                            @if($unread > 0)
                                <span class="badge rounded-pill bg-danger">{{ $unread }}</span>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Right Window: Chat Area -->
                <div class="chat-window" id="chat-window" style="display:none;">
                    <div class="chat-header">
                        <img id="current-seller-img" src="https://via.placeholder.com/40" style="width:40px; border-radius:50%;" alt="">
                        <h5 class="m-0" id="current-seller-name">Seller Name</h5>
                    </div>
                    
                    <div class="chat-messages" id="chat-box">
                        <!-- Messages loaded via AJAX -->
                    </div>

                    <div id="image-preview-container">
                        <div class="d-flex align-items-center justify-content-between">
                            <img id="image-preview" src="" alt="preview">
                            <button type="button" class="btn-close" onclick="removeImage()"></button>
                        </div>
                    </div>
                    
                    <form class="chat-input" id="chat-form">
                        <input type="hidden" id="active-seller-id" name="seller_id" value="">
                        
                        <label for="image-upload" class="attach-btn" title="Attach Image">
                            <i class="bi bi-paperclip"></i>
                        </label>
                        <input type="file" id="image-upload" name="image" accept="image/*" onchange="previewImage(this)">
                        
                        <input type="text" name="message" id="message-input" placeholder="Type a message...">
                        
                        <button type="submit" class="send-btn">
                            <i class="bi bi-send-fill"></i>
                        </button>
                    </form>
                </div>
                
                <div class="no-chat-selected" id="no-chat">
                    <i class="bi bi-chat-dots fs-1 mb-3"></i>
                    <h4>Select a seller to start chatting</h4>
                </div>

            </div>
        </div>
    </section>
</div>

<script>
    let currentSellerId = null;
    let chatInterval = null;
    let lastMessageCount = 0;
    const msgSound = new Audio('https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3');

    function openChat(sellerId, sellerName, sellerImage) {
        currentSellerId = sellerId;
        lastMessageCount = 0; // reset on seller change
        document.getElementById('active-seller-id').value = sellerId;
        document.getElementById('current-seller-name').innerText = sellerName;
        document.getElementById('current-seller-img').src = sellerImage;
        
        document.getElementById('no-chat').style.display = 'none';
        document.getElementById('chat-window').style.display = 'flex';
        
        loadMessages();
        
        if (chatInterval) clearInterval(chatInterval);
        chatInterval = setInterval(loadMessages, 3000);
    }

    function loadMessages() {
        if(!currentSellerId) return;
        
        fetch(`/admin/seller-chats/${currentSellerId}`)
            .then(res => res.json())
            .then(messages => {
                const chatBox = document.getElementById('chat-box');
                chatBox.innerHTML = '';
                
                // Play sound if new message arrived
                if (messages.length > lastMessageCount && lastMessageCount !== 0) {
                    let lastMsg = messages[messages.length - 1];
                    if(lastMsg.sender === 'seller') {
                        msgSound.play().catch(e => console.log('Audio play failed:', e));
                    }
                }
                lastMessageCount = messages.length;

                messages.forEach(msg => {
                    let time = new Date(msg.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                    let content = '';
                    if (msg.message) content += `<div>${msg.message}</div>`;
                    if (msg.image) content += `<img src="/${msg.image}" alt="attachment">`;
                    
                    let msgClass = msg.sender === 'admin' ? 'admin' : 'seller';
                    
                    chatBox.innerHTML += `
                        <div class="message ${msgClass}">
                            ${content}
                            <span class="message-time">${time}</span>
                        </div>
                    `;
                });
                // only scroll down if we just loaded or sent a new msg
                chatBox.scrollTop = chatBox.scrollHeight;
            });
    }

    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('image-preview').src = e.target.result;
                document.getElementById('image-preview-container').style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function removeImage() {
        document.getElementById('image-upload').value = '';
        document.getElementById('image-preview-container').style.display = 'none';
    }

    document.getElementById('chat-form').addEventListener('submit', function(e) {
        e.preventDefault();
        if(!currentSellerId) return;

        let formData = new FormData(this);
        let csrfToken = '{{ csrf_token() }}';
        
        // Add loading state to button
        let sendBtn = this.querySelector('.send-btn');
        sendBtn.disabled = true;
        sendBtn.innerHTML = '<i class="bi bi-hourglass-split"></i>';
        
        fetch('{{ route("admin.seller_chat.send") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(async res => {
            if(!res.ok) {
                let data = await res.json();
                throw new Error(data.message || 'Error occurred');
            }
            return res.json();
        })
        .then(data => {
            if(data.success) {
                document.getElementById('message-input').value = '';
                removeImage();
                loadMessages();
            }
        })
        .catch(err => {
            console.error(err);
            alert("Failed to send message: " + err.message);
        })
        .finally(() => {
            sendBtn.disabled = false;
            sendBtn.innerHTML = '<i class="bi bi-send-fill"></i>';
        });
    });
</script>
@endsection
