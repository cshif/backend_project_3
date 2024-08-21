<?php

namespace App\Http\Controllers;

use App\Models\Account;

class AccountController extends Controller
{
    public function index()
    {
        return Account::paginate(10);
    }

    public function store()
    {
        $validated = request()->validate([
            'balance' => 'required',
        ]);

        return Account::create($validated);
    }

    public function show(Account $account)
    {
        return $account->load(['users']);
    }

    public function update(Account $account)
    {
        $validated = request()->validate([
            'balance' => 'sometimes',
        ]);

        return $account->update($validated);
    }

    public function destroy(Account $account)
    {
        return $account->delete();
    }
}
