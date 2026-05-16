@extends('saller.master')

@section('main-content')
<style>
    .chat-container {
        display: flex;
        flex-direction: column;
        height: calc(100vh - 120px);
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .chat-header {
        padding: 15px 20px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .chat-header img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
    }
    .chat-messages {
        flex: 1;
        padding: 20px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 15px;
        background: #f1f5f9;
    }
    .message {
        max-width: 70%;
        padding: 12px 16px;
        border-radius: 12px;
        font-size: 14px;
        position: relative;
    }
    .message.seller {
        align-self: flex-end;
        background: #3b82f6;
        color: white;
        border-bottom-right-radius: 2px;
    }
    .message.admin {
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
        transition: color 0.2s;
    }
    .send-btn {
        color: #3b82f6;
    }
    .attach-btn:hover, .send-btn:hover {
        color: #1e293b;
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
</style>

<div class="main-content">
    <div class="page-content">
        <div class="chat-container">
            <div class="chat-header">
                <i class="bi bi-headset fs-3 text-primary"></i>
                <div>
                    <h5 class="m-0">Admin Support</h5>
                    <small class="text-success">Online</small>
                </div>
            </div>
            
            <div class="chat-messages" id="chat-box">
                <!-- Messages will be loaded here via AJAX -->
            </div>

            <div id="image-preview-container">
                <div class="d-flex align-items-center justify-content-between">
                    <img id="image-preview" src="" alt="preview">
                    <button type="button" class="btn-close" onclick="removeImage()"></button>
                </div>
            </div>

            <form class="chat-input" id="chat-form">
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
    </div>
</div>

<script>
    let lastMessageCount = 0;
    const msgSound = new Audio('https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3');

    function loadMessages() {
        fetch('{{ route("saller.chat.messages") }}')
            .then(res => res.json())
            .then(messages => {
                const chatBox = document.getElementById('chat-box');
                chatBox.innerHTML = '';
                
                // Play sound if new message arrived
                if (messages.length > lastMessageCount && lastMessageCount !== 0) {
                    let lastMsg = messages[messages.length - 1];
                    if(lastMsg.sender === 'admin') {
                        msgSound.play().catch(e => console.log('Audio play failed:', e));
                    }
                }
                lastMessageCount = messages.length;

                messages.forEach(msg => {
                    let time = new Date(msg.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                    let content = '';
                    if (msg.message) content += `<div>${msg.message}</div>`;
                    if (msg.image) content += `<img src="/${msg.image}" alt="attachment">`;
                    
                    let msgClass = msg.sender === 'seller' ? 'seller' : 'admin';
                    
                    chatBox.innerHTML += `
                        <div class="message ${msgClass}">
                            ${content}
                            <span class="message-time">${time}</span>
                        </div>
                    `;
                });
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
        let formData = new FormData(this);
        let csrfToken = '{{ csrf_token() }}';
        
        // Add loading state to button
        let sendBtn = this.querySelector('.send-btn');
        sendBtn.disabled = true;
        sendBtn.innerHTML = '<i class="bi bi-hourglass-split"></i>';
        
        fetch('{{ route("saller.chat.send") }}', {
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

    // Load initially and poll every 3 seconds
    loadMessages();
    setInterval(loadMessages, 3000);
</script>
@endsection
