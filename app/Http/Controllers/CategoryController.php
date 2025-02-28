<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['categories'] = Category::all();
        return view('categories.index', $data);
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
            'status' => ['required']
        ]);

        Category::firstOrCreate(
            [
                'name' => $request->name,
                'code' => $request->code,
            ],
            [
                'description' => $request->description,
                'status' => $request->status,
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
            ]
        );

        return redirect(route('categories', absolute: false))->with('success', 'Category Created Successfully!!!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'description' => ['required'],
            'status' => ['required']
        ]);

        Category::find($request->id)->update(
            [
                'name' => $request->name,
                'code' => $request->code,
                'description' => $request->description,
                'status' => $request->status,
                'updated_by' => Auth::user()->id,
            ]
        );

        return redirect(route('categories', absolute: false))->with('success', 'Category Updated Successfully!!!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Category::find($request->id)->delete();

        return redirect(route('categories', absolute: false))->with('success', 'Category Deleted Successfully!!!');
    }
}
