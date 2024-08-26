<?php

namespace App\Http\Controllers;

use App\Models\Account;

class DeactivateAccountController extends Controller
{
    public function destroy(Account $account)
    {
        return $account->delete();
    }
}
