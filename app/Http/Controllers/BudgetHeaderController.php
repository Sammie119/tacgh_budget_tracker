<?php

namespace App\Http\Controllers;

use App\Models\BudgetHeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetHeaderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['budget_headers'] = BudgetHeader::all();
        return view('budget_headers.index', $data);
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
            'start_date' => ['required'],
            'end_date' => ['required'],
            'status' => ['required']
        ]);

        BudgetHeader::firstOrCreate(
            [
                'name' => $request->name,
            ],
            [
                'description' => $request->description,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'status' => $request->status,
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
            ]
        );

        return redirect(route('budget_headers', absolute: false))->with('success', 'Budget Header Created Successfully!!!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'description' => ['required'],
            'start_date' => ['required'],
            'end_date' => ['required'],
            'status' => ['required']
        ]);

        BudgetHeader::find($request->id)->update(
            [
                'name' => $request->name,
                'description' => $request->description,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'status' => $request->status,
                'updated_by' => Auth::user()->id,
            ]
        );

        return redirect(route('budget_headers', absolute: false))->with('success', 'Budget Header Updated Successfully!!!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $budget = BudgetHeader::find($request->id);

        if($budget->status == 2 || $budget->status == 1){
            return redirect(route('budget_headers', absolute: false))->with('error', 'Budget Header cannot be Deleted!!!');
        }

        $budget->delete();
        return redirect(route('budget_headers', absolute: false))->with('success', 'Budget Header Deleted Successfully!!!');
    }
}
