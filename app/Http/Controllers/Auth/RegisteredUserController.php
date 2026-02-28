<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Organization;
use App\Models\Invitation;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'organization_name' => ['nullable', 'string', 'max:255', 'required_without:invitation_token'],
            'invitation_token' => ['nullable', 'string', 'exists:invitations,token'],
        ]);

        $role = 'admin';
        $organizationId = null;

        if ($request->has('invitation_token')) {
            $invitation = Invitation::where('token', $request->invitation_token)->firstOrFail();

            // Validate email matches invitation (security check)
            if ($invitation->email !== $request->email) {
                return back()->withErrors(['email' => 'Email address does not match the invitation.']);
            }

            $organizationId = $invitation->organization_id;
            $role = $invitation->role;
        } else {
            // Create New Organization
            $org = Organization::create([
                'name' => $request->organization_name,
                'domain' => request()->getHost(),
            ]);
            $organizationId = $org->id;
        }

        // Create User linked to Org
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'organization_id' => $organizationId,
            'role' => $role,
        ]);

        // Clean up invitation
        if (isset($invitation)) {
            $invitation->delete();
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
