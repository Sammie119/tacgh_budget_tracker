<?php

namespace App\Http\Controllers;

use App\Exports\CategoryReportExport;
use App\Exports\DepartmentalReportExport;
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
                    ->where('status', '>=', 1)
                    ->orderBy('category_id', 'asc', 'department_id', 'asc')
                    ->get();
                $data['header'] = [
                    'header_name' => "Directorate Report on $budget_header->name",
                    'type' => 'departmental_report',
                ];

                return view('report.report_output', $data)->with('success', 'Directorate/Unit Report Generated Successfully!!!');

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
            default:
                return false;
        }

    }

}
