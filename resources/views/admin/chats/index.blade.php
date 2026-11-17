@extends('layouts.admin')

@section('title', 'Live Chat - NexaMarket')

@push('styles')
<style>
    .admin-chat-page {
        max-width: 1240px;
        margin: 0 auto;
    }

    .admin-chat-page .sr-only {
        position: absolute;
        width: 1px;
        height: 1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        clip-path: inset(50%);
    }

    .admin-chat-heading {
        margin-bottom: 20px;
    }

    .admin-chat-heading h1 {
        margin-bottom: 6px;
        color: #102448;
        font-size: clamp(24px, 4vw, 32px);
        letter-spacing: -.03em;
    }

    .admin-chat-heading p {
        color: #64748b;
        font-size: 14px;
    }

    .admin-chat-notice {
        margin-bottom: 14px;
        border: 1px solid #fecaca;
        border-radius: 9px;
        padding: 11px 14px;
        background: #fef2f2;
        color: #b91c1c;
        font-size: 13px;
    }

    .admin-chat-notice[hidden] {
        display: none;
    }

    .admin-chat-shell {
        display: grid;
        min-height: 620px;
        grid-template-columns: minmax(245px, 310px) minmax(0, 1fr);
        overflow: hidden;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 10px 28px rgba(15, 23, 42, .05);
    }

    .admin-chat-list-panel {
        display: flex;
        min-width: 0;
        flex-direction: column;
        border-right: 1px solid #e2e8f0;
    }

    .admin-chat-list-heading {
        padding: 17px 15px 13px;
    }

    .admin-chat-list-heading h2 {
        margin-bottom: 13px;
        color: #102448;
        font-size: 16px;
    }

    .admin-chat-filters {
        display: flex;
        gap: 7px;
    }

    .admin-chat-filter {
        min-height: 31px;
        border: 1px solid #e2e8f0;
        border-radius: 999px;
        padding: 0 10px;
        background: #fff;
        color: #64748b;
        font: inherit;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
    }

    .admin-chat-filter.is-active {
        border-color: #bfdbfe;
        background: #eff6ff;
        color: #1d4ed8;
    }

    .admin-chat-conversations {
        min-height: 0;
        flex: 1;
        overflow-y: auto;
        border-top: 1px solid #f1f5f9;
    }

    .admin-chat-conversation {
        display: grid;
        width: 100%;
        grid-template-columns: 39px minmax(0, 1fr) auto;
        align-items: center;
        gap: 10px;
        border: 0;
        border-bottom: 1px solid #f1f5f9;
        padding: 13px 12px;
        background: #fff;
        color: #334155;
        text-align: left;
        cursor: pointer;
    }

    .admin-chat-conversation:hover,
    .admin-chat-conversation.is-active {
        background: #f8fafc;
    }

    .admin-chat-conversation.is-active {
        box-shadow: inset 3px 0 #2563eb;
    }

    .admin-chat-customer-avatar {
        display: grid;
        width: 39px;
        height: 39px;
        place-items: center;
        border-radius: 50%;
        background: #dbeafe;
        color: #102448;
        font-size: 14px;
        font-weight: 800;
    }

    .admin-chat-customer {
        min-width: 0;
    }

    .admin-chat-customer strong,
    .admin-chat-customer small,
    .admin-chat-customer p {
        display: block;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .admin-chat-customer strong {
        margin-bottom: 3px;
        color: #1e293b;
        font-size: 12px;
    }

    .admin-chat-customer small {
        margin-bottom: 4px;
        color: #94a3b8;
        font-size: 10px;
    }

    .admin-chat-customer p {
        color: #64748b;
        font-size: 11px;
    }

    .admin-chat-conversation-meta {
        display: grid;
        justify-items: end;
        gap: 6px;
        color: #94a3b8;
        font-size: 10px;
    }

    .admin-chat-unread {
        display: grid;
        min-width: 19px;
        height: 19px;
        place-items: center;
        border-radius: 999px;
        padding: 0 5px;
        background: #2563eb;
        color: #fff;
        font-size: 10px;
        font-weight: 700;
    }

    .admin-chat-empty-list {
        padding: 22px 15px;
        color: #94a3b8;
        font-size: 12px;
        line-height: 1.6;
        text-align: center;
    }

    .admin-chat-thread {
        display: flex;
        min-width: 0;
        min-height: 0;
        flex-direction: column;
        background: #f8fafc;
    }

    .admin-chat-thread-header {
        display: flex;
        min-height: 67px;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        border-bottom: 1px solid #e2e8f0;
        padding: 12px 17px;
        background: #fff;
    }

    .admin-chat-thread-header strong {
        display: block;
        margin-bottom: 4px;
        color: #102448;
        font-size: 14px;
    }

    .admin-chat-thread-header span {
        color: #64748b;
        font-size: 11px;
    }

    .admin-chat-messages {
        display: flex;
        min-height: 0;
        flex: 1;
        flex-direction: column;
        gap: 10px;
        overflow-y: auto;
        padding: 20px 16px;
        background-color: #f1f5f9;
        background-image: radial-gradient(rgba(148, 163, 184, .16) .7px, transparent .7px);
        background-size: 16px 16px;
        list-style: none;
    }

    .admin-chat-thread-empty {
        margin: auto;
        color: #94a3b8;
        font-size: 13px;
        text-align: center;
    }

    .admin-chat-load-older-item {
        align-self: center;
        padding: 3px 0;
    }

    .admin-chat-load-older-item[hidden] {
        display: none;
    }

    .admin-chat-load-older {
        border: 0;
        background: transparent;
        color: #1d4ed8;
        font: inherit;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
    }

    .admin-chat-message {
        display: flex;
        max-width: min(78%, 560px);
        flex-direction: column;
        align-self: flex-start;
        border: 1px solid #e2e8f0;
        border-radius: 12px 12px 12px 4px;
        padding: 10px 12px 7px;
        background: #fff;
        color: #1e293b;
        box-shadow: 0 1px 2px rgba(15, 23, 42, .04);
    }

    .admin-chat-message.is-admin {
        align-self: flex-end;
        border-color: #bfdbfe;
        border-radius: 12px 12px 4px 12px;
        background: #dbeafe;
    }

    .admin-chat-message p {
        margin: 0;
        overflow-wrap: anywhere;
        font-size: 13px;
        line-height: 1.55;
        white-space: pre-wrap;
    }

    .admin-chat-message time {
        align-self: flex-end;
        margin-top: 5px;
        color: #64748b;
        font-size: 10px;
    }

    .admin-chat-reply {
        display: flex;
        align-items: flex-end;
        gap: 10px;
        border-top: 1px solid #e2e8f0;
        padding: 12px;
        background: #fff;
    }

    .admin-chat-reply textarea {
        min-height: 42px;
        max-height: 120px;
        flex: 1;
        resize: vertical;
        border: 1px solid #cbd5e1;
        border-radius: 9px;
        padding: 10px 11px;
        outline: 0;
        color: #0f172a;
        font: inherit;
        font-size: 13px;
    }

    .admin-chat-reply textarea:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, .12);
    }

    .admin-chat-reply button {
        display: inline-flex;
        min-height: 42px;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border: 0;
        border-radius: 9px;
        padding: 0 14px;
        background: #102448;
        color: #fff;
        font: inherit;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
    }

    .admin-chat-reply button:hover {
        background: #1d4ed8;
    }

    .admin-chat-reply button:disabled {
        opacity: .6;
        cursor: wait;
    }

    .admin-chat-reply[hidden] {
        display: none;
    }

    @media (max-width: 760px) {
        .admin-chat-shell {
            min-height: 650px;
            grid-template-columns: 1fr;
            grid-template-rows: 220px minmax(380px, 1fr);
        }

        .admin-chat-list-panel {
            border-right: 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .admin-chat-list-heading {
            padding: 12px;
        }

        .admin-chat-list-heading h2 {
            margin-bottom: 8px;
        }

        .admin-chat-conversation {
            padding: 9px 11px;
        }

    }

    @media (prefers-reduced-motion: reduce) {
        .admin-chat-filter {
            scroll-behavior: auto;
        }
    }
</style>
@endpush

@section('admin-content')
@php
    $initialConversationId = $conversations->first()?->id;
@endphp
<section
    class="admin-chat-page"
    id="admin-chat-page"
    data-list-url="{{ route('admin.chats.conversations') }}"
    data-messages-template="{{ route('admin.chats.messages', ['conversation' => '__CONVERSATION__']) }}"
    data-reply-template="{{ route('admin.chats.store', ['conversation' => '__CONVERSATION__']) }}"
    data-csrf-token="{{ csrf_token() }}"
    data-selected-id="{{ $initialConversationId ?? '' }}"
>
    <header class="admin-chat-heading">
        <h1>Live Chat</h1>
        <p>Kelola percakapan dan balas pertanyaan pelanggan secara langsung.</p>
    </header>

    <div class="admin-chat-notice" id="admin-chat-notice" role="status" hidden></div>

    <div class="admin-chat-shell">
        <aside class="admin-chat-list-panel" aria-label="Daftar percakapan">
            <div class="admin-chat-list-heading">
                <h2>Percakapan</h2>
                <div class="admin-chat-filters" role="group" aria-label="Filter percakapan">
                    <button class="admin-chat-filter {{ $filter === 'all' ? 'is-active' : '' }}" type="button" data-chat-filter="all">Semua</button>
                    <button class="admin-chat-filter {{ $filter === 'unanswered' ? 'is-active' : '' }}" type="button" data-chat-filter="unanswered">Belum dibalas</button>
                </div>
            </div>
            <div class="admin-chat-conversations" id="admin-chat-conversations" aria-live="polite">
                @forelse($conversations as $conversation)
                    <button
                        class="admin-chat-conversation {{ $conversation->id === $initialConversationId ? 'is-active' : '' }}"
                        type="button"
                        data-conversation-id="{{ $conversation->id }}"
                    >
                        <span class="admin-chat-customer-avatar" aria-hidden="true">{{ mb_strtoupper(mb_substr($conversation->user->name, 0, 1)) }}</span>
                        <span class="admin-chat-customer">
                            <strong>{{ $conversation->user->name }}</strong>
                            <small>{{ $conversation->user->email }}</small>
                            <p>{{ $conversation->latestMessage?->body ?? 'Belum ada pesan' }}</p>
                        </span>
                        <span class="admin-chat-conversation-meta">
                            <time>{{ $conversation->latestMessage?->created_at?->format('H:i') }}</time>
                            @if($conversation->unread_count > 0)
                                <span class="admin-chat-unread">{{ $conversation->unread_count }}</span>
                            @endif
                        </span>
                    </button>
                @empty
                    <p class="admin-chat-empty-list">Belum ada percakapan masuk.</p>
                @endforelse
            </div>
        </aside>

        <section class="admin-chat-thread" aria-label="Isi percakapan">
            <header class="admin-chat-thread-header">
                <div>
                    <strong id="admin-chat-customer-name">{{ $conversations->first()?->user?->name ?? 'Pilih percakapan' }}</strong>
                    <span id="admin-chat-customer-email">{{ $conversations->first()?->user?->email ?? 'Pesan pelanggan akan tampil di sini' }}</span>
                </div>
            </header>

            <ol class="admin-chat-messages" id="admin-chat-messages" aria-live="polite" aria-relevant="additions">
                <li class="admin-chat-load-older-item" id="admin-chat-load-older-item" hidden>
                    <button class="admin-chat-load-older" id="admin-chat-load-older" type="button">Muat pesan sebelumnya</button>
                </li>
                <li class="admin-chat-thread-empty" id="admin-chat-thread-empty">
                    Pilih percakapan untuk membaca pesan.
                </li>
            </ol>

            <form class="admin-chat-reply" id="admin-chat-reply" hidden>
                <label class="sr-only" for="admin-chat-reply-input">Tulis balasan</label>
                <textarea id="admin-chat-reply-input" name="body" placeholder="Tulis balasan..." rows="1" maxlength="5000" required></textarea>
                <button type="submit"><i class="fa-solid fa-paper-plane" aria-hidden="true"></i> Kirim</button>
            </form>
        </section>
    </div>
</section>
@endsection

@push('scripts')
<script>
    (() => {
        const page = document.getElementById('admin-chat-page');
        if (!page) return;

        const list = document.getElementById('admin-chat-conversations');
        const thread = document.getElementById('admin-chat-messages');
        const threadEmpty = document.getElementById('admin-chat-thread-empty');
        const loadOlderItem = document.getElementById('admin-chat-load-older-item');
        const loadOlderButton = document.getElementById('admin-chat-load-older');
        const customerName = document.getElementById('admin-chat-customer-name');
        const customerEmail = document.getElementById('admin-chat-customer-email');
        const replyForm = document.getElementById('admin-chat-reply');
        const replyInput = document.getElementById('admin-chat-reply-input');
        const replyButton = replyForm.querySelector('button[type="submit"]');
        const notice = document.getElementById('admin-chat-notice');
        const filterButtons = [...page.querySelectorAll('[data-chat-filter]')];
        let selectedConversationId = page.dataset.selectedId || null;
        let lastMessageId = 0;
        let oldestMessageId = 0;
        let activeFilter = page.querySelector('[data-chat-filter].is-active')?.dataset.chatFilter || 'all';
        let pollInProgress = false;

        const requestHeaders = {
            Accept: 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': page.dataset.csrfToken,
        };

        const formatTime = (value) => value
            ? new Date(value).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })
            : '';

        const routeFor = (template, id) => template.replace('__CONVERSATION__', encodeURIComponent(id));

        const showNotice = (message) => {
            notice.textContent = message;
            notice.hidden = false;
        };

        const appendMessage = (message, prepend = false) => {
            if (thread.querySelector(`[data-message-id="${message.id}"]`)) return;
            threadEmpty?.remove();

            const item = document.createElement('li');
            item.className = `admin-chat-message${message.sender_role === 'admin' ? ' is-admin' : ''}`;
            item.dataset.messageId = String(message.id);

            const body = document.createElement('p');
            body.textContent = message.body;
            item.appendChild(body);

            const time = document.createElement('time');
            time.dateTime = message.sent_at || '';
            time.textContent = formatTime(message.sent_at);
            item.appendChild(time);
            if (prepend) {
                const firstMessage = thread.querySelector('.admin-chat-message');
                thread.insertBefore(item, firstMessage || null);
            } else {
                thread.appendChild(item);
            }
        };

        const renderConversations = (conversations) => {
            list.replaceChildren();

            if (conversations.length === 0) {
                const empty = document.createElement('p');
                empty.className = 'admin-chat-empty-list';
                empty.textContent = activeFilter === 'unanswered'
                    ? 'Tidak ada percakapan yang menunggu balasan.'
                    : 'Belum ada percakapan masuk.';
                list.appendChild(empty);
                selectedConversationId = null;
                lastMessageId = 0;
                oldestMessageId = 0;
                customerName.textContent = 'Pilih percakapan';
                customerEmail.textContent = 'Pesan pelanggan akan tampil di sini';
                replyForm.hidden = true;
                loadOlderItem.hidden = true;
                const emptyThread = document.createElement('li');
                emptyThread.className = 'admin-chat-thread-empty';
                emptyThread.textContent = 'Pilih percakapan untuk membaca pesan.';
                thread.replaceChildren(loadOlderItem, emptyThread);
                return;
            }

            for (const conversation of conversations) {
                const button = document.createElement('button');
                button.type = 'button';
                button.className = `admin-chat-conversation${String(conversation.id) === String(selectedConversationId) ? ' is-active' : ''}`;
                button.dataset.conversationId = String(conversation.id);

                const avatar = document.createElement('span');
                avatar.className = 'admin-chat-customer-avatar';
                avatar.setAttribute('aria-hidden', 'true');
                avatar.textContent = [...conversation.customer_name][0]?.toLocaleUpperCase('id-ID') || '?';

                const customer = document.createElement('span');
                customer.className = 'admin-chat-customer';
                const name = document.createElement('strong');
                name.textContent = conversation.customer_name;
                const email = document.createElement('small');
                email.textContent = conversation.customer_email;
                const preview = document.createElement('p');
                preview.textContent = conversation.latest_body || 'Belum ada pesan';
                customer.append(name, email, preview);

                const meta = document.createElement('span');
                meta.className = 'admin-chat-conversation-meta';
                const time = document.createElement('time');
                time.textContent = formatTime(conversation.latest_sent_at);
                meta.appendChild(time);
                if (conversation.unread_count > 0) {
                    const unread = document.createElement('span');
                    unread.className = 'admin-chat-unread';
                    unread.textContent = String(conversation.unread_count);
                    meta.appendChild(unread);
                }

                button.append(avatar, customer, meta);
                button.addEventListener('click', () => selectConversation(conversation));
                list.appendChild(button);
            }

            if (!conversations.some((conversation) => String(conversation.id) === String(selectedConversationId))) {
                selectedConversationId = String(conversations[0].id);
                selectConversation(conversations[0]);
            }
        };

        const refreshConversationList = async () => {
            const query = new URLSearchParams({ filter: activeFilter });
            const response = await fetch(`${page.dataset.listUrl}?${query}`, {
                headers: { Accept: 'application/json' },
                credentials: 'same-origin',
            });
            if (!response.ok) throw new Error('Daftar percakapan tidak dapat diperbarui.');
            const data = await response.json();
            renderConversations(data.conversations);
        };

        const loadMessages = async (cursor = null, direction = 'after') => {
            if (!selectedConversationId) return;
            const query = new URLSearchParams({ mark_read: '1' });
            if (cursor !== null) query.set(direction === 'before' ? 'before_id' : 'after_id', String(cursor));

            const response = await fetch(`${routeFor(page.dataset.messagesTemplate, selectedConversationId)}?${query}`, {
                headers: { Accept: 'application/json' },
                credentials: 'same-origin',
            });
            if (!response.ok) throw new Error('Pesan percakapan tidak dapat dimuat.');
            const data = await response.json();
            if (typeof data.has_more === 'boolean') loadOlderItem.hidden = !data.has_more;

            if (direction === 'before') {
                const previousHeight = thread.scrollHeight;
                for (const message of [...data.messages].reverse()) {
                    appendMessage(message, true);
                    oldestMessageId = Math.min(oldestMessageId || Number(message.id), Number(message.id));
                }
                thread.scrollTop += thread.scrollHeight - previousHeight;
            } else {
                for (const message of data.messages) {
                    appendMessage(message);
                    lastMessageId = Math.max(lastMessageId, Number(message.id));
                    oldestMessageId = oldestMessageId === 0
                        ? Number(message.id)
                        : Math.min(oldestMessageId, Number(message.id));
                }
            }
            if (direction !== 'before' && data.messages.length > 0) thread.scrollTop = thread.scrollHeight;
        };

        const selectConversation = async (conversation) => {
            selectedConversationId = String(conversation.id);
            lastMessageId = 0;
            oldestMessageId = 0;
            loadOlderItem.hidden = true;
            thread.replaceChildren(loadOlderItem);
            customerName.textContent = conversation.customer_name;
            customerEmail.textContent = conversation.customer_email;
            replyForm.hidden = false;
            for (const button of list.querySelectorAll('[data-conversation-id]')) {
                button.classList.toggle('is-active', button.dataset.conversationId === selectedConversationId);
            }
            try {
                await loadMessages();
                await refreshConversationList();
                replyInput.focus();
            } catch (error) {
                showNotice(error.message);
            }
        };

        filterButtons.forEach((button) => {
            button.addEventListener('click', async () => {
                activeFilter = button.dataset.chatFilter;
                filterButtons.forEach((filter) => filter.classList.toggle('is-active', filter === button));
                try {
                    await refreshConversationList();
                } catch (error) {
                    showNotice(error.message);
                }
            });
        });

        loadOlderButton.addEventListener('click', () => {
            if (oldestMessageId) {
                loadMessages(oldestMessageId, 'before').catch((error) => showNotice(error.message));
            }
        });

        replyForm.addEventListener('submit', async (event) => {
            event.preventDefault();
            const body = replyInput.value.trim();
            if (!body || !selectedConversationId) return;

            replyButton.disabled = true;
            try {
                const response = await fetch(routeFor(page.dataset.replyTemplate, selectedConversationId), {
                    method: 'POST',
                    headers: requestHeaders,
                    credentials: 'same-origin',
                    body: JSON.stringify({ body }),
                });
                if (!response.ok) {
                    const data = await response.json().catch(() => ({}));
                    throw new Error(data.errors?.body?.[0] || 'Balasan gagal dikirim.');
                }

                const data = await response.json();
                appendMessage(data.message);
                lastMessageId = Math.max(lastMessageId, Number(data.message.id));
                replyInput.value = '';
                thread.scrollTop = thread.scrollHeight;
                notice.hidden = true;
                await refreshConversationList();
            } catch (error) {
                showNotice(error.message || 'Koneksi terganggu. Balasan belum terkirim.');
            } finally {
                replyButton.disabled = false;
                replyInput.focus();
            }
        });

        const refresh = async () => {
            if (pollInProgress) return;
            pollInProgress = true;
            try {
                await refreshConversationList();
                await loadMessages(lastMessageId > 0 ? lastMessageId : null);
                notice.hidden = true;
            } catch (error) {
                showNotice(error.message);
            } finally {
                pollInProgress = false;
            }
        };

        if (selectedConversationId) {
            const firstConversation = [...list.querySelectorAll('[data-conversation-id]')]
                .find((button) => button.dataset.conversationId === String(selectedConversationId));
            if (firstConversation) {
                firstConversation.click();
            }
        }

        window.setInterval(refresh, 5000);
    })();
</script>
@endpush
