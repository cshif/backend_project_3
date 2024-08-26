<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Token\Parser;

class BalanceController extends Controller
{
    public function show(Account $account)
    {
        $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhY2NvdW50X2lkIjoxfQ.sQ_2OjlBqDFOahBizJp55gmrkUMrfu5YSl59CWUX-3k';
        $parser = new Parser(new JoseEncoder);
        $token = $parser->parse($token);
        $account_id = $token->claims()->get('account_id');

        if ($account_id === $account->id) {
            return $account->balance;
        }

        return response('Bad Request', 400);
    }
}
