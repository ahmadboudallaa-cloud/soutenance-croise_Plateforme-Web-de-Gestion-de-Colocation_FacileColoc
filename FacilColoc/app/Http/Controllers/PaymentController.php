<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request, Colocation $colocation)
    {
        Payment::create([
            'colocation_id' => $colocation->id,
            'from_user_id' => $request->from_user,
            'to_user_id' => $request->to_user,
            'amount' => $request->amount,
            'payment_date' => now(),
        ]);

        return redirect()
            ->route('colocations.show',$colocation)
            ->with('success','Paiement enregistré ✅');
    }
}