<?php

namespace App\Http\Controllers;

use App\Models\BudgetEntry;
use App\Models\BudgetHeader;
use App\Models\Category;
use App\Models\Department;
use App\Models\ExpenseEntry;
use App\Models\User;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function create($type){
        switch ($type) {
            case 'createUser':
                return view('users.create_form');

            case 'createBudgetHeader':
                return view('budget_headers.create_form');

            case 'createDepartment':
                $data['parent_department'] = Department::select('id', 'name')
                    ->where('status', 1)
                    ->orderBy('name')
                    ->get();
                return view('departments.create_form', $data);

            case 'createCategories':
                return view('categories.create_form');

            case 'createBudgetEntry':
                $data['categories'] = Category::select('id', 'name')
                    ->where('status', 1)
                    ->orderBy('name')
                    ->get();
                $data['departments'] = Department::select('id', 'name')
                    ->where('status', 1)
                    ->orderBy('name')
                    ->get();
                $data['budget_headers'] = BudgetHeader::select('id', 'name')
                    ->where('status', 1)
                    ->orderBy('name')
                    ->get();
                return view('budget_entries.create_form', $data);

            case 'createExpenseEntry':
                $data['budget_entries'] = BudgetEntry::select('id', 'name')
                    ->where('status', 1)
                    ->orderBy('name')
                    ->get();
                return view('expense_entries.create_form', $data);

            default:
                return "No form found";
        }
    }

    public function edit($type, $id){
//        dd($id);
        switch ($type) {
            case 'editUser':
                $data['user'] = User::find($id);
                return view('users.create_form', $data);

            case 'editBudgetHeader':
                $data['budget_header'] = BudgetHeader::find($id);
                return view('budget_headers.create_form', $data);

            case 'editDepartment':
                $data['parent_department'] = Department::select('id', 'name')
                    ->where('status', 1)
                    ->orderBy('name')
                    ->get();
                $data['department'] = Department::find($id);
                return view('departments.create_form', $data);

            case 'editCategories':
                $data['category'] = Category::find($id);
                return view('categories.create_form', $data);

            case 'editBudgetEntry':
                $data['entry'] = BudgetEntry::find($id);
                $data['categories'] = Category::select('id', 'name')
                    ->where('status', 1)
                    ->orderBy('name')
                    ->get();
                $data['departments'] = Department::select('id', 'name')
                    ->where('status', 1)
                    ->orderBy('name')
                    ->get();
                $data['budget_headers'] = BudgetHeader::select('id', 'name')
                    ->where('status', 1)
                    ->orderBy('name')
                    ->get();
                return view('budget_entries.create_form', $data);

            case 'editExpenseEntry':
                $data['entry'] = ExpenseEntry::find($id);
                $data['budget_entries'] = BudgetEntry::select('id', 'name')
                    ->where('status', 1)
                    ->orderBy('name')
                    ->get();
                return view('expense_entries.create_form', $data);

            default:
                return "No form found";
        }
    }

    public function view($type, $id){
        switch ($type) {
            case 'viewBudgetEntry':
                $data['budget'] = BudgetEntry::find($id);
                $data['expenses'] = ExpenseEntry::where(['budget_entry_id' => $id, 'status' => 1])->get();
//                return $data['budget'];
                return view('budget_entries.view_form', $data);

            case 'viewExpenseEntry':
                $data['expenses'] = ExpenseEntry::find($id);
//                dd($data['expenses']->name);
                return view('expense_entries.view_form', $data);

            default:
                return "No form found";
        }
    }

    public function delete($type, $id){
        switch ($type) {
            case 'deleteUser':
                return view('users.delete_form', ['user' => $id]);

            case 'deleteBudgetHeader':
                return view('budget_headers.delete_form', ['budget_header' => $id]);

            case 'deleteDepartment':
                return view('departments.delete_form', ['department' => $id]);

            case 'deleteCategories':
                return view('categories.delete_form', ['category' => $id]);

            case 'deleteBudgetEntry':
                return view('budget_entries.delete_form', ['budget_entries' => $id]);

            case 'deleteExpenseEntry':
                return view('expense_entries.delete_form', ['expense_entries' => $id]);

            default:
                return "No form found";
        }
    }
}
