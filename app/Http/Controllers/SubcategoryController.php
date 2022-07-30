<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subcategories = Subcategory::all();
        return view('dashboard.subcategories.index', compact('subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('dashboard.subcategories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->category_slug = Str::of($request->category_slug ? $request->category_slug : $request->category_name)->slug('-');
        $request->validate([
            'subcategory_name' => 'required|unique:subcategories',
            'subcategory_slug' => 'unique:subcategories',
            'category_id' => 'required'
        ]);
        $subcategory = new Subcategory();
        $subcategory->subcategory_name = $request->subcategory_name;
        $subcategory->subcategory_slug = $request->subcategory_slug;
        $subcategory->category_id = $request->category_id;
        $subcategory->save();
        return redirect()->back()->with('alert', ['message' => 'Subcategory created successfully.', 'title' => 'Created!', 'type' => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function show(Subcategory $subcategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Subcategory $subcategory)
    {
        $categories = Category::all();
        return view('dashboard.subcategories.edit', compact('subcategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subcategory $subcategory)
    {
        $request->category_slug = Str::of($request->category_slug ? $request->category_slug : $request->category_name)->slug('-');
        $request->validate([
            'subcategory_name' => 'required|unique:subcategories,subcategory_name,'.$subcategory->id,
            'subcategory_slug' => 'unique:subcategories,subcategory_slug,'.$subcategory->id,
            'category_id' => 'required'
        ]);
        $subcategory->subcategory_name = $request->subcategory_name;
        $subcategory->subcategory_slug = $request->subcategory_slug;
        $subcategory->category_id = $request->category_id;
        $subcategory->save();
        return redirect()->route('subcategories.index')->with('alert', ['message' => 'Subcategory updated successfully.', 'title' => 'Updated!', 'type' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subcategory $subcategory)
    {
        $subcategory->delete();
        return redirect()->back()->with('alert', ['type'=>'warning', 'message' => 'Subcategory '."'".$subcategory->subcategory_name."'".' has been deleted.', 'title' => 'Deleted!']);
    }
    /**
     * Get subcategories by category id
     *
     * @param \App\Models\Subcategory $id
     * @return \Illuminate\Http\Response as json
     */
    public function getSubcategories($id){
        $subcategories = Subcategory::where('category_id', $id)->get();
        return response()->json($subcategories);
    }
}
