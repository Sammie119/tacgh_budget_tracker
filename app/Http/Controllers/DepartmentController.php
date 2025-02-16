<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['departments'] = Department::where('id', '!=', 1)->get();
        return view('departments.index', $data);
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
            'parent_id' => ['required'],
            'status' => ['required']
        ]);

        Department::firstOrCreate(
            [
                'name' => $request->name,
                'parent_id' => $request->parent_id
            ],
            [
                'description' => $request->description,
                'status' => $request->status,
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
            ]
        );

        return redirect(route('departments', absolute: false))->with('success', 'Department Created Successfully!!!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'description' => ['required'],
            'parent_id' => ['required'],
            'status' => ['required']
        ]);

        Department::find($request->id)->update(
            [
                'name' => $request->name,
                'parent_id' => $request->parent_id,
                'description' => $request->description,
                'status' => $request->status,
                'updated_by' => Auth::user()->id,
            ]
        );

        return redirect(route('departments', absolute: false))->with('success', 'Department Updated Successfully!!!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Department::find($request->id)->delete();

        return redirect(route('departments', absolute: false))->with('success', 'Department Deleted Successfully!!!');
    }
}
