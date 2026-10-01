<x-mail::message>
# {{ $isNewAccount ? 'Create your account' : 'Sign in to Flexiwind' }}

@if ($isNewAccount)
Click below to create your Flexiwind account. No password to choose — this link is all you need.
@else
Click below to sign in. No password needed.
@endif

<x-mail::button :url="$url">
{{ $isNewAccount ? 'Create my account' : 'Sign in' }}
</x-mail::button>

This link expires in {{ $minutes }} minutes and can only be used once.

If you did not ask for it, you can ignore this email — nothing was created or changed.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
