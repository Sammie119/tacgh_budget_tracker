<?php

namespace App\Http\Controllers;

use App\Models\BudgetHeader;
use App\Models\BudgetEntry;
use App\Models\ExpenseEntry;
use App\Models\User;
use App\Models\VWBudgetEntry;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function dashboard()
    {
        $activeHeader = BudgetHeader::where('status', 1)->first();
        $header_id    = $activeHeader ? $activeHeader->id : null;

        // Top 5 by allocation — eager-load department & category to avoid N+1
        $data['top10budgets'] = VWBudgetEntry::with(['department', 'category'])
            ->where('header_id', $header_id)
            ->orderByDesc('amount')
            ->limit(5)
            ->get();

        // Top 5 overspending entries
        $data['top5overspending'] = VWBudgetEntry::with(['department', 'category'])
            ->where('header_id', $header_id)
            ->where('amount_remaining', '<', 0)
            ->orderBy('amount_remaining')
            ->limit(5)
            ->get();

        // Aggregate figures for KPI cards
        $data['total_allocation']   = VWBudgetEntry::where('header_id', $header_id)->sum('amount');
        $data['amount_requested']   = VWBudgetEntry::where('header_id', $header_id)->sum('amount_requested');
        $data['amount_used']        = VWBudgetEntry::where('header_id', $header_id)->sum('amount_used');
        $data['total_remaining']    = $data['total_allocation'] - $data['amount_used'];
        $data['total_entries']      = VWBudgetEntry::where('header_id', $header_id)->count();
        $data['overspend_count']    = VWBudgetEntry::where('header_id', $header_id)->where('amount_remaining', '<', 0)->count();
        $data['pending_requests']   = ExpenseEntry::where('header_id', $header_id)->where('status', 1)->count();

        $data['percentage'] = round(
            ($data['total_allocation'] != 0 ? $data['amount_used'] / $data['total_allocation'] : 0) * 100,
            2
        );

        $data['header_id']   = $header_id;
        $data['header_name'] = $activeHeader ? $activeHeader->name : 'N/A';
        $data['users']       = User::count();

        return view('dashboard', $data);
    }
}
