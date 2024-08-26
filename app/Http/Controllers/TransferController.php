<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Token\Parser;

class TransferController extends Controller
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
        $destination_account_id = request()->input('destination_account_id');

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

        if ($amount > $account->balance) {
            return response('Insufficient balance.', 400);
        }

        $destination_account = Account::find($destination_account_id);

        if (! $destination_account) {
            return response('Destination account not found.', 404);
        }

        /* main flow
         * 1. create transaction record
         * 2. update source account and destination account balance
         */
        return DB::transaction(function () use ($account, $destination_account) {
            $data = [
                'user_id' => request()->input('user_id'),
                'type' => 'transfer',
                'currency_type' => 'TWD',
                'status' => 'success',
                'source_account_id' => $account->id,
                'destination_account_id' => $destination_account->id,
            ];
            $validated = Validator::make($data, [
                'user_id' => 'required',
                'type' => 'required',
                'currency_type' => 'required',
                'note' => 'sometimes',
                'status' => 'required',
                'source_account_id' => 'required',
                'destination_account_id' => 'required',
            ])->validate();

            Transaction::create($validated);

            $account->update([
                'balance' => $account->balance - request()->input('amount'),
            ]);
            $destination_account->update([
                'balance' => $destination_account->balance + request()->input('amount'),
            ]);

            return response('Transfer completed.', 200);
        });
    }
}
