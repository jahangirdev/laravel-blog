<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('dashboard.categories.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.categories.create');
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
            'category_name' => 'required|unique:categories',
            'category_slug' => 'unique:categories'
        ]);
        Category::insert([
            'category_name' => $request->category_name,
            'category_slug' => 'unique'
        ]);
        return redirect()->back()->with('alert', ['type'=>'success', 'message' => 'Category inserted successfully.', 'title' => 'Great job!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('dashboard.categories.edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->category_slug = Str::of($request->category_slug ? $request->category_slug : $request->category_name)->slug('-');
        $request->validate([
            'category_name' => 'required|unique:categories,category_name,'.$category->id,
            'category_slug' => 'unique:categories,category_slug,'.$category->id
        ]);
        $category->category_name = $request->category_name;
        $category->category_slug = $request->category_slug;
        $category->save();
        return redirect()->route('categories.index')->with('alert', ['type'=>'success', 'message' => 'Category updated successfully.', 'title' => 'Updated!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->back()->with('alert', ['type'=>'warning', 'message' => 'Category '."'".$category->category_name."'".' has been deleted.', 'title' => 'Deleted!']);
    }
}
