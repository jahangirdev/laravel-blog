<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Image;
use File;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return view('dashboard.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        return view('dashboard.posts.create', compact('categories', 'subcategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //form validation
        $request->validate([
            'title' => 'required|string|min:10',
            'excerpt' => 'nullable|string',
            'category_id' => 'required',
            'subcategory_id' => 'nullable',
            'post_content' => 'required'
        ]);
        $status = $request->status == 'on' ? 1 : 0;
        $request->slug = self::createSlug($request->title);
        $imageLink = null;
        //if form submitted with image, upload image and set $imageLink = uploaded image link
        if($request->thumbnail){

            //generating image link using post slug, time and image extension
            $imageLink = 'public/uploads/img/'.$request->slug.'-'.time().'.'.$request->thumbnail->extension();

            //resize and upload image
            Image::make($request->thumbnail)->resize(300, 300)->save($imageLink);

        }
        //Insert post into database
        $post = new Post();
        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->excerpt = $request->excerpt;
        $post->category_id = $request->category_id;
        $post->subcategory_id = $request->subcategory_id;
        $post->user_id = Auth::id();
        $post->content = $request->post_content;
        $post->post_date = date("Y-m-d H:i:s");
        $post->thumbnail = $imageLink;
        $post->tags = $request->tags;
        $post->status = $status;
        $post->save();
        return redirect()->route('posts.index')->with('alert', ['message' => 'Post inserted successfully.', 'title' => 'Inserted!', 'type' => 'success']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->first();
        return response()->json($post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        return view('dashboard.posts.edit', compact('post', 'categories', 'subcategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //form validation
        $request->validate([
            'title' => 'required|string|min:10',
            'excerpt' => 'nullable|string',
            'category_id' => 'required',
            'subcategory_id' => 'nullable',
            'post_content' => 'required'
        ]);
        $status = $request->status == 'on' ? 1 : 0;
        $request->slug = Str::of($request->slug)->slug('-');
        $imageLink = null;
        //if form submitted with image
        if($request->thumbnail){
            //if the post already has an image, delete it
            if($post->thumbnail){
                if(File::exists($post->thumbnail)){
                    File::delete($post->thumbnail);
                };
            }
            //generating image link using post slug, time and image extension
            $imageLink = 'public/uploads/img/'.$request->slug.'-'.time().'.'.$request->thumbnail->extension();

            //resize and upload image
            Image::make($request->thumbnail)->resize(300, 300)->save($imageLink);

        }
        //Update post
        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->excerpt = $request->excerpt;
        $post->category_id = $request->category_id;
        $post->subcategory_id = $request->subcategory_id;
        $post->content = $request->post_content;
        $post->thumbnail = $imageLink;
        $post->tags = $request->tags;
        $post->status = $status;
        $post->update();
        return redirect()->route('posts.index')->with('alert', ['message' => 'Post updated successfully.', 'title' => 'Updated!', 'type' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if(File::exists($post->thumbnail)){
            File::delete($post->thumbnail);
        }
        $post->delete();
        return redirect()->back()->with('alert', ['type'=>'warning', 'message' => 'Post '."'".$post->title."'".' has been deleted.', 'title' => 'Deleted!']);
    }
    private static function createSlug($title){
        $slug = Str::of($title)->slug('-');
        $latestSlug =
            static::where("slug", 'like', $slug.'-%')
                ->orWhere("slug", $slug)
                ->orderBy('id', 'DESC')
                ->select('slug')
                ->first();
        if ($latestSlug) {
            $pieces = explode('-', $latestSlug);
            $number = intval(end($pieces));
            if($number>0){
                $slug .= '-' . ($number + 1);
            }
            else{
                $slug.= '-2';
            }
        }
        return $slug;
    }
}
