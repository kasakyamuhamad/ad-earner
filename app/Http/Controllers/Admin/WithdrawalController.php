<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function index()
    {
        return view('admin.withdrawals.index', [
            'message' => 'Withdrawals management will be implemented soon'
        ]);
    }
}