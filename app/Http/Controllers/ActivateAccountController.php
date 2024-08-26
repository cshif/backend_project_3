<?php

namespace App\Http\Controllers;

use App\Models\Account;

class ActivateAccountController extends Controller
{
    public function update(Account $account)
    {
        return $account->restore();
    }
}
