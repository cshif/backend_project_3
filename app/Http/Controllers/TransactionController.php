<?php

namespace App\Http\Controllers;

use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        return Transaction::paginate(10);
    }

    public function store()
    {
        $validated = request()->validate([
            'user_id' => 'required',
            'type' => 'required',
            'currency_type' => 'required',
            'note' => 'sometimes',
            'balance_before_transaction' => 'required',
            'balance_after_transaction' => 'required',
            'status' => 'required',
            'source_account_id' => 'sometimes',
            'destination_account_id' => 'sometimes',
        ]);

        return Transaction::create($validated);
    }

    public function show(Transaction $transaction)
    {
        return $transaction->load(['user']);
    }

    public function update(Transaction $transaction)
    {
        $validated = request()->validate([
            'user_id' => 'sometimes',
            'type' => 'sometimes',
            'currency_type' => 'sometimes',
            'note' => 'sometimes',
            'balance_before_transaction' => 'sometimes',
            'balance_after_transaction' => 'sometimes',
            'status' => 'sometimes',
            'source_account_id' => 'sometimes',
            'destination_account_id' => 'sometimes',
        ]);

        return $transaction->update($validated);
    }

    public function destroy(Transaction $transaction)
    {
        return $transaction->delete();
    }
}
