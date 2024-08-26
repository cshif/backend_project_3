<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Token\Parser;

class DepositController extends Controller
{
    public function store(Account $account)
    {
        $token = env('MOCK_JWT_TOKEN');
        $parser = new Parser(new JoseEncoder);
        $token = $parser->parse($token);
        $account_id = $token->claims()->get('account_id');

        if ($account_id !== $account->id or ! is_null($account->deleted_at)) {
            return response('Unauthorized.', 401);
        }

        $user_id = request()->input('user_id');
        $amount = request()->input('amount');

        if (! $user_id or ! $amount or ! is_numeric($amount)) {
            response('Bad request', 400);
        }

        $user_ids_own_account = User::where('account_id', $account_id)->pluck('id')->toArray();
        $is_user_own_account = in_array(
            $user_id,
            $user_ids_own_account
        );

        if (! $is_user_own_account) {
            return response('Unauthorized.', 401);
        }

        /* main flow
         * 1. create transaction record
         * 2. update account balance
         */
        return DB::transaction(function () use ($account, $amount) {
            $data = [
                'user_id' => request()->input('user_id'),
                'type' => 'deposit',
                'currency_type' => 'TWD',
                'balance_before_transaction' => $account->balance,
                'balance_after_transaction' => $account->balance + request()->input('amount'),
                'status' => 'success',
                'destination_account_id' => $account->id,
            ];
            $validated = Validator::make($data, [
                'user_id' => 'required',
                'type' => 'required',
                'currency_type' => 'required',
                'note' => 'sometimes',
                'balance_before_transaction' => 'required',
                'balance_after_transaction' => 'required',
                'status' => 'required',
                'destination_account_id' => 'required',
            ])->validate();

            Transaction::create($validated);

            return $account->update([
                'balance' => $account->balance + $amount,
            ]);
        });
    }
}
