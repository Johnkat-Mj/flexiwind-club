<x-mail::message>
# You have a seat on Flexiwind Pro

{{ $inviterName }} added you to their **{{ $planName }}** subscription. Accept below to get your own account, with your own CLI tokens.

<x-mail::button :url="$url">
Accept the invitation
</x-mail::button>

This invitation expires in {{ $days }} days and is tied to this email address.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
