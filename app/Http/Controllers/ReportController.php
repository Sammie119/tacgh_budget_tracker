<?php

namespace App\Http\Controllers;

use App\Exports\CategoryReportExport;
use App\Exports\DepartmentalReportExport;
use App\Exports\UtilisationReportExport;
use App\Models\BudgetHeader;
use App\Models\Category;
use App\Models\Department;
use App\Models\ExpenseEntry;
use App\Models\VWBudgetEntry;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index()
    {
        return view('report.index');
    }

    public function generate(Request $request)
    {
//        dd($request->all());
        switch ($request->report_type){
            case 'categoryReport':
                $request->validate([
                    'category_id' => ['required'],
                    'header_id' => ['required'],
                ]);

                $category = Category::find($request->category_id);
                $budget_header = BudgetHeader::find($request->header_id);

                $query = VWBudgetEntry::where(['category_id' => $request->category_id, 'header_id' => $request->header_id]);

                if(!empty($request->department_id)){
                    $department = Department::find($request->department_id);
                    if($department->parent_id == 1){
                        $array_key = [];
                        $d_id = Department::select('id')->where('parent_id', $department->id)->get()->toArray();

                        foreach($d_id as $id){
                            $array_key[] = $id['id'];
                        }
                        $array_key[] = (int) $request->department_id;

//                        dd( $array_key);
                        $d_array = implode(", ",$array_key);
//                        dd($d_array, "Parent Department");
                        $query->whereRaw("department_id IN ($d_array)");
                    } else {
                        $query->where('department_id', $request->department_id);
                    }
//                    dd($request->department_id, "Department");
                }

                $data['results'] = $query
                    ->with(['department', 'category'])
                    ->where('status', '>=', 1)
                    ->orderBy('created_at')
                    ->get();
                $data['header'] = [
                    'header_name' => "Category Report on $category->name, $budget_header->name",
                    'category_id' => $request->category_id,
                    'type' => 'category_report',
                ];
//                dd($data);
                return view('report.report_output', $data)->with('success', 'Category Report Generated Successfully!!!');

            case 'departmentalReport':
                $request->validate([
                    'department_id' => ['required'],
                    'header_id' => ['required'],
                ]);

                $budget_header = BudgetHeader::find($request->header_id);

                $query = VWBudgetEntry::where(['header_id' => $request->header_id]);

                if(!empty($request->department_id)){
                    $department = Department::find($request->department_id);
                    if($department->parent_id == 1){
                        $array_key = [];
                        $d_id = Department::select('id')->where('parent_id', $department->id)->get()->toArray();

                        foreach($d_id as $id){
                            $array_key[] = $id['id'];
                        }
                        $array_key[] = (int) $request->department_id;

//                        dd( $array_key);
                        $d_array = implode(", ",$array_key);
//                        dd($d_array, "Parent Department");
                        $query->whereRaw("department_id IN ($d_array)");
                    } else {
                        $query->where('department_id', $request->department_id);
                    }
//                    dd($request->department_id, "Department");
                }

                $data['results'] = $query
                    ->with(['department', 'category'])
                    ->where('status', '>=', 1)
                    ->orderBy('category_id', 'asc')
                    ->orderBy('department_id', 'asc')
                    ->get();
                $data['header'] = [
                    'header_name' => "Directorate Report on $budget_header->name",
                    'type' => 'departmental_report',
                ];

                return view('report.report_output', $data)->with('success', 'Directorate/Unit Report Generated Successfully!!!');

            case 'utilisationReport':
                $request->validate([
                    'header_id' => ['required'],
                ]);

                $budget_header = BudgetHeader::find($request->header_id);

                $query = VWBudgetEntry::with(['department', 'category'])
                    ->where('header_id', $request->header_id)
                    ->where('amount', '>', 0)
                    ->where('status', '>=', 1);

                if (!empty($request->department_id)) {
                    $department = Department::find($request->department_id);
                    if ($department->parent_id == 1) {
                        $child_ids = Department::select('id')->where('parent_id', $department->id)->pluck('id')->toArray();
                        $child_ids[] = (int) $request->department_id;
                        $query->whereIn('department_id', $child_ids);
                    } else {
                        $query->where('department_id', $request->department_id);
                    }
                }

                $threshold = is_numeric($request->threshold) ? (float) $request->threshold : 0;

                $results = $query->get()
                    ->map(function ($entry) {
                        $pct = $entry->amount > 0
                            ? round(($entry->amount_used / $entry->amount) * 100, 2)
                            : 0;
                        $entry->utilisation_pct = $pct;
                        return $entry;
                    })
                    ->filter(fn ($e) => $e->utilisation_pct >= $threshold)
                    ->sortByDesc('utilisation_pct')
                    ->values();

                // Cache flat array for PDF / Excel export
                $data_array = $results->map(fn ($e) => [
                    'category'       => $e->category->name ?? 'N/A',
                    'budget_entry'   => $e->name,
                    'department'     => $e->department->name ?? 'N/A',
                    'amount'         => $e->amount,
                    'amount_used'    => $e->amount_used,
                    'remaining'      => $e->amount - $e->amount_used,
                    'utilisation_pct'=> $e->utilisation_pct,
                    'status'         => $e->amount_used >= $e->amount ? 'Over Budget'
                        : ($e->utilisation_pct >= 80 ? 'Near Limit' : 'On Track'),
                ])->values();

                \Illuminate\Support\Facades\Cache::put('utilisation_report', $data_array, now()->addHours(3));

                $data['results']  = $results;
                $data['header']   = [
                    'header_name' => "Budget Utilisation Summary — {$budget_header->name}",
                    'type'        => 'utilisation_report',
                    'threshold'   => $threshold,
                ];

                return view('report.report_output', $data)
                    ->with('success', 'Budget Utilisation Report Generated Successfully!');

            default:
                return false;
        }
    }

    public function export($type, $id)
    {
        switch ($type){
            case 'categoryReport':
                return Excel::download(new CategoryReportExport($id), 'category_report.xlsx');

            case 'departmentalReport':
                return Excel::download(new DepartmentalReportExport($id), 'departmental_report.xlsx');

            case 'utilisationReport':
                return Excel::download(new UtilisationReportExport($id), 'utilisation_report.xlsx');

            default:
                return false;
        }
    }

    public function exportToPdf($type, $header)
    {
//        dd($type, $category_id);
        switch ($type){
            case 'categoryReport':
                $data['results'] = Cache::get('category_report');
                $data['header'] = [
                    'header_name' => $header,
                    'type' => $type,
                ];
//                dd($data['results']);
                $pdf = Pdf::loadView('report.report_pdf_output', $data)
                    ->setPaper('A4', 'landscape');

                return $pdf->download('category_report.pdf');

            case 'departmentalReport':
                $data['results'] = Cache::get('departmental_report');
                $data['header'] = [
                    'header_name' => $header,
                    'type' => $type,
                ];
//                dd($data['results']);
                $pdf = Pdf::loadView('report.report_pdf_output', $data)
                    ->setPaper('A4', 'landscape');

                return $pdf->download('departmental_report.pdf');

            case 'utilisationReport':
                $data['results'] = Cache::get('utilisation_report');
                $data['header'] = [
                    'header_name' => $header,
                    'type' => $type,
                ];
                $pdf = Pdf::loadView('report.report_pdf_output', $data)
                    ->setPaper('A4', 'landscape');

                return $pdf->download('utilisation_report.pdf');

            default:
                return false;
        }

    }

}
