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
            ->limit(5)
            ->orderByDesc('amount')
            ->get();
        $data['top5overspending'] = VWBudgetEntry::where('header_id', $data['header_id'])
            ->where('amount_remaining', '<', 0)
            ->limit(5)
            ->orderBy('amount_remaining')
            ->get();
        $data['total_allocation'] = VWBudgetEntry::where('header_id', $data['header_id'])
            ->sum('amount');
        $data['amount_used'] = VWBudgetEntry::where('header_id', $data['header_id'])
            ->sum('amount_used');

        $data['percentage'] = round((($data['total_allocation'] != 0) ? $data['amount_used']/$data['total_allocation'] : 0) * 100, 2);
        $data['users'] = User::count();
        return view('dashboard', $data);
    }
}
