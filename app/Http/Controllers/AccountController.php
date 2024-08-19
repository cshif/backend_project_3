<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::all();
        $accountsCount = $accounts->count();

        if ($accountsCount <= 0) {
            return response()->json(['error' => 'error'], 400);
        }

        return response()->json($accounts, 200);
    }

    public function show(int $id)
    {
        $account = Account::with('users')->find($id);

        if (! $account) {
            return response()->json(['error' => 'No account found.'], 404);
        }

        return response()->json($account, 200);
    }

    public function getUsersByAccountId(int $accountId)
    {
        $users = Account::find($accountId)->users ?? null;

        if (! $users) {
            return response()->json(['error' => 'No account found.'], 404);
        }

        return response()->json($users, 200);
    }

    public function store(Request $request)
    {
        $account = Account::create();

        if (! $account) {
            return response()->json(['error' => 'error'], 400);
        }

        return response()->json($account, 201);
    }

    public function update(Request $request, int $id)
    {
        $account = Account::find($id);

        if (! $account) {
            return response()->json(['error' => 'No account found.'], 404);
        }

        $account->fill($request->all());
        $account->save();

        return response()->json($account, 200);
    }

    public function destroy(int $id)
    {
        $account = Account::find($id);

        if (! $account) {
            return response()->json(['error' => 'No account found.'], 404);
        }

        $account->delete();

        return response()->json(['status' => 'Account delete successfully.'], 200);
    }
}
