<x-mail::message>
    # You've been invited!

    **{{ $invitation->organization->name }}** has invited you to join their workspace on LeadiX as a
    **{{ ucfirst($invitation->role) }}**.

    LeadiX helps teams track deals, manage invoices, and grow revenue together.

    <x-mail::button :url="$url">
        Accept Invitation
    </x-mail::button>

    If you didn't expect this invitation, you can ignore this email.

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>