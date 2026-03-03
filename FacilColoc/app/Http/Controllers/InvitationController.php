<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvitationMail;

class InvitationController extends Controller
{
    public function store(Request $request, Colocation $colocation)
    {
        $this->authorizeOwner($colocation);

        $request->validate([
            'email' => 'required|email',
        ]);

        $email = strtolower(trim($request->email));

        $existingUser = User::whereRaw('LOWER(email) = ?', [$email])->first();
        if ($existingUser) {
            $alreadyMember = $colocation->users()
                ->where('users.id', $existingUser->id)
                ->wherePivotNull('left_at')
                ->exists();

            if ($alreadyMember) {
                return back()->with('error', 'Cet utilisateur est dÃ©jÃ  membre de la colocation.');
            }
        }

        $existingInvitation = Invitation::where('colocation_id', $colocation->id)
            ->whereRaw('LOWER(email) = ?', [$email])
            ->where('status', 'pending')
            ->first();

        if ($existingInvitation) {
            return back()
                ->with('error', 'Une invitation est dÃ©jÃ  en attente pour cet email.')
                ->with('invite_link', route('invitations.show', $existingInvitation->token));
        }

        $invitation = Invitation::create([
            'colocation_id' => $colocation->id,
            'invited_by' => Auth::id(),
            'email' => $email,
            'token' => (string) Str::uuid(),
            'status' => 'pending',
        ]);

        $link = route('invitations.show', $invitation->token);

        try {
            Mail::to($email)->send(new InvitationMail($invitation));
            $message = 'Invitation crÃ©Ã©e et envoyÃ©e par email.';
        } catch (\Throwable $e) {
            $message = 'Invitation crÃ©Ã©e, mais lâ€™envoi email a Ã©chouÃ©.';
        }

        return back()
            ->with('success', $message)
            ->with('invite_link', $link);
    }

    public function show(string $token)
    {
        $invitation = Invitation::where('token', $token)->firstOrFail();

        $hasAccount = User::whereRaw('LOWER(email) = ?', [strtolower($invitation->email)])->exists();

        return view('invitations.show', compact('invitation', 'hasAccount'));
    }

    public function accept(string $token)
    {
        $invitation = Invitation::where('token', $token)->firstOrFail();

        if ($invitation->status !== 'pending') {
            return redirect()->route('dashboard')
                ->with('error', 'Cette invitation nâ€™est plus valide.');
        }

        if ($invitation->expires_at && $invitation->expires_at->isPast()) {
            return redirect()->route('dashboard')
                ->with('error', 'Cette invitation a expirÃ©.');
        }

        if (strtolower(Auth::user()->email) !== strtolower($invitation->email)) {
            return redirect()->route('dashboard')
                ->with('error', 'Cette invitation ne correspond pas Ã  votre email.');
        }

        $hasActiveColocation = Auth::user()
            ->colocations()
            ->where('colocations.status', 'active')
            ->wherePivotNull('left_at')
            ->exists();

        if ($hasActiveColocation) {
            return redirect()->route('dashboard')
                ->with('error', 'Vous avez dÃ©jÃ  une colocation active.');
        }

        $colocation = $invitation->colocation;

        if ($colocation->status !== 'active') {
            return redirect()->route('dashboard')
                ->with('error', 'Cette colocation est annulÃ©e.');
        }

        $alreadyMember = $colocation->users()
            ->where('users.id', Auth::id())
            ->wherePivotNull('left_at')
            ->exists();

        if ($alreadyMember) {
            $invitation->update([
                'status' => 'accepted',
                'accepted_at' => now(),
            ]);

            return redirect()->route('colocations.show', $colocation)
                ->with('success', 'Vous Ãªtes dÃ©jÃ  membre de cette colocation.');
        }

        $colocation->users()->attach(Auth::id(), [
            'role' => 'member',
            'left_at' => null,
        ]);

        $invitation->update([
            'status' => 'accepted',
            'accepted_at' => now(),
        ]);

        return redirect()->route('colocations.show', $colocation)
            ->with('success', 'Invitation acceptÃ©e.');
    }

    public function decline(string $token)
    {
        $invitation = Invitation::where('token', $token)->firstOrFail();

        if ($invitation->status !== 'pending') {
            return redirect()->route('dashboard')
                ->with('error', 'Cette invitation nâ€™est plus valide.');
        }

        if (strtolower(Auth::user()->email) !== strtolower($invitation->email)) {
            return redirect()->route('dashboard')
                ->with('error', 'Cette invitation ne correspond pas Ã  votre email.');
        }

        $invitation->update([
            'status' => 'declined',
            'declined_at' => now(),
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Invitation refusÃ©e.');
    }

    private function authorizeOwner(Colocation $colocation): void
    {
        $isOwner = $colocation->users()
            ->where('users.id', Auth::id())
            ->wherePivot('role', 'owner')
            ->wherePivotNull('left_at')
            ->exists();

        if (!$isOwner) {
            abort(403);
        }
    }

    public function destroy(Colocation $colocation, Invitation $invitation)
    {
        $this->authorizeOwner($colocation);

        if ($invitation->colocation_id !== $colocation->id) {
            abort(404);
        }

        $invitation->delete();

        return back()->with('success', 'Invitation supprimÃ©e.');
    }
}

