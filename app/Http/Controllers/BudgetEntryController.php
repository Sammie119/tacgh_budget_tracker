<?php

namespace App\Http\Controllers;

use App\Models\BudgetEntry;
use App\Models\VWBudgetEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['budget_entries'] = BudgetEntry::all();
        return view('budget_entries.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
//        dd($request->all());
        $request->validate([
            'name' => ['required'],
            'description' => ['required'],
            'category_id' => ['required'],
            'department_id' => ['required'],
            'header_id' => ['required'],
            'amount' => ['required'],
            'status' => ['required']
        ]);

        BudgetEntry::firstOrCreate(
            [
                'name' => $request->name,
                'category_id' => $request->category_id,
                'department_id' => $request->department_id,
                'header_id' => $request->header_id,
            ],
            [
                'description' => $request->description,
                'amount' => $request->amount,
                'status' => $request->status,
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
            ]
        );

        return redirect(route('budget_entries', absolute: false))->with('success', 'Budget Entry Created Successfully!!!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'description' => ['required'],
            'category_id' => ['required'],
            'department_id' => ['required'],
            'header_id' => ['required'],
            'amount' => ['required'],
            'status' => ['required']
        ]);

        BudgetEntry::find($request->id)->update(
            [
                'name' => $request->name,
                'category_id' => $request->category_id,
                'department_id' => $request->department_id,
                'header_id' => $request->header_id,
                'description' => $request->description,
                'amount' => $request->amount,
                'status' => $request->status,
                'updated_by' => Auth::user()->id,
            ]
        );

        return redirect(route('budget_entries', absolute: false))->with('success', 'Budget Entry Created Successfully!!!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $budget = BudgetEntry::find($request->id);

        if($budget->status == 2 || $budget->status == 1){
            return redirect(route('budget_entries', absolute: false))->with('error', 'Budget Entry cannot be Deleted!!!');
        }

        $budget->delete();
        return redirect(route('budget_entries', absolute: false))->with('success', 'Budget Entry Deleted Successfully!!!');
    }

    public function getBudgetEntry(Request $request)
    {
        $budget_entry = VWBudgetEntry::where(['id' => $request->budget_entry, 'status' => 1])->first();
//        dd($budget_entry, $request->budget_entry);
        if($budget_entry){
            $result = [
                'amount' => $budget_entry->amount,
                'remaining' => ($budget_entry->amount - $budget_entry->amount_used),
            ];
            return response()->json(['budget_entry' => $result]);
        }

        return response()->json(['budget_entry' => 0]);
    }
}
