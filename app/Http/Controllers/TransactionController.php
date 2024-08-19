<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::all();
        $transactionsCount = $transactions->count();

        if ($transactionsCount <= 0) {
            return response()->json(['error' => 'error'], 400);
        }

        return response()->json($transactions, 200);
    }

    public function show(int $id)
    {
        // todo join
        $transaction = Transaction::find($id);

        if (! $transaction) {
            return response()->json(['error' => 'No transaction found.'], 404);
        }

        return response()->json($transaction, 200);
    }

    public function getUserByTransactionId(int $transactionId)
    {
        $user = Transaction::find($transactionId)->user ?? null;

        if (! $user) {
            return response()->json(['error' => 'No transaction found.'], 404);
        }

        return response()->json($user, 200);
    }

    public function store(Request $request)
    {
        $transaction = Transaction::create(request()->all());

        if (! $transaction) {
            return response()->json(['error' => 'error'], 400);
        }

        return response()->json($transaction, 201);
    }

    public function update(Request $request, int $id)
    {
        $transaction = Transaction::find($id);

        if (! $transaction) {
            return response()->json(['error' => 'No transaction found.'], 404);
        }

        $transaction->fill($request->all());
        $transaction->save();

        return response()->json($transaction, 200);
    }

    public function destroy(Request $request, int $id)
    {
        $transaction = Transaction::find($id);

        if (! $transaction) {
            return response()->json(['error' => 'No transaction found.'], 404);
        }

        $transaction->delete();

        return response()->json(['status' => 'Transaction delete successfully.'], 200);
    }
}
