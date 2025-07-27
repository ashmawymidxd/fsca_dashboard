@component('mail::message')
# Reply to Your Contact Message

Hello {{ $contact->name }},

Thank you for contacting us. Here is our reply to your message:

@component('mail::panel')
{{ $replyMessage }}
@endcomponent

**Original Message:**
{{ $contact->message }}

Thanks,
{{ config('app.name') }}
@endcomponent
