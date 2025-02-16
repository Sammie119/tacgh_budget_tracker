<?php

namespace App\Http\Controllers;

use App\Models\BudgetHeader;
use App\Models\User;
use App\Models\VWBudgetEntry;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function dashboard()
    {
        $data['header_id'] = BudgetHeader::where('status', 1)->first()->id;
        $data['top10budgets'] = VWBudgetEntry::where('header_id', $data['header_id'])
            ->limit(10)
            ->orderByDesc('amount')
            ->get();
        $data['total_allocation'] = VWBudgetEntry::where('header_id', $data['header_id'])
            ->sum('amount');
        $data['amount_used'] = VWBudgetEntry::where('header_id', $data['header_id'])
            ->sum('amount_used');

        $data['percentage'] = round(($data['amount_used']/$data['total_allocation']) * 100, 2);
        $data['users'] = User::count();
        return view('dashboard', $data);
    }
}
