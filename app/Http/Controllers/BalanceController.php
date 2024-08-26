<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Token\Parser;

class BalanceController extends Controller
{
    public function show(Account $account)
    {
        $token = env('MOCK_JWT_TOKEN');
        $parser = new Parser(new JoseEncoder);
        $token = $parser->parse($token);
        $account_id = $token->claims()->get('account_id');

        if ($account_id === $account->id) {
            return $account->balance;
        }

        return response('Bad Request', 400);
    }
}
