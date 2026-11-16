<p>Halo {{ $contactMessage->name }},</p>

<p>Terima kasih telah menghubungi NexaMarket. Berikut balasan kami untuk pesan dengan subjek “{{ $contactMessage->subject }}”:</p>

<p>{!! nl2br(e($reply)) !!}</p>

<p>Salam,<br>Tim NexaMarket</p>
