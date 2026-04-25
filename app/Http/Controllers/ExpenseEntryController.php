<?php

namespace App\Http\Controllers;

use App\Imports\ExpenseAmountImport;
use App\Models\BudgetEntry;
use App\Models\ExpenseEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ExpenseEntryController extends Controller
{
    private function getBudgetEntryID($name)
    {
        $budget_entry = BudgetEntry::where(['id' => $name, 'status' => 1])->first();

        if($budget_entry){
            return $budget_entry;
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['expense_entries'] = ExpenseEntry::with(['department', 'category', 'budgetEntry'])
            ->orderByDesc('created_at')
            ->get();
        return view('request_entries.index', $data);
    }

    public function indexExpense()
    {
        $data['expense_entries'] = ExpenseEntry::with(['department', 'budgetEntry'])
            ->where('status', '>=', 1)
            ->orderByDesc('created_at')
            ->get();
        return view('expense_entries.index', $data);
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
            'budget_entry_id' => ['required'],
            'amount' => ['required'],
//            'status' => ['required']
        ]);

        $budget_entry = $this->getBudgetEntryID($request->budget_entry_id);

        ExpenseEntry::firstOrCreate(
            [
                'name' => $request->name,
                'category_id' => $budget_entry->category_id,
                'department_id' => $budget_entry->department_id,
                'header_id' => $budget_entry->header_id,
                'budget_entry_id' => $budget_entry->id
            ],
            [
                'description' => strtoupper($request->description),
                'amount_budgeted' => $budget_entry->amount,
                'amount_used' => 0.00,
                'amount_requested' => $request->amount,
                'status' => 1,
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
            ]
        );

        return redirect(route('request_entries', absolute: false))->with('success', 'Request Entry Created Successfully!!!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'description' => ['required'],
            'budget_entry_id' => ['required'],
            'amount' => ['required'],
            'status' => ['required']
        ]);

        $budget_entry = $this->getBudgetEntryID($request->budget_entry_id);

        $expense = ExpenseEntry::find($request->id);

        if($expense->amount_spent > 0){
            return redirect(route('request_entries', absolute: false))->with('error', 'Request cannot be Updated....!!!!');
        }

        $expense->update(
            [
                'name' => $request->name,
                'category_id' => $budget_entry->category_id,
                'department_id' => $budget_entry->department_id,
                'header_id' => $budget_entry->header_id,
                'budget_entry_id' => $budget_entry->id,
                'description' => strtoupper($request->description),
                'amount_budgeted' => $budget_entry->amount,
                'amount_used' => 0.00,
                'amount_requested' => $request->amount,
                'status' => 1,
                'updated_by' => Auth::user()->id,
            ]
        );

        return redirect(route('request_entries', absolute: false))->with('success', 'Request Entry Updated Successfully!!!');
    }

    public function updateExpense(Request $request)
    {
        $request->validate([
            'amount_spent' => ['required']
        ]);

//        dd($request->all());

        ExpenseEntry::find($request->id)->update(
            [
                'amount_spent' => $request->amount_spent,
                'status' => 2,
                'updated_by' => Auth::user()->id,
            ]
        );

        return redirect(route('expense_entries', absolute: false))->with('success', 'Expense Entered Successfully!!!');
    }

    /**
     * Bulk-import amount_spent values from an uploaded Excel file.
     * Expected columns: id, amount_spent
     */
    public function importExpense(Request $request)
    {
        $request->validate([
            'import_file' => ['required', 'file', 'mimes:xlsx,xls,csv'],
        ]);

        $import = new ExpenseAmountImport();
        Excel::import($import, $request->file('import_file'));

        $message = "{$import->updatedCount} expense(s) updated successfully.";
        if ($import->skippedCount > 0) {
            $message .= " {$import->skippedCount} row(s) skipped (not found or invalid).";
        }

        return redirect(route('expense_entries'))->with('success', $message);
    }

    /**
     * Download a blank Excel template for bulk expense upload.
     */
    public function downloadExpenseTemplate()
    {
        // Build the template as a simple collection
        $rows = collect([
            ['id' => 'EXPENSE_ENTRY_ID', 'amount_spent' => 'AMOUNT_SPENT'],
            ['id' => '1',                'amount_spent' => '0.00'],
        ]);

        return Excel::download(new class($rows) implements \Maatwebsite\Excel\Concerns\FromCollection,
            \Maatwebsite\Excel\Concerns\WithHeadings,
            \Maatwebsite\Excel\Concerns\WithStyles {
            public function __construct(private $rows) {}
            public function collection() { return $this->rows; }
            public function headings(): array { return ['id', 'amount_spent']; }
            public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet): array {
                return [1 => ['font' => ['bold' => true]]];
            }
        }, 'expense_upload_template.xlsx');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $expense = ExpenseEntry::find($request->id);

        if($expense->status == 1){
            return redirect(route('request_entries', absolute: false))->with('error', 'Request Entry cannot be Deleted, Its in Active State!!!');
        }

        $expense->delete();
        return redirect(route('request_entries', absolute: false))->with('success', 'Budget Entry Deleted Successfully!!!');
    }
}
