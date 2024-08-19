<?php

namespace App\Http\Controllers;

use App\Models\Transaction;

class TransactionController extends Controller
{
    public function getUserByTransactionId(int $transactionId)
    {
        $user = Transaction::find($transactionId)->user ?? null;

        if (! $user) {
            return response()->json(['error' => 'No transaction found.'], 404);
        }

        return response()->json($user, 200);
    }
}
