<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $usersCount = $users->count();

        if ($usersCount <= 0) {
            return response()->json(['error' => 'error'], 400);
        }

        return response()->json($users, 200);
    }

    public function show(int $id)
    {
        $user = User::with('account')->find($id);

        if (! $user) {
            return response()->json(['error' => 'No user found.'], 404);
        }

        return response()->json($user, 200);
    }

    public function getAccountByUserId(int $userId)
    {
        $account = User::find($userId)->account ?? null;

        if (! $account) {
            return response()->json(['error' => 'No user found.'], 404);
        }

        return response()->json($account, 200);
    }

    public function getTransactionsByUserId(int $userId)
    {
        $transactions = User::find($userId)->transactions ?? null;

        if (! $transactions) {
            return response()->json(['error' => 'No user found.'], 404);
        }

        return response()->json($transactions, 200);
    }

    public function store(Request $request)
    {
        $user = User::create($request->input());

        if (! $user) {
            return response()->json(['error' => 'error'], 400);
        }

        return response()->json($user, 201);
    }

    public function update(Request $request, int $id)
    {
        $user = User::find($id);

        if (! $user) {
            return response()->json(['error' => 'No user found.'], 404);
        }

        $user->fill($request->all());
        $user->save();

        return response()->json($user, 200);
    }

    public function destroy(Request $request, int $id)
    {
        $user = User::find($id);

        if (! $user) {
            return response()->json(['error' => 'No user found.'], 404);
        }

        $user->delete();

        return response()->json(['status' => 'User delete successfully.'], 200);
    }
}
