<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'colocation_id' => 'required|exists:colocations,id',
            'payer_id' => 'required|exists:users,id',
            'receiver_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0.01',
        ]);

        if ($request->payer_id == $request->receiver_id) {
            return back()->with('error', 'Le payeur et le bénéficiaire doivent être différents.');
        }

        $colocation = Colocation::findOrFail($request->colocation_id);
        if ($colocation->status !== 'active') {
            return back()->with('error', 'La colocation est annulée.');
        }

        $isMember = $colocation->users()
            ->where('users.id', Auth::id())
            ->wherePivotNull('left_at')
            ->exists();

        if (!$isMember) {
            abort(403);
        }

        $payerIsMember = $colocation->users()
            ->where('users.id', $request->payer_id)
            ->wherePivotNull('left_at')
            ->exists();

        $receiverIsMember = $colocation->users()
            ->where('users.id', $request->receiver_id)
            ->wherePivotNull('left_at')
            ->exists();

        if (!$payerIsMember || !$receiverIsMember) {
            return back()->with('error', 'Le payeur et le bénéficiaire doivent être membres actifs de la colocation.');
        }

        Payment::create([
            'colocation_id' => $request->colocation_id,
            'payer_id' => $request->payer_id,
            'receiver_id' => $request->receiver_id,
            'amount' => $request->amount,
        ]);

        return back()->with('success', 'Paiement enregistré.');
    }
}
