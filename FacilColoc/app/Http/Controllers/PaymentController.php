<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    private function calculateBalances($members, $expenses, $payments): array
    {
        $totalExpenses = $expenses->sum('amount');
        $memberCount = $members->count();
        $share = $memberCount > 0 ? $totalExpenses / $memberCount : 0;

        $balances = [];

        foreach ($members as $member) {
            $paidExpenses = $expenses
                ->where('paid_by', $member->id)
                ->sum('amount');

            $received = $payments
                ->where('receiver_id', $member->id)
                ->sum('amount');

            $sent = $payments
                ->where('payer_id', $member->id)
                ->sum('amount');

            $paid = $paidExpenses + $sent - $received;

            $balances[$member->id] = [
                'balance' => $paid - $share,
            ];
        }

        return $balances;
    }

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

        $members = $colocation->users()->whereNull('left_at')->get();
        $expenses = $colocation->expenses()->get();
        $payments = $colocation->payments()->get();
        $balances = $this->calculateBalances($members, $expenses, $payments);

        $payerBalance = $balances[$request->payer_id]['balance'] ?? 0;
        $receiverBalance = $balances[$request->receiver_id]['balance'] ?? 0;

        $maxPayable = min(abs(min($payerBalance, 0)), max($receiverBalance, 0));
        $amount = round((float) $request->amount, 2);
        $maxPayable = round((float) $maxPayable, 2);

        if ($maxPayable <= 0) {
            return back()->with('error', 'Aucune dette active entre ces membres.');
        }

        if ($amount > $maxPayable + 0.01) {
            return back()->with('error', 'Le montant dépasse la dette actuelle.');
        }

        $duplicate = Payment::where('colocation_id', $request->colocation_id)
            ->where('payer_id', $request->payer_id)
            ->where('receiver_id', $request->receiver_id)
            ->where('amount', $amount)
            ->where('created_at', '>=', now()->subMinutes(2))
            ->exists();

        if ($duplicate) {
            return back()->with('error', 'Paiement déjà enregistré.');
        }

        Payment::create([
            'colocation_id' => $request->colocation_id,
            'payer_id' => $request->payer_id,
            'receiver_id' => $request->receiver_id,
            'amount' => $amount,
        ]);

        return redirect()
            ->route('colocations.show', $request->colocation_id)
            ->with('success', 'Paiement enregistré.');
    }
}
