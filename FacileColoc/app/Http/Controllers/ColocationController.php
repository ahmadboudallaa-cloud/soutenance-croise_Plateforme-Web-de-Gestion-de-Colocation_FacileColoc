<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Colocation;
use App\Services\MembershipService;

class ColocationController extends Controller
{
    public function create()
    {
        return view('colocations.create');
    }

    public function store(Request $request, MembershipService $membershipService)
    {
        $request->validate([
            'name' => 'required|min:3'
        ]);

        $user = Auth::user();

        // Vérifier colocation active
        if ($membershipService->userHasActiveColocation($user)) {
            return back()->withErrors([
                'name' => 'Vous avez déjà une colocation active'
            ]);
        }

        // Création
        $colocation = Colocation::create([
            'name' => $request->name,
            'status' => 'active',
            'owner_id' => $user->id,
        ]);

        // owner automatique
        $colocation->members()->attach($user->id, [
            'role' => 'owner',
            'joined_at' => now(),
            'is_active' => true,
        ]);

        return redirect()->route('colocations.show', $colocation);
    }

    public function show(Colocation $colocation)
    {
        $members = $colocation->members;

        return view('colocations.show', compact('colocation','members'));
    }
}