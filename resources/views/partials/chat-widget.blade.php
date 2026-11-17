@php
    $chatAdminName = config('chat.admin_name', 'Admin NexaMarket');
    $chatAvatar = config('chat.admin_avatar_url');
    $chatAvatar = is_string($chatAvatar)
        && (str_starts_with($chatAvatar, 'https://') || str_starts_with($chatAvatar, '/storage/'))
        ? $chatAvatar
        : null;
@endphp

@push('styles')
<style>
    .nexa-chat-widget {
        position: fixed;
        z-index: 1100;
        right: 24px;
        bottom: 24px;
        font-family: Arial, sans-serif;
    }

    .nexa-chat-widget .sr-only {
        position: absolute;
        width: 1px;
        height: 1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        clip-path: inset(50%);
    }

    .nexa-chat-toggle {
        position: relative;
        display: grid;
        width: 60px;
        height: 60px;
        place-items: center;
        border: 0;
        border-radius: 50%;
        background: #10244a;
        color: #fff;
        box-shadow: 0 10px 28px rgba(15, 23, 42, .24);
        font-size: 23px;
        cursor: pointer;
        transition: background .2s ease, transform .2s ease;
    }

    .nexa-chat-toggle:hover {
        transform: translateY(-2px);
        background: #1d4ed8;
    }

    .nexa-chat-badge {
        position: absolute;
        top: -3px;
        right: -3px;
        display: grid;
        min-width: 21px;
        height: 21px;
        place-items: center;
        border: 2px solid #fff;
        border-radius: 999px;
        padding: 0 5px;
        background: #ef4444;
        color: #fff;
        font-size: 10px;
        font-weight: 700;
    }

    .nexa-chat-panel {
        position: absolute;
        right: 0;
        bottom: 74px;
        display: flex;
        width: min(370px, calc(100vw - 28px));
        height: min(560px, calc(100dvh - 120px));
        min-height: 360px;
        flex-direction: column;
        overflow: hidden;
        border: 1px solid #dbe3ee;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 20px 60px rgba(15, 23, 42, .22);
    }

    .nexa-chat-panel[hidden] {
        display: none;
    }

    .nexa-chat-header {
        display: flex;
        min-height: 72px;
        align-items: center;
        gap: 12px;
        padding: 12px 15px;
        background: #10244a;
        color: #fff;
    }

    .nexa-chat-avatar {
        display: grid;
        width: 43px;
        height: 43px;
        flex: 0 0 43px;
        place-items: center;
        overflow: hidden;
        border-radius: 50%;
        background: #dbeafe;
        color: #10244a;
        font-size: 17px;
        font-weight: 800;
    }

    .nexa-chat-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .nexa-chat-heading {
        min-width: 0;
        flex: 1;
    }

    .nexa-chat-heading strong {
        display: block;
        overflow: hidden;
        font-size: 14px;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .nexa-chat-status {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-top: 5px;
        color: #cbd5e1;
        font-size: 11px;
    }

    .nexa-chat-status::before {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #94a3b8;
        content: "";
    }

    .nexa-chat-status.is-online::before {
        background: #4ade80;
    }

    .nexa-chat-close {
        display: grid;
        width: 36px;
        height: 36px;
        flex: 0 0 36px;
        place-items: center;
        border: 0;
        border-radius: 50%;
        background: transparent;
        color: #fff;
        font-size: 16px;
        cursor: pointer;
    }

    .nexa-chat-close:hover {
        background: rgba(255, 255, 255, .12);
    }

    .nexa-chat-messages {
        display: flex;
        min-height: 0;
        flex: 1;
        flex-direction: column;
        gap: 10px;
        overflow-y: auto;
        padding: 16px 13px;
        background-color: #f1f5f9;
        background-image: radial-gradient(rgba(148, 163, 184, .18) .7px, transparent .7px);
        background-size: 16px 16px;
        list-style: none;
    }

    .nexa-chat-empty {
        max-width: 250px;
        align-self: center;
        margin: auto;
        border: 1px solid #e2e8f0;
        border-radius: 13px;
        padding: 13px 15px;
        background: #fff;
        color: #64748b;
        font-size: 13px;
        line-height: 1.6;
        text-align: center;
    }

    .nexa-chat-load-older {
        align-self: center;
        border: 0;
        background: transparent;
        color: #1d4ed8;
        font: inherit;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
    }

    .nexa-chat-load-older-item {
        align-self: center;
        padding: 3px 0;
    }

    .nexa-chat-load-older-item[hidden] {
        display: none;
    }

    .nexa-chat-message {
        display: flex;
        max-width: 88%;
        flex-direction: column;
        align-self: flex-start;
        border: 1px solid #e2e8f0;
        border-radius: 13px 13px 13px 4px;
        padding: 9px 11px 6px;
        background: #fff;
        color: #1e293b;
        box-shadow: 0 1px 2px rgba(15, 23, 42, .05);
    }

    .nexa-chat-message.is-user {
        align-self: flex-end;
        border-color: #bfdbfe;
        border-radius: 13px 13px 4px 13px;
        background: #dbeafe;
    }

    .nexa-chat-message p {
        margin: 0;
        overflow-wrap: anywhere;
        font-size: 13px;
        line-height: 1.55;
        white-space: pre-wrap;
    }

    .nexa-chat-message time {
        align-self: flex-end;
        margin-top: 4px;
        color: #64748b;
        font-size: 10px;
    }

    .nexa-chat-notice {
        padding: 7px 12px;
        background: #fff7ed;
        color: #9a3412;
        font-size: 12px;
    }

    .nexa-chat-notice[hidden] {
        display: none;
    }

    .nexa-chat-form {
        display: flex;
        align-items: flex-end;
        gap: 8px;
        border-top: 1px solid #e2e8f0;
        padding: 11px;
        background: #fff;
    }

    .nexa-chat-input {
        min-height: 42px;
        max-height: 100px;
        flex: 1;
        resize: vertical;
        border: 1px solid #cbd5e1;
        border-radius: 11px;
        padding: 10px 11px;
        outline: 0;
        color: #0f172a;
        font: inherit;
        font-size: 13px;
    }

    .nexa-chat-input:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, .12);
    }

    .nexa-chat-send {
        display: grid;
        width: 42px;
        height: 42px;
        flex: 0 0 42px;
        place-items: center;
        border: 0;
        border-radius: 11px;
        background: #1d4ed8;
        color: #fff;
        font-size: 15px;
        cursor: pointer;
    }

    .nexa-chat-send:hover {
        background: #1e40af;
    }

    .nexa-chat-send:disabled {
        opacity: .6;
        cursor: wait;
    }

    @media (max-width: 480px) {
        .nexa-chat-widget {
            right: 14px;
            bottom: 14px;
        }

        .nexa-chat-panel {
            position: fixed;
            right: 8px;
            bottom: 82px;
            width: calc(100vw - 16px);
            height: min(620px, calc(100dvh - 100px));
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .nexa-chat-toggle {
            transition: none;
        }
    }
</style>
@endpush

<div
    class="nexa-chat-widget"
    id="nexa-chat-widget"
    data-messages-url="{{ route('chat.messages') }}"
    data-send-url="{{ route('chat.store') }}"
    data-csrf-token="{{ csrf_token() }}"
    data-admin-name="{{ $chatAdminName }}"
>
    <section class="nexa-chat-panel" id="nexa-chat-panel" aria-label="Percakapan dengan layanan pelanggan" role="dialog" aria-modal="false" hidden>
        <header class="nexa-chat-header">
            <span class="nexa-chat-avatar" aria-hidden="true">
                @if($chatAvatar)
                    <img src="{{ $chatAvatar }}" alt="">
                @else
                    <i class="fa-solid fa-headset"></i>
                @endif
            </span>
            <div class="nexa-chat-heading">
                <strong>{{ $chatAdminName }}</strong>
                <span class="nexa-chat-status" id="nexa-chat-status" aria-live="polite">Memeriksa status...</span>
            </div>
            <button class="nexa-chat-close" id="nexa-chat-close" type="button" aria-label="Tutup chat">
                <i class="fa-solid fa-xmark" aria-hidden="true"></i>
            </button>
        </header>

        <ol class="nexa-chat-messages" id="nexa-chat-messages" aria-live="polite" aria-relevant="additions">
            <li class="nexa-chat-load-older-item" id="nexa-chat-load-older-item" hidden>
                <button class="nexa-chat-load-older" id="nexa-chat-load-older" type="button">Muat pesan sebelumnya</button>
            </li>
            <li class="nexa-chat-empty" id="nexa-chat-empty">
                Selamat datang. Sampaikan pertanyaan Anda, tim kami akan membalas di sini.
            </li>
        </ol>

        <div class="nexa-chat-notice" id="nexa-chat-notice" role="status" hidden></div>

        <form class="nexa-chat-form" id="nexa-chat-form">
            <label class="sr-only" for="nexa-chat-input">Tulis pesan</label>
            <textarea class="nexa-chat-input" id="nexa-chat-input" name="body" placeholder="Tulis pesan..." rows="1" maxlength="5000" required></textarea>
            <button class="nexa-chat-send" type="submit" aria-label="Kirim pesan">
                <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>
            </button>
        </form>
    </section>

    <button
        class="nexa-chat-toggle"
        id="nexa-chat-toggle"
        type="button"
        aria-label="Buka live chat NexaMarket"
        aria-expanded="false"
        aria-controls="nexa-chat-panel"
    >
        <i class="fa-regular fa-comments" aria-hidden="true"></i>
        <span class="nexa-chat-badge" id="nexa-chat-badge" aria-label="Pesan baru" hidden></span>
    </button>
</div>

@push('scripts')
<script>
    (() => {
        const widget = document.getElementById('nexa-chat-widget');
        if (!widget) return;

        const panel = document.getElementById('nexa-chat-panel');
        const toggle = document.getElementById('nexa-chat-toggle');
        const closeButton = document.getElementById('nexa-chat-close');
        const messages = document.getElementById('nexa-chat-messages');
        const emptyState = document.getElementById('nexa-chat-empty');
        const loadOlderItem = document.getElementById('nexa-chat-load-older-item');
        const loadOlderButton = document.getElementById('nexa-chat-load-older');
        const status = document.getElementById('nexa-chat-status');
        const notice = document.getElementById('nexa-chat-notice');
        const badge = document.getElementById('nexa-chat-badge');
        const form = document.getElementById('nexa-chat-form');
        const input = document.getElementById('nexa-chat-input');
        const sendButton = form.querySelector('button[type="submit"]');
        let lastMessageId = 0;
        let oldestMessageId = 0;
        let unreadCount = 0;
        let pollInProgress = false;

        const requestHeaders = {
            Accept: 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': widget.dataset.csrfToken,
        };

        const setAdminStatus = (online) => {
            status.textContent = online ? 'Online' : 'Offline · pesan tetap diterima';
            status.classList.toggle('is-online', online);
        };

        const updateBadge = () => {
            badge.textContent = unreadCount > 9 ? '9+' : String(unreadCount);
            badge.hidden = unreadCount === 0;
            toggle.setAttribute('aria-label', unreadCount > 0
                ? `Buka live chat, ${unreadCount} balasan baru`
                : 'Buka live chat NexaMarket');
        };

        const appendMessage = (message, prepend = false) => {
            if (messages.querySelector(`[data-message-id="${message.id}"]`)) return;
            emptyState?.remove();

            const item = document.createElement('li');
            item.className = `nexa-chat-message${message.sender_role === 'user' ? ' is-user' : ''}`;
            item.dataset.messageId = String(message.id);

            const body = document.createElement('p');
            body.textContent = message.body;
            item.appendChild(body);

            const time = document.createElement('time');
            time.dateTime = message.sent_at || '';
            time.textContent = message.sent_at
                ? new Date(message.sent_at).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })
                : '';
            item.appendChild(time);
            if (prepend) {
                const firstMessage = messages.querySelector('.nexa-chat-message');
                messages.insertBefore(item, firstMessage || null);
            } else {
                messages.appendChild(item);
            }
        };

        const pollMessages = async (markRead = !panel.hidden) => {
            if (pollInProgress) return;
            pollInProgress = true;
            const query = new URLSearchParams({ mark_read: markRead ? '1' : '0' });
            if (lastMessageId > 0) query.set('after_id', String(lastMessageId));

            try {
                const response = await fetch(`${widget.dataset.messagesUrl}?${query}`, {
                    headers: { Accept: 'application/json' },
                    credentials: 'same-origin',
                });
                if (!response.ok) throw new Error('Chat tidak dapat diperbarui.');

                const data = await response.json();
                setAdminStatus(Boolean(data.admin_online));
                if (typeof data.has_more === 'boolean') loadOlderItem.hidden = !data.has_more;

                for (const message of data.messages) {
                    appendMessage(message);
                    lastMessageId = Math.max(lastMessageId, Number(message.id));
                    oldestMessageId = oldestMessageId === 0
                        ? Number(message.id)
                        : Math.min(oldestMessageId, Number(message.id));
                    if (message.sender_role === 'admin' && !message.read_at && panel.hidden) unreadCount += 1;
                }

                updateBadge();
                notice.hidden = true;
                if (!panel.hidden && data.messages.length > 0) {
                    messages.scrollTop = messages.scrollHeight;
                }
            } catch {
                status.textContent = 'Koneksi terganggu';
                status.classList.remove('is-online');
            } finally {
                pollInProgress = false;
            }
        };

        const setPanelOpen = (open) => {
            panel.hidden = !open;
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            if (open) {
                unreadCount = 0;
                updateBadge();
                pollMessages(true);
                input.focus();
            }
        };

        toggle.addEventListener('click', () => setPanelOpen(panel.hidden));
        closeButton.addEventListener('click', () => setPanelOpen(false));

        loadOlderButton.addEventListener('click', async () => {
            if (!oldestMessageId) return;
            const previousHeight = messages.scrollHeight;
            const query = new URLSearchParams({
                before_id: String(oldestMessageId),
                mark_read: '1',
            });

            try {
                const response = await fetch(`${widget.dataset.messagesUrl}?${query}`, {
                    headers: { Accept: 'application/json' },
                    credentials: 'same-origin',
                });
                if (!response.ok) throw new Error('Riwayat pesan tidak dapat dimuat.');
                const data = await response.json();
                for (const message of [...data.messages].reverse()) {
                    appendMessage(message, true);
                    oldestMessageId = Math.min(oldestMessageId, Number(message.id));
                }
                loadOlderItem.hidden = !data.has_more;
                messages.scrollTop += messages.scrollHeight - previousHeight;
            } catch (error) {
                notice.textContent = error.message || 'Riwayat pesan tidak dapat dimuat.';
                notice.hidden = false;
            }
        });

        form.addEventListener('submit', async (event) => {
            event.preventDefault();
            const body = input.value.trim();
            if (!body) {
                input.focus();
                return;
            }

            sendButton.disabled = true;
            notice.hidden = true;

            try {
                const response = await fetch(widget.dataset.sendUrl, {
                    method: 'POST',
                    headers: requestHeaders,
                    credentials: 'same-origin',
                    body: JSON.stringify({ body }),
                });

                if (!response.ok) {
                    const data = await response.json().catch(() => ({}));
                    throw new Error(data.errors?.body?.[0] || 'Pesan gagal dikirim. Silakan coba lagi.');
                }

                const data = await response.json();
                appendMessage(data.message);
                lastMessageId = Math.max(lastMessageId, Number(data.message.id));
                input.value = '';
                messages.scrollTop = messages.scrollHeight;
            } catch (error) {
                notice.textContent = error.message || 'Koneksi terganggu. Pesan belum terkirim.';
                notice.hidden = false;
            } finally {
                sendButton.disabled = false;
                input.focus();
            }
        });

        input.addEventListener('keydown', (event) => {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                form.requestSubmit();
            }
        });

        pollMessages(false);
        window.setInterval(() => pollMessages(!panel.hidden), 5000);
    })();
</script>
@endpush
