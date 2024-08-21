<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return User::paginate(10);
    }

    public function store()
    {
        $validated = request()->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'account_id' => 'required',
        ]);

        return User::create($validated);
    }

    public function show(User $user)
    {
        return $user->load(['account', 'transactions']);
    }

    public function update(User $user)
    {
        $validated = request()->validate([
            'name' => 'sometimes',
            'email' => 'sometimes',
            'account_id' => 'sometimes',
        ]);

        return $user->update($validated);
    }

    public function destroy(User $user)
    {
        return $user->delete();
    }
}
